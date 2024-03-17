<!-- ccsstaffDashboardPage.php -->
<?php
session_start();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Message</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
                <?php include('ccsheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('ccssidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
            <?php
                if (isset($_GET["msg_success"])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_success"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                
                if (isset($_GET["msg_fail"])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_fail"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if (isset($_GET["msg"])) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo $_GET["msg"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                ?>
                <div class="row">
                <div class="col-md-9">
            <!-- Display messages -->
            <div class="list-group">
                <h5 class="list-group-item list-group-item-action active" aria-current="true">Latest Messages</h5>
                <?php
// Fetch the most recent message sent by each user based on timestamp
$user_messages_query = "SELECT u.fname, u.lname, m.message, m.timestamp
                        FROM tblusers u
                        INNER JOIN tblmessages m ON u.id = m.sender_id
                        INNER JOIN (
                            SELECT sender_id, MAX(timestamp) AS max_timestamp
                            FROM tblmessages
                            GROUP BY sender_id
                        ) latest_msg ON m.sender_id = latest_msg.sender_id AND m.timestamp = latest_msg.max_timestamp
                        WHERE u.usertype != 'CCS Staff' AND u.status = 'Active'
                        ORDER BY m.timestamp DESC"; // Order by timestamp in descending order
                        $user_messages_result = mysqli_query($con, $user_messages_query);

                        if ($user_messages_result && mysqli_num_rows($user_messages_result) > 0) {
                            while ($user_message_row = mysqli_fetch_assoc($user_messages_result)) {
                                echo '<a href="#" class="list-group-item list-group-item-action">';
                                echo '<div class="d-flex w-100 justify-content-between">';
                                echo '<h7 class="mb-1">' . $user_message_row['fname'] . ' ' . $user_message_row['lname'] . '</h7>';
                                echo '<small class="text-muted">' . date('F j, Y, g:i a', strtotime($user_message_row['timestamp'])) . '</small>';
                                echo '</div>';
                                echo '<p class="mb-1">Message: ' . $user_message_row['message'] . '</p>'; // Display the most recent message
                                echo '</a>';
                            }
                        } else {
                            echo '<a href="#" class="list-group-item list-group-item-action">No users found.</a>';
                        }
                        ?>
            </div>
        </div>

        <div class="col-md-3">
    <!-- Display users in scrollable list group format -->
        <div class="list-group" style="max-height: 600px; overflow-y: auto;">
            <style>
                /* Hide the scrollbar */
                .list-group::-webkit-scrollbar {
                    display: none;
                }
            </style>
            <h5 class="list-group-item list-group-item-action active" aria-current="true">Users</h5>
            <?php
            $user_query = "SELECT * FROM tblusers WHERE usertype <> 'CCS Staff' AND usertype <> 'Admin' AND status = 'Active'";
            $user_result = mysqli_query($con, $user_query);

            if ($user_result && mysqli_num_rows($user_result) > 0) {
                while ($user_row = mysqli_fetch_assoc($user_result)) {
                    echo '<a href="#" class="list-group-item list-group-item-action">';
                    echo '<div class="d-flex w-100 justify-content-between">';
                    echo '<h7 class="mb-1">' . $user_row['fname'] . ' ' . $user_row['lname'] . '</h7>';
                    echo '</div>';
                    echo '<h9 class="mb-1">' . $user_row['usertype'] . '</h9>';
                    echo '</a>';
                }
            } else {
                echo '<a href="#" class="list-group-item list-group-item-action">No users found.</a>';
            }
            ?>
        </div>

        </div>

        </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>