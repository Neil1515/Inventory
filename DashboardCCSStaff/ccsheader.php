<!-- ccsheader.php -->
<?php
// Include necessary files
include('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);
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
?>
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

</style>
<div class="container-fluid">
    <div class="header--wrapper py-2">
        <div class="header sad">
            <div class="logo-and-text">
                <!--<img src="/inventory/images/imsicon.png" alt="Logo" class="rounded float-start">-->
                <h3 class="text-dark">CCS INVENTORY MANAGEMENT SYSTEM</h3>
            </div>
            <span class="text-muted">Staff Dashboard</span>
        </div>
        <div class="user--info">
            <div class="dropdown">
                <!-- Message Icon and Counter -->
                <a href="ccsstaffMessaging.php" class="btn btn-secondary custom-dropdown-btn" type="button" id="messageDropdown" data-bs-toggle="messagedropdown" aria-expanded="false">
                    <i class="fas fa-envelope fs-5 me-1"></i> <!-- Message icon -->
                    <sup class="badge bg-danger">0</sup> <!-- Notification counter -->
                </a>

               <!-- Notification Icon and Counter -->
                <button href="ccsstaffNotifications.php" class="btn btn-secondary custom-dropdown-btn" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fs-5 me-1"></i> <!-- Add the correct Font Awesome bell icon class -->
                    <sup class="badge bg-danger" id="notificationCounter">0</sup>
                </button>

<!-- Notification Dropdown Menu -->
<ul class="dropdown-menu" aria-labelledby="notificationDropdown" id="notificationMenu">
    <div class="notification-header">
        <h5><i class="fas fa-bell fs-5 ms-1 me-1"></i>Notifications</h5>
    </div>
    <?php
// Fetch notifications from tblborrowingreports
$query = "SELECT br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqborrow AS datetime, 'request to borrow' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.datetimereqborrow IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqborrow
          UNION
          SELECT br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqreservation AS datetime, 'request to reserve' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.datetimereqreservation IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqreservation
          UNION
          SELECT br.borrowerid, u.fname, u.lname, GROUP_CONCAT(ib.subcategoryname SEPARATOR '|') AS subcategories, br.datetimereqreturn AS datetime, 'request to returned' AS action 
          FROM tblborrowingreports br
          JOIN tblusers u ON br.borrowerid = u.id
          JOIN tblitembrand ib ON FIND_IN_SET(ib.id, br.itemid)
          WHERE br.datetimereqreturn IS NOT NULL
          GROUP BY br.borrowerid, br.datetimereqreturn
          ORDER BY datetime DESC";

$result = mysqli_query($con, $query);

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
            $borrowerId = $row['borrowerid']; // Get borrower ID
            $href = 'ccsstaffViewBorrower_all_items.php?borrowerId=' . $borrowerId; // Set appropriate URL for Request to borrow
        } elseif ($row['action'] === 'request to reserve') {
            $borrowerId = $row['borrowerid']; // Get borrower ID
            $href = 'ccsstaffViewBorrower_allreserve_items.php?borrowerId=' . $borrowerId; // Set appropriate URL for Request to borrow
        } elseif ($row['action'] === 'request to returned') {
            $borrowerId = $row['borrowerid']; // Get borrower ID
            $href = 'ccsstaffViewUnreturnItems.php?borrower_id='. $borrowerId; // Change to appropriate URL for Return
        } elseif ($row['action'] === 'Returned') {
            $href = 'return.php'; // Change to appropriate URL for Return
        }

        // Explode the concatenated subcategories
        $subcategories = explode('|', $row['subcategories']);
        $subcategory_counts = array_count_values($subcategories);

        // Display each notification as a dropdown item
        echo '<li class="notification-item">';
        echo '<a href="' . $href . '" class="notification-link" style="text-decoration: none !important;">';

        echo '<div class="notification-content">';
        echo '<p class="notification-text">';
        // Check if the user has a profile image
        if (!empty($borrowerId)) {
            // Check if the profile image exists
            $profileImagePath = "/inventory/images/imageofusers/" . $borrowerId . ".png";
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                // If the user has a profile image, display it with a timestamp
                echo '<img src="' . $profileImagePath . '?' . time() . '" width="160">';
            } else {
                // If the profile image does not exist, display the default image with a timestamp
                echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="160">';
            }
        } else {
            // If senderId is empty, display the default image with a timestamp
            echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="160">';
        }

        echo '<strong> '.$row['fname'] . ' ' . $row['lname'] . '</strong> ';
        echo $row['action'] . ' item ';

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
?>
</ul>
                <button class="btn btn-secondary dropdown-toggle custom-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php 
                    if (isset($row)) {
                        echo $row['fname'] . ' ' . $row['lname'];
                    } else {
                        // Retrieve user information based on the logged-in user ID
                        $query = "SELECT fname, lname FROM tblusers WHERE id = ?";
                        $stmt = mysqli_prepare($con, $query);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "s", $_SESSION['staff_id']);
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $user_row = mysqli_fetch_assoc($result);
                                    echo $user_row['fname'] . ' ' . $user_row['lname'];
                                }
                            }
                            mysqli_stmt_close($stmt);
                        }
                    }
                    ?>
                    <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture">
                </button>

                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <!-- Add your dropdown items here -->
                    <li><a class="dropdown-item" href="ccsstafProfile.php?staffId=<?php echo $staffId; ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="/Inventory/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

