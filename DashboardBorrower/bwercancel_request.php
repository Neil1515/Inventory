<!-- bwercancel_request.php -->
<?php
// Include your database connection file here
include "bwerfunctions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    date_default_timezone_set('Asia/Manila');
    $datetimecanceled = date("Y-m-d H:i:s");

    // Update the database
    $query = "UPDATE tblborrowingreports SET itemreqstatus = 'Canceled', datetimecanceled = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $datetimecanceled, $itemId);
        if (mysqli_stmt_execute($stmt)) {
            // Request canceled successfully

            // Update status of the item in tblitembrand table to 'Available'
            $update_query = "UPDATE tblitembrand SET status = 'Available' WHERE id = (SELECT itemid FROM tblborrowingreports WHERE id = ?)";
            $update_stmt = mysqli_prepare($con, $update_query);
            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "i", $itemId);
                if (mysqli_stmt_execute($update_stmt)) {
                    // Close the database connection
                    mysqli_close($con);
                    // Output success message
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => 'Failed to update item status']);
                }
            } else {
                echo json_encode(['error' => 'Failed to prepare update statement']);
            }
        } else {
            echo json_encode(['error' => 'Failed to cancel request']);
        }
    } else {
        echo json_encode(['error' => 'Database error']);
    }
} else {
    // Invalid request
    echo json_encode(['error' => 'Invalid request']);
}
?>
