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

if (isset($_POST['requestBorrow'])) {
    // Assuming you have an active database connection stored in $con
    if ($con) {
        // Initialize variables
        $itemreqstatus = "Pending Borrow";
        // Set the timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');

        // Get the current date and time in the Philippines timezone
        $datetimereqborrow = date("Y-m-d H:i:s");

        // Use a prepared statement to prevent SQL injection
        $sqlInsert = "INSERT INTO `tblborrowingreports` (itemid, borrowerid, itemreqstatus, datetimereqborrow) VALUES (?, ?, ?, ?)";

        // Use a prepared statement to prevent SQL injection
        $stmtInsert = mysqli_prepare($con, $sqlInsert);

        // Use a prepared statement to update the status in tblitembrand
        $sqlUpdateItemStatus = "UPDATE `tblitembrand` SET status = ? WHERE id = ?";
        $stmtUpdateItemStatus = mysqli_prepare($con, $sqlUpdateItemStatus);

        if ($stmtInsert && $stmtUpdateItemStatus) {
            // Initialize $selectedItemIds array inside the condition
            $selectedItemIds = isset($_POST['selectedItemIds']) ? $_POST['selectedItemIds'] : [];
            // Loop through each selected item ID
            foreach ($selectedItemIds as $itemid) {
                // Bind parameters inside the loop for each item
                mysqli_stmt_bind_param($stmtInsert, "iiss", $itemid, $borrowerId, $itemreqstatus, $datetimereqborrow);

                // Execute the statement for inserting into tblborrowingreports
                mysqli_stmt_execute($stmtInsert);

                // Bind parameters for updating status in tblitembrand
                mysqli_stmt_bind_param($stmtUpdateItemStatus, "si", $itemreqstatus, $itemid);

                // Execute the statement for updating status in tblitembrand
                mysqli_stmt_execute($stmtUpdateItemStatus);
            }

            // Close the statements
            mysqli_stmt_close($stmtInsert);
            mysqli_stmt_close($stmtUpdateItemStatus);

            // Optionally, you can redirect the user to a confirmation page
            echo "<script>window.location.href='borrowerDashboardPage.php?msg_success=Successfully Requesting Borrow';</script>";
            exit();
        } else {
            // Log the error instead of displaying to users
            error_log("Statement preparation failed for inserting into tblborrowingreports or updating tblitembrand: " . mysqli_error($con));
        }
    }
}
echo '<form action="" method="post" enctype="multipart/form-data" name="requestBorrowForm">';
// Retrieve selected item IDs from the URL parameters
if (isset($_GET['itemIds'])) {
    $selectedItemIds = explode(',', $_GET['itemIds']);

    // Display the selected item details
    echo '<div class="container">';
    echo '<div class="row mb-1">';
    echo '<div class="col-md-6">';
    echo '<h3 class="mb-0">Selected Item(s)</h3></div>';
    echo '<div class="col-md-6 text-end">';
    echo '<a href="borrowerDashboardPage.php" class="btn btn-danger">Cancel</a>';
    echo ' <button type="submit" class="btn btn-success" name="requestBorrow">Request Borrow</button>';
    echo '</div>';
    echo '<h6 class="text-danger ">Note: Any deformation or lost/damage of items borrowed are subject to replacement on your account.</h6>';
    echo '</div>';
    echo '</div>';

    echo '<div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-2">';

    // Loop through each selected item ID
    foreach ($selectedItemIds as $itemId) {
        // Fetch item details from the database based on the item ID
        $queryItemDetails = "SELECT * FROM tblitembrand WHERE id = ?";
        $stmtItemDetails = mysqli_prepare($con, $queryItemDetails);

        if ($stmtItemDetails) {
            mysqli_stmt_bind_param($stmtItemDetails, "s", $itemId);

            if (mysqli_stmt_execute($stmtItemDetails)) {
                $resultItemDetails = mysqli_stmt_get_result($stmtItemDetails);

                if ($resultItemDetails && mysqli_num_rows($resultItemDetails) > 0) {
                    // Valid item details, fetch the item details and display them in a card
                    $itemDetails = mysqli_fetch_assoc($resultItemDetails);

                    // Fetch subcategory information for the current item
                    $sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
                    $stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

                    if ($stmtSubcategory) {
                        mysqli_stmt_bind_param($stmtSubcategory, "i", $itemId);
                        mysqli_stmt_execute($stmtSubcategory);
                        $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

                        if ($resultSubcategory) {
                            // Fetch subcategory details
                            $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);

                            // Construct the image path based on subcategory information
                            $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
                        } else {
                            // If subcategory information is not found, use the default image
                            $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                        }

                        mysqli_stmt_close($stmtSubcategory);
                    } else {
                        // Log the error instead of displaying to users
                        error_log("Statement preparation failed for subcategory: " . mysqli_error($con));
                        $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                    }
                    ?>
                    <!-- Modal HTML Structure -->
                    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="noteModalLabel">Note</h5>
                                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                                </div>
                                <div class="modal-body">
                                <p class="text-danger ">Any deformation or lost/damage of items borrowed are subject to replacement on your account.</p>
                                    <img src="\Inventory\images\Itemsnotes.jpg" class="img-fluid" alt="Return of Damaged Goods">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $itemDetails['categoryname']; ?></h6>                               
                                <div class="mb-3 text-center">
                                    <img src="<?php echo $imagePath; ?>" alt="Image" width="100">
                                </div>
                                <div class="mb-1 text-center">
                                    <h5 class="card-text"><?php echo $itemDetails['subcategoryname']; ?></h5>
                                </div>
                                <div class="mb-1">
                                    <h7 class="card-text">Item Description : <?php echo $itemDetails['itembrand']; ?></h7>
                                </div>
                                <div class="mb-1">
                                    <h7 class="card-text">Model No: <?php echo $itemDetails['modelno']; ?></h7>
                                </div>
                                <div class="mb-1">
                                    <h7 class="card-text">Serial No: <?php echo $itemDetails['serialno']; ?></h7>
                                </div>
                                <!-- Hidden input field for selected item IDs -->
                                <input type="hidden" name="selectedItemIds[]" value="<?php echo $itemId; ?>">
                            </div>
                        </div>
                    </div>

                    <?php
                } else {
                    // Handle the case when item details are not found
                    echo "<p class='alert alert-warning'>No details found for item ID: {$itemId}</p>";
                }
            } else {
                die('Statement execution failed: ' . mysqli_stmt_error($stmtItemDetails));
            }
            mysqli_stmt_close($stmtItemDetails);
        } else {
            die('Statement preparation failed: ' . mysqli_error($con));
        }
    }
    echo '</div>'; // Close the container
} else {
    // Handle the case when item IDs are not present in the URL
    echo '<p class="alert alert-warning">No item IDs selected.</p>';
}
echo '</form>'; 
?>
<!-- Bootstrap CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
    crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Show the modal when the page loads
        $('#noteModal').modal('show');
    });
</script>