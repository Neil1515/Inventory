<!-- updateUserStatus.php -->
<?php
include 'ccsfunctions.php';

// Check if it's a GET request and the required parameters are set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'], $_GET['approveby'])) {
    // Get the user ID and approval information from the GET data
    $userId = $_GET['userId'];
    $approveby = $_GET['approveby'];
    date_default_timezone_set('Asia/Manila');
    $datetimeapprove = date("Y-m-d H:i:s");

    // Update user status and approval information in the database
    $query = "UPDATE tblusers SET status = 'Active', datetimeapprove = ?, addedbyid = ?, approveby = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Assume $_SESSION['staff_id'] contains the current staff ID
        $addedbyid = $_SESSION['staff_id'];

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sssi', $datetimeapprove, $addedbyid, $approveby, $userId);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: ccsstaffPendingAccounts.php?msg_success=User ID:'. urlencode("{$userId} Approved successfully"));
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

