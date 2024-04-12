<!-- ccsupdate_date_timeofreservation.php -->
<?php
include 'ccsfunctions.php';

// Get the itemId and updatedDateTime from the POST data
$itemId = $_POST['itemId'];
$updatedDateTime = $_POST['updatedDateTime'];

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get the current date and time in the Philippines timezone
$updatereservation = date("Y-m-d H:i:s");

// Update datetimereserve and updatereservation for all items associated with the same reservation
$queryUpdate = "UPDATE tblborrowingreports SET datetimereserve = ?, updatereservation = ? WHERE id IN (SELECT id FROM tblborrowingreports WHERE datetimereserve = (SELECT datetimereserve FROM tblborrowingreports WHERE id = ?))";
$stmtUpdate = mysqli_prepare($con, $queryUpdate);

if ($stmtUpdate) {
    mysqli_stmt_bind_param($stmtUpdate, "ssi", $updatedDateTime, $updatereservation, $itemId);

    if (mysqli_stmt_execute($stmtUpdate)) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Failed to update datetimereserve']);
    }

    mysqli_stmt_close($stmtUpdate);
} else {
    // Return error response
    echo json_encode(['success' => false, 'error' => 'Statement preparation failed: ' . mysqli_error($con)]);
}
?>


