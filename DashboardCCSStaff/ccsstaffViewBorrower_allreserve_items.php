<!-- ccsstaffDashboardPage.php -->
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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View All Reserve Items</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
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
                    <div class="d-flex justify-content-between">
                        <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Reserve Approval</h3>
                        <div class="text-end">
                            <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h5 class="text-start">Borrower: <?= $borrowerName ?></h5>
                        <div class="text-end mb-1">
                            <button class="btn btn-primary"  id="selectAllBtn">Select All</button>
                            <a href="ccsstaffUsersPendingReserveItems.php" id="back" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Image</th>
                                    <th>Item Name</th>
                                    <th>Item Description</th>
                                    <th class="text-center">Serial No</th>
                                    <th class="text-center">Date of use</th>
                                    <th class="text-center">Time of use</th>
                                    <th class="text-center">Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch items for the specified borrower with a pending status
                                $queryItems = "SELECT * FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Reserve' ORDER BY datetimereqborrow DESC";
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

                                                            // Display item details in a table row
                                                            echo '<tr>';
                                                            // Check if an image exists, if not, use a default image
                                                            $imagePath = 'inventory/SubcategoryItemsimages/' . $rowItemDetails['subcategoryname'] . '.png';
                                                            if (file_exists($imagePath)) {
                                                                echo "<td class='text-center'><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                                                            } else {
                                                                // Use a default image if no image is uploaded
                                                                echo "<td class='text-center'><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                                            }
                                                            echo '<td>' . $rowItemDetails['subcategoryname'] . '</td>';
                                                            echo '<td>' . $rowItemDetails['itembrand'] . '</td>';
                                                            echo '<td class="text-center">' . $rowItemDetails['serialno'] . '</td>';
                                                            $formattedDate = date('F d, Y', strtotime($rowItem['datetimereserve']));
                                                            $formattedTime = date('g:i A', strtotime($rowItem['datetimereserve']));
                                                            echo '<td class="text-center">' . $formattedDate . '</td>';
                                                            echo '<td class="text-center">' . $formattedTime . '</td>';
                                                            echo '<td class="text-center"><input type="checkbox" name="itemIds[]" value="' . $rowItem['id'] . '"></td>';
                                                            echo '</tr>';
                                                        } else {
                                                            echo '<tr><td colspan="7">No details found for item ID: ' . $rowItem['itemid'] . '</td></tr>';
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
                                            echo '<tr><td colspan="7">No items with a pending status found for this borrower.</td></tr>';
                                        }
                                    } else {
                                        die('Statement execution failed: ' . mysqli_stmt_error($stmtItems));
                                    }

                                    mysqli_stmt_close($stmtItems);
                                } else {
                                    die('Statement preparation failed: ' . mysqli_error($con));
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- Buttons for approve and reject actions (initially hidden) -->
                        <div class="text-end" id="actionButtons" style="display: none;">
                            <button class="btn btn-primary" id="approveBtn">Approve Selected</button>
                            <button class="btn btn-danger" id="rejectBtn">Reject Selected</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Handle click event for Select All button
                    $('#selectAllBtn').click(function() {
                        // Check all checkboxes in the table
                        $('input[type="checkbox"]').prop('checked', true);
                        // Show the action buttons
                        $('#actionButtons').show();
                    });
                    
                    // Function to handle checkbox click event
                    $('input[type="checkbox"]').click(function() {
                        if ($(this).prop("checked") == true) {
                            $('#actionButtons').show(); // Show the action buttons when an item is selected
                        } else {
                            // Check if any other checkbox is still selected
                            var anyChecked = false;
                            $('input[type="checkbox"]').each(function() {
                                if ($(this).prop("checked") == true) {
                                    anyChecked = true;
                                    return false; // Break out of the loop
                                }
                            });
                            // Hide the action buttons if no other checkbox is selected
                            if (!anyChecked) {
                                $('#actionButtons').hide();
                            }
                        }
                    });

                    // Approve selected items
                    $('#approveBtn').click(function() {
                        // Implement logic to approve selected items
                        alert('Approve selected items');
                    });

                    // Reject selected items
                    $('#rejectBtn').click(function() {
                        // Implement logic to reject selected items
                        alert('Reject selected items');
                    });
                });
            </script>

        </div>
    </div>
</div>