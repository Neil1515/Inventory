 <!-- ccslistofitems.php -->
 <?php
 // Query to fetch categories
    $queryitems = "SELECT * FROM tblitembrand ORDER BY categoryname, subcategoryname, itembrand";
    $resultitems = mysqli_query($con, $queryitems);

    // Define CSS classes for different statuses
    $statusClasses = array(
        'Available' => 'text-success',
        'Standby' => 'text-secondary',
        'Reserve' => 'text-warning',
        'Borrowed' => 'text-primary',
        'Missing' => 'text-danger',
        'Pending Borrow' => 'text-danger',
        'Pending Reserve' => 'text-danger'
    );
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
.text-success {
        color: green;
    }

    .text-warning {
        color: #f39c12; /* Orange color */
    }

    .text-primary {
        color: blue;
    }

    .text-danger {
        color: red;
    }

    .truncate-text {
    max-width: 150px; /* Adjust as needed */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    
    .truncate-text:hover {
    max-width: none;
    overflow: visible;
    white-space: normal;
    }
</style>

<!-- Add this script to include jQuery before your custom script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Your custom script -->
<script>
    $(document).ready(function() {
        // Use event delegation for the click event on a parent container
        $('.table').on('click', '.category-row', function() {
            $(this).nextUntil('.category-row').toggle();
        });
    });

    $(document).ready(function() {
        // Event listener for changing the number of entries
        $('#entriesDropdown').on('change', function() {
            var entriesPerPage = parseInt($(this).val());

            // Hide all table rows
            $('tbody tr').hide();

            // Show only the specified number of rows
            $('tbody tr').slice(0, entriesPerPage).show();
        });

        // Trigger the change event initially to show the default number of entries
        $('#entriesDropdown').trigger('change');
    });
    $(document).ready(function() {
  // Toggle class on hover to show full text
  $('.truncate-text').hover(function() {
    $(this).toggleClass('show-full-text');
  });
});
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
            <div class="container">   
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="text-start"><i class='fas fa-list me-2'></i>List of Items</h3>
                    <div class="col-md-6 text-end">
                        <div class="row">
                            
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
                    </div>
                </div>
            </div>
                <div class="row table-responsive ">
                    <table  class="table">
                        <thead class="table-dark">
                            <tr class="align-middle">
                                <th scope="col">Category</th>
                                <th scope="col">Item Name</th>  
                                <th scope="col">Item Description</th>                                           
                                <th scope="col">Model No</th>
                                <th scope="col">Serial No</th>
                                <th scope="col">Assign to</th>                                
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
                                    <td colspan='12' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>       
                                    </tr>";
                                    $currentCategory = $row['categoryname'];
                                }
                                
                                // Display the subcategory and other item details with a class for toggling
                                echo "<tr class='item-details-row align-middle'>";
                                // Check if an image exists, if not, use a default image
                                $imagePath = 'inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                                if (file_exists($imagePath)) {
                                    echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                                } else {
                                    // Use a default image if no image is uploaded
                                    echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                }            
                                echo "<td>{$row['subcategoryname']}</td>";       
                                echo "<td class='truncate-text'>{$row['itembrand']}</td>";                                                      
                                echo "<td class='truncate-text'>{$row['modelno']}</td>";
                                echo "<td>{$row['serialno']}</td>";                   
                                echo "<td class='truncate-text'>{$row['assignfor']}</td>";
                                //echo "<td class='text-center'>";
                                //if ($row['borrowable'] == 'Yes') {
                                    // Display a checkmark icon for 'Yes' with bigger size
                                    //echo "<i class='fas fa-check-circle fa-2x text-success'></i>";
                                //} else {
                                    // Display a times (X) icon for 'No' with bigger size
                                    //echo "<i class='fas fa-times-circle fa-2x text-danger'></i>";
                                //}
                                $status = $row['status'];
                                $statusClass = isset($statusClasses[$status]) ? $statusClasses[$status] : '';
                                echo "<td class='{$statusClass}'>{$status}</td>";                             
                                echo "</td>";
                                echo "<td>
                                <a href=\"ccstaffEditItemDetails.php?id={$row['id']}\" class=\"btn btn-outline-primary btn-sm\"><i class='fa-solid fa-pen-to-square fs-7 me-2'></i>Edit</a>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>