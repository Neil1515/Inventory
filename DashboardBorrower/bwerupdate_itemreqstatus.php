<!-- bwerupdate_itemreqstatus.php -->
<?php
// Include your database connection file here
include 'bwerfunctions.php';

// Check if itemId is set and not empty
if (isset($_POST['itemId']) && !empty($_POST['itemId'])) {
    // Sanitize input
    $itemId = $_POST['itemId'];

    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datetimereqreturn = date("Y-m-d H:i:s");

    // Update itemreqstatus and datetimereqreturn for the specified itemId
    $query = "UPDATE tblborrowingreports SET itemreqstatus = 'Request Return', datetimereqreturn = ? WHERE id = ? AND itemreqstatus = 'Approved'";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $datetimereqreturn, $itemId);
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Return success message
                echo "Item request status updated successfully.";
            } else {
                // No rows affected, item request status may not be 'Approved'
                echo "Item request status is not 'Approved' or item not found.";
            }
        } else {
            // Return error message
            echo "Error updating item request status: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        // Return error message
        echo "Statement preparation failed: " . mysqli_error($con);
    }
} else {
    // Return error message if itemId is not set or empty
    echo "Invalid request.";
}
?>

