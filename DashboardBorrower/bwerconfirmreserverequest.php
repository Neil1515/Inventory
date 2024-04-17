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

    // Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestReserve'])) {
    // Initialize variables
    $itemreqstatus = "Pending Reserve";
    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datetimereqreservation = date("Y-m-d H:i:s");

    // Concatenate dateOfUse and timeOfUse to form datetimereserve
    $dateOfUse = $_POST['dateOfUse'];
    $timeOfUse = $_POST['timeOfUse'];
    $datetimereserve = date("Y-m-d H:i:s", strtotime("$dateOfUse $timeOfUse"));

    
    // Get selected item IDs from form
    $selectedItemIds = isset($_POST['selectedItemIds']) ? $_POST['selectedItemIds'] : [];

    // Prepare SQL statement to insert into tblborrowingreports
    $sqlInsert = "INSERT INTO tblborrowingreports (itemid, borrowerid, itemreqstatus, datetimereqreservation, reservelocation, reservepurpose, datetimereserve) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = mysqli_prepare($con, $sqlInsert);

    // Prepare SQL statement to update status in tblitembrand
    $sqlUpdateItemStatus = "UPDATE tblitembrand SET status = ? WHERE id = ?";
    $stmtUpdateItemStatus = mysqli_prepare($con, $sqlUpdateItemStatus);

    // Check if both statements are prepared successfully
    if ($stmtInsert && $stmtUpdateItemStatus) {
        // Loop through each selected item ID
        foreach ($selectedItemIds as $itemid) {
            // Bind parameters for inserting into tblborrowingreports
            mysqli_stmt_bind_param($stmtInsert, "iisssss", $itemid, $borrowerId, $itemreqstatus, $datetimereqreservation, $_POST['location'], $_POST['purpose'], $datetimereserve);

            // Execute the insert statement
            if (!mysqli_stmt_execute($stmtInsert)) {
                // Log error if execution fails
                error_log("Error executing insert statement: " . mysqli_error($con));
            }

            // Bind parameters for updating status in tblitembrand
            mysqli_stmt_bind_param($stmtUpdateItemStatus, "si", $itemreqstatus, $itemid);

            // Execute the update statement
            if (!mysqli_stmt_execute($stmtUpdateItemStatus)) {
                // Log error if execution fails
                error_log("Error executing update statement: " . mysqli_error($con));
            }
        }

        // Close the statements
        mysqli_stmt_close($stmtInsert);
        mysqli_stmt_close($stmtUpdateItemStatus);

        echo "<script>window.location.href='borrowerDashboardPage.php?msg_success=Successfully Requesting to Reserve';</script>";
        exit();
    } else {
        // Log the error if preparation fails
        error_log("Statement preparation failed: " . mysqli_error($con));
    }
}
    
    ?>
    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php
                echo '<form action="" method="post" enctype="multipart/form-data" name="requestBorrowForm">';
                
                // Retrieve selected item IDs from the URL parameters
                if (isset($_GET['itemIds'])) {
                    $selectedItemIds = explode(',', $_GET['itemIds']);

                    // Display the selected item details
                    echo '<div class="row mb-1">';
                    echo '<div class="col-md-12">';
                    echo '<h3 class="mb-0">Selected Item(s)</h3></div>';
                    echo '<h6 class="text-danger ">Note: Any deformation or lost/damage of items borrowed are subject to replacement on your account.</h6>';
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
                                                    <p class="text-danger ">Reservation should be filed <strong>--- days before the actual date of use.</strong>  Assigned CCS Staff must be notified there be any changes of schedule of the reserved time</p>
                                                    <img src="\Inventory\images\reserveditems.jpg" class="img-fluid" alt="Return of Damaged Goods">
                                                    <p class="text-danger ">Any deformation or lost/damage of items borrowed are subject to replacement on your account.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
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
                                                    <h7 class="card-text">Item Conditon: <?php echo $itemDetails['itemcondition']; ?></h7>
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
                ?>
            </div>
            <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-1">Reserve Form</h3>
                    <form action="" method="post" enctype="multipart/form-data" name="requestBorrowForm">
                        <div class="mb-2">
                            <label for="dateOfUse" class="form-label">Date of Use<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="dateOfUse" name="dateOfUse" required>
                        </div>
                        <div class="mb-2">
                            <label for="timeOfUse" class="form-label">Time of Use<span class="text-danger">*</span></label>
                            <input type="time" class="form-control" id="timeOfUse" name="timeOfUse" required>
                        </div>
                        <div class="mb-2">
                            <label for="purpose" class="form-label">Purpose<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="4" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="location" name="location" rows="4" required></textarea>
                        </div>
                        <div class="mb-1 text-center">
                            <a href="borrowerDashboardPage.php" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-success" name="requestReserve">Request Reserve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    </form>
    <script>
         $(document).ready(function() {
        // Show the modal when the page loads
        $('#noteModal').modal('show');

        // Set the minimum date for the "Date of Use" input to today
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("dateOfUse").min = today;
        });
    </script>
