<!-- adminheader.php -->
<div class="container-fluid">
    <div class="header--wrapper">
        <div class="header--title">
            <div class="logo-and-text">
                <!-- <img src="/inventory/images/imsicon.png" alt="Logo" class="logo">-->
                <h3>CCS INVENTORY MANAGEMENT SYSTEM</h3>
            </div>
            <span>Admin Dashboard</span>
        </div>
        <div class="user--info">
            <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle custom-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin
                    <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture">
            </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <!-- Add your dropdown items here -->
                    <li><a class="dropdown-item" href="/Inventory/DashboardAdmin/editadminaccount.php">Profile</a></li>
                    <li><a class="dropdown-item" href="/Inventory/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>