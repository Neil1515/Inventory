<!-- deanheader.php -->
<?php
include('deanfunction.php');
// Retrieve user information based on the logged-in user ID
$deanId = $_SESSION['dean_id'];
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $deanId);
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
<div class="container-fluid">
    <div class="header--wrapper py-3">
        <div class="header sad">
            <div class="logo-and-text">
                <!--<img src="/inventory/images/imsicon.png" alt="Logo" class="rounded float-start">-->
                <h3 class="text-dark">CCS INVENTORY MANAGEMENT SYSTEM</h3>
            </div>
            <span class="text-muted">Dean Dashboard</span>
        </div>
        <div class="user--info">
            <div class="dropdown">
                <!-- Notification Icon and Counter -->
                <button class="btn btn-secondary custom-dropdown-btn" type="button" id="notificationDropdown" data-bs-toggle="notificationdropdown" aria-expanded="false">
                    <i class="fas fa-bell fs-5 me-1"></i> <!-- Add the correct Font Awesome bell icon class -->
                    <sup class="badge bg-danger">3</sup>
                </button>

                <!-- User Dropdown -->
                <button class="btn btn-secondary dropdown-toggle custom-dropdown-btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- User Name -->
                    <?php echo $row['fname'] . ' ' . $row['lname']; ?>
                    <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture">
                </button>

                <!-- User Dropdown Menu -->
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <!-- Add your dropdown items here -->
                    <li><a class="dropdown-item" href="deanProfile.php?deanId=<?php echo $deanId; ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="/Inventory/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
