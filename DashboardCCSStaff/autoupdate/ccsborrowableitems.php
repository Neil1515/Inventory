<!-- ccsborrowableitems.php -->
<!-- ccslistofborrowableitems.php -->
<?php
// Query to fetch categories
include('ccsfunctions.php');
//$queryitems = "SELECT * FROM tblitembrand WHERE borrowable = 'Yes' ORDER BY categoryname, subcategoryname, itembrand";
$queryitems = "SELECT *, COUNT(*) as quantity FROM tblitembrand WHERE borrowable = 'Yes' GROUP BY itembrand, subcategoryname, modelno, serialno, itemcondition, status ORDER BY categoryname, subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);


// Initialize counters for each status
$availableCount = 0;
$reserveCount = 0;
$borrowedCount = 0;
$missingCount = 0;
$pendingborrowCount = 0;
$pendingreserveCount = 0;

while ($row = mysqli_fetch_assoc($resultitems)) {
    switch ($row['status']) {
        case 'Available':
            $availableCount += $row['quantity'];
            break;
        case 'Reserve':
            $reserveCount += $row['quantity'];
            break;
        case 'Borrowed':
            $borrowedCount += $row['quantity'];
            break;
        case 'Missing':
            $missingCount += $row['quantity'];
            break;
        case 'Pending Borrow':
            $pendingborrowCount += $row['quantity'];
            break;    
        case 'Pending Reserve':
            $pendingreserveCount += $row['quantity'];
            break;
    }
}

// Reset the result set to the beginning
mysqli_data_seek($resultitems, 0);
?>

<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .ccs-main-container {
            display: flex;
            justify-content: center;
        }
        .card {
            margin-bottom: 2px;
        }

        .card-title {
            font-weight: bold;
            font-size: 13px;
        }
        .category-row {
            cursor: pointer;
            color: black;
        }
        /*colors for each status */
        .status-available {
            color: green;
            font-weight: bold;
        }
        .status-reserve {
            color: #808000;
            font-weight: bold;
        }
        .status-borrowed {
            color: blue;
            font-weight: bold;
        }
        .status-missing {
            color: red;
            font-weight: bold;
        }
        .status-pendingborrow {
            color: red;
            font-weight: bold;
        }
        .status-pendingreserve {
            color: red;
            font-weight: bold;
        }
        .status-missing-row {
            background-color: rgba(255, 0, 0, 0.2); 
        }
        .card:hover {
         background-color: azure;
         transition: background-color 0.3s ease-in-out;
         cursor: pointer;
        }
    </style>

    <!-- Add this script to include jQuery before your custom script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Your custom script -->
<script>
    $(document).ready(function() {
        // Event listener for the search input
        $('#searchInput').on('input', function() {
            // Get the search query value
            var searchQuery = $(this).val().toLowerCase();

            // Iterate through each row in the table body
            $('.item-details-row').each(function() {
                var category = $(this).find('td:nth-child(1)').text().toLowerCase();
                var itemBrand = $(this).find('td:nth-child(2)').text().toLowerCase();
                var subcategory = $(this).find('td:nth-child(3)').text().toLowerCase();
                var modelNo = $(this).find('td:nth-child(4)').text().toLowerCase();
                var serialNo = $(this).find('td:nth-child(5)').text().toLowerCase();
                var remarks = $(this).find('td:nth-child(6)').text().toLowerCase();
                var status = $(this).find('td:nth-child(7)').text().toLowerCase();

                // Check if any column contains the search query
                if (
                    category.includes(searchQuery) ||
                    itemBrand.includes(searchQuery) ||
                    subcategory.includes(searchQuery) ||
                    modelNo.includes(searchQuery) ||
                    serialNo.includes(searchQuery) ||
                    remarks.includes(searchQuery) ||
                    status.includes(searchQuery)
                ) {
                    // Show the row if it contains the search query
                    $(this).show();
                } else {
                    // Hide the row if it doesn't contain the search query
                    $(this).hide();
                }
            });
        });

        // Use event delegation for the click event on a parent container
        $('.table').on('click', '.category-row', function() {
            $(this).nextUntil('.category-row').toggle();
        });
    });

