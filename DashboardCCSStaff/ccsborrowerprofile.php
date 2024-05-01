<!-- ccsborrowerprofile.php -->
<?php
// Retrieve borrower information based on the provided borrower ID
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
    $queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
    $stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

    if ($stmtBorrowerDetails) {
        mysqli_stmt_bind_param($stmtBorrowerDetails, "s", $borrowerId);

        if (mysqli_stmt_execute($stmtBorrowerDetails)) {
            $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

            if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
                // Borrower information found, fetch the row
                $row = mysqli_fetch_assoc($resultBorrowerDetails);
            } else {
                // No borrower information found for the provided ID
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
?>

<!-- Display borrower details in a card form -->
<div class="container">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Borrower Profile</h5>
                    <div>
                        <a href="javascript:history.back()" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
                        <a  class="btn btn-primary"><i class="fas fa-file-alt"></i> Reports</a>
                        <a href="ccsstaffConversation.php?sender_id=<?php echo $row['id']; ?>" class="btn btn-success"><i class='fas fa-envelope'></i> Message</a>
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
                                    if (!empty($borrowerId)) {
                                        $profileImagePath = "/inventory/images/imageofusers/{$borrowerId}.png";
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
                                    <h6> <span class="report-icon" title="Report this account"><i class="fas fa-flag"></i>
                                        Name: <?php echo $row['fname'] .' '. $row['lname']; ?>  </span>
                                        <?php
                                        // Check the online status and display the appropriate icon
                                        if ($row['online_status'] == 'online') {
                                            echo '<span class="text-success small-dot"><i class="fas fa-check-circle"></i> Online</span>'; // Checkmark icon for online
                                        } else {
                                            echo '<span class="text-danger small-dot"><i class="fas fa-times-circle"></i> Offline</span>'; // Times icon for offline
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
                                    <li class="list-group-item">Total Item (Damage/Lost): <?php echo $totalDamageLostItems ?></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Circular cards -->
                        <div class="row mt-4">
                            <div class="col-md-3 mt-2">
                            <a href="ccsstaffViewUnreturnItems.php?borrower_id=<?php echo $row['id']; ?>" class="hoverable-card">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Borrowed Items</h5>
                                        <h3 class="card-text"><?php echo $totalApprovedItems ?></h3>
                                    </div>
                                </div>
                            </a>
                            </div>
                            <div class="col-md-3 mt-2">
                            <a href="ccsstaffViewBorrower_all_items.php?borrowerId=<?php echo $row['id']; ?>" class="hoverable-card">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Pending Borrow</h5>
                                        <h3 class="card-text"><?php echo $totalPendingBorrowItems ?></h3>
                                    </div>
                                </div>
                            </a>
                            </div>
                            <div class="col-md-3 mt-2">
                            <a href="ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $row['id']; ?>" class="hoverable-card">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Accepted Reserve</h5>
                                        <h3 class="card-text"><?php echo $totalApprovedReserveItems ?></h3>
                                    </div>
                                </div>
                            </a>
                            </div>
                            <div class="col-md-3 mt-2">
                            <a href="ccsstaffViewBorrower_allreserve_items.php?borrowerId=<?php echo $row['id']; ?>" class="hoverable-card">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Pending Reserve</h5>
                                        <h3 class="card-text"><?php echo $totalPendingReserveItems  ?></h3>
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
            text-decoration: none !important;;
        }
        .hoverable-card:hover .card {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
        .report-icon:hover {
    color: #dc3545; /* Change to desired danger color */
    cursor: pointer;
}
.report-icon::after {
    content: "Report this account?";
    position: absolute;
    left: 20px; /* Adjust as needed */
    top: -20px; /* Adjust as needed */
    display: none;
    background-color: #dc3545; /* Change to desired danger color */
    color: #fff;
    padding: 3px 6px;
    border-radius: 5px;
    font-size: 12px;
}
.report-icon:hover::after {
    display: inline-block;
}

    </style>