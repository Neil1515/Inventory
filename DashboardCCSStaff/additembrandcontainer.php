<!-- additembrandcontainer.php -->
<?php
include "ccsfunctions.php";
$staffname = '';

$staffId = $_SESSION['staff_id'];
// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $staffId);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $staffname = $rowUser['fname'] . ' ' . $rowUser['lname'];

        // Set the staffid variable
        $staffid = $staffId;
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }    

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}

// Assuming $con is your database connection variable

if (isset($_POST["addItemBrand"])) {
    $itemBrand = $_POST['itemBrand'];
    $categoryName = $_POST['categoryName'];
    $subcategoryName = $_POST['subcategoryName'];
    $remarks = $_POST['remarks'];
    $modelNo = $_POST['modelNo'];
    $serialNo = $_POST['serialNo'];
    $unitCost = $_POST['unitCost'];
    $status = "Available";
    $datepurchased = $_POST['datePurchased'];
    $borrowable = $_POST['borrowable'];
    $quantity = $_POST['quantity'];
    $itemcondition = $_POST['itemcondition'];

    date_default_timezone_set('Asia/Manila');
    $datetimeadded = date("Y-m-d H:i:s");

    // Use prepared statement to avoid SQL injection
    $sql = "INSERT INTO `tblitembrand` (`itembrand`, `staffid`, `staffname`, `categoryname`, `subcategoryname`, `remarks`, `modelno`, `serialno`, `unitcost`, `datetimeadded`, `datepurchased`, `borrowable`, `status`, `itemcondition`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Loop to insert rows based on quantity
        for ($i = 0; $i < $quantity; $i++) {
            // Add 's' for string and 'd' for double (decimal) placeholders for each parameter
            mysqli_stmt_bind_param($stmt, "ssssssssdsssss", $itemBrand, $staffid, $staffname, $categoryName, $subcategoryName, $remarks, $modelNo, $serialNo, $unitCost, $datetimeadded, $datepurchased, $borrowable, $status, $itemcondition);

            if (mysqli_stmt_execute($stmt)) {
                // Success message or further processing if needed
            } else {
                echo "Failed: " . mysqli_error($con);
            }
        }
        mysqli_stmt_close($stmt);
        echo "<script>window.location.href='ccstaffAddItemBrand.php?msg_success=New {$subcategoryName} {$itemBrand} Items created successfully';</script>";
        exit();
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
    }
}
?>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-9 text-end"> 
            <!-- Form to add a new item Product -->
            <form action="ccstaffAddItemBrand.php" method="post" enctype="multipart/form-data" name="addItemBrandForm">
            <h4 class="col-md text-start"><i class="fas fa-plus-circle me-2"></i>Add Product</h4>
        </div>
        <div class="col-md-3 text-end">
            <a href="ccsstaffDashboardPage.php" class="col-md-5 btn btn-danger">Cancel</a>
            <button type="submit" class="col-md-5 btn btn-success" name="addItemBrand">Add Product</button>
        </div>
        
        <div class="col-md-6">          
                
                <div class="mb-3">
                    <label for="categoryName" class="form-label">Category Name<span class="text-danger">*</span></label>
                    <select class="form-select" id="categoryName" name="categoryName" required>
                    <option value="" selected disabled>Select Category</option>
                        <?php
                        // Fetch categories from tblsubcategory
                        $queryCategories = "SELECT DISTINCT categoryname FROM tblsubcategory ORDER BY categoryname";
                        $resultCategories = mysqli_query($con, $queryCategories);

                        while ($categoryRow = mysqli_fetch_assoc($resultCategories)) {
                            echo "<option value='{$categoryRow['categoryname']}'>{$categoryRow['categoryname']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subcategoryName" class="form-label">Item Name<span class="text-danger">*</span></label>
                    <select class="form-select" id="subcategoryName" name="subcategoryName" required>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="itemBrand" class="form-label">Item Description<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="itemBrand" name="itemBrand"  required>
                </div>
                <div class="mb-3">
                    <label for="datePurchased" class="form-label">Date Purchased<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="datePurchased" name="datePurchased" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Item Quantity<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="mb-3">
                    <label for="itemcondition" class="form-label">Item Condition<span class="text-danger">*</span></label>
                    <select class="form-select" id="itemcondition" name="itemcondition" required>
                        <option value="" selected disabled>Select Item Condition</option>
                        <option value="New">New: The item is brand new and has never been used.</option>
                        <option value="Like New">Like New: The item is in excellent condition, almost indistinguishable from new.</option>
                        <option value="Good">Good: The item is in good condition with minor signs of wear or use.</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="modelNo" class="form-label">Model No</label>
                    <input type="text" class="form-control" id="modelNo"  name="modelNo">
                </div>
                <div class="mb-3">
                    <label for="serialNo" class="form-label">Serial No<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="serialNo"  name="serialNo" required>
                </div>
                <div class="mb-3">
                    <label for="unitCost" class="form-label">Unit Cost</label>
                    <input type="number" class="form-control" id="unitCost" name="unitCost" placeholder="₱" step="0.01">
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks"  name="remarks"></textarea>
                </div>
                <div class="mb-3">
                    <span class="form-label">Borrowable<span class="text-danger">*</span></span>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="borrowable" id="borrowableYes" value="Yes" required>
                        <label class="form-check-label" for="borrowableYes">Yes</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="borrowable" id="borrowableNo" value="No" required>
                        <label class="form-check-label" for="borrowableNo">No</label>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your Custom Script -->
<script>
    $(document).ready(function()
    {
        // Event listener for the category dropdown
        $("#categoryName").change(function()
        {
            var selectedCategory = $(this).val();

            // Fetch subcategories from tblsubcategory based on the selected category
            $.ajax(
            {
                url: "getSubcategories.php",
                type: "POST",
                data: { category: selectedCategory },
                success: function(data)
                {
                    // Update the subcategory dropdown with the fetched data
                    $("#subcategoryName").html(data);

                    // Trigger change event on subcategory dropdown to handle image display
                    $("#subcategoryName").trigger("change");
                },
                error: function(xhr, status, error) 
                {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
</script>
