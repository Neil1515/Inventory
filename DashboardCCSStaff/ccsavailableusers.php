<!-- ccsavailableusers.php -->
<div class="list-group" style="max-height: 600px; overflow-y: auto;">
    <style>
        /* Hide the scrollbar */
        .list-group::-webkit-scrollbar {
            display: none;
        }
    </style>
    <h5 class="list-group-item list-group-item-action active" aria-current="true">Users</h5>
    <?php
    // Query to fetch users with online status
    $online_query = "SELECT * FROM tblusers WHERE usertype <> 'CCS Staff' AND usertype <> 'Admin' AND status = 'Active' AND online_status = 'online'";
    $online_result = mysqli_query($con, $online_query);

    if ($online_result && mysqli_num_rows($online_result) > 0) {
        while ($online_row = mysqli_fetch_assoc($online_result)) {
            echo '<a href="ccsstaffConversation.php?sender_id=' . $online_row['id'] . '" class="list-group-item list-group-item-action">';
            echo '<div class="d-flex w-100 justify-content-between">';
            echo '<h7 class="mb-1"><i class="fas fa-user me-1"></i> ' . $online_row['fname'] . ' ' . $online_row['lname'] . '</h7>';
            echo '<span class="badge bg-success"><i class="fas fa-circle"></i> Online</span>';
            echo '</div>';
            echo '<h9 class="mb-1">' . $online_row['usertype'] . '</h9>';
            echo '</a>';
        }
    }

    // Query to fetch users with offline status
    $offline_query = "SELECT * FROM tblusers WHERE usertype <> 'CCS Staff' AND usertype <> 'Admin'  AND usertype <> 'Dean' AND status = 'Active' AND online_status <> 'online'";
    $offline_result = mysqli_query($con, $offline_query);

    if ($offline_result && mysqli_num_rows($offline_result) > 0) {
        while ($offline_row = mysqli_fetch_assoc($offline_result)) {
            echo '<a href="ccsstaffConversation.php?sender_id=' . $offline_row['id'] . '" class="list-group-item list-group-item-action">';
            echo '<div class="d-flex w-100 justify-content-between">';
            echo '<h7 class="mb-1"><i class="fas fa-user me-1"></i> ' . $offline_row['fname'] . ' ' . $offline_row['lname'] . '</h7>';
            echo '<span class="badge bg-secondary"><i class="fas fa-circle"></i> Offline</span>';
            echo '</div>';
            echo '<h9 class="mb-1">' . $offline_row['usertype'] . '</h9>';
            echo '</a>';
        }
    } else {
        echo '<a href="#" class="list-group-item list-group-item-action">No users found.</a>';
    }
    ?>
</div>

