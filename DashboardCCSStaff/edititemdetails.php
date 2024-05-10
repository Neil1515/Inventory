<!-- edititemdetails.php -->
<?php
include "ccsfunctions.php";
// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$id = isset($_GET["id"]) ? $_GET["id"] : null;

$sqlSelect = "SELECT * FROM `tblitembrand` WHERE id = ? LIMIT 1";
$stmtSelect = mysqli_prepare($con, $sqlSelect);

if ($stmtSelect) {
    mysqli_stmt_bind_param($stmtSelect, "i", $id);
    mysqli_stmt_execute($stmtSelect);
    $result = mysqli_stmt_get_result($stmtSelect);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch item: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelect);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed: " . mysqli_error($con));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateitem"])) {
        // Check if the item is pending for deletion
        $sqlCheckPending = "SELECT * FROM `tblpendingitemremoval` WHERE itemid = ? AND status = 'Pending'";
        $stmtCheckPending = mysqli_prepare($con, $sqlCheckPending);

        if ($stmtCheckPending) {
            mysqli_stmt_bind_param($stmtCheckPending, "i", $id);
            mysqli_stmt_execute($stmtCheckPending);
            $resultCheckPending = mysqli_stmt_get_result($stmtCheckPending);

            if ($resultCheckPending && mysqli_num_rows($resultCheckPending) > 0) {
                echo '<div class="alert alert-danger mt-3" role="alert">
                        Item is pending for deletion. Update not allowed.
                     </div>';
            } else {
                // Retrieve form data
                $itembrand = $_POST["itembrand"];
                $categoryname = $_POST["categoryname"];
                $subcategoryname = $_POST["subcategoryname"];
                $serialno = $_POST["serialno"];
                $modelno = $_POST["modelno"];
                $datePurchased = $_POST["datePurchased"];
                $unitCost = $_POST["unitCost"];
                $assignfor = $_POST["assignfor"];
                $remarks = $_POST["remarks"];
                $borrowable = $_POST['borrowable'];

                // Determine the status based on the value of "borrowable"
                $status = ($borrowable == 'Yes') ? 'Available' : 'Standby';

                // Update query
                $sqlUpdate = "UPDATE `tblitembrand` SET
                    itembrand = ?,
                    categoryname = ?,
                    subcategoryname = ?,
                    serialno = ?,
                    modelno = ?,
                    datepurchased = ?,
                    unitcost = ?,
                    assignfor = ?,
                    remarks = ?,
                    borrowable = ?,
                    status = ?
                    WHERE id = ?";

                $stmtUpdate = mysqli_prepare($con, $sqlUpdate);

                if ($stmtUpdate) {
                    // Bind parameters
                    mysqli_stmt_bind_param(
                        $stmtUpdate,
                        "ssssssdssssi",
                        $itembrand,
                        $categoryname,
                        $subcategoryname,
                        $serialno,
                        $modelno,
                        $datePurchased,
                        $unitCost,
                        $assignfor,
                        $remarks,
                        $borrowable,
                        $status, // Status parameter added here
                        $id
                    );

                    // Execute the statement
                    if (mysqli_stmt_execute($stmtUpdate)) {
                        echo "<script>window.location.href='ccstaffListofItems.php?msg_success=Item details updated successfully.';</script>";
                        exit();
                    } else {
                        // Log the error instead of displaying to users
                        error_log("Failed to update item: " . mysqli_error($con));
                        echo '<div class="alert alert-danger mt-3" role="alert">
                                Error updating item details.
                             </div>';
                    }        

                    mysqli_stmt_close($stmtUpdate);
                } else {
                    // Log the error instead of displaying to users
                    error_log("Statement preparation failed: " . mysqli_error($con));
                    echo '<div class="alert alert-danger mt-3" role="alert">
                            Error updating item details.
                         </div>';
                }
            }
        } else {
            // Log the error instead of displaying to users
            error_log("Statement preparation failed: " . mysqli_error($con));
            echo '<div class="alert alert-danger mt-3" role="alert">
                    Error checking pending status.
                 </div>';
        }
    } elseif (isset($_POST["confirmdelete"])) {
    // Check if the item is borrowable
    $sqlCheckBorrowable = "SELECT borrowable FROM `tblitembrand` WHERE id = ?";
    $stmtCheckBorrowable = mysqli_prepare($con, $sqlCheckBorrowable);

    if ($stmtCheckBorrowable) {
        mysqli_stmt_bind_param($stmtCheckBorrowable, "i", $id);
        mysqli_stmt_execute($stmtCheckBorrowable);
        $resultCheckBorrowable = mysqli_stmt_get_result($stmtCheckBorrowable);

        if ($resultCheckBorrowable && $rowBorrowable = mysqli_fetch_assoc($resultCheckBorrowable)) {
            // Check if the item is not borrowable
            if ($rowBorrowable['borrowable'] == 'Yes') {
                // Inform the user that deletion is not allowed for borrowable items
                echo '<div class="alert alert-danger mt-3" role="alert">
                        Deletion not allowed for borrowable items. Set "Allow Borrow" to "No" to proceed.                    
                    </div>';
            } else {
                // Proceed with deletion request
                // Check if the item has already been requested for deletion
                $sqlCheckRequest = "SELECT * FROM `tblpendingitemremoval` WHERE itemid = ? AND status = 'Pending'";
                $stmtCheckRequest = mysqli_prepare($con, $sqlCheckRequest);

                if ($stmtCheckRequest) {
                    mysqli_stmt_bind_param($stmtCheckRequest, "i", $id);
                    mysqli_stmt_execute($stmtCheckRequest);
                    $resultCheckRequest = mysqli_stmt_get_result($stmtCheckRequest);

                    if ($resultCheckRequest && mysqli_num_rows($resultCheckRequest) > 0) {
                        // Inform the user that the item has already been requested for deletion
                        echo '<div class="alert alert-danger mt-3" role="alert">
                                This item has already been requested for deletion.
                             </div>';
                    } else {
                        // Insert request to delete item into tblpendingitemremoval
                        $staffid = $_POST["staffid"]; // Assuming you have a staff ID
                        $status = "Pending";
                        // Determine item condition based on purchase date
                        date_default_timezone_set('Asia/Manila');
                        $datetimereq = date("Y-m-d H:i:s");

                        $sqlInsertRequest = "INSERT INTO `tblpendingitemremoval` (itemid, staffid, status, datetimereq) VALUES (?, ?, ?, ?)";
                        $stmtInsertRequest = mysqli_prepare($con, $sqlInsertRequest);

                        if ($stmtInsertRequest) {
                            mysqli_stmt_bind_param($stmtInsertRequest, "iiss", $id, $staffid, $status, $datetimereq);
                            if (mysqli_stmt_execute($stmtInsertRequest)) {
                                echo "<script>window.location.href='ccstaffEditItemDetails.php?id=$id&msg_success=Deletion request sent successfully. Please await approval from Dean.';</script>";
                                exit();
                            } else {
                                // Log the error instead of displaying to users
                                error_log("Failed to insert deletion request: " . mysqli_error($con));
                                echo '<div class="alert alert-danger mt-3" role="alert">
                                        Error sending deletion request.
                                     </div>';
                            }
                            mysqli_stmt_close($stmtInsertRequest);
                        } else {
                            // Log the error instead of displaying to users
                            error_log("Statement preparation failed: " . mysqli_error($con));
                            echo '<div class="alert alert-danger mt-3" role="alert">
                                    Error sending deletion request.
                                 </div>';
                        }
                    }
                } else {
                    // Log the error instead of displaying to users
                    error_log("Statement preparation failed: " . mysqli_error($con));
                    echo '<div class="alert alert-danger mt-3" role="alert">
                            Error checking deletion request.
                         </div>';
                }
            }
        } else {
            // Log the error instead of displaying to users
            error_log("Failed to fetch borrowable status: " . mysqli_error($con));
            echo '<div class="alert alert-danger mt-3" role="alert">
                    Error fetching borrowable status.
                 </div>';
        }
    } else {
        // Log the error instead of displaying to users
        error_log("Statement preparation failed: " . mysqli_error($con));
        echo '<div class="alert alert-danger mt-3" role="alert">
                Error checking borrowable status.
             </div>';
    }
}
}
?>
<form action="" method="post" enctype="multipart/form-data" name="updateitemForm">

