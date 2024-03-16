<!-- ccsreject_item.php -->
<?php
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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the item ID from the POST data
    $itemId = $_POST['itemId'];

    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datimerejected = date("Y-m-d H:i:s");

    // Update the item status in tblborrowingreports table
    $queryUpdateItemStatus = "UPDATE tblborrowingreports SET itemreqstatus = 'Rejected', rejectedbyid = ?, datimerejected = ?  WHERE id = ? AND itemreqstatus = 'Pending Borrow'";
    $stmtUpdateItemStatus = mysqli_prepare($con, $queryUpdateItemStatus);

    if ($stmtUpdateItemStatus) {
        mysqli_stmt_bind_param($stmtUpdateItemStatus, "isi", $rejectedbyid, $datimerejected, $itemId);
        
        if (mysqli_stmt_execute($stmtUpdateItemStatus)) {
            // Update the status of the corresponding item in tblitembrand table
            $queryUpdateItemBrandStatus = "UPDATE tblitembrand SET status = 'Available' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE id = ?)";
            $stmtUpdateItemBrandStatus = mysqli_prepare($con, $queryUpdateItemBrandStatus);
            
            if ($stmtUpdateItemBrandStatus) {
                mysqli_stmt_bind_param($stmtUpdateItemBrandStatus, "i", $itemId);
                
                if (mysqli_stmt_execute($stmtUpdateItemBrandStatus)) {
                    echo "<script>window.location.href='ccsstaffViewBorrower_all_items.php?msg_success=Item rejected successfully';</script>";
                } else {
                    // Log the error instead of displaying to users
                    error_log("Error updating item brand status: " . mysqli_error($con));
                    echo "Error updating item brand status. Please try again later.";
                }

                mysqli_stmt_close($stmtUpdateItemBrandStatus);
            } else {
                // Log the error instead of displaying to users
                error_log("Error preparing statement for item brand status: " . mysqli_error($con));
                echo "Error preparing statement for item brand status. Please try again later.";
            }
        } else {
            // Log the error instead of displaying to users
            error_log("Error updating item status: " . mysqli_error($con));
            echo "Error updating item status. Please try again later.";
        }

        mysqli_stmt_close($stmtUpdateItemStatus);
    } else {
        // Log the error instead of displaying to users
        error_log("Error preparing statement: " . mysqli_error($con));
        echo "Error preparing statement. Please try again later.";
    }
} else {
    // If the request is not a POST request, return an error
    echo "Invalid request method!";
}
?>
