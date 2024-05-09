<!-- bwercancel_itemreqstatus.php -->
<?php
// Include your database connection file here
include 'bwerfunctions.php';

// Check if itemId is set and not empty
if (isset($_POST['itemId']) && !empty($_POST['itemId'])) {
    // Sanitize input
    $itemId = $_POST['itemId'];

    // Update itemreqstatus and set datetimereqreturn to NULL for the specified itemId
    $query = "UPDATE tblborrowingreports SET itemreqstatus = 'Approved', datetimereqreturn = NULL WHERE id = ? AND itemreqstatus = 'Request Return'";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $itemId);
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Return success message
                echo "Item request status updated successfully.";
            } else {
                // No rows affected, item request status may not be 'Approved'
                echo "Item request status is not 'Request Return' or item not found.";
            }
            // Return success message and redirect script
            //echo "<script>window.location.href='borrowerItemsBorrowed.php?msg_success=Item request status updated successfully.';</script>";
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

