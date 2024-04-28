<!-- bwermessage_count.php -->
<?php
// Include necessary files
include('bwerfunctions.php');

// Initialize unread message count
$unreadMessages = 0;

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user ID
$borrowerId = $_SESSION['borrower_id'];

// Query to count unread messages for the current borrower
$query = "SELECT COUNT(*) AS unread_count FROM tblmessage_recipients WHERE recipient_id = ? AND status = 'unread'";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch unread message count
            $row = mysqli_fetch_assoc($result);
            $unreadMessages = $row['unread_count'];
        }
    } else {
        // Handle query execution error
        echo "Error executing query: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt);
} else {
    // Handle query preparation error
    echo "Error preparing statement: " . mysqli_error($con);
}
?>
