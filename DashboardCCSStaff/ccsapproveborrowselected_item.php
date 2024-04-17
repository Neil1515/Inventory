<!-- ccsapproveborrowselected_item.php -->
<?php
// Include necessary files and initialize the database connection
include('ccsfunctions.php');
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
        $approvebyid = $rowUser['id'];
    } else {
        // Log the error
        error_log("Failed to fetch user data: " . mysqli_error($con));
        exit(json_encode(array('success' => false, 'error' => 'Failed to fetch user data.')));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
    exit(json_encode(array('success' => false, 'error' => 'Failed to prepare statement for user data.')));
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if itemIds is set in the POST data
    if (isset($_POST["itemIds"]) && !empty($_POST["itemIds"])) {
        // Retrieve the itemIds array from POST data
        $itemIds = $_POST["itemIds"];

        // Get the current staff ID from the session or adjust this part as per your authentication mechanism
        session_start();
        $staffId = $_SESSION['staff_id']; // Adjust this based on your session variable storing staff ID

        date_default_timezone_set('Asia/Manila');
        // Get the current date and time
        $datimeapproved = date('Y-m-d H:i:s');

        // Prepare and execute the query to update tblborrowingreports
        $queryUpdateItemStatus = "UPDATE tblborrowingreports SET itemreqstatus = 'Approved', approvebyid = ?, datimeapproved = ? WHERE id = ? AND itemreqstatus = 'Approve Reserve'";
        $stmtUpdateItemStatus = mysqli_prepare($con, $queryUpdateItemStatus);

        if ($stmtUpdateItemStatus) {
            foreach ($itemIds as $itemId) {
                mysqli_stmt_bind_param($stmtUpdateItemStatus, "isi", $staffId, $datimeapproved, $itemId);
                mysqli_stmt_execute($stmtUpdateItemStatus);
            }
            mysqli_stmt_close($stmtUpdateItemStatus);

            // Prepare the response data
            $response = array('success' => true);
            echo json_encode($response); // Return success response here
        } else {
            // Handle statement preparation error
            die('Statement preparation failed: ' . mysqli_error($con));
        }


        // Prepare and execute the query to update tblitembrand
        $queryUpdateItemBrandStatus = "UPDATE tblitembrand SET status = 'Borrowed' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE id = ?)";
        $stmtUpdateItemBrandStatus = mysqli_prepare($con, $queryUpdateItemBrandStatus);

        if ($stmtUpdateItemBrandStatus) {
            foreach ($itemIds as $itemId) {
                mysqli_stmt_bind_param($stmtUpdateItemBrandStatus, "i", $itemId);
                mysqli_stmt_execute($stmtUpdateItemBrandStatus);
            }
            mysqli_stmt_close($stmtUpdateItemBrandStatus);
        } else {
            // Handle statement preparation error
            die('Statement preparation failed: ' . mysqli_error($con));
        }

        // Prepare the response data
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        // If itemIds is not set or empty, prepare error response
        $response = array('success' => false, 'error' => 'No item IDs provided');
        echo json_encode($response);
    }
} else {
    // If the request method is not POST, prepare error response
    $response = array('success' => false, 'error' => 'Invalid request method');
    echo json_encode($response);
}
?>
