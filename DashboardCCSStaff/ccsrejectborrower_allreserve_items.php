<!-- ccsrejectborrower_allreserve_items.php -->
<?php
// Include your database connection file
include 'ccsfunctions.php';

// Start the session
session_start();

// Fetch staff ID from the session
$staffId = $_SESSION['staff_id'] ?? 0; // Use 0 as a default value or handle it based on your application logic

// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname, id FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $staffId);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser && $rowUser = mysqli_fetch_assoc($resultUser)) {
        $staffname = $rowUser['fname'] . ' ' . $rowUser['lname'];
        $rejectedbyid = $rowUser['id'];
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}

// Check if the borrowerId is provided in the query string
if (isset($_GET['borrowerId'])) {
    $borrowerId = $_GET['borrowerId'];

    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datimerejected = date("Y-m-d H:i:s");

    // Use $rejectedbyid directly from $rowUser
    $rejectedbyid = $rowUser['id'];

    // Update the itemreqstatus to 'Rejected', rejectedbyid, and datimerejected for the specified borrower
    $queryUpdateStatus = "UPDATE tblborrowingreports SET itemreqstatus = 'Rejected', rejectedbyid = ?, datimerejected = ? WHERE borrowerid = ? AND itemreqstatus = 'Pending Reserve'";
    $stmtUpdateStatus = mysqli_prepare($con, $queryUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "iss", $rejectedbyid, $datimerejected, $borrowerId);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Update the status in tblitembrand to 'Available' for the Rejected items
            $queryUpdateItemStatus = "UPDATE tblitembrand SET status = 'Available' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Rejected')";
            $stmtUpdateItemStatus = mysqli_prepare($con, $queryUpdateItemStatus);

            if ($stmtUpdateItemStatus) {
                mysqli_stmt_bind_param($stmtUpdateItemStatus, "i", $borrowerId);

                if (mysqli_stmt_execute($stmtUpdateItemStatus)) {
                    echo "<script>window.location.href='ccsstaffUsersPendingReserveItems.php?msg_success=Items reject successfully';</script>";
                    //echo 'Items Rejected successfully!';
                } else {
                    echo 'Error updating item statuses in tblitembrand: ' . mysqli_stmt_error($stmtUpdateItemStatus);
                }

                mysqli_stmt_close($stmtUpdateItemStatus);
            } else {
                echo 'Statement preparation failed for tblitembrand: ' . mysqli_error($con);
            }
        } else {
            echo 'Error updating item statuses in tblborrowingreports: ' . mysqli_stmt_error($stmtUpdateStatus);
        }

        mysqli_stmt_close($stmtUpdateStatus);
    } else {
        echo 'Statement preparation failed for tblborrowingreports: ' . mysqli_error($con);
    }
} else {
    echo 'Borrower ID not provided in the query string.';
}
?>
