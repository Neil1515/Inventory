<!-- ccsitemapproval.php -->
<?php
// Query to fetch categories
include('ccsfunctions.php');

// Query to fetch pending item removal requests with staff full names and item subcategory names
$sql = "SELECT pr.id, CONCAT(u.fname, ' ', u.lname) AS stafffullname, ib.subcategoryname, ib.serialno, pr.datetimereq, pr.status, pr.itemid       
        FROM `tblpendingitemremoval` pr
        LEFT JOIN `tblusers` u ON pr.staffid = u.id
        LEFT JOIN `tblitembrand` ib ON pr.itemid = ib.id
        ORDER BY id DESC";
$result = mysqli_query($con, $sql);
?>
<main class="ccs-main-container">
    <div class="container">
        <!-- Title and Search Input -->
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="col-md-6">
                    <div class="row">
                        <h3 class="text-start"><i class="fas fa-trash-alt"></i> Pending Item Deletion Requests</h3>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row table-responsive">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table class='table'>";
                echo "<thead class='table-dark'>";
                echo "<tr class='text-center'>";
                echo "<th scope='col'>Item ID</th>";
                echo "<th scope='col'>Requested by</th>";
                echo "<th scope='col'>Item Name</th>";
                echo "<th scope='col'>Serial Number</th>";
                echo "<th scope='col'>Date Requested</th>";
                echo "<th scope='col'>Status</th>";
                echo "<th scope='col'>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody id='tableBody'>"; // Added ID to the tbody

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='text-center'>";
                    echo "<td>{$row['itemid']}</td>";
                    echo "<td>{$row['stafffullname']}</td>";
                    echo "<td>{$row['subcategoryname']}</td>";
                    echo "<td>{$row['serialno']}</td>";
                    $datetimereq = $row['datetimereq'] ? date("F d, Y g:i A", strtotime($row['datetimereq'])) : '---';
                    echo '<td class="text-center">' . $datetimereq . '</td>';
                    echo "<td>{$row['status']}</td>";
                    echo '<td class="text-center">';
                    // Conditionally display action buttons based on the status
                    if ($row['status'] === 'Pending') {
                        // Display both Approve and Decline buttons
                        echo '<form action="ccsprocess_reqdelation.php" method="post">';
                        echo '<input type="hidden" name="report_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" name="decline_reqdelation" class="btn btn-danger me-2">Decline</button>';
                        echo '<button type="submit" name="approve_reqdelation" class="btn btn-success">Approve</button>';
                        echo '</form>';
                    } else {
                        // Display only the status
                        echo $row['status'];
                    }
                    echo '</td>';
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No pending item deletion requests found.</p>";
            }
            ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the search input element
        const searchInput = document.getElementById('searchInput');

        // Add event listener for input change
        searchInput.addEventListener('input', function () {
            // Get the search query
            const query = searchInput.value.toLowerCase();

            // Get the table body
            const tableBody = document.getElementById('tableBody');

            // Get all table rows
            const rows = tableBody.getElementsByTagName('tr');

            // Loop through all rows
            for (let row of rows) {
                // Get the cells of the row
                const cells = row.getElementsByTagName('td');

                // Variable to store whether the row matches the search query
                let matches = false;

                // Loop through all cells
                for (let cell of cells) {
                    // Check if the cell contains the search query
                    if (cell.textContent.toLowerCase().includes(query)) {
                        matches = true;
                        break;
                    }
                }

                // Toggle row visibility based on whether it matches the search query
                row.style.display = matches ? '' : 'none';
            }
        });
    });
</script>
