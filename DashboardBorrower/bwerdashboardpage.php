<!-- ccslistofborrowableitems.php -->
<?php
// Include necessary files
include('bwerfunctions.php');


$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

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

// Query to fetch categories
$queryitems = "SELECT * FROM tblitembrand WHERE borrowable = 'Yes' AND status = 'Available' ORDER BY categoryname, subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);

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


        .category-row {
            cursor: pointer;
            color: black;
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
                var category = $(this).find('td:nth-child(2)').text().toLowerCase();
                var itemBrand = $(this).find('td:nth-child(3)').text().toLowerCase();
                var subcategory = $(this).find('td:nth-child(4)').text().toLowerCase();
                var modelNo = $(this).find('td:nth-child(5)').text().toLowerCase();
                var serialNo = $(this).find('td:nth-child(6)').text().toLowerCase();
                var remarks = $(this).find('td:nth-child(7)').text().toLowerCase();
                var status = $(this).find('td:nth-child(8)').text().toLowerCase();

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

        // Event listener for the checkboxes
        $('.item-details-row input[type="checkbox"]').on('change', function() {
            // Get the count of selected checkboxes
            var selectedCount = $('.item-details-row input:checked').length;
            // Update the text showing the count of selected items
            $('#selectedItemCount').text(selectedCount);

            // Show or hide the "text-end" and "Borrow" buttons based on whether any item is selected
            if (selectedCount > 0) {
                $('#reserveButton').show();
                $('#borrowButton').show();
            } else {
                $('#reserveButton').hide();
                $('#borrowButton').hide();
            }
        });

        // Event listener for the Reserve button
        $('#reserveButton').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission or anchor link behavior

            var selectedIds = [];

            // Iterate through each checked checkbox
            $('.item-details-row input:checked').each(function() {
                // Get the data-itemid attribute from the parent row
                var itemId = $(this).closest('.item-details-row').data('id');

                // Add the item ID to the selectedIds array
                selectedIds.push(itemId);
            });

            // Redirect to the confirmation page with the selected IDs
            window.location.replace('borrowerReserveRequest.php?itemIds=' + selectedIds.join(','));
        });

        // Event listener for the Borrow button
        $('#borrowButton').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission or anchor link behavior

            var selectedIds = [];

            // Iterate through each checked checkbox
            $('.item-details-row input:checked').each(function() {
                // Get the data-itemid attribute from the parent row
                var itemId = $(this).closest('.item-details-row').data('id');

                // Add the item ID to the selectedIds array
                selectedIds.push(itemId);
            });

            // Redirect to the confirmation page with the selected IDs
            window.location.replace('borrowerBorrowRequest.php?itemIds=' + selectedIds.join(','));
        });
    });
</script>



<main class="ccs-main-container">
    <div class="container mt-1">
        <div class="row">
            <?php
            if (mysqli_num_rows($resultitems) > 0) {
                // If there are borrowable items, display the list
                echo '
                <div class="d-flex justify-content-between mb-1">
                    <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>List of Borrowable Items</h3>
                    <div class="text-end">
                        <input type="text" class="form-control search-input mb-1" placeholder="Search" name="search" id="searchInput">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="text-start">Item Selected: <span id="selectedItemCount">0</span></h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="#" id="reserveButton" class="btn btn-danger mb-1" style="display: none;">Reserve</a>
                        <a href="#" id="borrowButton" class="btn btn-success mb-1" style="display: none;">Borrow</a>
                    </div>
                </div>
                <div class="row table-responsive">
                
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Category Name</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Model No</th>
                                <th scope="col">Serial No</th>
                                <th scope="col">Item Condition</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $currentCategory = null;
                            while ($row = mysqli_fetch_assoc($resultitems)) {
                                // Check if the category has changed
                                if ($currentCategory != $row['categoryname']) {
                                    // Display the category name row with a class for click event
                                    echo "<tr class='category-row'>
                                            <td colspan='8' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>
                                        </tr>";
                                    $currentCategory = $row['categoryname'];
                                }
                                // Display the subcategory and other item details with a class for toggling
                                echo "<tr class='item-details-row' data-id='{$row['id']}'>";
                                // Check if an image exists, if not, use a default image
                                $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                                if (file_exists($imagePath)) {
                                    echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                                } else {
                                    // Use a default image if no image is uploaded
                                    echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                }
                                echo "<td>{$row['subcategoryname']}</td>";
                                echo "<td>{$row['itembrand']}</td>";
                                echo "<td class='text-center'>{$row['modelno']}</td>";
                                echo "<td class='text-center'>{$row['serialno']}</td>";
                                echo "<td class='text-center'>";
                                // Display text with background color based on item condition
                                switch ($row['itemcondition']) {
                                    case 'New':
                                        echo "<span class='badge bg-success fa-1x' title='New: The item is brand new and has never been used.'>New</span>";
                                        break;
                                    case 'Like New':
                                        echo "<span class='badge bg-primary fa-1x' title='Like New: The item is in excellent condition, almost indistinguishable from new.'>Like New</span>";
                                        break;
                                    case 'Good':
                                        echo "<span class='badge bg-info fa-1x' title='Good: The item is in good condition with minor signs of wear or use.'>Good</span>";
                                        break;
                                    case 'Fair':
                                        echo "<span class='badge bg-warning fa-1x' title='Fair: The item is in acceptable condition but shows noticeable signs of wear or use.'>Fair</span>";
                                        break;
                                    case 'Poor':
                                        echo "<span class='badge bg-danger fa-1x' title='Poor: The item is in poor condition and may require repairs or refurbishment.'>Poor</span>";
                                        break;
                                    default:
                                        echo $row['itemcondition'];
                                }
                                echo "</td>";
                                echo "<td><input type='checkbox'></td>";
                                echo "</tr>";
                            }
                        echo '
                        </tbody>
                    </table>
                </div>';
            } else {
                // If there are no borrowable items, display a message
                echo '<div class="text-center">
                        <h3>No borrowable items available at the moment.</h3>
                      </div>';
            }
            ?>
        </div>
    </div>
</main>
