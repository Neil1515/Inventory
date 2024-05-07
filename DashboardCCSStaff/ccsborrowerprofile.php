<!-- ccsborrowerprofile.php -->
<?php
// Check if the borrower ID is set
if (isset($_GET['borrower_id'])) {
    $borrowerId = mysqli_real_escape_string($con, $_GET['borrower_id']);

    // Query to count total returned items
    $queryReturnedItems = "SELECT COUNT(*) AS total_returned FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Returned'";
    $stmtReturnedItems = mysqli_prepare($con, $queryReturnedItems);

    if ($stmtReturnedItems) {
        mysqli_stmt_bind_param($stmtReturnedItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtReturnedItems)) {
            $resultReturnedItems = mysqli_stmt_get_result($stmtReturnedItems);
            $rowReturnedItems = mysqli_fetch_assoc($resultReturnedItems);
            $totalReturnedItems = $rowReturnedItems['total_returned'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtReturnedItems));
        }

        mysqli_stmt_close($stmtReturnedItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }
    // Query to count total borrowed items where approvebyid is not null and the count is greater than 0
    $queryBorrowedItems = "SELECT COUNT(*) AS total_borrowed FROM tblborrowingreports WHERE borrowerid = ? AND approvebyid IS NOT NULL AND approvebyid != ''";
    $stmtBorrowedItems = mysqli_prepare($con, $queryBorrowedItems);

    if ($stmtBorrowedItems) {
        mysqli_stmt_bind_param($stmtBorrowedItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtBorrowedItems)) {
            $resultBorrowedItems = mysqli_stmt_get_result($stmtBorrowedItems);
            $rowBorrowedItems = mysqli_fetch_assoc($resultBorrowedItems);
            $totalBorrowedItems = $rowBorrowedItems['total_borrowed'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowedItems));
        }

        mysqli_stmt_close($stmtBorrowedItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to count total approved items and request returns for the borrower
    $queryApprovedItems = "SELECT COUNT(*) AS total_approved FROM tblborrowingreports WHERE borrowerid = ? AND (itemreqstatus = 'Approved' OR itemreqstatus = 'Request Return')";
    $stmtApprovedItems = mysqli_prepare($con, $queryApprovedItems);

    if ($stmtApprovedItems) {
        mysqli_stmt_bind_param($stmtApprovedItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtApprovedItems)) {
            $resultApprovedItems = mysqli_stmt_get_result($stmtApprovedItems);
            $rowApprovedItems = mysqli_fetch_assoc($resultApprovedItems);
            $totalApprovedItems = $rowApprovedItems['total_approved'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtApprovedItems));
        }

        mysqli_stmt_close($stmtApprovedItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to count total pending borrow items for the borrower
    $queryPendingBorrowItems = "SELECT COUNT(*) AS total_pending_borrow FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Borrow'";
    $stmtPendingBorrowItems = mysqli_prepare($con, $queryPendingBorrowItems);

    if ($stmtPendingBorrowItems) {
        mysqli_stmt_bind_param($stmtPendingBorrowItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtPendingBorrowItems)) {
            $resultPendingBorrowItems = mysqli_stmt_get_result($stmtPendingBorrowItems);
            $rowPendingBorrowItems = mysqli_fetch_assoc($resultPendingBorrowItems);
            $totalPendingBorrowItems = $rowPendingBorrowItems['total_pending_borrow'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingBorrowItems));
        }

        mysqli_stmt_close($stmtPendingBorrowItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to count total pending reserve items for the borrower
    $queryPendingReserveItems = "SELECT COUNT(*) AS total_pending_reserve FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Reserve'";
    $stmtPendingReserveItems = mysqli_prepare($con, $queryPendingReserveItems);

    if ($stmtPendingReserveItems) {
        mysqli_stmt_bind_param($stmtPendingReserveItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtPendingReserveItems)) {
            $resultPendingReserveItems = mysqli_stmt_get_result($stmtPendingReserveItems);
            $rowPendingReserveItems = mysqli_fetch_assoc($resultPendingReserveItems);
            $totalPendingReserveItems = $rowPendingReserveItems['total_pending_reserve'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingReserveItems));
        }

        mysqli_stmt_close($stmtPendingReserveItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to count total damage or lost items for the borrower
    $queryDamageLostItems = "SELECT COUNT(*) AS total_damage_lost FROM tblborrowingreports WHERE borrowerid = ? AND returnitemcondition IN ('Damage', 'Lost')";
    $stmtDamageLostItems = mysqli_prepare($con, $queryDamageLostItems);

    if ($stmtDamageLostItems) {
        mysqli_stmt_bind_param($stmtDamageLostItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtDamageLostItems)) {
            $resultDamageLostItems = mysqli_stmt_get_result($stmtDamageLostItems);
            $rowDamageLostItems = mysqli_fetch_assoc($resultDamageLostItems);
            $totalDamageLostItems = $rowDamageLostItems['total_damage_lost'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtDamageLostItems));
        }

        mysqli_stmt_close($stmtDamageLostItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to count total approved reserve items for the borrower
    $queryApprovedReserveItems = "SELECT COUNT(*) AS total_approved_reserve FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Approve Reserve'";
    $stmtApprovedReserveItems = mysqli_prepare($con, $queryApprovedReserveItems);

    if ($stmtApprovedReserveItems) {
        mysqli_stmt_bind_param($stmtApprovedReserveItems, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtApprovedReserveItems)) {
            $resultApprovedReserveItems = mysqli_stmt_get_result($stmtApprovedReserveItems);
            $rowApprovedReserveItems = mysqli_fetch_assoc($resultApprovedReserveItems);
            $totalApprovedReserveItems = $rowApprovedReserveItems['total_approved_reserve'];
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtApprovedReserveItems));
        }

        mysqli_stmt_close($stmtApprovedReserveItems);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Query to retrieve borrower details
    $queryBorrowerDetails = "SELECT * FROM tblusers WHERE (usertype='Student' OR usertype='Employee') AND id = ?";
    $stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

    if ($stmtBorrowerDetails) {
        mysqli_stmt_bind_param($stmtBorrowerDetails, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtBorrowerDetails)) {
            $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

            if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
                // Borrower information found, fetch the row
                $row = mysqli_fetch_assoc($resultBorrowerDetails);
                $userBorrowerId = $row['id'];
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">';
                die("No borrower information found for ID: $borrowerId");
            }
        } else {
            // Handle query execution failure
            die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
        }

        mysqli_stmt_close($stmtBorrowerDetails);
    } else {
        // Handle statement preparation failure
        die('Statement preparation failed: ' . mysqli_error($con));
    }
}
// Check if the form is submitted
if (isset($_POST['reportuserBtn'])) {
    // Check if all required fields are filled
    if (isset($_POST['reportReason']) && !empty($_POST['reportReason'])) {
        // Insert the reported user data into the database
        date_default_timezone_set('Asia/Manila');
        $datetimereported = date("Y-m-d H:i:s");
        // Get the report reason
        $reportReason = $_POST['reportReason'];

        // If the reason is "Other", get the other reason text
        if ($reportReason == 'Other' && isset($_POST['otherReason']) && !empty($_POST['otherReason'])) {
            $otherReason = $_POST['otherReason'];
            // Set the report reason to the other reason text
            $reportReason = $otherReason;
        }

        // Check if the borrower has already been reported
        $queryCheckReport = "SELECT * FROM tblreportborroweracc WHERE borrowerid = ? AND (status = 'Pending' OR status = 'Approved')";
        $stmtCheckReport = mysqli_prepare($con, $queryCheckReport);
        if ($stmtCheckReport) {
            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmtCheckReport, "s", $borrowerId);
            if (mysqli_stmt_execute($stmtCheckReport)) {
                // Fetch the result
                $resultCheckReport = mysqli_stmt_get_result($stmtCheckReport);
                if (mysqli_num_rows($resultCheckReport) > 0) {
                    // Borrower already reported
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo '<div>This borrower has already been reported.</div>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                } else {
                    $queryInsertReport = "INSERT INTO tblreportborroweracc (staffid, borrowerid, reason, status, datetimereported) VALUES (?, ?, ?, 'Pending', ?)";
                    $stmtInsertReport = mysqli_prepare($con, $queryInsertReport);
                    if ($stmtInsertReport) {
                        // Bind parameters and execute the statement
                        mysqli_stmt_bind_param($stmtInsertReport, "ssss", $staffId, $borrowerId, $reportReason, $datetimereported);
                        if (mysqli_stmt_execute($stmtInsertReport)) {
                            // Report inserted successfully
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                            echo '<div>Report submitted successfully. Please await approval from Admin.</div>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        } else {
                            // Handle query execution failure
                            echo '<div class="alert alert-danger" role="alert">Error: Unable to submit report.</div>';
                        }
                        mysqli_stmt_close($stmtInsertReport);
                    } else {
                        // Handle statement preparation failure
                        echo '<div class="alert alert-danger" role="alert">Error: Unable to prepare statement.</div>';
                    }
                }
            } else {
                // Handle query execution failure
                echo '<div class="alert alert-danger" role="alert">Error: Unable to execute query.</div>';
            }
            mysqli_stmt_close($stmtCheckReport);
        } else {
            // Handle statement preparation failure
            echo '<div class="alert alert-danger" role="alert">Error: Unable to prepare statement.</div>';
        }
    } else {
        // If report reason is not selected
        echo '<div class="alert alert-danger" role="alert">Please select a reason for reporting.</div>';
    }
}
?>
<!-- Report user Modal -->
<div class="modal fade" id="reportuserModal" tabindex="-1" aria-labelledby="reportuserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportuserModalLabel">Report User Account </h5>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="/inventory/images/account1.png" alt="Image" id="userImage"
                            style="width: 200px; height: 200px;">
                    </div>

                    <div class="form-group">
                        <label for="reportReason">Reason for Reporting<span class="text-danger">*</span></label>
                        <select class="form-control" id="reportReason" name="reportReason" required>
                            <option value="" selected disabled>Select Reason</option>
                            <option value="Spamming borrow/reserve requests">Spamming borrow/reserve requests</option>
                            <option value="Suspicious behavior">Suspicious behavior</option>
                            <option value="Damaging borrowed items intentionally">Damaging borrowed items intentionally
                            </option>
                            <option value="Not returning borrowed items">Not returning borrowed items</option>
                            <option value="Violating terms and conditions">Violating terms and conditions</option>
                            <option value="Other">Other (please specify)</option> <!-- Change value to "Other" -->
                        </select>

                    </div>
                    <div class="form-group mt-3" id="otherReasonGroup" style="display: none;">
                        <label for="otherReason">Other Reason<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="otherReason" name="otherReason">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="reportuserBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Display borrower details in a card form -->
