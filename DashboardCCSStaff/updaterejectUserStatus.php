<!-- updaterejectUserStatus.php -->
<?php
include 'ccsfunctions.php';

// Check if it's a GET request and the required parameter is set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
    // Get the user ID from the GET data
    $userId = $_GET['userId'];

    // Delete the user from the database
    $query = "DELETE FROM tblusers WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'i', $userId);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: ccsstaffPendingAccounts.php?msg_success=User ID:' . urlencode("{$userId} Rejected successfully"));
            exit();
        } else {
            echo "Failed: " . mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
    }
} else {
    echo "Invalid request.";
}
?>
