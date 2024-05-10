<!-- ccslistofpendingborrowerusers.php -->
<?php
    include 'ccsfunctions.php';
    // Assuming you have an active database connection stored in $con
    // Fetch staff ID from the session
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

    // Fetch unique borrower IDs with pending requests
    $queryBorrowers = "SELECT DISTINCT borrowerid FROM tblborrowingreports WHERE itemreqstatus = 'Pending Borrow'";
    $resultBorrowers = mysqli_query($con, $queryBorrowers);

    // Output the container and search input
    echo '<div class="ccs-main-container">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="d-flex justify-content-between">';
    echo '<h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>List of Pending Borrow</h3>';
    echo '<div class="text-end">';
    echo '<input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">';
    echo '</div>';
    echo '</div>';
    echo '<div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 g-1">';

    $cardCount = 0; // Track the number of cards displayed

    if ($resultBorrowers && mysqli_num_rows($resultBorrowers) > 0) {
        // Iterate through each borrower
        while ($rowBorrower = mysqli_fetch_assoc($resultBorrowers)) {
            $borrowerId = $rowBorrower['borrowerid'];

            // Count the number of items requested by the current borrower
            $queryItemCount = "SELECT COUNT(itemid) AS itemCount FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Borrow'";
            $stmtItemCount = mysqli_prepare($con, $queryItemCount);

            if ($stmtItemCount) {
                mysqli_stmt_bind_param($stmtItemCount, "i", $borrowerId);

                if (mysqli_stmt_execute($stmtItemCount)) {
                    $resultItemCount = mysqli_stmt_get_result($stmtItemCount);
                    $rowItemCount = mysqli_fetch_assoc($resultItemCount);

                    // Valid borrower details, fetch the borrower details and display them in a card
                    $queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
                    $stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

                    if ($stmtBorrowerDetails) {
                        mysqli_stmt_bind_param($stmtBorrowerDetails, "i", $borrowerId);

                        if (mysqli_stmt_execute($stmtBorrowerDetails)) {
                            $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

                            if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
                                $borrowerDetails = mysqli_fetch_assoc($resultBorrowerDetails);
                                $cardCount++; // Increment card count
                ?>
                                <div class="card me-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Name: <a href="ccstaffBorrowerProfile.php?borrower_id=<?php echo $borrowerId; ?>"><?php echo $borrowerDetails['fname'] . ' ' . $borrowerDetails['lname']; ?></a></h5>
                                        <p class="card-text"><?php echo $borrowerDetails['usertype']; ?> ID: <?php echo $borrowerDetails['id']; ?></p>
                                        <p class="card-text">Number of item(s): <?php echo $rowItemCount['itemCount']; ?></p>

                                        <!-- Display the item IDs with pending status and their subcategories with quantity -->
                                        <?php
                                        $queryPendingItems = "SELECT br.itemid, ib.subcategoryname
                                            FROM tblborrowingreports br
                                            INNER JOIN tblitembrand ib ON br.itemid = ib.id
                                            WHERE br.borrowerid = ? AND br.itemreqstatus = 'Pending Borrow'";
                                        $stmtPendingItems = mysqli_prepare($con, $queryPendingItems);

                                        if ($stmtPendingItems) {
                                            mysqli_stmt_bind_param($stmtPendingItems, "i", $borrowerId);

                                            if (mysqli_stmt_execute($stmtPendingItems)) {
                                                $resultPendingItems = mysqli_stmt_get_result($stmtPendingItems);

                                                if ($resultPendingItems && mysqli_num_rows($resultPendingItems) > 0) {
                                                    $itemCounts = array();

                                                    while ($rowPendingItem = mysqli_fetch_assoc($resultPendingItems)) {
                                                        $subcategory = $rowPendingItem['subcategoryname'];

                                                        // Increment the count for each subcategory
                                                        if (isset($itemCounts[$subcategory])) {
                                                            $itemCounts[$subcategory]++;
                                                        } else {
                                                            $itemCounts[$subcategory] = 1;
                                                        }
                                                    }

                                                    echo '<p class="card-text">Pending Item(s): ';
                                                    foreach ($itemCounts as $subcategory => $count) {
                                                        echo $subcategory;

                                                        // Display quantity if greater than 1
                                                        if ($count > 1) {
                                                            echo '(' . $count . ')';
                                                        }
                                                        echo ', ';
                                                    }
                                                    echo '</p>';
                                                } else {
                                                    echo '<p class="card-text">No items with pending status.</p>';
                                                }
                                            } else {
                                                die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingItems));
                                            }

                                            mysqli_stmt_close($stmtPendingItems);
                                        } else {
                                            die('Statement preparation failed: ' . mysqli_error($con));
                                        }
                                        ?>
                                    </div>
                            <div class='text-end me-1'>
                                <a class='btn btn-danger mb-1' onclick="rejectAllItemsToThisBorrowerId(<?php echo $borrowerId; ?>, '<?php echo $borrowerDetails['fname'] . ' ' . $borrowerDetails['lname']; ?>')">Reject All</a>
                                <a class='btn btn-primary mb-1' onclick="approveAllItemsToThisBorrowerId(<?php echo $borrowerId; ?>, '<?php echo $borrowerDetails['fname'] . ' ' . $borrowerDetails['lname']; ?>')">Release All</a>
                                <a href='ccsstaffViewBorrower_all_items.php?borrowerId=<?php echo $borrowerId; ?>' class='btn btn-success mb-1'>View <?php echo $rowItemCount['itemCount']; ?> Items</a>
                            </div>
                        </div>
                            <?php
                        } else {
                            echo "<p class='alert alert-warning'>No details found for borrower ID: {$borrowerId}</p>";
                        }
                    } else {
                        die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
                    }
                    mysqli_stmt_close($stmtBorrowerDetails);
                } else {
                    die('Statement preparation failed: ' . mysqli_error($con));
                }
            } else {
                die('Statement execution failed: ' . mysqli_stmt_error($stmtItemCount));
            }
            mysqli_stmt_close($stmtItemCount);
        } else {
            die('Statement preparation failed: ' . mysqli_error($con));
        }
    }
} else {
    echo '<div class="col-md-10">';
    echo '<p class="alert alert-info">No borrowers with pending requests found.</p>';
    echo '</div>';
}

