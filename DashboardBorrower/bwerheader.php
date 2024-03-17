<!-- borrowerheader.php -->
<div class="container-fluid">
    <div class="header--wrapper py-3">
        <div class="header sad">
            <div class="logo-and-text">
                <!--<img src="/inventory/images/imsicon.png" alt="Logo" class="rounded float-start">-->
                <h3 class="text-dark">CCS INVENTORY MANAGEMENT SYSTEM</h3>
            </div>
            <span class="text-muted">Borrower/<?php echo $row['usertype']; ?> Dashboard</span>
        </div>
        <div class="user--info">
            <div class="dropdown">
                <!-- Notification Icon and Counter -->
                <a href="borrowerMessage.php" class="btn btn-secondary custom-dropdown-btn" type="button" id="messageDropdown" data-bs-toggle="messagedropdown" aria-expanded="false">
                    <i class="fas fa-envelope fs-5 me-1"></i> <!-- Message icon -->
                    <sup class="badge bg-danger">0</sup> <!-- Notification counter -->
                </a>

                <!-- Notification Icon and Counter -->
                <button class="btn btn-secondary custom-dropdown-btn" type="button" id="notificationDropdown" data-bs-toggle="notificationdropdown" aria-expanded="false">
                    <i class="fas fa-bell fs-5 me-1"></i> <!-- Add the correct Font Awesome bell icon class -->
                    <sup class="badge bg-danger">0</sup>
                </button>

                <button class="btn btn-secondary dropdown-toggle custom-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- User Name -->
                    <?php echo $row['fname'] . ' ' . $row['lname']; ?>
                    <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture">
                </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <!-- Add your dropdown items here -->
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="/Inventory/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>