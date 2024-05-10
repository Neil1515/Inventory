<?php
// Include necessary files
include ('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}


// Query to fetch pending item removal requests
$sql = "SELECT * FROM `tblusers` WHERE `status` = 'Pending'";
$result = mysqli_query($con, $sql);

// Count the number of pending item removal requests
$accountPending = mysqli_num_rows($result);

// Query to fetch pending item removal requests
$sql = "SELECT COUNT(DISTINCT borrowerid) AS num_borrowers
        FROM tblborrowingreports
        WHERE itemreqstatus = 'Pending Borrow'";
$result = $con->query($sql);

// Check if the query executed successfully
if ($result !== false) {
    // Fetch the count of borrowers with Pending item
    $row = $result->fetch_assoc();
    $borrowerPending = $row['num_borrowers'];
} else {
    // Handle query execution error
    echo "Error: " . $con->error;
}

// Free result set
$result->free_result();

// Query to fetch pending item removal requests
$sql = "SELECT COUNT(DISTINCT borrowerid) AS num_borrowers FROM `tblborrowingreports` WHERE `itemreqstatus` = 'Pending Reserve' OR  `itemreqstatus` = 'Approve Reserve'";
$result = mysqli_query($con, $sql);

// Check if the query executed successfully
if ($result !== false) {
    // Fetch the count of borrowers with Pending item
    $row = $result->fetch_assoc();
    $borrowerreservePending = $row['num_borrowers'];
} else {
    // Handle query execution error
    echo "Error: " . $con->error;
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
            $userType = $row["usertype"];
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
<aside class="ccs-sidebar">
    <div class="container">
        <div class="sidebar-header col-md-2">
            <!-- You can add a header here if needed -->
        </div>
        <ul class="nav flex-column ">
            <li class="nav-item ">
                <a class="nav-link " href="ccsstaffDashboardPage.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="ccsstaffInventoryProperties.php">
                    <i class=" fas fa-box-open me-2"></i>
                    <span>All Items</span>
                </a>
            </li>
            <?php if ($row['usertype'] === 'CCS Staff'): ?>
            <li class="nav-item">
                <a class="nav-link" href="ccstaffListofItems.php">
                    <i class="fas fa-list-ul me-2"></i>
                    <span>List of Items</span>
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#approvalsSubMenu" aria-expanded="false">
                    <i class="fas fa-clock me-2"></i> <!-- Icon for Pending Approvals -->
                    <span>Pending Approvals</span>
                </a>
                <ul class="nav submenu collapse" id="approvalsSubMenu">
                    <li>
                        <a class="nav-link" href="ccsstaffPendingAccounts.php">
                            <i class="fas fa-user-clock me-2"></i> <!-- Icon for Pending Accounts -->
                            Manage Account <sup class="badge bg-danger"><?php echo $accountPending; ?></sup>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="ccsstaffListofPendingBorrowerusers.php">
                            <i class="fas fa-hand-holding me-2"></i> <!-- Icon for Pending Borrow -->
                            Pending Borrow <sup class="badge bg-danger"><?php echo $borrowerPending; ?></sup>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="ccsstaffUsersPendingReserveItems.php">
                            <i class="fas fa-clock me-2"></i> <!-- Icon for Pending Reserve -->
                            Pending Reserve <sup class="badge bg-danger"><?php echo $borrowerreservePending; ?></sup>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if ($row['usertype'] === 'CCS Staff'): ?>
            <li class="nav-item ">
                <a class="nav-link submenu-toggle " href="#" data-bs-toggle="collapse" data-bs-target="#manageItemsSubMenu" aria-expanded="false">
                    <i class="fas fa-cogs me-2"></i>
                    <span>Manage Items</span>
                </a>
                <ul class="nav submenu collapse" id="manageItemsSubMenu">
                    <li >
                        <a class="nav-link" href="ccstaffManageCategory.php">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add Item Category
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="ccstaffManageSubcategory.php">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add Item Name
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="ccstaffAddItemBrand.php">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add Item
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if ($row['usertype'] === 'CCS Staff'): ?>
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#newSubMenu" aria-expanded="false">
                    <i class="fas fa-tasks me-2"></i>
                    <span>Assign Items</span>
                </a>
                <ul class="nav submenu collapse" id="newSubMenu">
                    <li>
                        <!-- Assign for here -->
                        <ul class="nav submenu">
                            <?php
                            // Fetch unique non-empty and non-NULL assignfor values from tblitembrand
                            $queryAssignFor = "SELECT DISTINCT assignfor FROM tblitembrand  WHERE assignfor IS NOT NULL AND assignfor <> '' ORDER BY assignfor";
                            $resultAssignFor = mysqli_query($con, $queryAssignFor);

                            // Check if there are values in the result set
                            if (mysqli_num_rows($resultAssignFor) > 0) {
                                while ($assignForRow = mysqli_fetch_assoc($resultAssignFor)) {
                                    echo "<li><a class='nav-link' href='ccsstaffAssignItems.php?assignfor={$assignForRow['assignfor']}'><i class='fas fa-chalkboard-teacher me-2'></i>{$assignForRow['assignfor']}</a></li>";
                                }
                            } else {
                                // No non-empty and non-NULL values, you can optionally display a message or handle it as needed
                                echo "<li><span class='nav-link'>No Assign Items</span></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="ccsstaffReports.php">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Inventory/logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Log out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<style>
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