</script>
<main class="ccs-main-container">
        <div id="dashboard-container" class="container">
            <div class="row">
        <div class="col-md-6 ">
            <h3 class="text-start"><i class='fas fa-tachometer-alt me-2'></i>Dashboard</h3>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a href="ccsstaffReports.php" class="btn btn-secondary"><i class="fas fa-file-alt"></i> Reports</a>
                <a href="ccsstaffStatistics.php" class="btn btn-primary"><i class="fas fa-chart-bar"></i> Statistics</a>
                <a href="ccsstaffCalendar.php" class="btn btn-danger"><i class="fas fa-calendar-alt"></i> Calendar</a>
                <a href="ccsstaffReturnListofBorrowers.php" class="btn btn-success"><i class="fas fa-undo"></i> Return Item</a>
            </div>
        </div>
            <!-- Column for Available Items -->
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-box-open"></i> Available Items: <?php echo $availableCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Reserve Items -->
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-bookmark me-2"></i>Reserve Items: <?php echo $reserveCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Borrowed Items -->
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-handshake"></i> Borrowed Items: <?php echo $borrowedCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Damage\Lost Items -->
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-times-circle"></i> Damage\Lost:  <?php echo $missingCount; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-times-circle"></i> Pending Borrow:  <?php echo $pendingborrowCount; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-1">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-times-circle"></i> Pending Reserve:  <?php echo $pendingreserveCount; ?></span>
                    </div>
                </div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="row">
        <div class="col text-start">
            <!--show  -->
        </div>
            <div class="col-3 text-end mb-2">
             <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
            </div>
        </div>
        </div>
        <div class="row table-responsive">
            <table  id="example" class="table table-bordered" >
            <thead class="table-dark ">
                    <tr class='text-center'>
                        <th scope="col">Image</th>
                        <th scope="col">Quantity</th> 
                        <th scope="col">Item Name</th> 
                        <th scope="col">Item Description</th>                                           
                        <th scope="col">Model No</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Item Condition</th>              
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentCategory = null;
                    while ($row = mysqli_fetch_assoc($resultitems)) {
                        // Check if the category has changed
                        if ($currentCategory != $row['categoryname']) {
                            // Display the category name row with a class for click event
                            echo "<tr class='category-row'>
                                    <td colspan='9' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>       
                                  </tr>";
                            $currentCategory = $row['categoryname'];
                        }
                                                         
                        // Display the subcategory and other item details with a class for toggling
                        echo "<tr class='item-details-row";

                        // Add class for highlighting missing items
                        if ($row['status'] == 'Missing') {
                            echo " status-missing-row";
                        }
                        echo "'>";
                        // Check if an image exists, if not, use a default image
                        $imagePath = '/inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                        if (file_exists($imagePath)) {
                            echo "<td class='text-center'><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                        } else {
                            // Use a default image if no image is uploaded
                            echo "<td class='text-center'><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                        }
                        echo "<td class='text-center'>{$row['quantity']}</td>";     
                        echo "<td>{$row['subcategoryname']}</td>";           
                        echo "<td>{$row['itembrand']}</td>";                    
                        echo "<td class='text-center'>{$row['modelno']}</td>";
                        echo "<td class='text-center'>{$row['serialno']}</td>";
                        echo "<td class='text-center'>{$row['itemcondition']}</td>";                                            
                        // Add class to status based on its value
                        $statusClass = '';
                        switch ($row['status']) {
                            case 'Available':
                                $statusClass = 'status-available';
                                break;
                            case 'Reserve':
                                $statusClass = 'status-reserve';
                                break;
                            case 'Borrowed':
                                $statusClass = 'status-borrowed';
                                break;
                            case 'Missing':
                                $statusClass = 'status-missing';
                                break;
                            case 'Pending Borrow':
                                $statusClass = 'status-pendingborrow';
                                break;
                            case 'Pending Reserve':
                                $statusClass = 'status-pendingreserve';
                                break;    
                        }
                        
                        echo "<td class='{$statusClass}'>{$row['status']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

