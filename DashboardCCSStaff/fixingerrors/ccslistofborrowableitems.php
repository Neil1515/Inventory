<!-- ccslistofborrowableitems.php -->
<?php
// Query to fetch categories
$queryitems = "SELECT * FROM tblitembrand WHERE borrowable = 'Yes' ORDER BY categoryname, subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);

// Initialize counters for each status
$availableCount = 0;
$reserveCount = 0;
$borrowedCount = 0;
$missingCount = 0;

while ($row = mysqli_fetch_assoc($resultitems)) {
    switch ($row['status']) {
        case 'Available':
            $availableCount++;
            break;
        case 'Reserve':
            $reserveCount++;
            break;
        case 'Borrowed':
            $borrowedCount++;
            break;
        case 'Missing':
            $missingCount++;
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
            font-size: 18px;
        }
        .category-row {
            cursor: pointer;
            color: black;
        }
        /*colors for each status */
        .status-available {
            color: green;

        }
        .status-reserve {
            color: #808000;
        }
        .status-borrowed {
            color: blue;
        }
        .status-missing {
            color: red;
            font-weight: bold;
        }
        .status-missing-row {
            background-color: rgba(255, 0, 0, 0.2); /* Transparent red background */
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
    <div class="container mt-1">
        <div class="row">
        <div class="d-flex justify-content-between mb-2">
            <h3 class="text-start"><i class='fas fa-tachometer-alt me-2'></i>List of Borrowable Items</h3>
            <div class="text-end">
            <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
        </div>
        </div>
            <!-- Column for Available Items -->
            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-box-open"></i> Available Items: <?php echo $availableCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Reserve Items -->
            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-bookmark me-2"></i></i> Reserve Items: <?php echo $reserveCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Borrowed Items -->
            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-handshake"></i> Borrowed Items: <?php echo $borrowedCount; ?></span>
                    </div>
                </div>
            </div>
            <!-- Column for Missing Items -->
            <div class="col-md-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title"><i class="fas fa-times-circle"></i> Missing Items:  <?php echo $missingCount; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table">
            <thead class="table-dark">
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Item Brand</th> 
                        <th scope="col">Subcategory Name</th>                                             
                        <th scope="col">Model No</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
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
                        $imagePath = 'inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                        if (file_exists($imagePath)) {
                            echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                        } else {
                            // Use a default image if no image is uploaded
                            echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                        }                     
                        echo "<td>{$row['itembrand']}</td>";
                        echo "<td>{$row['subcategoryname']}</td>";                        
                        echo "<td class='text-center'>{$row['modelno']}</td>";
                        echo "<td class='text-center'>{$row['serialno']}</td>";                      
                        echo "<td class='text-center'>{$row['remarks']}</td>";
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
                        }
                        
                        echo "<td class='{$statusClass}'>{$row['status']}</td>";
                        echo "<td>";
                        switch ($row['status']) {
                            case 'Available':
                                echo "<a href=\"ccsstaffBorrowing.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fas fa-handshake fs-6 me-2'></i>Borrow</a>";
                                echo " <a href=\"ccsstaffReserveItem.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fas fa-bookmark fs-6 me-2'></i>Reserve</a>";
                                break;
                            case 'Reserve':
                                echo "<a href=\"ccsstaffProceedBorrowing.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fas fa-arrow-right fs-6 me-2'></i>Proceed Borrow</a>";
                                break;
                            case 'Borrowed':
                                echo "<a href=\"ccsstaffReturnItem.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fas fa-undo fs-6 me-2'></i>Return item</a>";
                                break;
                            case 'Missing':
                                echo "<a href=\"ccstaffEditItemDetails.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fas fa-pencil-alt fs-6 me-2'></i>Edit</a>";
                                break;
                            default:
                                // Default action or no action for other statuses
                                break;
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

