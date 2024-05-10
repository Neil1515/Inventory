<!-- bwerreserveitems.php -->
<?php
// Output the container and search input
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="d-flex justify-content-between">';
echo '<h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Current Pending Reservation</h3>';
echo '<div class="text-end">';
echo '<input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">';
echo '</div>';
echo '</div>';
echo '<div class="mb-2">';
echo '<a href="borrowerPendingReserve.php"  class="btn btn-danger me-2">Pending Reservation</a>';
echo '<a href="borrowerAcceptedReserve.php"  class="btn btn-primary">Accepted Reservation</a>';
echo '</div>';

$query = "SELECT borrowerid FROM tblborrowingreports WHERE borrowerid = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $borrower_row = mysqli_fetch_assoc($result);
            $borrowerId = $borrower_row['borrowerid'];

            $query_items = "SELECT DISTINCT b.id, b.itemid, i.itembrand, i.categoryname, i.subcategoryname, i.modelno, i.serialno, b.approvebyid, b.datetimereserve
                            FROM tblborrowingreports b
                            INNER JOIN tblitembrand i ON b.itemid = i.id
                            WHERE b.borrowerid = ? AND b.itemreqstatus = 'Pending Reserve'";
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
                            echo '<h7 class="card-text">Serial No: <span class="text-danger">' . $item_row['serialno'] . '</span><br></h7>';
                            $formattedDatetime = date('F d, Y (g:i A) ', strtotime($item_row['datetimereserve']));
                            echo '<h7 class="card-text">Date Reserve: <br> ' . $formattedDatetime . '</h7>';
                            echo '<div class="card text-end">';
                            echo '<a class="btn btn-danger" onclick="cancelRequest(' . $item_row['id'] . ')">Cancel Request</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="alert alert-info">No pending item found to your account.</p>';
                    }
                } else {
                    echo 'Statement execution failed: ' . mysqli_stmt_error($stmt_items);
                }
            } else {
                echo 'Statement preparation failed: ' . mysqli_error($con);
            }
        } else {
            echo '<p class="alert alert-info">No pending item found to your account.</p>';
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function cancelRequest(itemId) {
        $.ajax({
            type: "POST",
            url: "bwercancel_request.php", // PHP script to handle the AJAX request
            data: { itemId: itemId }, // Data to be sent to the server
            success: function (response) {
                // Handle the response from the server, if needed
                console.log(response);
                //alert('Item Canceled successfully!');
                window.location.href = 'borrowerPendingReserve.php?msg_success=Reserve item Successfully Canceled';
            }
        });
    }
</script>