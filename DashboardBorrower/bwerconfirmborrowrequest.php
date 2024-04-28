<!-- bwerconfirmborrowrequest.php -->
<?php
include "bwerfunctions.php";

$borrowerId = $_SESSION['borrower_id'];
// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $borrowerId);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $borrowername = $rowUser['fname'] . ' ' . $rowUser['lname'];
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}

// Initialize $itemsArray
$itemsArray = array();

// Check if items are passed via URL parameters
if(isset($_GET['items'])) {
    // Decode the JSON data
    $itemsJSON = urldecode($_GET['items']);
    $itemsArray = json_decode($itemsJSON, true); // Convert JSON string to associative array
}

if(isset($_POST['requestBorrow'])) {
    // Initialize variables
    $itemreqstatus = "Pending Borrow";
    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datetimereqborrow = date("Y-m-d H:i:s");
    
// Iterate over the items in the $itemsArray
foreach ($itemsArray as $item) {
    // Check if the item exists in tblitembrand and is available for borrowing
    $query = "SELECT id, subcategoryname, itembrand, borrowable, status FROM tblitembrand WHERE subcategoryname = ? AND itembrand = ? AND borrowable = 'Yes' AND status = 'Available'";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $item['subcategoryname'], $item['itembrand']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // If matching items are found
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $itemId, $subcategoryname, $itembrand, $borrowable, $status);

        // Initialize an array to store the IDs of available items
        $availableItemIds = [];

        // Loop through the results to store the IDs
        while (mysqli_stmt_fetch($stmt)) {
            // Add the ID to the array
            $availableItemIds[] = $itemId;
        }

        // Determine the quantity to borrow
        $quantityToBorrow = $item['count'];

        // Ensure there are enough available items to borrow
        if ($quantityToBorrow <= count($availableItemIds)) {
            // Select unique item IDs based on the quantity to borrow
            $borrowItemIds = array_slice($availableItemIds, 0, $quantityToBorrow);

            // Insert records into tblborrowingreports and update status for each item based on the quantity to borrow
            foreach ($borrowItemIds as $borrowItemId) {
                // Insert a new record into tblborrowingreports
                $query = "INSERT INTO tblborrowingreports (itemid, borrowerid, itemreqstatus, datetimereqborrow) VALUES (?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt_insert, "ssss", $borrowItemId, $borrowerId, $itemreqstatus, $datetimereqborrow);
                mysqli_stmt_execute($stmt_insert);

                // Update the status of the item to "Pending Borrow" in tblitembrand
                $query = "UPDATE tblitembrand SET status = ? WHERE id = ?";
                $stmt_update_status = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt_update_status, "ss", $itemreqstatus, $borrowItemId);
                mysqli_stmt_execute($stmt_update_status);
            }
        } else {
            // Log an error or handle the case where there are not enough available items
            error_log("Not enough available items to borrow for subcategory: " . $item['subcategoryname'] . " and itembrand: " . $item['itembrand']);
        }
    }
}
    // Optionally, you can redirect the user to a confirmation page
    echo "<script>window.location.href='borrowerDashboardPage.php?msg_success=Successfully Requesting Borrow, Please await for CCS Staff for approval';</script>";
    exit();
} else {
    error_log("Statement preparation failed for inserting into tblborrowingreports or updating tblitembrand: " . mysqli_error($con));
}
?>
<main class="ccs-main-container">
    <form action="" method="post" enctype="multipart/form-data" name="requestBorrowForm">
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-12"> <!-- Adjusted column size for the left side -->
                    <div class="d-flex justify-content-between mb-1">
                        <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Confirmation of Borrowing Request</h3>
                        <div class="text-end">
                            <!--<input type="text" class="form-control search-input mb-1" placeholder="Search" name="search" id="searchInput">-->
                            <a href="borrowerDashboardPage.php" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-success" name="requestBorrow" onclick="showSwal('success-message')">Confirm Request</button>
                        </div>
                    </div>
                    <h6 class="text-danger ">Note: Any deformation or lost/damage of items borrowed are subject to replacement on your account.</h6>
                </div>
                <?php
                // Display each item in the same format as cards
                foreach($itemsArray as $item) {
                    // Check if an image exists
                    $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $item['subcategoryname'] . '.png';
                    if (!file_exists($imagePath)) {
                        // Use a default image if no image is uploaded
                        $imagePath = '/inventory/SubcategoryItemsimages/defaultimageitem.png';
                    }
                    // Output the item details in the card format
                    echo '
                    <div class="col-md-3 mb-1">
                        <div class="card">
                            <div class="text-center"> <!-- Center the image -->
                                <img src="' . $imagePath . '" class="card-img-top" alt="Item Image" style="max-width: 80px; max-height: 80px;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . $item['subcategoryname'] . '</h5>';
                    // Check if item brand exists and is not empty before displaying
                    if(isset($item['itembrand']) && !empty($item['itembrand'])) {
                        echo '<p class="card-text">Item Description <br>' . $item['itembrand'] . '</p>';
                    }
                    
                    echo '<p class="card-text">Quantity: ' . $item['count'] . '</p>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </form>
</main>

