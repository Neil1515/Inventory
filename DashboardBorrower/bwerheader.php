<!-- borrowerheader.php -->
<?php
// Include necessary files
include('bwerfunctions.php');
include('bwermessage_count.php');
// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$BorrowerId = $_SESSION['borrower_id'];
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $BorrowerId);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
// Fetch the count of unique dates and times with notifications from tblborrowingreports for the logged-in borrower ID
$queryCount = "SELECT COUNT(DISTINCT datetime) AS notification_count
               FROM (
                   SELECT br.borrowerid, br.datetimereqborrow AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimereqborrow IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datetimereqreservation AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimereqreservation IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datimeapproved AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datimeapproved IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datetimeapprovereserved AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimeapprovereserved IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datetimecanceled AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimecanceled IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datimerejected AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datimerejected IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datetimereturn AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimereturn IS NOT NULL
                   UNION ALL
                   SELECT br.borrowerid, br.datetimereqreturn AS datetime
                   FROM tblborrowingreports br
                   WHERE br.borrowerid = ? AND br.datetimereqreturn IS NOT NULL
               ) AS subquery";
$stmtCount = mysqli_prepare($con, $queryCount);
if ($stmtCount) {
    mysqli_stmt_bind_param($stmtCount, "ssssssss", $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId);
    if (mysqli_stmt_execute($stmtCount)) {
        $resultCount = mysqli_stmt_get_result($stmtCount);
        if ($resultCount && mysqli_num_rows($resultCount) > 0) {
            $rowCount = mysqli_fetch_assoc($resultCount);
            // Total notification count is the count of unique dates and times with notifications
            $notificationCount = $rowCount['notification_count'];
        } else {
            $notificationCount = 0;
        }
    } else {
        $notificationCount = 0;
    }
    mysqli_stmt_close($stmtCount);
} else {
    $notificationCount = 0;
}
?>

<div class="container-fluid">
    <div class="header--wrapper py-2">
        <div class="header sad">
            <div class="logo-and-text">
                <!--<img src="/inventory/images/imsicon.png" alt="Logo" class="rounded float-start">-->
                <h3 class="text-dark">CCS INVENTORY MANAGEMENT SYSTEM</h3>
            </div>
            <span class="text-muted">Borrower/<?php echo $row['usertype']; ?> Dashboard</span>
        </div>
        <div class="user--info">
            <div class="dropdown">
                <!-- Message Icon and Counter -->
                <a href="borrowerMessage.php" class="btn btn-secondary custom-dropdown-btn" type="button" id="messageDropdown" data-bs-toggle="messagedropdown" aria-expanded="false">
                    <i class="fas fa-envelope fs-5 me-1"></i> <!-- Message icon -->
                    <sup class="badge bg-danger"><?php echo $unreadMessages; ?></sup> <!-- Message counter -->
                </a>
<!-- Notification Icon and Counter -->
<button class="btn btn-secondary custom-dropdown-btn mr-2" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-bell fs-5 me-1"></i> <!-- Add the correct Font Awesome bell icon class -->
    <sup class="badge bg-danger" id="notificationCounter"><?php echo $notificationCount; ?></sup>
</button>
<!-- Notification Dropdown Menu -->
<ul class="dropdown-menu" aria-labelledby="notificationDropdown" id="notificationMenu">
    <div class="notification-header">
        <h5><i class="fas fa-bell fs-5 ms-1 me-1"></i>Notifications</h5>
    </div>        
    <?php
