<!-- ccsreturnitem.php -->
<?php
include "ccsfunctions.php";

$id = isset($_GET["id"]) ? $_GET["id"] : null;

// Fetch the item details from tblitembrand based on the given item ID
$sqlSelectItem = "SELECT * FROM `tblitembrand` WHERE id = ? LIMIT 1";
$stmtSelectItem = mysqli_prepare($con, $sqlSelectItem);

if ($stmtSelectItem) {
    mysqli_stmt_bind_param($stmtSelectItem, "i", $id);
    mysqli_stmt_execute($stmtSelectItem);
    $resultItem = mysqli_stmt_get_result($stmtSelectItem);

    if ($resultItem) {
        $rowItem = mysqli_fetch_assoc($resultItem);

        // Check the status of the item
        if ($rowItem['status'] === 'Available') {
            // Log the error instead of displaying to users
            error_log("Item is not borrowed and cannot be returned.");
            exit('<div class="alert alert-danger mt-3" role="alert">Item is not borrowed and cannot be returned.</div>');
        }
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch item: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectItem);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed: " . mysqli_error($con));
}

// Fetch the last borrowed item details from tblborrowingreports based on the given item ID
$sqlSelect = "SELECT * FROM tblborrowingreports WHERE itemid = ? ORDER BY id DESC LIMIT 1";
$stmtSelect = mysqli_prepare($con, $sqlSelect);

if ($stmtSelect) {
    mysqli_stmt_bind_param($stmtSelect, "i", $id);
    mysqli_stmt_execute($stmtSelect);
    $result = mysqli_stmt_get_result($stmtSelect);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch last borrowed item: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelect);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed: " . mysqli_error($con));
}

$sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
$stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

if ($stmtSubcategory) {
    mysqli_stmt_bind_param($stmtSubcategory, "i", $id);
    mysqli_stmt_execute($stmtSubcategory);
    $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

    if ($resultSubcategory) {
        $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);

        // Construct the image path based on subcategory information
        $imagePath = 'inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
        
        // Check if the image file exists, if not, set the path to the default image
        if (!file_exists($imagePath)) {
            $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
        }
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch subcategory: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSubcategory);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for subcategory: " . mysqli_error($con));
}


// $staffId = getUserIdByUsername($staffname);
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
if (isset($_POST["proceedreturn"])) {
    if (isset($rowItem['id'])) {
        // Assuming $con is your database connection variable
        $returnBorrowerName = $_POST['returnborrowername'];
        $itemStatus = $_POST['itemstatus'];
        $damageDetails = isset($_POST['damageDetails']) ? $_POST['damageDetails'] : null;
        
        // Set the timezone to Asia/Manila
        date_default_timezone_set('Asia/Manila');

        // Get the current date and time in the Philippines timezone
        $datetimereturn = date("Y-m-d H:i:s");

        // Use prepared statement to avoid SQL injection
        $sql = "INSERT INTO `tblreturnreports` (`itemid`, `staffid`, `staffname`, `itembrand`, `categoryname`, `subcategoryname`, `serialno`, `remarks`, `datetimereturn`, `returnborrowername`, `itemstatus`, `damageDetails`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Add 's' for string and 'd' for double (decimal) placeholders for each parameter
            mysqli_stmt_bind_param($stmt, "isssssssssss", $id, $staffId, $staffname, $row['itembrand'], $row['categoryname'], $row['subcategoryname'], $row['serialno'], $row['remarks'], $datetimereturn, $returnBorrowerName, $itemStatus, $damageDetails);
            
            if (mysqli_stmt_execute($stmt)) {
                // Update the item status in tblborrowingreports
                $updateStatusQuery = "UPDATE `tblitembrand` SET status = 'Available' WHERE id = ?";
                $stmtUpdateStatus = mysqli_prepare($con, $updateStatusQuery);

                if ($stmtUpdateStatus) {
                    mysqli_stmt_bind_param($stmtUpdateStatus, "i", $id);
                    mysqli_stmt_execute($stmtUpdateStatus);
                    mysqli_stmt_close($stmtUpdateStatus);
                } else {
                    // Log the error instead of displaying to users
                    error_log("Failed to prepare status update statement: " . mysqli_error($con));
                }
                echo "<script>window.location.href='ccsstaffDashboardPage.php?msg_success=The {$row['subcategoryname']} {$row['itembrand']} has been successfully returned by {$returnBorrowerName}.';</script>";
                exit();
            } else {
                echo "<script>alert('Item cannot be returned.');</script>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare statement: " . mysqli_error($con);
        }
    } else {
        echo'<div class="alert alert-danger mt-3" role="alert">';
        echo'Item is not borrowed and cannot be returned.';
        echo'</div>';// Consider logging this instead of displaying to users
    }
}
?>

