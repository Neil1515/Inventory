 <!-- ccslistofitems.php -->
 <?php
 // Query to fetch categories
    $queryitems = "SELECT * FROM tblitembrand ORDER BY categoryname, subcategoryname, itembrand";
    $resultitems = mysqli_query($con, $queryitems);
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
    });
</script>

        <main class="ccs-main-container">
            <div class="container">   
            <h3><i class="fas fa-list me-2"></i>List of Items</h3>            
                <div class="row">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col">Item Name</th>  
                                <th scope="col">Item Description</th>                                           
                                <th scope="col">Model No</th>
                                <th scope="col">Serial No</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Unit Cost</th>
                                <th scope="col">Remarks</th> 
                                <th scope="col">Assign to</th>                                
                                <th scope="col">Borrowable</th>
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
                                    <td colspan='11' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>       
                                    </tr>";
                                    $currentCategory = $row['categoryname'];
                                }
                                
                                // Display the subcategory and other item details with a class for toggling
                                echo "<tr class='item-details-row'>";
                                // Check if an image exists, if not, use a default image
                                $imagePath = 'inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                                if (file_exists($imagePath)) {
                                    echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                                } else {
                                    // Use a default image if no image is uploaded
                                    echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                }            
                                echo "<td>{$row['subcategoryname']}</td>";       
                                echo "<td>{$row['itembrand']}</td>";                                                      
                                echo "<td>{$row['modelno']}</td>";
                                echo "<td>{$row['serialno']}</td>";   
                                echo "<td>{$row['datepurchased']}</td>"; 
                                echo "<td><a>₱</a>{$row['unitcost']}</td>";                  
                                echo "<td>{$row['remarks']}</td>";
                                echo "<td>{$row['assignfor']}</td>";
                                echo "<td>";
                                if ($row['borrowable'] == 'Yes') {
                                    // Display a checkmark icon for 'Yes' with bigger size
                                    echo "<i class='fas fa-check-circle fa-2x text-success'></i>";
                                } else {
                                    // Display a times (X) icon for 'No' with bigger size
                                    echo "<i class='fas fa-times-circle fa-2x text-danger'></i>";
                                }                              
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