// Fetch notifications from tblborrowingreports for the logged-in borrower ID
$query = "SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqborrow AS datetime, 'request to borrow' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimereqborrow IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqborrow
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqreservation AS datetime, 'request to reserve' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimereqreservation IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqreservation
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datimeapproved AS datetime, 'request to borrow: <strong>Approved</strong>' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datimeapproved IS NOT NULL
          GROUP BY br.borrowerid, br.datimeapproved
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimeapprovereserved AS datetime, 'request to reserve: <strong>Approved</strong>' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimeapprovereserved IS NOT NULL
          GROUP BY br.borrowerid, br.datetimeapprovereserved
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimecanceled AS datetime, 'cancel' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimecanceled IS NOT NULL
          GROUP BY br.borrowerid, br.datetimecanceled
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datimerejected AS datetime, 'request is rejected' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datimerejected IS NOT NULL
          GROUP BY br.borrowerid, br.datimerejected
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereturn AS datetime, 'returned' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimereturn IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereturn
          UNION
          SELECT br.id AS report_id, br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqreturn AS datetime, 'request to return' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.borrowerid = ?  -- Filter by borrower ID
          AND br.datetimereqreturn IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqreturn
          ORDER BY datetime DESC";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssss", $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId, $BorrowerId);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="notification-dropdown">';
            while ($row = mysqli_fetch_assoc($result)) {
                // Format datetime to include AM/PM
                $formattedDatetime = date('h:i:s A', strtotime($row['datetime']));

                // Calculate the time difference between now and the notification datetime
                $notificationDate = date('Y-m-d', strtotime($row['datetime']));
                $currentDate = date('Y-m-d');
                $dateDiff = strtotime($currentDate) - strtotime($notificationDate);

                // Determine the appropriate timeframe for the notification
                if ($dateDiff == 0) { // Today
                    $timeframe = "Today";
                } elseif ($dateDiff == 86400) { // Yesterday
                    $timeframe = "Yesterday";
                } elseif ($dateDiff < 259200) { // Less than 3 days
                    $days = round($dateDiff / 86400); // Calculate the number of days
                    $timeframe = "$days days ago";
                } elseif ($dateDiff < 604800) { // Less than 1 week
                    $timeframe = "Last Week";
                } elseif ($dateDiff < 2592000) { // Less than 1 month
                    $timeframe = "Last Month";
                } else {
                    $timeframe = "More than a month ago"; // Default to more than a month
                }

                // Determine the href based on the action
                $href = '#'; // Default href
                if ($row['action'] === 'request to borrow') {
                    $href = 'borrowerPendingborrowItems.php';
                } elseif ($row['action'] === 'request to borrow: <strong>Approved</strong>') {
                    $href = 'borrowerItemsBorrowed.php';
                } elseif ($row['action'] === 'request to reserve') {
                    $href = 'borrowerPendingReserve.php';
                } elseif ($row['action'] === 'request to reserve: <strong>Approved</strong>') {
                    $href = 'borrowerAcceptedReserve.php';
                } elseif ($row['action'] === 'cancel') {
                    $href = '#';  
                } elseif ($row['action'] === 'returned') {
                    $href = 'borrowerReturn.php'; // Change to appropriate URL for Return
                }

                // Explode the concatenated subcategories
                $subcategories = explode('|', $row['subcategories']);
                $subcategory_counts = array_count_values($subcategories);

                // Display each notification as a dropdown item
                echo '<li class="notification-item">';
                echo '<a href="' . $href . '" class="notification-link" style="text-decoration: none !important;">';

                echo '<div class="notification-content">';
                echo '<p class="notification-text">';
                echo '<i class="fas fa-user me-1"></i>You '. $row['action'] . ' item, ';

                // Display each subcategory with its count
                foreach ($subcategory_counts as $subcategory => $count) {
                    echo $subcategory . ($count > 1 ? "($count)" : "") . ', ';
                }

                echo '<br>' . $timeframe . ' ' . $formattedDatetime;
                echo '</p>';
                echo '</div>';
                echo '</a>';
                echo '</li>';
            }
            echo '</div>';
        } else {
            // Display a message if there are no notifications
            echo '<li><a class="dropdown-item" href="#">No notifications</a></li>';
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>
</ul>
                
<button class="btn btn-secondary dropdown-toggle custom-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <?php 
    if (isset($row)) {
        echo $row['fname'] . ' ' . $row['lname'];
        // Check if the user has a profile image
        if (!empty($row['id'])) {
            // Check if the profile image exists
            $profileImagePath = "/inventory/images/imageofusers/" . $row['id'] . ".png";
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                // If the user has a profile image, display it with a timestamp
                echo '<img src="' . $profileImagePath . '?' . time() . '" width="30" height="30px">';
            } else {
                // If the profile image does not exist, display the default image with a timestamp
                echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="30" height="30px">';
            }
        } else {
            // If senderId is empty, display the default image with a timestamp
            echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="30" height="30px">';
        }
        
    } else {
        // Retrieve user information based on the logged-in user ID
        $query = "SELECT fname, lname, id FROM tblusers WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['borrower_id']);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if ($result && mysqli_num_rows($result) > 0) {
                    $user_row = mysqli_fetch_assoc($result);
                    echo $user_row['fname'] . ' ' . $user_row['lname'];
                    if (!empty($user_row['id'])) {
                        // If the user has a profile image, display it
                        $profileImagePath = "/inventory/images/imageofusers/" . $user_row['id'] . ".png";
                        echo '<img src="' . $profileImagePath . '?' . time() . '" alt="userpicture" class="userpicture" width="50">';
                        //echo '<img src="/inventory/images/imageofusers/' . $user_row['id'] . '.png" alt="userpicture" class="userpicture" width="50">';
                    } else {
                        // If the user does not have a profile image, display the default image
                        //echo '<img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture" width="50">';
                        echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" alt="userpicture" class="userpicture" width="50">';
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    ?>
</button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <!-- Add your dropdown items here -->
                    <li><a class="dropdown-item" href="borrowerProfile.php?borrowerId=<?php echo $BorrowerId; ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="bwerlogout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    .notification-dropdown {
        max-height: 450px; /* Set a fixed height */
        overflow-y: auto; /* Add scrollbar if content exceeds the height */
        padding: 0; /* Remove default padding */
        width: 260px; /* Set a width for the dropdown */
    }

    .notification-item {
        list-style-type: none; /* Remove default list style */
        background-color: #fff; /* Background color for each notification item */
        border-bottom: 1px solid #ddd; /* Add border between items */
    }

    .notification-item:hover {
        background-color: #f8f9fa; /* Background color on hover */
    }

    .notification-dropdown::-webkit-scrollbar {
        display: none; /* Hide the scrollbar */
    }

    .notification-content {
        padding: 10px;
    }

    .notification-text {
        margin: 0;
        font-size: 14px;
        color: #212529;
    }
    .header--wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    }

    .user--info {
        display: flex;
        align-items: center;
        background-color: transparent !important;
    }
    .custom-dropdown-btn {
        background-color: transparent !important; /* Set background to transparent */
        border: none !important; /* Remove border */
        color: #000 !important; /* Set text color */
    }

    .custom-dropdown-btn:hover {
        background-color: transparent !important; /* Set background to transparent on hover */
    }

    .dropdown img {
        width: 30px;
        height: 30px;
        cursor: pointer;
        border-radius: 50%;
        margin-left: 5px;
    }

</style>