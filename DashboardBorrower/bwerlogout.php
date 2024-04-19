<?php
// bwerlogout.php
session_start();

// Include necessary files
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user ID from session
$borrowerId = $_SESSION['borrower_id'];

// Update user's online_status to 'offline'
$updateQuery = "UPDATE tblusers SET online_status = 'offline' WHERE id = ?";
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

// Unset all session variables
//$_SESSION = array();

// Destroy the session
//session_destroy();

// Redirect to the login page
header('Location: /Inventory/index.php');
exit();
?>