// Close the container div
echo '</div>';
echo '</div>';
echo '</div>';
?>
<!-- Modalrelease HTML Structure -->
<div class="modal fade" id="confirmationModalrelease" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmationModalLabel">Pending Approval</h4>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            </div>
            <!-- Image -->
            <div class="text-center mt-3">
                <img src="\Inventory\images\hardware-tools.png"  width='430' alt="User">
            </div> 
            <div class="modal-body">     
                <!-- Note -->
                <p class="text-center" id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <!-- Disabled Confirm button initially -->
                <button type="button" class="btn btn-danger" id="" data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApproveButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Modalreject HTML Structure -->
<div class="modal fade" id="confirmationModalreject" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmationModalLabel">Pending Approval</h4>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            </div>
            <!-- Image -->
            <div class="text-center mt-3">
                <img src="\Inventory\images\hardware-tools.png"  width='430' alt="User">
            </div> 
            <div class="modal-body">     
                <!-- Note -->
                <p class="text-center" id="modalMessages"></p>
            </div>
            <div class="modal-footer">
                <!-- Disabled Confirm button initially -->
                <button type="button" class="btn btn-danger" id="" data-bs-dismiss="modal" >Cancel</button>
                <button type="button" class="btn btn-success" id="confirmRejectButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
function approveAllItemsToThisBorrowerId(borrowerId, borrowerName) {
     // Set the confirmation message
     $('#modalMessage').html('Are you sure you want to <strong class="text-success">RELEASE</strong> all items to this user? <br><h5><strong class="text-danger">'+borrowerName+'</strong></h5>');
    // Show the confirmation modal
    $('#confirmationModalrelease').modal('show');

    // Set the borrowerId as a data attribute in the confirm button
    $('#confirmApproveButton').attr('data-borrower-id', borrowerId);
}

function rejectAllItemsToThisBorrowerId(borrowerId, borrowerName) {
    // Set the confirmation message
    $('#modalMessages').html('Are you sure you want to <strong class="text-danger">REJECT</strong> all items to this user? <h5><strong class="text-danger">' + borrowerName + '</strong></h5>');
    // Show the confirmation modal
    $('#confirmationModalreject').modal('show');

    // Set the borrowerId as a data attribute in the confirm button
    $('#confirmRejectButton').attr('data-borrower-id', borrowerId);
}

// Function to handle approval confirmation on modal confirm button click
$('#confirmApproveButton').click(function() {
    var borrowerId = $(this).attr('data-borrower-id');

    // Send an AJAX request to approve all items
    $.ajax({
        type: 'GET',
        url: 'ccsapproveborrower_all_items.php',
        data: { borrowerId: borrowerId },
        success: function (response) {
            handleApprovalResponse(response);
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed. Status: ' + status + ', Error: ' + error);
        }
    });
});

// Function to handle rejection confirmation on modal confirm button click
$('#confirmRejectButton').click(function() {
    var borrowerId = $(this).attr('data-borrower-id');

    // Send an AJAX request to reject all items
    $.ajax({
        type: 'GET',
        url: 'ccsrejectborrower_all_items.php',
        data: { borrowerId: borrowerId },
        success: function (response) {
            handleRejectResponse(response);
        },
        error: function (xhr, status, error) {
            console.error('AJAX request failed. Status: ' + status + ', Error: ' + error);
        }
    });
});

// Function to handle response after approval
function handleApprovalResponse(response) {
    console.log(response);

    // Handle the response accordingly
    if (response.includes('Items approved successfully')) {
        $('#confirmationModalrelease').modal('hide'); // Hide the modal
        showSwal('success-message'); // Show success message
        // You can also update the UI dynamically if needed
        window.location.href = 'ccsstaffListofPendingBorrowerusers.php?msg_success=Items approved successfully by ';
    } else {
        // Handle error case
        $('#confirmationModalrelease').modal('hide'); // Hide the modal
        alert('Error: ' + response);
    }
}

// Function to handle response after rejection
function handleRejectResponse(response) {
    console.log(response);

    // Handle the response accordingly
    if (response.includes('Items reject successfully')) {
        $('#confirmationModalreject').modal('hide'); // Hide the modal
        showSwal('success-message'); // Show success message
        // You can also update the UI dynamically if needed
        window.location.href = 'ccsstaffListofPendingBorrowerusers.php?msg_success=Items reject successfully ';
    } else {
        // Handle error case
        $('#confirmationModalreject').modal('hide'); // Hide the modal
        alert('Error: ' + response);
    }
}

(function($) {
  showSwal = function(type) {
    'use strict';
     if (type === 'success-message') {
      swal({
        title: ' Successfully!',
        text: 'Successfully',
        type: 'success',
      })

    } else {
        swal("Error occurred !");
    } 
  }
})(jQuery);
</script>
<style>
    .card:hover {
        background-color: azure;
        transition: background-color 0.3s ease-in-out;
        cursor: pointer;
    }
    a {
        text-decoration: none !important;
        ;
    }
</style>
