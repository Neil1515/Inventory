<!-- ccslistofpendingborrowerusers.php -->
<?php
include 'ccsfunctions.php';
// Assuming you have an active database connection stored in $con
// Fetch staff ID from the session
$staffId = $_SESSION['staff_id'];

// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $staffId);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $staffname = $rowUser['fname'] . ' ' . $rowUser['lname'];
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}

// Fetch unique borrower IDs with pending requests
$queryBorrowers = "SELECT DISTINCT borrowerid FROM tblborrowingreports WHERE itemreqstatus = 'Approved' OR itemreqstatus = 'Request Return'";
$resultBorrowers = mysqli_query($con, $queryBorrowers);

?>
<div class="ccs-main-container">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <h3 class="text-start"><i class='fas fa-tachometer-alt me-2'></i>Unreturn Items</h3>
        </div>
        <div class="col-md-3 d-flex justify-content-end align-items-center">
            <a href="ccsstaffDashboardPage.php" class="btn btn-danger me-2">Back</a>
            <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
        </div>
    </div>
</div>


<?php
echo '<div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-1">';

if ($resultBorrowers && mysqli_num_rows($resultBorrowers) > 0) {
    // Iterate through each borrower
    while ($rowBorrower = mysqli_fetch_assoc($resultBorrowers)) {
        $borrowerId = $rowBorrower['borrowerid'];

        // Count the number of items requested by the current borrower
        $queryItemCount = "SELECT COUNT(itemid) AS itemCount FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Approved' OR itemreqstatus = 'Request Return'";
        $stmtItemCount = mysqli_prepare($con, $queryItemCount);

        if ($stmtItemCount) {
            mysqli_stmt_bind_param($stmtItemCount, "i", $borrowerId);

            if (mysqli_stmt_execute($stmtItemCount)) {
                $resultItemCount = mysqli_stmt_get_result($stmtItemCount);
                $rowItemCount = mysqli_fetch_assoc($resultItemCount);

                // Valid borrower details, fetch the borrower details and display them in a card
                $queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
                $stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

                if ($stmtBorrowerDetails) {
                    mysqli_stmt_bind_param($stmtBorrowerDetails, "i", $borrowerId);

                    if (mysqli_stmt_execute($stmtBorrowerDetails)) {
                        $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

                        if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
                            $borrowerDetails = mysqli_fetch_assoc($resultBorrowerDetails);
?>

                        <div class="card me-2">
                            <div class="card-body">
                                <h5 class="card-title">Borrower ID: <?php echo $borrowerDetails['id']; ?></h5>
                                <p class="card-text">Name: <?php echo $borrowerDetails['fname'] . ' ' . $borrowerDetails['lname']; ?></p>
                                <p class="card-text">Type: <?php echo $borrowerDetails['usertype']; ?></p>
                                <p class="card-text">Number of item(s): <?php echo $rowItemCount['itemCount']; ?></p>

                                <!-- Display the item IDs with Approved status and their subcategories with quantity -->
                                <?php
                                $queryPendingItems = "SELECT br.itemid, ib.subcategoryname
                                                    FROM tblborrowingreports br
                                                    INNER JOIN tblitembrand ib ON br.itemid = ib.id
                                                    WHERE br.borrowerid = ? AND br.itemreqstatus = 'Approved'";
                                $stmtPendingItems = mysqli_prepare($con, $queryPendingItems);

                                if ($stmtPendingItems) {
                                    mysqli_stmt_bind_param($stmtPendingItems, "i", $borrowerId);

                                    if (mysqli_stmt_execute($stmtPendingItems)) {
                                        $resultPendingItems = mysqli_stmt_get_result($stmtPendingItems);

                                        if ($resultPendingItems && mysqli_num_rows($resultPendingItems) > 0) {
                                            $itemCounts = array();

                                            while ($rowPendingItem = mysqli_fetch_assoc($resultPendingItems)) {
                                                $subcategory = $rowPendingItem['subcategoryname'];

                                                // Increment the count for each subcategory
                                                if (isset($itemCounts[$subcategory])) {
                                                    $itemCounts[$subcategory]++;
                                                } else {
                                                    $itemCounts[$subcategory] = 1;
                                                }
                                            }

                                            echo '<p class="card-text">Borrowed Item(s): ';
                                            foreach ($itemCounts as $subcategory => $count) {
                                                echo $subcategory;
                                                
                                                // Display quantity if greater than 1
                                                if ($count > 1) {
                                                    echo '(' . $count . ')';
                                                }

                                                echo ', ';
                                            }
                                            echo '</p>';
                                        } else {
                                            echo '<p class="card-text">No items with pending status.</p>';
                                        }
                                    } else {
                                        die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingItems));
                                    }

                                    mysqli_stmt_close($stmtPendingItems);
                                } else {
                                    die('Statement preparation failed: ' . mysqli_error($con));
                                }
                                ?>
                            </div>
                            <div class='text-end me-1'>
                            <a href='ccsstaffReturnAll.php?borrower_id=<?php echo $borrowerDetails['id']; ?>' class='btn btn-primary mb-1'>Return All</a>
                                <a href='ccsstaffViewUnreturnItems.php?borrower_id=<?php echo $borrowerDetails['id']; ?>' class='btn btn-success mb-1'>View <?php echo $rowItemCount['itemCount']; ?> Items</a>
                            </div>
                        </div>
                            <?php
                        } else {
                            echo "<p class='alert alert-warning'>No details found for borrower ID: {$borrowerId}</p>";
                        }
                    } else {
                        die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
                    }
                    mysqli_stmt_close($stmtBorrowerDetails);
                } else {
                    die('Statement preparation failed: ' . mysqli_error($con));
                }
            } else {
                die('Statement execution failed: ' . mysqli_stmt_error($stmtItemCount));
            }
            mysqli_stmt_close($stmtItemCount);
        } else {
            die('Statement preparation failed: ' . mysqli_error($con));
        }
    }
} else {
    echo '<p class="alert alert-info">No borrowers with borrowed items found.</p>';
}
// Close the container div
echo '</div>';
echo '</div>';
echo '</div>';
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>
    .card:hover {
        background-color: azure;
        transition: background-color 0.3s ease-in-out;
        cursor: pointer;
    }
</style>
