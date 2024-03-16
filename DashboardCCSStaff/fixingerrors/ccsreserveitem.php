<!-- ccsreserveitem.php -->
<?php
include "ccsfunctions.php";
$staffname = '';
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

$staffId = $_SESSION['staff_id'];

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

if (isset($_POST['proceedreserve'])) {
    if (isset($row['id']) && $row['status'] !== 'Reserve') {
        $borrowername = $_POST['borrowername'];
        $reason = $_POST['reason'];
        $location = $_POST['location'];
        
        date_default_timezone_set('Asia/Manila');
        $datetimereserve = date("Y-m-d H:i:s");
        $itemid = $row['id'];

        // Check if the item is already reserved
        if ($row['status'] !== 'Borrowed') {
            // Insert data into tblreservereports using prepared statement
            $sqlInsert = "INSERT INTO `tblreservereports` 
            (itemid, staffid, itembrand, categoryname, subcategoryname, serialno, remarks, datetimereserve, borrowername, reason, location, staffname) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmtInsert = mysqli_prepare($con, $sqlInsert);

            if ($stmtInsert) {
                mysqli_stmt_bind_param($stmtInsert, "ssssssssssss", $itemid, $staffId, $row['itembrand'], $row['categoryname'], $row['subcategoryname'], $row['serialno'], $row['remarks'], $datetimereserve, $borrowername, $reason, $location, $staffname);

                if (mysqli_stmt_execute($stmtInsert)) {
                    // Update the item status to 'Reserved'
                    $updateStatusQuery = "UPDATE `tblitembrand` SET status = 'Reserve' WHERE id = ?";
                    $stmtUpdateStatus = mysqli_prepare($con, $updateStatusQuery);
                    
                    if ($stmtUpdateStatus) {
                        mysqli_stmt_bind_param($stmtUpdateStatus, "i", $itemid);

                        if (mysqli_stmt_execute($stmtUpdateStatus)) {
                            mysqli_stmt_close($stmtUpdateStatus);
                            // Redirect to the main dashboard page with success message
                            echo "<script>window.location.href='ccsstaffBorrowableitems.php?msg_success=Successfully recorded details for Reserve {$row['itembrand']} {$row['categoryname']} to {$borrowername}.';</script>";
                            exit();
                        } else {
                            // Log the error instead of displaying to users
                            error_log("Failed to execute status update statement: " . mysqli_error($con));
                        }
                    } else {
                        // Log the error instead of displaying to users
                        error_log("Failed to prepare status update statement: " . mysqli_error($con));
                    }
                } else {
                    // Log the error instead of displaying to users
                    error_log("Failed to execute insert statement: " . mysqli_error($con));
                }
                mysqli_stmt_close($stmtInsert);
            } else {
                // Log the error instead of displaying to users
                error_log("Failed to prepare insert statement: " . mysqli_error($con));
            }
        } else {
            echo "<script>alert('Item is already Borrowed.');</script>";
        }
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Item is already Reserved.</div>';
    }
}

$sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
$stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

if ($stmtSubcategory) {
    mysqli_stmt_bind_param($stmtSubcategory, "i", $id);
    mysqli_stmt_execute($stmtSubcategory);
    $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

    if ($resultSubcategory) {
        $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);

        $imagePath = 'inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
    } 

    if (!file_exists($imagePath)) {
        $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
    }
    else {
        error_log("Failed to fetch subcategory: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSubcategory);
} else {
    error_log("Statement preparation failed for subcategory: " . mysqli_error($con));
}
?>

<div class="container mt-1">
    <div class="row">
        <div class="col-md-7">
            <!-- Form to add a new item Product -->         
                <h4 class="mb-1"><i class="fas fa-bookmark me-2"></i>Reserve Item</h4>
                <!-- Add your form fields here if needed -->
        </div>
        <div class="col-md-5 text-end">
        <form action="" method="post" enctype="multipart/form-data" name="proceedreserveForm" id="proceedreserveForm">
            <a href="ccsstaffBorrowableitems.php" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success" name="proceedreserve">Proceed Reserve</button>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-5">
            <?php if (isset($row)): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Item Details</h5>
                        <!--<div class="mb-3">-->
                            <!--<span class="form-label">Item ID:</span>-->
                            <!--<span class="form-text" id="id"> </span>-->
                        <!--</div>-->
                        <div class="mb-3 text-center">
                            <img src="<?php echo $imagePath; ?>" alt="Image" width="200">
                        </div>
                        <div class="mb-3">
                            <span class="form-label">Item Brand:</span>
                            <span class="form-text" id="itembrand"> <?php echo $row['itembrand'] ?? '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="form-label">Category Name:</span>
                            <span class="form-text"><?php echo $row['categoryname'] ?? '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="form-label">Subcategory Name:</span>
                            <span class="form-text"><?php echo $row['subcategoryname'] ?? '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="form-label">Serial No:</span>
                            <span class="form-text"><?php echo $row['serialno'] ?? '' ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="form-label">Remarks:</span>
                            <span class="form-text"><?php echo $row['remarks'] ?? '' ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Item not found.
                </div>
            <?php endif; ?>
        </div>
        <!-- Reserve details section -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reserve Details</h5>
                    <div class="mb-3">
                        <label for="borrowername" class="form-label">Full Name:<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="borrowername" name="borrowername"  required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason:<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location of item used:<span class="text-danger">*</span></label>                     
                        <textarea class="form-control" id="location" name="location"  required></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form> <!-- Closing form tag is moved outside the row -->
</div>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- jQuery and Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
