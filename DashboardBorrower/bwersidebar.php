<aside class="ccs-sidebar">
    <div class="container">
        <div class="sidebar-header col-md-2">
            <!-- You can add a header here if needed -->
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="borrowerDashboardPage.php">
                    <i class="fas fa-list me-2"></i>
                    <span>Available Items</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="borrowerItemsBorrowed.php">
                    <i class="fas fa-cart-arrow-down me-2"></i>
                    <span>Items Borrowed</span>
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
                            Pending Borrow 
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="borrowerPendingReserve.php">
                            <i class="fas fa-clock me-2"></i>
                            Pending Reserve 
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
    .ccs-sidebar {
        font-size: 20px;
    }


    /* Add a specific style for the submenu */
    .ccs-sidebar .submenu {
        margin-left: 8px; /* Adjust the indentation as needed */
        
    }

    .ccs-sidebar .submenu .nav-link {
        padding: 10px 0px; /* Adjust the padding as needed */
        color: #495057; /* Change the text color for submenu items */
    }

    .ccs-sidebar .submenu .nav-link:hover {
        background-color: #dee2e6; /* Change the background color on hover */
    }

    .ccs-sidebar .nav-link {
        color: #343a40; /* Dark text color */
        padding: 10px 0px;
        transition: background-color 0.3s ease;
        
    }

    .ccs-sidebar .nav-link:hover {
        background-color: #e9ecef; /* Light gray background on hover */
        padding: 10px 0px;
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

