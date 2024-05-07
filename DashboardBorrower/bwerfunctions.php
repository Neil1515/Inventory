<!-- borrowerfunctions.php -->
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

// Retrieve user ID from session
$borrowerId = $_SESSION['borrower_id'];

// Update user's online_status to 'online'
$updateQuery = "UPDATE tblusers SET online_status = 'online' WHERE id = ?";
$stmt = mysqli_prepare($con, $updateQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);
    if (!mysqli_stmt_execute($stmt)) {
        // Handle the case when update fails
        // You might want to log the error or display an error message
        die('Failed to update online status: ' . mysqli_error($con));
    }
    mysqli_stmt_close($stmt);
} else {
    // Handle the case when statement preparation fails
    // You might want to log the error or display an error message
    die('Statement preparation failed: ' . mysqli_error($con));
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

// Update status to 'Available' in tblitembrand
$queryUpdateItemStatus = "UPDATE tblitembrand SET status = 'Available' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE itemreqstatus = 'Expired Reservation' AND datetimereserve < ?)";
$stmtUpdateItemStatus = mysqli_prepare($con, $queryUpdateItemStatus);

if ($stmtUpdateItemStatus) {
    mysqli_stmt_bind_param($stmtUpdateItemStatus, "s", $currentDateTime);
    if (!mysqli_stmt_execute($stmtUpdateItemStatus)) {
        // Handle the case when update fails
        // You might want to log the error or display an error message
        die('Failed to update item status in tblitembrand: ' . mysqli_error($con));
    }
    mysqli_stmt_close($stmtUpdateItemStatus);
} else {
    // Handle the case when statement preparation fails
    // You might want to log the error or display an error message
    die('Statement preparation failed: ' . mysqli_error($con));
}

?>

<script>
// Send AJAX request to update online status to 'offline' when browser is closed
window.addEventListener("beforeunload", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "bwerupdate_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("borrowerId=<?php echo $borrowerId; ?>&status=offline");
});
</script>
