<!-- bweritemsborrowed.php -->
<?php
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<h3 class="text-start">Your Items Borrowed </h3>';

$query = "SELECT borrowerid FROM tblborrowingreports WHERE borrowerid = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $borrower_row = mysqli_fetch_assoc($result);
            $borrowerId = $borrower_row['borrowerid'];

            $query_items = "SELECT DISTINCT b.itemid, i.itembrand, i.categoryname, i.subcategoryname, i.modelno, i.serialno, b.approvebyid, b.datimeapproved, u.fname, u.lname
                            FROM tblborrowingreports b
                            INNER JOIN tblitembrand i ON b.itemid = i.id
                            LEFT JOIN tblusers u ON b.approvebyid = u.id
                            WHERE b.borrowerid = ? AND b.itemreqstatus = 'Approved'";
            $stmt_items = mysqli_prepare($con, $query_items);

            if ($stmt_items) {
                mysqli_stmt_bind_param($stmt_items, "s", $borrowerId);

                if (mysqli_stmt_execute($stmt_items)) {
                    $result_items = mysqli_stmt_get_result($stmt_items);

                    if ($result_items && mysqli_num_rows($result_items) > 0) {
                        while ($item_row = mysqli_fetch_assoc($result_items)) {
                            $imagePath = ''; // Initialize image path
                            
                            // Fetch subcategory information for the current item
                            $sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
                            $stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

                            if ($stmtSubcategory) {
                                mysqli_stmt_bind_param($stmtSubcategory, "i", $item_row['itemid']);
                                mysqli_stmt_execute($stmtSubcategory);
                                $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

                                if ($resultSubcategory) {
                                    $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);
                                    $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
                                }
                                mysqli_stmt_close($stmtSubcategory);
                            }
                            
                            // If subcategory image is not found, use default
                            if (empty($imagePath)) {
                                $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                            }

                            echo '<div class="col-md-3 mb-3">';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $item_row['categoryname'] . '</h5>';
                            echo '<div class="mb-3 text-center">';
                            echo '<img src="' . $imagePath . '" alt="Image" width="70">';
                            echo '</div>';  
                            echo '<h7 class="text-center">' . $item_row['subcategoryname'] . '<br></h7>';
                            echo '<h7 class="card-text">' . $item_row['itembrand'] . '<br></h7>';
                            echo '<h7 class="card-text">Serial No: ' . $item_row['serialno'] . '<br></h7>';
                            echo '<h7 class="card-text">Approved by: ' . $item_row['fname'] . ' ' . $item_row['lname'] . '<br></h7>';
                            $formattedDatetime = date('F d, Y (g:i A) ', strtotime($item_row['datimeapproved']));
                            echo '<h7 class="card-text">Date Approved: <br> ' . $formattedDatetime . '</h7>';

                            echo '<div class="card text-end">';
                            echo ' <button type="submit" class="btn btn-success " name="requestBorrow">Request Return</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No items found for this borrower.';
                    }
                } else {
                    echo 'Statement execution failed: ' . mysqli_stmt_error($stmt_items);
                }
            } else {
                echo 'Statement preparation failed: ' . mysqli_error($con);
            }
        } else {
            echo 'No items found for this borrower.';
        }
    } else {
        echo 'Statement execution failed: ' . mysqli_stmt_error($stmt);
    }
} else {
    echo 'Statement preparation failed: ' . mysqli_error($con);
}

echo '</div>';
echo '</div>';
echo '</div>';
?>