<div class="container mt-1">
    <div class="row">
        <div class="col-md-7">
            <!-- Form to add a new item Product -->
            <form action="" method="post" enctype="multipart/form-data" name="proceedborrowForm">
                <h4 class="mb-1"><i class='fas fa-undo me-2'></i>Return Item</h4>
                <!-- Add your form fields here if needed -->
        </div>
        <div class="col-md-5 text-end">
            <a href="ccsstaffDashboardPage.php" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success" name="proceedreturn">Proceed Return</button>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-5">
            <?php if (isset($row)): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Item Details</h5>
                        <div class="mb-2">
                            <img src="<?php echo $imagePath; ?>" alt="Image" width="100">
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Item Brand:</span>
                            <span class="form-text" id="itembrand"> <?php echo $row['itembrand'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Category Name:</span>
                            <span class="form-text"><?php echo $row['categoryname'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Subcategory Name:</span>
                            <span class="form-text"><?php echo $row['subcategoryname'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Serial No:</span>
                            <span class="form-text"><?php echo $row['serialno'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Remarks:</span>
                            <span class="form-text"><?php echo $row['remarks'] ?? '' ?></span>
                        </div>
                        <h5 class="card-title">Borrower Details</h5>
                        <div class="mb-2">
                            <span class="form-label">Name:</span>
                            <span class="form-text"><?php echo $row['borrowername'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Date Borrowed:</span>
                            <span class="form-text"><?php echo isset($row['datetimeborrow']) ? date("Y-m-d (h:i A)", strtotime($row['datetimeborrow'])) : '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Reason:</span>
                            <span class="form-text"><?php echo $row['reason'] ?? '' ?></span>
                        </div>
                        <div class="mb-2">
                            <span class="form-label">Location of item used:</span>
                            <span class="form-text"><?php echo $row['location'] ?? '' ?></span>
                        </div>
                        <h5 class="card-title">Authorization Officer</h5>
                        <div class="mb-0">
                            <span class="form-label">Staff:</span>
                            <span class="form-text"><?php echo $row['staffname'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Borrowed Item not found.
                </div>
            <?php endif; ?>
        </div>
        <!-- Borrower details section -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Returning Details</h5>
                    <div class="mb-3">
                        <label for="returnborrowername" class="form-label">Person Name:<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="returnborrowername" name="returnborrowername"  required>
                    </div>
                    <div class="mb-3">
                        <label for="itemstatus" class="form-label">Item Status:<span class="text-danger">*</span></label>
                        <select class="form-control" id="itemstatus" name="itemstatus" required onchange="toggleDamageTextArea()">
                            <option value="No Issue">No Issue</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </div>

                    <div class="mb-3" id="damageTextArea" style="display: none;">
                        <label for="damageDetails" class="form-label">Damage Details:<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="damageDetails" name="damageDetails" placeholder="Please specify the damages"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form> <!-- Closing form tag is moved outside the row -->
</div>
<script>
    function toggleDamageTextArea() {
        var itemStatusDropdown = document.getElementById('itemstatus');
        var damageTextArea = document.getElementById('damageTextArea');
        
        // If "Damage" is selected, show the text area; otherwise, hide it
        damageTextArea.style.display = itemStatusDropdown.value === 'Damage' ? 'block' : 'none';
    }
</script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
