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

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$queryPendingAccounts = "SELECT * FROM tblusers WHERE status = 'Pending' AND (fname LIKE '%$searchTerm%' OR lname LIKE '%$searchTerm%' OR id LIKE '%$searchTerm%') ORDER BY datetimeregister DESC";

// Fetch and display pending accounts
$resultPendingAccounts = mysqli_query($con, $queryPendingAccounts);
?>

<div class="container">
    <div class="row align-items-center mb-1">
        <div class="col-md-8">
            <h2><i class='fas fa-user-clock me-2'></i>List of Pending Accounts</h2>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control search-input" placeholder="Search by Name or ID" name="search" id="searchInput">
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 g-1" id="pendingAccounts">
        <?php
        if (mysqli_num_rows($resultPendingAccounts) > 0) {
            while ($rowPending = mysqli_fetch_assoc($resultPendingAccounts)) {
                $genderIcon = ($rowPending['gender'] == 'Male') ? 'fas fa-male' : 'fas fa-female';

                echo '<div class="col">';
                echo "<div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$rowPending['fname']} {$rowPending['lname']}<br></h5>
                            <h7 class='card-text id'>ID: {$rowPending['id']}<br></h7>
                            <h7 class='card-text'>Email: {$rowPending['email']}<br></h7>
                            <h7 class='card-text'>Gender: {$rowPending['gender']}<br></h7>
                            <h7 class='card-text'>Department: {$rowPending['department']}<br></h7>
                            <div class='text-end'>
                                <a href='#' class='btn btn-danger'>Reject</a>
                                <a href='#' class='btn btn-primary' onclick=\"approveUser('{$rowPending['id']}', '{$approveby}')\">Approve</a>                                
                                <a href='ccsviewproofimage.php?userId={$rowPending['id']}' class='btn btn-success'>View Proof</a>
                            </div>
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
    </div> <!-- closing div for row -->
</div> <!-- closing div for container -->

<style>
    .card:hover {
        background-color: azure;
        transition: background-color 0.3s ease-in-out;
        cursor: pointer;
    }
</style>
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        var searchTerm = this.value.trim().toLowerCase();
        var pendingAccounts = document.getElementById("pendingAccounts");
        var cards = pendingAccounts.getElementsByClassName("card");

        for (var i = 0; i < cards.length; i++) {
            var card = cards[i];
            var name = card.querySelector(".card-title").innerText.trim().toLowerCase();
            var id = card.querySelector(".id").innerText.trim().toLowerCase();

            if (name.includes(searchTerm) || id.includes(searchTerm)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        }
    });

    function approveUser(userId, approveby) {
        var confirmationMessage = 'Are you sure you want to approve this user?';
        var isConfirmed = confirm(confirmationMessage);

        if (isConfirmed) {
            // Redirect to updateUserStatus.php with appropriate parameters
            window.location.href = 'updateUserStatus.php?userId=' + userId + '&approveby=' + approveby;
        }
    }
</script>
