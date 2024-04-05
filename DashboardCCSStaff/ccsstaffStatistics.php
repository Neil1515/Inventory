<!-- ccsstaffStatistics.php -->
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

// Fetch data from the database
$queryTotalItems = "SELECT COUNT(*) AS totalItems FROM tblitembrand";
$queryBorrowableItems = "SELECT COUNT(*) AS borrowableItems FROM tblitembrand WHERE borrowable = 'yes'";

$resultTotalItems = mysqli_query($con, $queryTotalItems);
$resultBorrowableItems = mysqli_query($con, $queryBorrowableItems);

if ($resultTotalItems && $resultBorrowableItems) {
    $rowTotalItems = mysqli_fetch_assoc($resultTotalItems);
    $rowBorrowableItems = mysqli_fetch_assoc($resultBorrowableItems);

    $totalItemsCount = $rowTotalItems['totalItems'];
    $borrowableItemsCount = $rowBorrowableItems['borrowableItems'];
} else {
    // Handle the case when the query fails
    $totalItemsCount = 0;
    $borrowableItemsCount = 0;
}

// Fetch data from the database for the most borrowed items
$queryMostBorrowedItems = "SELECT itemid, COUNT(*) AS borrowCount FROM tblborrowingreports GROUP BY itemid ORDER BY borrowCount DESC LIMIT 5";
$resultMostBorrowedItems = mysqli_query($con, $queryMostBorrowedItems);

$mostBorrowedItems = [];
while ($rowMostBorrowedItem = mysqli_fetch_assoc($resultMostBorrowedItems)) {
    $mostBorrowedItemId = $rowMostBorrowedItem['itemid'];

    // Retrieve the item information from the tblitembrand table
    $queryItemInfo = "SELECT subcategoryname FROM tblitembrand WHERE id = ?";
    $stmtItemInfo = mysqli_prepare($con, $queryItemInfo);
    if ($stmtItemInfo) {
        mysqli_stmt_bind_param($stmtItemInfo, "s", $mostBorrowedItemId);
        if (mysqli_stmt_execute($stmtItemInfo)) {
            $resultItemInfo = mysqli_stmt_get_result($stmtItemInfo);
            if ($resultItemInfo && mysqli_num_rows($resultItemInfo) > 0) {
                $rowItemInfo = mysqli_fetch_assoc($resultItemInfo);
                $mostBorrowedItems[] = [
                    'name' => $rowItemInfo['subcategoryname'],
                    'count' => $rowMostBorrowedItem['borrowCount']
                ];
            }
        }
        mysqli_stmt_close($stmtItemInfo);
    }
}

// Check if a month is selected, if not, set the default value to the current month
$selectedMonth = isset($_GET['selected_month']) ? $_GET['selected_month'] : date('n');

// Sanitize the input to prevent SQL injection
$selectedMonth = mysqli_real_escape_string($con, $selectedMonth);

// Fetch data from the database for the most borrowed items based on the selected month
$queryMostBorrowedItems = "SELECT tblitembrand.subcategoryname, COUNT(tblborrowingreports.id) AS totalApprovals
FROM tblborrowingreports
INNER JOIN tblitembrand ON tblborrowingreports.itemid = tblitembrand.id
WHERE MONTH(tblborrowingreports.datimeapproved) = $selectedMonth
GROUP BY tblitembrand.subcategoryname
ORDER BY totalApprovals DESC
LIMIT 5";

$resultMostBorrowedItems = mysqli_query($con, $queryMostBorrowedItems);

