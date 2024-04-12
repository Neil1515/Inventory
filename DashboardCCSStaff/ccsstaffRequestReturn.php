<!-- ccsstaffReturnCode.php -->
<?php
session_start();
// Include necessary files
include('ccsfunctions.php');
// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}
// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);

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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tracking return</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
                <?php include('ccsheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('ccssidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
            <?php
            // Fetch unique borrower IDs with pending requests
            $queryBorrowers = "SELECT DISTINCT borrowerid FROM tblborrowingreports WHERE itemreqstatus = 'Request return'";
            $resultBorrowers = mysqli_query($con, $queryBorrowers);

                // Output the container and search input
                echo '<div class="ccs-main-container">';
                echo '<div class="container">';
                echo '<div class="row">';
                echo '<div class="d-flex justify-content-between">';
                echo '<h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Return request</h3>';
                echo '<div class="text-end">';
                echo '<input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">';
                echo '</div>';
                echo '</div>';
                echo '<div class=" text-end">';
                echo '<a href="ccsstaffReturnListofBorrowers.php"  class="btn btn-danger">Back</a>';
                echo '</div>';
                echo '<div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-1">';
                if ($resultBorrowers && mysqli_num_rows($resultBorrowers) > 0) {
                    // Iterate through each borrower
                    while ($rowBorrower = mysqli_fetch_assoc($resultBorrowers)) {
                        $borrowerId = $rowBorrower['borrowerid'];
                
                        // Count the number of items requested by the current borrower
                        $queryItemCount = "SELECT COUNT(itemid) AS itemCount FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Request return'";
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
                                                <a href='#' class='btn btn-success mb-1'>View <?php echo $rowItemCount['itemCount']; ?> Items</a>
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
                    echo '<p class="alert alert-info">No borrowers with Request return items found.</p>';
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
                
            </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
