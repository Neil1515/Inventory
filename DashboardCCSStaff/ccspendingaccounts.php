<!-- ccspendingaccounts.php -->
<?php
include "ccsfunctions.php";
$staffname = '';

$addedbyid = $_SESSION['staff_id'];

// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $addedbyid);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $approveby = $rowUser['fname'] . ' ' . $rowUser['lname'];
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}
?>

<div class="container ">
    <h2><i class='fas fa-bookmark me-2'></i>List of Pending Accounts</h2>
    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-1">
        <?php
        // Fetch and display pending accounts
        $queryPendingAccounts = "SELECT * FROM tblusers WHERE status = 'Pending' ORDER BY datetimeregister";
        $resultPendingAccounts = mysqli_query($con, $queryPendingAccounts);

        if (mysqli_num_rows($resultPendingAccounts) > 0) {
            while ($rowPending = mysqli_fetch_assoc($resultPendingAccounts)) {
                $genderIcon = ($rowPending['gender'] == 'Male') ? 'fas fa-male' : 'fas fa-female';

                echo "<div class='card me-3'>
                        <div class='card-body'>
                            <h5 class='card-title'>
                                <i class='fas fa-user me-2'></i>{$rowPending['fname']} {$rowPending['lname']}
                            </h5>
                            <p class='card-text'>
                                <i class='fas fa-id-card me-2'></i>ID: {$rowPending['id']}
                            </p>
                            <p class='card-text'>
                                <i class='fas fa-envelope me-2'></i>Email: {$rowPending['email']}
                            </p>
                            <p class='card-text'>
                                <i class='" . ($rowPending['gender'] == 'Male' ? 'fas fa-mars' : 'fas fa-venus') . " me-2'></i>Gender: {$rowPending['gender']}
                            </p>
                            <p class='card-text'>
                                <i class='fas fa-building me-2'></i>Department: {$rowPending['department']}
                            </p>
                            <div class='text-end'>
                                <a href='#' class='btn btn-danger mb-1'>Reject</a>
                                <a href='#' class='btn btn-primary mb-1' onclick=\"approveUser('{$rowPending['id']}', '{$approveby}')\">Approve</a>                                
                                <a href='ccsviewproofimage.php?userId={$rowPending['id']}' class='btn btn-success mb-1'>View Proof</a>
                            </div>
                        </div>
                      </div>";
            }
        } else {
            echo "<div class='card me-5'>
            <div class='card-body'>
                <p class='card-text'>No pending accounts.</p>
            </div>
          </div>";
        }
        ?>
    </div>
</div>

<style>
    .card:hover {
         background-color: azure;
         transition: background-color 0.3s ease-in-out;
         cursor: pointer;
    }
</style>
<script>
    function approveUser(userId, approveby) {
        var confirmationMessage = 'Are you sure you want to approve this user?';
        var isConfirmed = confirm(confirmationMessage);

        if (isConfirmed) {
            // Redirect to updateUserStatus.php with appropriate parameters
            window.location.href = 'updateUserStatus.php?userId=' + userId + '&approveby=' + approveby;
        }
    }
</script>