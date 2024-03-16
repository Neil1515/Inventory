<!-- ccsviewborrower_all_items.php -->
<?php
include 'ccsfunctions.php';
// Fetch borrower ID from the query string
$borrowerId = $_GET['borrowerId'];

// Debugging statement
error_log('Borrower ID: ' . $borrowerId);

// Fetch borrower details
$queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
$stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

if ($stmtBorrowerDetails) {
    mysqli_stmt_bind_param($stmtBorrowerDetails, "i", $borrowerId);

    if (mysqli_stmt_execute($stmtBorrowerDetails)) {
        $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

        if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
            $rowBorrowerDetails = mysqli_fetch_assoc($resultBorrowerDetails);
            $borrowerName = $rowBorrowerDetails['fname'] . ' ' . $rowBorrowerDetails['lname'];
        } else {
            die('No details found for the specified borrower ID: ' . $borrowerId);
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
    }

    mysqli_stmt_close($stmtBorrowerDetails);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}

?>

<div class="ccs-main-container">
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>View Items for Approval</h3>
                <div class="text-end">
                    <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <h5 class="text-start">Borrower: <?= $borrowerName ?></h5>
                <div class="text-end">
                <a href="ccsstaffListofPendingBorrowerusers.php" id="back" class="btn btn-danger mb-1">Back</a>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-5 g-1">
                <?php
                // Fetch items for the specified borrower with a pending status
                $queryItems = "SELECT * FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Borrow' ORDER BY datetimereqborrow DESC";
                $stmtItems = mysqli_prepare($con, $queryItems);

                if ($stmtItems) {
                    mysqli_stmt_bind_param($stmtItems, "i", $borrowerId);

                    if (mysqli_stmt_execute($stmtItems)) {
                        $resultItems = mysqli_stmt_get_result($stmtItems);

                        if ($resultItems && mysqli_num_rows($resultItems) > 0) {
                            while ($rowItem = mysqli_fetch_assoc($resultItems)) {
                                // Fetch item details from tblitembrand based on itemid
                                $queryItemDetails = "SELECT * FROM tblitembrand WHERE id = ?";
                                $stmtItemDetails = mysqli_prepare($con, $queryItemDetails);

                                if ($stmtItemDetails) {
                                    mysqli_stmt_bind_param($stmtItemDetails, "i", $rowItem['itemid']);

                                    if (mysqli_stmt_execute($stmtItemDetails)) {
                                        $resultItemDetails = mysqli_stmt_get_result($stmtItemDetails);

                                        if ($resultItemDetails && mysqli_num_rows($resultItemDetails) > 0) {
                                            $rowItemDetails = mysqli_fetch_assoc($resultItemDetails);

                                            // Fetch subcategory information for the current item
                                            $sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
                                            $stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

                                            if ($stmtSubcategory) {
                                                mysqli_stmt_bind_param($stmtSubcategory, "i", $rowItem['itemid']);
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

                                            // Display item details in a card
                                            echo '<div class="col">';
                                            echo '<div class="card">';
                                            echo '<div class="card-body">';
                                            echo '<h6 class="card-title">' . $rowItemDetails['categoryname'] . '</h6>';
                                            echo '<div class="mb-3 text-center">';
                                            echo '<img src="' . $imagePath . '" alt="Image" width="100">';
                                            echo '</div>';  
                                            echo '<h7 class=" card-text">' . $rowItemDetails['subcategoryname'] . '<br></h7>';
                                            echo '<h7 class=" text-center">' . $rowItemDetails['id'] . '<br></h7>';
                                            echo '<h7 class=" text-center">' . $rowItemDetails['itembrand'] . '<br></h7>';
                                            echo '<h7 class="card-text">Serial #: ' . $rowItemDetails['serialno'] . '</h7>';
                                            $formattedDatetime = date('F d, Y g:i A ', strtotime($rowItem['datetimereqborrow']));
                                            echo '<p class="card-text">Date Filled:<br> ' . $formattedDatetime . '</p>';
                                            echo '<div class="text-end">';
                                            echo '<a href="#" class="btn btn-danger" style="margin-right: 10px; padding: 10px;" onclick="rejectItem(' . $rowItem['id'] . ', ' . $borrowerId . ')">Reject</a>';
                                            echo '<a href="#" class="btn btn-primary" style="padding: 10px;" onclick="approveItem(' . $rowItem['id'] . ', ' . $borrowerId . ')">Approve</a>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        } else {
                                            echo '<p class="alert alert-info">No details found for item ID: ' . $rowItem['itemid'] . '</p>';
                                        }
                                    } else {
                                        die('Statement execution failed: ' . mysqli_stmt_error($stmtItemDetails));
                                    }

                                    mysqli_stmt_close($stmtItemDetails);
                                } else {
                                    die('Statement preparation failed: ' . mysqli_error($con));
                                }
                            }
                        } else {
                            echo '<p class="alert alert-info">No items with a pending status found for this borrower.</p>';
                        }
                    } else {
                        die('Statement execution failed: ' . mysqli_stmt_error($stmtItems));
                    }

                    mysqli_stmt_close($stmtItems);
                } else {
                    die('Statement preparation failed: ' . mysqli_error($con));
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function approveItem(itemId, borrowerId) {
        if (confirm('Are you sure you want to approve this item?')) {
        $.ajax({
            type: "POST",
            url: "ccsapprove_item.php", // PHP script to handle the AJAX request
            data: { itemId: itemId }, // Data to be sent to the server
            success: function(response) {
                // Handle the response from the server, if needed
                console.log(response);
                //alert('Item approved successfully!');
                window.location.href = 'ccsstaffViewBorrower_all_items.php?borrowerId=' + borrowerId + '&msg_success=Items approved successfully';
            }
        });
    }
    }

    function rejectItem(itemId, borrowerId) {
        if (confirm('Are you sure you want to reject this item?')) {
        $.ajax({
            type: "POST",
            url: "ccsreject_item.php", // PHP script to handle the AJAX request
            data: { itemId: itemId }, // Data to be sent to the server
            success: function(response) {
                // Handle the response from the server, if needed
                console.log(response);
                //alert('Item reject successfully!');
                window.location.href = 'ccsstaffViewBorrower_all_items.php?borrowerId=' + borrowerId + '&msg_success=Item rejected successfully';
            }
        });
    }
    }

</script>
