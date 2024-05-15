<!-- ccsmaincontainer.php -->
<?php
// Query to fetch categories
$queryitems = "SELECT id, itembrand, categoryname, subcategoryname, modelno, serialno, datepurchased, unitcost, assignfor, COUNT(*) as quantity FROM tblitembrand GROUP BY itembrand, subcategoryname, assignfor ORDER BY categoryname, assignfor, subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);

?>
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
                var rowContent = $(this).text().toLowerCase();

                // Check if any column contains the search query
                if (rowContent.includes(searchQuery)) {
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
    <div class="container ">
        <div class="row">
        <div class="d-flex justify-content-between mb-2">
            <h3 class="text-start"><i class='fas fa-tachometer-alt me-2'></i>List of CCS Inventory Properties</h3>
            <div class="text-end">
            <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
            </div>
        </div>
        </div>
        <div class="table-responsive row">
            <table class="table">
            <thead class="table-dark">
                
                    <tr> 
                        <th scope="col">Image</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Item Name</th> 
                        <th scope="col">Item Description</th>                                             
                        <th scope="col">Model No</th>
                        <th scope="col">Serial No</th> 
                        <th scope="col" class="text-start">Action</th>
                    </tr>
            </thead>
            <?php
                    $currentCategory = null;
                    $currentAssignFor = null;
                    
                    while ($row = mysqli_fetch_assoc($resultitems)) {
                        // Check if the category has changed
                        if ($currentCategory != $row['categoryname']) {
                            // Display the category name row with a class for click event
                            echo "<tr class='category-row text-center'>
                                    <td colspan='10' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>  
                                  </tr>";
                    
                            $currentCategory = $row['categoryname'];
                        }
                    
                        // Check if the assignfor is not empty and has changed
                        if (!empty($row['assignfor']) && $currentAssignFor != $row['assignfor']) {
                            // Display the assignfor row with a class for click event
                            echo "<tr class='assignfor-row'>
                                    <td colspan='10' style='background-color: gray;'><i class='fas fa-chalkboard-teacher me-2'></i><strong>{$row['assignfor']}</strong></td>  
                                  </tr>";
                    
                            $currentAssignFor = $row['assignfor'];
                        }
                
                        // Display the subcategory and other item details
                        echo "<tr class='item-details-row align-middle' >";
                        $imagePath = 'inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                        if (file_exists($imagePath)) {
                            echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                        } else {
                            echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                        }
                    
                        echo "<td class='text-center'>{$row['quantity']}</td>";
                        echo "<td>{$row['subcategoryname']}</td>";
                        echo "<td>{$row['itembrand']}</td>";
                        echo "<td class='text-center'>---</td>";
                        echo "<td class='text-center'>---</td>";
                        echo "<td>
                                <a href='ccsstaffViewItemInfo.php?itemId={$row['id']}' class='btn btn-outline-primary btn-sm'>
                                    <i class='fa-solid fa-pen-to-square fs-7 me-2'></i>View info
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
            <tbody>
            </tbody>
        </div>
    </div>
</main>