$totalApprovalsItems = [];
while ($rowTotalApprovalsItem = mysqli_fetch_assoc($resultMostBorrowedItems)) {
    $totalApprovalsItems[] = [
        'name' => $rowTotalApprovalsItem['subcategoryname'],
        'totalApprovals' => $rowTotalApprovalsItem['totalApprovals']
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistics</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <div class="row">
                    <div class="col">
                    <div class="row">
                    <div class="d-flex justify-content-between mb-1">
                        <h3 class="text-start"><i class='fas fa-chart-bar me-2'></i>Statistics</h3>
                        <div class="text-end">
                        <a href="ccsstaffDashboardPage.php" class="btn btn-danger">Back</a>
                    </div>    
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                     <!-- Fetch data from the database -->
                     <?php
                        $query = "SELECT categoryname, subcategoryname, COUNT(*) as count FROM tblitembrand GROUP BY categoryname, subcategoryname";
                        $result = mysqli_query($con, $query);
                        
                        $categories = [];
                        $subcategories = [];
                        $data = [];
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $category = $row['categoryname'];
                            $subcategory = $row['subcategoryname'];
                            $count = $row['count'];
                        
                            if (!isset($categories[$category])) {
                                $categories[$category] = [];
                            }
                        
                            if (!in_array($subcategory, $categories[$category])) {
                                $categories[$category][] = $subcategory;
                            }
                        
                            if (!isset($data[$category])) {
                                $data[$category] = [];
                            }
                        
                            $data[$category][$subcategory] = $count;
                        }
                        
                        $labels = [];
                        $datasetData = [];
                        
                        foreach ($categories as $category => $subcategoriesArray) {
                            $label = $category;
                            $sum = 0;
                        
                            foreach ($subcategoriesArray as $subcategory) {
                                $sum += $data[$category][$subcategory];
                            }
                        
                            $labels[] = $label;
                            $datasetData[] = $sum;
                        }
                        ?>
                       <div class="row">
                            <div class="col-md-9">
                                <!-- Card for Donut Chart -->
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <canvas id="donutChart" width="400" height="520"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-2">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Item Counts  </h5>
                                    <canvas id="clusterBarChart" width="200" height="130"></canvas>
                                </div>
                                </div>  
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Most Borrowed Items</h5>
                                        <form action="" method="GET">
                                            <div class="input-group mb-2">
                                            <select class="form-select" name="selected_month" id="selected_month">
                                            <?php 
                                            // Generate options for the dropdown menu
                                            for ($m = 1; $m <= 12; $m++) {
                                                $month = date('F', mktime(0, 0, 0, $m, 1));
                                                $selected = isset($_GET['selected_month']) && $_GET['selected_month'] == $m ? 'selected' : '';
                                                // Check if the current iteration is the current month
                                                if ($selected == '' && $m == date('n')) {
                                                    $selected = 'selected';
                                                }
                                                echo "<option value='$m' $selected>$month</option>";
                                            }
                                            ?>
                                        </select>

                                                <button type="submit" class="btn btn-primary">Apply</button>
                                            </div>
                                        </form>
                                        <?php if (!empty($totalApprovalsItems)) { ?>
                                            <ul class="list-group">
                                                <?php foreach ($totalApprovalsItems as $item) { ?>
                                                    <li class="list-group-item"><?php echo $item['name']; ?>: <?php echo $item['totalApprovals']; ?></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } else { ?>
                                            <p class="text-center">No data available</p>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <script>
    // Draw Donut Chart
    var ctx = document.getElementById('donutChart').getContext('2d');
    var donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Total items',
                data: <?php echo json_encode($datasetData); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Distribution of Items by Category',
                fontSize: 18,
                fontColor: '#333',
                padding: 20
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#666',
                    fontSize: 14
                }
            }
        }
    });

    // Draw Cluster Bar Chart
    var ctxCluster = document.getElementById('clusterBarChart').getContext('2d');
    var clusterBarChart = new Chart(ctxCluster, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(['Total Items', 'Borrowable Items']); ?>,
            datasets: [{
                label: 'Total Items',
                data: <?php echo json_encode([$totalItemsCount, 0]); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Borrowable Items',
                data: <?php echo json_encode([0, $borrowableItemsCount]); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    stacked: true
                }
            }
        }
    });
</script>

                
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
