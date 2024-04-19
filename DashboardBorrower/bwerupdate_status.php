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

// Check if borrowerId and status are set
if (isset($_POST['borrowerId']) && isset($_POST['status'])) {
    // Sanitize input
    $borrowerId = mysqli_real_escape_string($con, $_POST['borrowerId']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Update user's online_status to the provided status
    $updateQuery = "UPDATE tblusers SET online_status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $status, $borrowerId);
        if (mysqli_stmt_execute($stmt)) {
            // Status updated successfully
            echo "Status updated to $status";
        } else {
            // Handle the case when update fails
            echo "Failed to update status: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        // Handle the case when statement preparation fails
        echo "Statement preparation failed: " . mysqli_error($con);
    }
} else {
    // Handle the case when borrowerId or status is not set
    echo "Borrower ID or status not provided";
}

// Close the database connection
mysqli_close($con);
?>