<!-- Delete item Modal HTML Structure -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="..\images\delete.gif" alt="delete Image" id="deleteImage" style="max-width: 100%; max-height: 100%;">
                </div>
                <div class="text-center mb-3">
                    <p>Are you sure you want to request delete this item?</p>
                </div>
                <input type="hidden" name="staffid" value=<?php echo $staffId ?>> 
                <input type="hidden" name="confirmdelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmdeleteBtn">Confirm Request</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-1">
<?php if (isset($row)): ?>
        <div class="row">
            <div class="col-md-7">
            <!-- Form to add a new item Product -->
            <h4 class="col-md text-start">Item Details 
            <?php 
            // Check if the item has a pending deletion request
            $sqlCheckRequest = "SELECT * FROM `tblpendingitemremoval` WHERE itemid = ? AND status = 'Pending'";
            $stmtCheckRequest = mysqli_prepare($con, $sqlCheckRequest);

            if ($stmtCheckRequest) {
                mysqli_stmt_bind_param($stmtCheckRequest, "i", $id);
                mysqli_stmt_execute($stmtCheckRequest);
                $resultCheckRequest = mysqli_stmt_get_result($stmtCheckRequest);

                if ($resultCheckRequest && mysqli_num_rows($resultCheckRequest) > 0) {
                    // Item deletion is pending, display the section
                    echo '<span class="text-danger"><i class="fas fa-trash-alt"></i> Pending</span>';
                }
                else{
                }
            }?>
            </h4>
            </div>
            <div class="col-md-5 text-end">          
                <a class="btn btn-danger" name="deleteitem" id="deleteItemButton"><i class="fas fa-trash-alt"></i> Request to Delete</a>
                <!--<a  class="btn btn-success" name="overviewitem"><i class="fas fa-history"></i> View History Transaction</a>-->
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                    <div class="card">
                        <div class="card-body"> 
                        <div class="row">                        
                            <div class="col-md-7 text-end"> 
                                <h4 class="col-md text-start">Edit Item Details</h4>
                            </div>
                            <div class="col-md-5 text-end">
                            <h5 for="status" class="form-label">Status: <?php echo $row['status'] ?? ''; ?> </h5>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                 
                                    <div class="mb-3">
                                    <span class="form-label">Category Name:<span class="text-danger">*</span></span>
                                    <select class="form-select" id="categoryname" name="categoryname" required>
                                        <?php
                                        // Fetch categories from tblsubcategory
                                        $queryCategories = "SELECT DISTINCT categoryname FROM tblsubcategory ORDER BY categoryname";
                                        $resultCategories = mysqli_query($con, $queryCategories);

                                        while ($categoryRow = mysqli_fetch_assoc($resultCategories)) {
                                            $selected = ($row['categoryname'] == $categoryRow['categoryname']) ? 'selected' : '';
                                            echo "<option value='{$categoryRow['categoryname']}' $selected>{$categoryRow['categoryname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                        <span class="form-label">Item Name:<span class="text-danger">*</span></span>
                                        <select class="form-select" id="subcategoryname" name="subcategoryname" required>
                                            <?php
                                            // Check if the category is set in the $row
                                            if (isset($row['categoryname'])) {
                                                // Fetch subcategories based on the selected category
                                                $selectedCategory = $row['categoryname'];
                                                $querySubcategories = "SELECT subcategoryname FROM tblsubcategory WHERE categoryname = '$selectedCategory' ORDER BY subcategoryname";
                                                $resultSubcategories = mysqli_query($con, $querySubcategories);

                                                if ($resultSubcategories) {
                                                    while ($subcategoryRow = mysqli_fetch_assoc($resultSubcategories)) {
                                                        $selected = ($row['subcategoryname'] == $subcategoryRow['subcategoryname']) ? 'selected' : '';
                                                        echo "<option value='{$subcategoryRow['subcategoryname']}' $selected>{$subcategoryRow['subcategoryname']}</option>";
                                                    }
                                                } else {
                                                    // Handle the case where fetching subcategories fails
                                                    echo "<option value=''>Error fetching subcategories</option>";
                                                }
                                            } else {
                                                // Handle the case where the category is not set
                                                echo "<option value=''>Please select a category first</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label">Item Description:<span class="text-danger">*</span></span>
                                        <input type="text" class="form-control" id="itembrand" name="itembrand" value="<?php echo $row['itembrand'] ?? ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label">Serial No:<span class="text-danger">*</span></span>
                                        <input type="text" class="form-control" id="serialno" name="serialno" value="<?php echo $row['serialno'] ?? ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label">Model No:</span>
                                        <input type="text" class="form-control" id="modelno" name="modelno" value="<?php echo $row['modelno'] ?? ''; ?>" >
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <!-- Your right column content -->
                                    <div class="mb-3">
                                        <span for="datepurchased" class="form-label">Date Purchased:<span class="text-danger">*</span></span>
                                        <!-- date input -->
                                        <input type="date" class="form-control" id="datePurchased" name="datePurchased" value="<?php echo $row['datepurchased'] ?? ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <span for="unitcost" class="form-label">Unit Cost:<span class="text-danger">*</span></span>
                                        <input type="number" class="form-control" id="unitCost" name="unitCost" placeholder="₱" step="0.01" value="<?php echo $row['unitcost'] ?? ''; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <span for="assignfor" class="form-label">Assign For:</span>
                                        
                                        <input type="text" class="form-control" id="assignfor" name="assignfor" value="<?php echo $row['assignfor'] ?? ''; ?>" >
                                    </div>
                                    <div class="mb-3">
                                        <span for="remarks" class="form-label">Remarks:</span>
                                        <textarea class="form-control" id="remarks" name="remarks"><?php echo $row['remarks'] ?? ''; ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <span class="form-label">Allow to borrow?<span class="text-danger"> *</span></span>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="borrowable" id="borrowableYes" value="Yes" <?php echo ($row['borrowable'] == 'Yes') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="borrowableYes">Yes</label>
                                        </div>

                                        <?php
                                        // Check if the status is not "Available" or "Standby"; if not, hide the "No" radio button
                                        $hideNoRadio = ($row['status'] != 'Available' && $row['status'] != 'Standby') ? 'style="display: none;"' : '';
                                        ?>
                                        <div class="form-check form-check-inline" <?php echo $hideNoRadio; ?>>
                                            <input class="form-check-input" type="radio" name="borrowable" id="borrowableNo" value="No" <?php echo ($row['borrowable'] == 'No') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="borrowableNo">No</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 text-end">                                       
                                    <a href="ccstaffListofItems.php" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
                                    <button type="submit" class="btn btn-success" name="updateitem"><i class="fas fa-save"></i> Save Changes</button>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger mt-3" role="alert">
            Item not found.
            </div>
    <?php endif; ?>
</div>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Autocomplete library CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

<!-- jQuery and Autocomplete library JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Event listener for the category dropdown
        $("#categoryname").change(function () {
            // Get the selected category
            var selectedCategory = $(this).val();

            // Fetch subcategories from tblsubcategory based on the selected category
            $.ajax({
                url: "getSubcategories.php",
                type: "POST",
                data: { category: selectedCategory },
                success: function (data) {
                    // Update the subcategory dropdown with the fetched data
                    $("#subcategoryname").html(data);

                    // Trigger change event on subcategory dropdown to handle additional tasks if needed
                    $("#subcategoryname").trigger("change");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
    var deleteItemButton = document.getElementById('deleteItemButton');
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    var confirmDeleteBtn = document.getElementById('confirmdeleteBtn');

    deleteItemButton.addEventListener('click', function() {
        deleteModal.show();
    });

    confirmDeleteBtn.addEventListener('click', function() {
        document.forms['updateitemForm'].submit();
    });
});

</script>
