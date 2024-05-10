<!-- ccsfunctions.php -->
<?php
// Database connection
$servername = 'localhost';
$db_id = 'root';
$db_password = '';
$db_name = 'maininventorydb';

// Attempt to connect to the database
$con = mysqli_connect($servername, $db_id, $db_password, $db_name);

// Check for connection errors
if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Retrieve current date and time
date_default_timezone_set('Asia/Manila');
$currentDateTime = date("Y-m-d H:i:s");

// Update expired reservations in tblborrowingreports
$queryUpdateExpiredReservations = "UPDATE tblborrowingreports SET itemreqstatus = 'Expired Reservation'  WHERE (itemreqstatus = 'Approve Reserve' OR itemreqstatus = 'Pending Reserve') AND datetimereserve < ?";
$stmtUpdateExpiredReservations = mysqli_prepare($con, $queryUpdateExpiredReservations);

if ($stmtUpdateExpiredReservations) {
    mysqli_stmt_bind_param($stmtUpdateExpiredReservations, "s", $currentDateTime);
    if (!mysqli_stmt_execute($stmtUpdateExpiredReservations)) {
        // Handle the case when update fails
        // You might want to log the error or display an error message
        die('Failed to update expired reservations in tblborrowingreports: ' . mysqli_error($con));
    }
    mysqli_stmt_close($stmtUpdateExpiredReservations);
} else {
    // Handle the case when statement preparation fails
    // You might want to log the error or display an error message
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>
