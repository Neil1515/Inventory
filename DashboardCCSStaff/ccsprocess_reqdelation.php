<!-- ccsprocess_reqdelation.php -->
<?php
include('ccsfunctions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["approve_reqdelation"])) {
        $reportId = $_POST["report_id"];

        // Fetch item ID from the pending item removal request
        $sqlSelect = "SELECT itemid FROM `tblpendingitemremoval` WHERE id = ?";
        $stmtSelect = mysqli_prepare($con, $sqlSelect);
        
        if ($stmtSelect) {
            mysqli_stmt_bind_param($stmtSelect, "i", $reportId);
            mysqli_stmt_execute($stmtSelect);
            $result = mysqli_stmt_get_result($stmtSelect);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $itemId = $row['itemid'];

                // Delete item from tblitembrand
                $sqlDelete = "DELETE FROM `tblitembrand` WHERE id = ?";
                $stmtDelete = mysqli_prepare($con, $sqlDelete);

                if ($stmtDelete) {
                    mysqli_stmt_bind_param($stmtDelete, "i", $itemId);
                    if (mysqli_stmt_execute($stmtDelete)) {
                        // Delete the pending item removal request
                        $sqlDeleteRequest = "DELETE FROM `tblpendingitemremoval` WHERE id = ?";
                        $stmtDeleteRequest = mysqli_prepare($con, $sqlDeleteRequest);

                        if ($stmtDeleteRequest) {
                            mysqli_stmt_bind_param($stmtDeleteRequest, "i", $reportId);
                            if (mysqli_stmt_execute($stmtDeleteRequest)) {
                                // Redirect back to ccsitemapproval.php with success message
                                header("Location: ccsstaffItemAproval.php?msg_success=Item deletion request approved successfully.");
                                exit();
                            } else {
                                // Log the error instead of displaying to users
                                error_log("Failed to delete pending item removal request: " . mysqli_error($con));
                                // Redirect back to ccsitemapproval.php with error message
                                header("Location: ccsstaffItemAproval.php?msg_error=Error approving item deletion request.");
                                exit();
                            }
                        }
                    } else {
                        // Log the error instead of displaying to users
                        error_log("Failed to delete item from tblitembrand: " . mysqli_error($con));
                        // Redirect back to ccsitemapproval.php with error message
                        header("Location: ccsstaffItemAproval.php?msg_error=Error approving item deletion request.");
                        exit();
                    }
                }
            } else {
                // Redirect back to ccsitemapproval.php with error message
                header("Location: ccsstaffItemAproval.php?msg_error=Item deletion request not found.");
                exit();
            }
        }
    } elseif (isset($_POST["decline_reqdelation"])) {
        $reportId = $_POST["report_id"];

        // Delete the pending item removal request
        $sqlDeleteRequest = "DELETE FROM `tblpendingitemremoval` WHERE id = ?";
        $stmtDeleteRequest = mysqli_prepare($con, $sqlDeleteRequest);

        if ($stmtDeleteRequest) {
            mysqli_stmt_bind_param($stmtDeleteRequest, "i", $reportId);
            if (mysqli_stmt_execute($stmtDeleteRequest)) {
                // Redirect back to ccsitemapproval.php with success message
                header("Location: ccsstaffItemAproval.php?msg_success=Item deletion request declined successfully.");
                exit();
            } else {
                // Log the error instead of displaying to users
                error_log("Failed to delete pending item removal request: " . mysqli_error($con));
                // Redirect back to ccsitemapproval.php with error message
                header("Location: ccsstaffItemAproval.php?msg_error=Error declining item deletion request.");
                exit();
            }
        }
    }
} else {
    // Redirect back to ccsitemapproval.php if accessed directly
    header("Location: ccsstaffItemAproval.php");
    exit();
}
?>