<div class="container">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5> Borrower Profile</h5>
                    <div>
                        <a href="javascript:history.back()" class="btn btn-danger"><i class="fas fa-arrow-left"></i>
                            Back</a>
                        <a href="ccsstaffborrowerreports.php?borrower_id=<?php echo $row['id']; ?>"
                            class="btn btn-primary"><i class="fas fa-file-alt"></i> Reports</a>
                        <a href="ccsstaffConversation.php?sender_id=<?php echo $row['id']; ?>"
                            class="btn btn-success"><i class='fas fa-envelope'></i> Message</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($row)) {
                        // Display borrower details in the card
                        ?>
                        <div class="row align-items-center">
                            <!-- Profile picture -->
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    <?php
                                    // Display profile picture
                                    if (!empty($userBorrowerId)) {
                                        $profileImagePath = "/inventory/images/imageofusers/{$userBorrowerId}.png";
                                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                                            echo '<img src="' . $profileImagePath . '?' . time() . '" class="img-fluid rounded-circle " width="250" height="250">';
                                        } else {
                                            echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" class="img-fluid rounded-circle" width="250" height="250">';
                                        }
                                    } else {
                                        echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" class="img-fluid rounded-circle" width="250" height="250">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- Profile details -->
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h6> <span class="report-icon" id="borrowerName"><i class="fas fa-flag"></i>
                                                Name: <?php echo $row['fname'] . ' ' . $row['lname']; ?> </span>
                                            <?php
                                            // Check the online status and display the appropriate icon
                                            if ($row['online_status'] == 'online') {
                                                echo '<span class="text-success small-dot"><i class="fas fa-check-circle"></i> Online</span>'; // Checkmark icon for online
                                            } else {
                                                echo '<span class="text-danger small-dot"><i class="fas fa-times-circle"></i> Offline</span>'; // Times icon for offline
                                            }
                                            ?>
                                            <?php
                                            // Check if the borrower has already been reported
                                            $queryCheckReport = "SELECT * FROM tblreportborroweracc WHERE borrowerid = ? AND status IN ('Pending', 'Approved')";
                                            $stmtCheckReport = mysqli_prepare($con, $queryCheckReport);

                                            if ($stmtCheckReport) {
                                                // Bind parameters and execute the statement
                                                mysqli_stmt_bind_param($stmtCheckReport, "s", $userBorrowerId); // Use $userBorrowerId here
                                                if (mysqli_stmt_execute($stmtCheckReport)) {
                                                    // Fetch the result
                                                    $resultCheckReport = mysqli_stmt_get_result($stmtCheckReport);
                                                    if (mysqli_num_rows($resultCheckReport) > 0) {
                                                        // Borrower already reported
                                                        while ($rowReport = mysqli_fetch_assoc($resultCheckReport)) {
                                                            if ($rowReport['status'] === 'Pending') {
                                                                // Borrower reported as pending
                                                                echo '<h5 class="card-title"><span class="text-danger"> <i class="fas fa-exclamation-triangle"></i> Reported Pending</span></h5>';
                                                            } else if ($rowReport['status'] === 'Approved') {
                                                                // Borrower reported as Approved
                                                                echo '<h5 class="card-title"><span class="text-danger"> <i class="fas fa-exclamation-triangle"></i> Account Blocked</span></h5>';
                                                            } else if ($rowReport['status'] === 'Unblock') {
                                                                // Borrower reported as Declined or Unblock
                                                                echo '<h5 class="card-title"></h5>';
                                                            } else if ($rowReport['status'] === 'Declined') {
                                                                // Borrower reported as Declined or Unblock
                                                                echo '<h5 class="card-title"></h5>';
                                                            }
                                                        }
                                                    } else {
                                                        // Borrower not reported
                                                        echo '<h5 class="card-title"></h5>';
                                                    }
                                                }
                                                mysqli_stmt_close($stmtCheckReport);
                                            }

                                            ?>
                                        </h6>
                                    </li>
                                    <li class="list-group-item">Email: <?php echo $row['email']; ?></li>
                                    <li class="list-group-item">User Type: <?php echo $row['usertype']; ?></li>
                                    <li class="list-group-item">Department: <?php echo $row['department']; ?></li>
                                    <li class="list-group-item">Gender: <?php echo $row['gender']; ?></li>
                                    <li class="list-group-item">Total Item Borrowed: <?php echo $totalBorrowedItems ?></li>
                                    <li class="list-group-item">Total Item Returned: <?php echo $totalReturnedItems ?></li>
                                    <li class="list-group-item">Total Item (Damage/Lost):
                                        <?php echo $totalDamageLostItems ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Circular cards -->
                        <div class="row mt-4">
                            <div class="col-md-3 mt-2">
                                <a href="ccsstaffViewUnreturnItems.php?borrower_id=<?php echo $row['id']; ?>"
                                    class="hoverable-card">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Borrowed Items</h5>
                                            <h3 class="card-text"><?php echo $totalApprovedItems ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mt-2">
                                <a href="ccsstaffViewBorrower_all_items.php?borrowerId=<?php echo $row['id']; ?>"
                                    class="hoverable-card">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Pending Borrow</h5>
                                            <h3 class="card-text"><?php echo $totalPendingBorrowItems ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mt-2">
                                <a href="ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $row['id']; ?>"
                                    class="hoverable-card">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Accepted Reserve</h5>
                                            <h3 class="card-text"><?php echo $totalApprovedReserveItems ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mt-2">
                                <a href="ccsstaffViewBorrower_allreserve_items.php?borrowerId=<?php echo $row['id']; ?>"
                                    class="hoverable-card">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Pending Reserve</h5>
                                            <h3 class="card-text"><?php echo $totalPendingReserveItems ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    } else {
                        // Display error message if no borrower details found
                        echo '<p>No borrower information found. </p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    a {
        text-decoration: none !important;
        ;
    }

    .hoverable-card:hover .card {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    .report-icon:hover {
        color: #dc3545;
        /* Change to desired danger color */
        cursor: pointer;
    }

    .report-icon::after {
        content: "Report this user?";
        position: absolute;
        left: 20px;
        /* Adjust as needed */
        top: -20px;
        /* Adjust as needed */
        display: none;
        background-color: #dc3545;
        /* Change to desired danger color */
        color: #fff;
        padding: 3px 6px;
        border-radius: 5px;
        font-size: 12px;
    }

    .report-icon:hover::after {
        display: inline-block;
    }
</style>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap and Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.getElementById('borrowerName').addEventListener('click', function () {
        $('#reportuserModal').modal('show'); // Show the modal
    });
    document.getElementById('reportReason').addEventListener('change', function () {
        var otherReasonGroup = document.getElementById('otherReasonGroup');
        var otherReasonInput = document.getElementById('otherReason');

        if (this.value === 'Other') { // Update this condition
            otherReasonGroup.style.display = 'block';
            otherReasonInput.required = true;
            otherReasonInput.placeholder = 'Enter other reason here'; // Set placeholder text
        } else {
            otherReasonGroup.style.display = 'none';
            otherReasonInput.required = false;
            otherReasonInput.placeholder = ''; // Clear placeholder text
        }
    });

    // Ensure that the "Other Reason" field is properly shown/hidden on page load
    window.addEventListener('DOMContentLoaded', function () {
        var reportReasonSelect = document.getElementById('reportReason');
        var otherReasonGroup = document.getElementById('otherReasonGroup');
        var otherReasonInput = document.getElementById('otherReason');

        if (reportReasonSelect.value === 'Other') { // Update this condition
            otherReasonGroup.style.display = 'block';
            otherReasonInput.required = true;
            otherReasonInput.placeholder = 'Enter other reason here'; // Set placeholder text
        } else {
            otherReasonGroup.style.display = 'none';
            otherReasonInput.required = false;
            otherReasonInput.placeholder = ''; // Clear placeholder text
        }
    });
</script>