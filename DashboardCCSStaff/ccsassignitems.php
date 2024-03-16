<!-- ccsassignitems.php -->
<?php
include('ccsfunctions.php'); // Include necessary files

// Retrieve the assignfor value from the query parameters
$selectedAssignFor = $_GET['assignfor'] ?? '';

// Use $selectedAssignFor as needed in your page
echo "<h3><i class='fas fa-chalkboard-teacher me-2'></i> $selectedAssignFor</h3>";

// Fetch items based on the selected assignfor value
$queryItems = "SELECT * FROM tblitembrand WHERE assignfor = ?";
$stmtItems = mysqli_prepare($con, $queryItems);

if ($stmtItems) {
    mysqli_stmt_bind_param($stmtItems, "s", $selectedAssignFor);

    if (mysqli_stmt_execute($stmtItems)) {
        $resultItems = mysqli_stmt_get_result($stmtItems);

        if ($resultItems && mysqli_num_rows($resultItems) > 0) {
            // Display items in a table
            echo '<table class="table">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th>Category Name</th>';
            echo '<th>Item Brand</th>';
            echo '<th>Subcategory Name</th>';
            echo '<th>Model No</th>';
            echo '<th>Serial No</th>';
            echo '<th>Unit Cost</th>';
            
            echo '<th>Date Purchased</th>';
            echo '<th>Remarks</th>';
            echo '<th>Status</th>';
            //echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            
            echo '<tbody>';
            
            $currentCategory = null; // Initialize $currentCategory variable

            while ($item = mysqli_fetch_assoc($resultItems)) {
                // Check if the category has changed
                if ($currentCategory != $item['categoryname']) {
                    // Display the category name row with a class for click event
                    echo "<tr class='category-row'>
                        <td colspan='10' style='background-color: azure;'><strong>{$item['categoryname']}</strong></td>       
                        </tr>";
                    $currentCategory = $item['categoryname'];
                }
                echo '<tr>';
                // Check if an image exists, if not, use a default image
                $imagePath = 'inventory/SubcategoryItemsimages/' . $item['subcategoryname'] . '.png';
                if (file_exists($imagePath)) {
                    echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                } else {
                    // Use a default image if no image is uploaded
                    echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                }
                echo '<td>' . $item['itembrand'] . '</td>';
                echo '<td>' . $item['subcategoryname'] . '</td>';
                echo '<td>' . $item['modelno'] . '</td>';
                echo '<td>' . $item['serialno'] . '</td>';
                echo '<td>' . $item['unitcost'] . '</td>';
               
                echo '<td>' . $item['datepurchased'] . '</td>';
                 echo '<td>' . $item['remarks'] . '</td>';
                echo '<td>' . $item['status'] . '</td>';
                //echo "<td>
                //<a href=\"#\" data-item-id='{$item['id']}' onclick=\"confirmRemoveAssignfor(this)\" class=\"btn btn-outline-danger btn-sm\"><i class='fa-solid fa-trash fs-7'></i>Remove</a>
              //</td>";
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            // Handle the case when no items are found for the selected assignfor
            echo '<p>No items found for the selected Assign For.</p>';
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmtItems));
    }

    mysqli_stmt_close($stmtItems);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
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

       // Function to confirm removal
        window.confirmRemoveAssignfor = function(link) {
            var itemId = $(link).data('item-id');
            if (confirm('Are you sure you want to remove this item from Assign For?')) {
                // Perform AJAX request to update_assignfor.php
                $.ajax({
                    url: 'update_assignfor.php',
                    method: 'POST',
                    data: { itemId: itemId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Reload the page or update the UI as needed
                            location.reload();
                        } else {
                            alert('Failed to remove item from Assign For: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed', xhr, status, error);
                        alert('ambot ngano di ma wagtang.');
                    }
                });
            }
        };

    });
</script>