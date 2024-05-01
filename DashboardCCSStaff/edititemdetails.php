<!-- edititemdetails.php -->
<?php
include "ccsfunctions.php";

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateitem"])) {
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
?>
<form action="" method="post" enctype="multipart/form-data" name="updateitemForm">
<div class="container mt-1">
        <div class="row">
            <div class="col-md-7">
                <!-- Form to add a new item Product -->
                <h4 class="col-md text-start">Item Details</h4>
            </div>
            <div class="col-md-5 text-end">          
                <button type="submit" class="btn btn-danger" name="deleteitem"><i class="fas fa-trash-alt"></i> Delete Item</button>
                <button type="submit" class="btn btn-success" name="overviewitem"><i class="fas fa-history"></i> View History Transaction</button>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <?php if (isset($row)): ?>
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
                                        <span class="form-label">Serial No:</span>
                                        <input type="text" class="form-control" id="serialno" name="serialno" value="<?php echo $row['serialno'] ?? ''; ?>" >
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
                                    <a href="ccstaffListofItems.php" class="btn btn-danger"><i class="fas fa-times-circle"></i> Cancel</a>
                                    <button type="submit" class="btn btn-success" name="updateitem"><i class="fas fa-save"></i> Save Changes</button>                                    </div>
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
        </div>
    </div>
<!-- Your Custom Script -->

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Autocomplete library CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha384-vk5+OZkz1TK8j0rPbZtph/uW9RJpZl3sn4b8bDqz7g9br7RsEC0tDZ4QbI5P1ptN" crossorigin="anonymous">

<!-- jQuery and Autocomplete library JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha384-nvVw+zI2tP8Y2vZ1bqBCvC4zACD/02rR5L5bZ2b/RYs8wZgEAsHCCjQ6bphG/P4f" crossorigin="anonymous"></script>

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

    $(document).ready(function () {
        // Initialize autocomplete on the assignfor field
        $("#assignfor").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "getAssignForSuggestions.php", // Replace with the actual PHP file to fetch suggestions
                    method: "POST",
                    dataType: "json",
                    data: { term: request.term },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2 // Minimum characters before triggering autocomplete
        });
    });
</script>
