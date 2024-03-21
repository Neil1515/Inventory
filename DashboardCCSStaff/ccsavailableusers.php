<!-- ccsavailableusers.php -->
<!-- Display users in scrollable list group format -->
<div class="list-group" style="max-height: 600px; overflow-y: auto;">
            <style>
                /* Hide the scrollbar */
                .list-group::-webkit-scrollbar {
                    display: none;
                }
            </style>
            <h5 class="list-group-item list-group-item-action active" aria-current="true">Users</h5>
            <?php
            $user_query = "SELECT * FROM tblusers WHERE usertype <> 'CCS Staff' AND usertype <> 'Admin' AND status = 'Active'";
            $user_result = mysqli_query($con, $user_query);

            if ($user_result && mysqli_num_rows($user_result) > 0) {
                while ($user_row = mysqli_fetch_assoc($user_result)) {
                    echo '<a href="#" class="list-group-item list-group-item-action">';
                    echo '<div class="d-flex w-100 justify-content-between">';
                    echo '<h7 class="mb-1">' . $user_row['fname'] . ' ' . $user_row['lname'] . '</h7>';
                    echo '</div>';
                    echo '<h9 class="mb-1">' . $user_row['usertype'] . '</h9>';
                    echo '</a>';
                }
            } else {
                echo '<a href="#" class="list-group-item list-group-item-action">No users found.</a>';
            }
            ?>
        </div>