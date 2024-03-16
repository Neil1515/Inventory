<!-- ccslistborroweditems.php -->
<?php
include('ccsfunctions.php');

// Assuming $con is your database connection variable
$query = "SELECT * FROM `tblitembrand` WHERE `status` = 'Reserve' ORDER BY categoryname, subcategoryname";
$result = mysqli_query($con, $query);

if (!$result) {
    // Handle the case when the query fails
    die('Query failed: ' . mysqli_error($con));
}
?>

<!-- Display the list of Reserve items as cards -->
<div class="container">
    <h2><i class='fas fa-bookmark me-2'></i>List of Reserve Items</h2>
    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-4 g-2">
    <?php
        while ($rowItem = mysqli_fetch_assoc($result)) {
            // Fetch the last Reserve item details for the current item
            $sqlSelect = "SELECT * FROM tblreservereports WHERE itemid = ? ORDER BY id DESC LIMIT 1";
            $stmtSelect = mysqli_prepare($con, $sqlSelect);

            if ($stmtSelect) {
                mysqli_stmt_bind_param($stmtSelect, "i", $rowItem['id']);
                mysqli_stmt_execute($stmtSelect);
                $resultSelect = mysqli_stmt_get_result($stmtSelect);

                // Check if there are rows to fetch
                if ($resultSelect) {
                    // Fetch the last borrowed item details
                    $row = mysqli_fetch_assoc($resultSelect);

                    // Check if $row is not null
                    if ($row) {
                        // Fetch subcategory information for the current item
                        $sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
                        $stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

                        if ($stmtSubcategory) {
                            mysqli_stmt_bind_param($stmtSubcategory, "i", $rowItem['id']);
                            mysqli_stmt_execute($stmtSubcategory);
                            $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

                            if ($resultSubcategory) {
                                // Fetch subcategory details
                                $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);

                                // Construct the image path based on subcategory information
                                $imagePath = 'inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
                            } else {
                                // If subcategory information is not found, use the default image
                                $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                            }

                            mysqli_stmt_close($stmtSubcategory);
                        } else {
                            // Log the error instead of displaying to users
                            error_log("Statement preparation failed for subcategory: " . mysqli_error($con));
                            $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                        }

                        // Output the card for the current borrowed item
                        echo '<div class="col ">';
                        echo '<div class="card ">';
                        echo '<div class="card-body">';
                        echo '<h7 class="card-title">' . $row['categoryname'] . '</h7>';
                        echo '<div class="mb-3 text-center">';
                        echo '<img src="' . $imagePath . '" alt="Image" width="100">';
                        echo '</div>';
                        echo '<div  class="mb-1 text-center">';
                        echo '<h5 class="card-text">' . $rowItem['subcategoryname'] . '</h5>';
                        echo '</div>';
                        echo '<div class="mb-1">';
                        echo '<h7 class="card-text">Item: ' . $rowItem['itembrand'] . '</h7>';
                        echo '</div>';
                        echo '<div class="mb-1">';
                        echo '<h7 class="card-text">Borrower Name: ' . $row['borrowername'] . '</h7>';
                        echo '</div>';
                        echo '<div class="mb-3">';
                    // Assuming $row['datetimereserve'] contains the date and time in the format 'Y-m-d H:i:s'
                        $dateReserve = new DateTime($row['datetimereserve'], new DateTimeZone('UTC'));
                        $dateReserve->setTimezone(new DateTimeZone('Asia/Manila'));
                        echo '<h7 class=" card-text">Date Reserve: ' . $dateReserve->format('m-d-Y') . '</h7>';
                        echo '</div>';
                        echo '<div class="mb-2 text-start">';
                        echo '<a href="ccsstaffProceedBorrowing.php?item_id=' . $rowItem['id'] . '" class="btn btn-primary">Proceed Borrow</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // Log the error instead of displaying to users
                        error_log("No rows fetched for last borrowed item: " . mysqli_error($con));
                    }
                } else {
                    // Log the error instead of displaying to users
                    error_log("Failed to fetch last borrowed item: " . mysqli_error($con));
                }

                mysqli_stmt_close($stmtSelect);
            } else {
                // Log the error instead of displaying to users
                error_log("Statement preparation failed: " . mysqli_error($con));
            }
        }
    ?>
    </div>
</div>

<!-- Add your Bootstrap and Font Awesome links and scripts here -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
