<!-- ccsmessage_count.php -->
<?php
// Include necessary files
include('ccsfunctions.php');


// Initialize unread message count
$unreadMessages = 0;
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user ID
$staffId = $_SESSION['staff_id'];

// Query to count unread messages for the current recipient
$query = "SELECT COUNT(DISTINCT m.sender_id) AS unread_count 
          FROM tblmessages m
          INNER JOIN tblmessage_recipients mr ON m.id = mr.message_id
          WHERE mr.recipient_id = ? AND mr.status = 'unread'";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $staffId);
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
