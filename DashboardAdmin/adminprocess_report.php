<?php
// process_report.php

// Assuming you have a valid database connection here
$servername = 'localhost';
$db_id = 'root';
$db_password = '';
$db_name = 'maininventorydb';

// Attempt to connect to the database
$con = mysqli_connect($servername, $db_id, $db_password, $db_name);

// Check for connection errors
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'approve_report' button was clicked
    if (isset($_POST['approve_report'])) {
        // Get the report ID from the form
        $reportId = $_POST['report_id'];

        // Update the status in tblreportborroweracc to 'Approved'
        $updateQuery = "UPDATE tblreportborroweracc SET status = 'Approved' WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "s", $reportId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Get the borrower ID from tblreportborroweracc
        $getBorrowerIdQuery = "SELECT borrowerid FROM tblreportborroweracc WHERE id = ?";
        $stmt = mysqli_prepare($con, $getBorrowerIdQuery);
        mysqli_stmt_bind_param($stmt, "s", $reportId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $borrowerId = $row['borrowerid'];
        mysqli_stmt_close($stmt);

        // Update the status in tblusers to 'Blocked' for the borrower
        $updateUserStatusQuery = "UPDATE tblusers SET status = 'Blocked' WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateUserStatusQuery);
        mysqli_stmt_bind_param($stmt, "s", $borrowerId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect back to the adminreportedborrower.php page with a success message
        header('Location: adminreportedborrower.php?msg=Report approved successfully.');
        exit();
    } elseif (isset($_POST['decline_report'])) {
        // If the 'decline_report' button was clicked, update the status in tblreportborroweracc to 'Declined'
        $reportId = $_POST['report_id'];
        $updateQuery = "UPDATE tblreportborroweracc SET status = 'Declined' WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "s", $reportId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect back to the adminreportedborrower.php page with a success message
        header('Location: adminreportedborrower.php?msg=Report declined successfully.');
        exit();
    } elseif (isset($_POST['unblock_report'])) {
        // If the 'unblock_report' button was clicked, update the status in tblusers to 'Available' for the borrower
        // and update the status in tblreportborroweracc to 'Unblock'
        $reportId = $_POST['report_id'];
    
        // Get the borrower ID from tblreportborroweracc
        $getBorrowerIdQuery = "SELECT borrowerid FROM tblreportborroweracc WHERE id = ?";
        $stmt = mysqli_prepare($con, $getBorrowerIdQuery);
        mysqli_stmt_bind_param($stmt, "s", $reportId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $borrowerId = $row['borrowerid'];
        mysqli_stmt_close($stmt);
    
        // Update the status in tblusers to 'Available' for the borrower
        $updateUserStatusQuery = "UPDATE tblusers SET status = 'Active' WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateUserStatusQuery);
        mysqli_stmt_bind_param($stmt, "s", $borrowerId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        // Update the status in tblreportborroweracc to 'Unblock'
        $updateReportStatusQuery = "UPDATE tblreportborroweracc SET status = 'Unblock' WHERE id = ?";
        $stmt = mysqli_prepare($con, $updateReportStatusQuery);
        mysqli_stmt_bind_param($stmt, "s", $reportId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        // Redirect back to the adminreportedborrower.php page with a success message
        header('Location: adminreportedborrower.php?msg=Borrower unblocked successfully.');
        exit();
    }
} else {
    // If the request method is not POST, redirect to the adminreportedborrower.php page
    header('Location: adminreportedborrower.php');
    exit();
}
?>
