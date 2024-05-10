
<?php
// Include necessary files
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user information based on the logged-in user ID
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
            die('User information not found');
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
// Count the number of items borrowed by the borrower where itemreqstatus is 'Approved'
$countQuery = "SELECT COUNT(*) AS borrowed_count FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Approved'";
$countStmt = mysqli_prepare($con, $countQuery);

if ($countStmt) {
    mysqli_stmt_bind_param($countStmt, "i", $borrowerId);

    if (mysqli_stmt_execute($countStmt)) {
        $countResult = mysqli_stmt_get_result($countStmt);
        $countRow = mysqli_fetch_assoc($countResult);
        $borrowedCount = $countRow['borrowed_count'];
    } else {
        // Handle the case when count query execution fails
        die('Count query execution failed: ' . mysqli_stmt_error($countStmt));
    }
    mysqli_stmt_close($countStmt);
} else {
    // Handle the case when count statement preparation fails
    die('Count statement preparation failed: ' . mysqli_error($con));
}

// Count the number of items borrowed by the borrower where itemreqstatus is 'Approved'
$countQuery = "SELECT COUNT(*) AS pendingborrow_count FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Borrow'";
$countStmt = mysqli_prepare($con, $countQuery);

if ($countStmt) {
    mysqli_stmt_bind_param($countStmt, "i", $borrowerId);

    if (mysqli_stmt_execute($countStmt)) {
        $countResult = mysqli_stmt_get_result($countStmt);
        $countRow = mysqli_fetch_assoc($countResult);
        $pendingborrowCount = $countRow['pendingborrow_count'];
    } else {
        // Handle the case when count query execution fails
        die('Count query execution failed: ' . mysqli_stmt_error($countStmt));
    }
    mysqli_stmt_close($countStmt);
} else {
    // Handle the case when count statement preparation fails
    die('Count statement preparation failed: ' . mysqli_error($con));
}

// Count the number of items borrowed by the borrower where itemreqstatus is 'Approved'
$countQuery = "SELECT COUNT(*) AS reserve_count FROM tblborrowingreports WHERE borrowerid = ? AND (itemreqstatus = 'Pending Reserve' OR itemreqstatus = 'Approve Reserve')";
$countStmt = mysqli_prepare($con, $countQuery);

if ($countStmt) {
    mysqli_stmt_bind_param($countStmt, "i", $borrowerId);

    if (mysqli_stmt_execute($countStmt)) {
        $countResult = mysqli_stmt_get_result($countStmt);
        $countRow = mysqli_fetch_assoc($countResult);
        $reserveCount = $countRow['reserve_count'];
    } else {
        // Handle the case when count query execution fails
        die('Count query execution failed: ' . mysqli_stmt_error($countStmt));
    }
    mysqli_stmt_close($countStmt);
} else {
    // Handle the case when count statement preparation fails
    die('Count statement preparation failed: ' . mysqli_error($con));
}
?>
<aside class="ccs-sidebar">
    <div class="container">
        <div class="sidebar-header col-md-2">
            <!-- You can add a header here if needed -->
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="borrowerDashboardPage.php">
                    <i class="fas fa-list me-2"></i>
                    Available Items
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="borrowerItemsBorrowed.php">
                    <i class="fas fa-cart-arrow-down me-2"></i>
                    Item Borrowed (<?php echo $borrowedCount; ?>)
                </a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#approvalsSubMenu" aria-expanded="false">
                    <i class="fas fa-history me-2"></i>
                    <span>Pending Request</span>
                </a>
                <ul class="nav submenu collapse" id="approvalsSubMenu">
                    <li>
                        <a class="nav-link" href="borrowerPendingborrowItems.php">
                            <i class="fas fa-clock me-2"></i>
                            Pending Borrow <sup class="badge bg-danger"><?php echo $pendingborrowCount; ?></sup>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="borrowerPendingReserve.php">
                            <i class="fas fa-clock me-2"></i>
                            Pending Reserve <sup class="badge bg-danger"><?php echo $reserveCount; ?></sup>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="borrowerReports.php">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="bwerlogout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Log out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<style>
    .sup {
    font-size: 10px; /* Define the font size */
}

    .ccs-sidebar {
        font-size: 20px;
    }

    /* Add a specific style for the submenu */
    .ccs-sidebar .submenu {
        margin-left: 10px; /* Adjust the indentation as needed */
        
    }

    .ccs-sidebar .submenu .nav-link {
        padding: 8px 0px; /* Adjust the padding as needed */
        color: #495057; /* Change the text color for submenu items */
        font-size: 17px;
    }

    .ccs-sidebar .submenu .nav-link:hover {
        background-color: #dee2e6; /* Change the background color on hover */
    }

    .ccs-sidebar .nav-link {
        color: #343a40; /* Dark text color */
        padding: 8px 0px;
        transition: background-color 0.3s ease;
        
    }

    .ccs-sidebar .nav-link:hover {
        background-color: #e9ecef; /* Light gray background on hover */
        padding: 8px 0px;
    }

    .ccs-sidebar .nav-link.active {
        background-color: #007bff; /* Blue background for active link */
        color: #ffffff; /* White text color for active link */
        padding: 10px 0px;
    }

    @media (max-width: 768px) {
        .ccs-sidebar {
            font-size: 23px;
        }
    }
</style>

