<!-- bweritemsborrowed.php -->
<?php
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<h3 class="text-start">Current Borrowed Items </h3>';

$query = "SELECT borrowerid FROM tblborrowingreports WHERE borrowerid = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $borrower_row = mysqli_fetch_assoc($result);
            $borrowerId = $borrower_row['borrowerid'];

            $query_items = "SELECT DISTINCT b.id, b.itemid, b.itemreqstatus, i.itembrand, i.categoryname, i.subcategoryname, i.modelno, i.serialno, b.approvebyid, b.datimeapproved, u.fname, u.lname
                            FROM tblborrowingreports b
                            INNER JOIN tblitembrand i ON b.itemid = i.id
                            LEFT JOIN tblusers u ON b.approvebyid = u.id
                            WHERE b.borrowerid = ? AND(b.itemreqstatus = 'Approved' OR b.itemreqstatus = 'Request return')";
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
                            echo '<h5 class="card-title">' . $item_row['subcategoryname'] . '</h5>';
                            echo '<div class="mb-3 text-center">';
                            echo '<img src="' . $imagePath . '" alt="Image" width="70">';
                            echo '</div>';  
                            //echo '<h7 class="text-center">' . $item_row['subcategoryname'] . '<br></h7>';
                            echo '<h7 class="card-text">' . $item_row['itembrand'] . '<br></h7>';
                            echo '<h7 class="card-text">Serial No: ' . $item_row['serialno'] . '<br></h7>';
                            echo '<h7 class="card-text">Released by: ' . $item_row['fname'] . ' ' . $item_row['lname'] . '<br></h7>';
                            $formattedDatetime = date('F d, Y (g:i A) ', strtotime($item_row['datimeapproved']));
                            echo '<h7 class="card-text">Date Released: <br> ' . $formattedDatetime . '</h7>';
                            echo '<div class="card text-end">';
                            if (isset($item_row['itemreqstatus'])) {
                                switch ($item_row['itemreqstatus']) {
                                    case 'Approved':
                                        echo '<button type="button" class="btn btn-success request-return-btn" data-item-id="' . $item_row['id'] . '">Request Return</button>';
                                        break;
                                    case 'Request Return':
                                        echo '<button type="button" class="btn btn-primary request-cancel-btn" data-item-id="' . $item_row['id'] . '">Request Sent</button>';                                        break;
                                    default:
                                        // Default action or no action for other statuses
                                        break;
                                }
                            } else {
                                echo '<p class="text-danger">Status not available</p>';
                            }
                            echo '</div>';                       
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        //echo 'No items found to your account.';
                        echo '<p class="alert alert-info">No items found to your account.</p>';
                    }
                } else {
                    echo 'Statement execution failed: ' . mysqli_stmt_error($stmt_items);
                }
            } else {
                echo 'Statement preparation failed: ' . mysqli_error($con);
            }
        } else {
            echo '<p class="alert alert-info">No items found to your account.</p>';
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

<script>
    // JavaScript function to handle Request Return button click
    document.addEventListener('DOMContentLoaded', function () {
        const requestReturnButtons = document.querySelectorAll('.request-return-btn');

        requestReturnButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-item-id');
                requestReturn(itemId);
            });
        });

        function requestReturn(itemId) {
            // Send AJAX request to update itemreqstatus
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle successful response
                        console.log(xhr.responseText);
                        // Check if the response contains a success message
                        if (xhr.responseText.includes("Item request status updated successfully.")) {
                            // Display success message
                            //alert("Item request status updated successfully.");
                            // Redirect to the desired page
                            window.location.href = 'borrowerItemsBorrowed.php?msg_success=Item request return updated successfully.';
                        } else {
                            // Handle other responses if needed
                        }
                    } else {
                        // Handle error
                        console.error('Request failed: ' + xhr.status);
                    }
                }
            };

            xhr.open('POST', 'bwerupdate_itemreqstatus.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('itemId=' + encodeURIComponent(itemId));
        }
    });
    // JavaScript function to handle Request cancel button click
    document.addEventListener('DOMContentLoaded', function () {
        const requestCancelButtons = document.querySelectorAll('.request-cancel-btn');

        requestCancelButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-item-id');
                requestCancel(itemId);
            });
        });

        function requestCancel(itemId) {
            // Send AJAX request to update itemreqstatus
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle successful response
                        console.log(xhr.responseText);
                        // Check if the response contains a success message
                        if (xhr.responseText.includes("Item request status updated successfully.")) {

                            window.location.href = 'borrowerItemsBorrowed.php?msg_success=Item request cancel return updated successfully.';
                        } else {
                            // Handle other responses if needed
                        }
                    } else {
                        // Handle error
                        console.error('Request failed: ' + xhr.status);
                    }
                }
            };

            xhr.open('POST', 'bwercancel_itemreqstatus.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('itemId=' + encodeURIComponent(itemId));
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const requestCancelButtons = document.querySelectorAll('.request-cancel-btn');

        requestCancelButtons.forEach(button => {
            button.addEventListener('mouseover', function () {
                this.textContent = 'Cancel Request';
                this.classList.remove('btn-primary');
                this.classList.add('btn-danger');
            });

            button.addEventListener('mouseout', function () {
                this.textContent = 'Request Sent';
                this.classList.remove('btn-danger');
                this.classList.add('btn-primary');
            });
        });
    });
</script>
