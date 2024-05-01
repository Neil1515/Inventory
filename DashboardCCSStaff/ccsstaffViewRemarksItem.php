<!-- ccsstaffViewRemarksItem.php -->
<?php
session_start();
// Include necessary files
include('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>

<!-- ccsstaffViewRemarksItem.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Remarks</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">
            <?php include('ccsheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('ccssidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md">
                        <h4 class="text-start"><i class="fas fa-plus-circle me-2"></i>Items</h4>
                    </div>
                    <div class="col-md-10 text-end">
                        <a href="ccsstaffInventoryProperties.php" class="btn btn-danger">Back</a>
                    </div>
                </div>
                <?php
                if (isset($_GET["msg_success"])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_success"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if (isset($_GET["msg_fail"])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_fail"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if (isset($_GET["msg"])) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo $_GET["msg"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                // Check if itemId is provided in the query string
                if (isset($_GET['itemId'])) {
                    $itemId = $_GET['itemId'];

                    // Query to fetch item details based on itemId
                    $queryItemDetails = "SELECT * FROM tblitembrand WHERE id = ?";
                    $stmtItemDetails = mysqli_prepare($con, $queryItemDetails);

                    if ($stmtItemDetails) {
                        mysqli_stmt_bind_param($stmtItemDetails, "i", $itemId);
                        mysqli_stmt_execute($stmtItemDetails);
                        $resultItemDetails = mysqli_stmt_get_result($stmtItemDetails);

                        if ($resultItemDetails && $rowItemDetails = mysqli_fetch_assoc($resultItemDetails)) {

                            // Display item details and other items with the same brand in a single table
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th scope="col">Item ID</th>';
                            echo '<th scope="col">Item Description</th>';
                            echo '<th scope="col">Subcategory</th>';
                            echo '<th scope="col">Model No</th>';
                            echo '<th scope="col">Serial No</th>';
                            echo '<th scope="col">Date of Purchase</th>';
                            echo '<th scope="col">Unit Cost</th>';
                            echo '<th scope="col">Status</th>';
                            echo '<th scope="col">Item Condition</th>';
                            echo '<th scope="col">Remarks</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            
                            // Display item details row
                            echo '<tr>';
                            echo '<td>' . $rowItemDetails['id'] . '</td>';
                            echo '<td>' . $rowItemDetails['itembrand'] . '</td>';
                            echo '<td>' . $rowItemDetails['subcategoryname'] . '</td>';
                            echo '<td>' . $rowItemDetails['modelno'] . '</td>';
                            echo '<td>' . $rowItemDetails['serialno'] . '</td>';
                            echo '<td>' . $rowItemDetails['datepurchased'] . '</td>';
                            echo '<td>' . $rowItemDetails['unitcost'] . '</td>';
                            echo '<td>' . $rowItemDetails['status'] . '</td>';
                            echo '<td>' . $rowItemDetails['itemcondition'] . '</td>';
                            echo '<td>' . $rowItemDetails['remarks'] . '</td>';
                            echo '</tr>';
                            
                            // Fetch other items with the same itembrand
                            $querySameBrandItems = "SELECT * FROM tblitembrand WHERE itembrand = ? AND categoryname = ? AND subcategoryname = ? AND modelno = ? AND serialno = ? AND datepurchased = ? AND unitcost = ?  AND id != ?";
                            $stmtSameBrandItems = mysqli_prepare($con, $querySameBrandItems);

                            if ($stmtSameBrandItems) {
                                mysqli_stmt_bind_param($stmtSameBrandItems, "sssssssi", $rowItemDetails['itembrand'], $rowItemDetails['categoryname'], $rowItemDetails['subcategoryname'], $rowItemDetails['modelno'], $rowItemDetails['serialno'], $rowItemDetails['datepurchased'], $rowItemDetails['unitcost'], $itemId);
                                mysqli_stmt_execute($stmtSameBrandItems);
                                $resultSameBrandItems = mysqli_stmt_get_result($stmtSameBrandItems);

                                if ($resultSameBrandItems) {
                                    // Display other items rows
                                    while ($rowSameBrandItem = mysqli_fetch_assoc($resultSameBrandItems)) {
                                        echo '<tr>';
                                        echo '<td>' . $rowSameBrandItem['id'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['itembrand'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['subcategoryname'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['modelno'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['serialno'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['datepurchased'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['unitcost'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['status'] . '</td>';
                                        echo '<td>' . $rowSameBrandItem['remarks'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="8">Failed to fetch other items with the same brand.</td></tr>';
                                }

                                mysqli_stmt_close($stmtSameBrandItems);
                            } else {
                                echo '<tr><td colspan="8">Statement preparation failed for same brand items: ' . mysqli_error($con) . '</td></tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';

                        } else {
                            echo '<tr><td colspan="8">Failed to fetch item details.</td></tr>';
                        }

                        mysqli_stmt_close($stmtItemDetails);
                    } else {
                        echo '<tr><td colspan="8">Statement preparation failed for item details: ' . mysqli_error($con) . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">Item ID not provided in the query string.</td></tr>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
