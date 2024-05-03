<!-- ccsviewborrower_allapprovereserve_items.php -->
<?php
include 'ccsfunctions.php';

// Fetch borrower ID from the query string
$borrowerId = $_GET['borrowerId'];

// Debugging statement
error_log('Borrower ID: ' . $borrowerId);

// Fetch borrower details
$queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
$stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

if ($stmtBorrowerDetails) {
    mysqli_stmt_bind_param($stmtBorrowerDetails, "i", $borrowerId);

    if (mysqli_stmt_execute($stmtBorrowerDetails)) {
        $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

        if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
            $rowBorrowerDetails = mysqli_fetch_assoc($resultBorrowerDetails);
            $borrowerName = $rowBorrowerDetails['fname'] . ' ' . $rowBorrowerDetails['lname'];
        } else {
            die('No details found for the specified borrower ID: ' . $borrowerId);
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
    }

    mysqli_stmt_close($stmtBorrowerDetails);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>
<style>
.text-start img {
    width: 50px;
    height: 50px;
    cursor: pointer;
    border-radius: 50%;
    align-items: center;
    margin-left: 5px;
    }

</style>
<!-- Modal HTML Structure -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update Date and Time of Reservation</h5>
                <input type="hidden" id="itemId" name="itemId">
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="dateOfUse" class="form-label">Date of Use<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="dateOfUse" name="dateOfUse" required>
                </div>
                <div class="mb-2">
                    <label for="timeOfUse" class="form-label">Time of Use<span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="timeOfUse" name="timeOfUse" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveChangesBtn" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="ccs-main-container">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Reserve Item</h3>
            <div class="text-end">
                <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <h5 class="text-start"><?php
                    // Check if the user has a profile image
                        if (!empty($borrowerId)) {
                                // Check if the profile image exists
                                $profileImagePath = "/inventory/images/imageofusers/" . $borrowerId . ".png";
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                                // If the user has a profile image, display it with a timestamp
                                echo '<img src="' . $profileImagePath . '?' . time() . '" width="50">';
                                } else {
                                // If the profile image does not exist, display the default image with a timestamp
                                echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="50">';
                                }
                            } else {
                                // If senderId is empty, display the default image with a timestamp
                                    echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="50">';
                                }
                                ?>  <a href="ccstaffBorrowerProfile.php?borrower_id=<?php echo $borrowerId ?>" style='text-decoration: none;'><?= $borrowerName ?></a></h5>
            <div class="text-end mb-1">
            <a href="javascript:history.back()" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>

                <button class="btn btn-primary" id="selectAllBtn">Select All</button>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Image</th>
                            <th>Item Name</th>
                            <th>Item Description</th>
                            <th class="text-center">Serial No</th>
                            <th class="text-center">Item Condtion</th>
                            <th class="text-center">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Assuming $reserveDate should contain the current date 
                    $reserveDatetime = date('Y-m-d');
                    // Fetch items for the specified borrower with an Approve status
                    $queryItems = "SELECT * FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Approve Reserve' ORDER BY datetimereserve ASC";
                    $stmtItems = mysqli_prepare($con, $queryItems);

                    if ($stmtItems) {
                        mysqli_stmt_bind_param($stmtItems, "i", $borrowerId);

                        if (mysqli_stmt_execute($stmtItems)) {
                            $resultItems = mysqli_stmt_get_result($stmtItems);

                            if ($resultItems && mysqli_num_rows($resultItems) > 0) {
                                // Initialize an empty array to store items grouped by datetimereserve
                                $groupedItems = array();

                                while ($rowItem = mysqli_fetch_assoc($resultItems)) {
                                    $datetimereserve = $rowItem['datetimereserve'];

                                    // Check if the group for this datetimereserve exists, if not, create it
                                    if (!isset($groupedItems[$datetimereserve])) {
                                        $groupedItems[$datetimereserve] = array();
                                    }

                                    // Add the item to the corresponding group
                                    $groupedItems[$datetimereserve][] = $rowItem;
                                }

                                // Loop through each group and display items in the table
                                foreach ($groupedItems as $datetimereserve => $items) {
                                    // Determine if the reservation date matches the current date
                                    $isCurrentDate = (date('Y-m-d', strtotime($datetimereserve)) === $reserveDatetime);

                                    // Assign CSS class based on the comparison result
                                    $tdClass = $isCurrentDate ? 'table-success' : 'table-secondary';

                                    // Output table row with appropriate CSS class
                                    if (!empty($items)) {
                                        echo '<tr><td colspan="7" class="table ' . $tdClass . '" data-datetime="' . $datetimereserve . '"> Date and Time of Reservation: ' . date('F d, Y g:i A', strtotime($datetimereserve)) . ' <a class="btn btn-outline-primary btn-sm edit-btn" data-reserve-id="' . $items[0]['id'] . '"><i class="fa-solid fa-pen-to-square fs-15"></i></a> <br> Purpose: ' . $items[0]['reservepurpose'] . '<br> Location: ' . $items[0]['reservelocation'] . ' </td></tr>';
                                    } else {
                                        echo '<tr><td colspan="7">No items found</td></tr>';
                                    }
                                    
                                    foreach ($items as $rowItem) {
                                        // Fetch item details from tblitembrand based on itemid
                                        $queryItemDetails = "SELECT * FROM tblitembrand WHERE id = ?";
                                        $stmtItemDetails = mysqli_prepare($con, $queryItemDetails);

                                        if ($stmtItemDetails) {
                                            mysqli_stmt_bind_param($stmtItemDetails, "i", $rowItem['itemid']);

                                            if (mysqli_stmt_execute($stmtItemDetails)) {
                                                $resultItemDetails = mysqli_stmt_get_result($stmtItemDetails);

                                                if ($resultItemDetails && mysqli_num_rows($resultItemDetails) > 0) {
                                                    $rowItemDetails = mysqli_fetch_assoc($resultItemDetails);

                                                    // Display item details in a table row
                                                    echo '<tr data-reserve-date="' . $datetimereserve . '" data-reserve-id="' . $rowItem['id'] . '">';

                                                    // Check if an image exists, if not, use a default image
                                                    $imagePath = 'inventory/SubcategoryItemsimages/' . $rowItemDetails['subcategoryname'] . '.png';
                                                    if (file_exists($imagePath)) {
                                                        echo "<td class='text-center'><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                                                    } else {
                                                        // Use a default image if no image is uploaded
                                                        echo "<td class='text-center'><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                                    }
                                                    echo '<td>' . $rowItemDetails['subcategoryname'] . '</td>';
                                                    echo '<td>' . $rowItemDetails['itembrand'] . '</td>';
                                                    echo '<td class="text-center">' . $rowItemDetails['serialno'] . '</td>';
                                                    echo '<td class="text-center">' . $rowItemDetails['itemcondition'] . '</td>';
                                                    echo '<td class="text-center"><input type="checkbox" name="itemIds[]" value="' . $rowItem['id'] . '"></td>';
                                                    echo '</tr>';
                                                } else {
                                                    echo '<tr><td colspan="7">No details found for item ID: ' . $rowItem['itemid'] . '</td></tr>';
                                                }
                                            } else {
                                                die('Statement execution failed: ' . mysqli_stmt_error($stmtItemDetails));
                                            }

                                            mysqli_stmt_close($stmtItemDetails);
                                        } else {
                                            die('Statement preparation failed: ' . mysqli_error($con));
                                        }
                                    }
                                }
                            } else {
                                echo '<tr><td colspan="7">No items with a pending status found for this borrower.</td></tr>';
                            }
                        } else {
                            die('Statement execution failed: ' . mysqli_stmt_error($stmtItems));
                        }

                        mysqli_stmt_close($stmtItems);
                    } else {
                        die('Statement preparation failed: ' . mysqli_error($con));
                    }
                    ?>
                </tbody>
                </table>
                <!-- Buttons for approve and reject actions (initially hidden) -->
                <div class="text-end mb-2" id="actionButtons" style="display: none;">
                    <?php if ($reserveDatetime === $currentDate): ?>
                        <button class="btn btn-primary" id="borrowBtn">Release Selected</button>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-danger" id="rejectBtn">Cancel Selected</button>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Bootstrap JavaScript (Ensure it's included after jQuery) -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                $(document).ready(function() {
         // Set the minimum date for the "Date of Use" input to today
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("dateOfUse").min = today;
    
                    // Pass the current date to JavaScript
                    var currentDate = '<?php echo $currentDate; ?>';

                    // Function to check if the selected item's reserve date matches the current date (without considering time)
                    function isCurrentDateReserve(itemReserveDate) {
                        var currentDateObj = new Date(currentDate);
                        var itemReserveDateObj = new Date(itemReserveDate);
                        // Convert both dates to UTC to ignore timezones
                        var currentUtcDate = Date.UTC(currentDateObj.getFullYear(), currentDateObj.getMonth(), currentDateObj.getDate());
                        var reserveUtcDate = Date.UTC(itemReserveDateObj.getFullYear(), itemReserveDateObj.getMonth(), itemReserveDateObj.getDate());
                        return currentUtcDate === reserveUtcDate;
                    }


                    // Handle click event for Select All button
                    $('#selectAllBtn').click(function() {
                        // Check all checkboxes in the table
                        $('input[type="checkbox"]').prop('checked', true);
                        // Show the action buttons
                        $('#actionButtons').show();

                        // Check if all selected items have reserve date equal to the current date
                        var allCurrentDateReserve = true;
                        $('input[name="itemIds[]"]:checked').each(function() {
                            var reserveDate = $(this).closest('tr').data('reserve-date');
                            if (!isCurrentDateReserve(reserveDate)) {
                                allCurrentDateReserve = false;
                                return false; // Exit the loop
                            }
                        });

                        // Hide the "Borrow Selected" button if all checkboxes are checked and reserve dates don't match
                        if (allCurrentDateReserve) {
                            $('#borrowBtn').show();
                        } else {
                            $('#borrowBtn').hide();
                        }
                    });



                    // Handle checkbox click event
                $('input[type="checkbox"]').click(function() {
                    if ($(this).prop("checked") == true) {
                        // Show the action buttons when an item is selected
                        $('#actionButtons').show();
                        // Check if all selected items have reserve date equal to the current date
                        var allCurrentDateReserve = true;
                        $('input[name="itemIds[]"]:checked').each(function() {
                            var reserveDate = $(this).closest('tr').data('reserve-date');
                            if (!isCurrentDateReserve(reserveDate)) {
                                allCurrentDateReserve = false;
                                return false; // Exit the loop
                            }
                        });
                        // Show or hide the "Borrow Selected" button based on the comparison result
                        if (!allCurrentDateReserve) {
                            $('#borrowBtn').hide();
                        } else {
                            $('#borrowBtn').show();
                        }
                    } else {
                        // Check if any other checkbox is still selected
                        var anyChecked = false;
                        $('input[name="itemIds[]"]:checked').each(function() {
                            if ($(this).prop("checked") == true) {
                                anyChecked = true;
                                return false; // Break out of the loop
                            }
                        });
                        // Hide the action buttons if no other checkbox is selected
                        if (!anyChecked) {
                            $('#actionButtons').hide();
                        }
                        // Check if all remaining selected items have reserve date equal to the current date
                        else {
                            var allCurrentDateReserve = true;
                            $('input[name="itemIds[]"]:checked').each(function() {
                                var reserveDate = $(this).closest('tr').data('reserve-date');
                                if (!isCurrentDateReserve(reserveDate)) {
                                    allCurrentDateReserve = false;
                                    return false; // Exit the loop
                                }
                            });
                            // Show or hide the "Borrow Selected" button based on the comparison result
                            if (!allCurrentDateReserve) {
                                $('#borrowBtn').hide();
                            } else {
                                $('#borrowBtn').show();
                            }
                        }
                    }
                });
                    // Approve selected items
                    $('#borrowBtn').click(function() {
                        // Get the IDs of the selected items
                        var itemIds = [];
                        $('input[name="itemIds[]"]:checked').each(function() {
                            itemIds.push($(this).val());
                        });

                        if (itemIds.length > 0) {
                            // Check if all selected items have reserve date equal to the current date
                            var allCurrentDateReserve = true;
                            $('input[name="itemIds[]"]:checked').each(function() {
                                var reserveDate = $(this).closest('tr').data('reserve-date');
                                if (!isCurrentDateReserve(reserveDate)) {
                                    allCurrentDateReserve = false;
                                    return false; // Exit the loop
                                }
                            });

                            // Display confirmation dialog if all selected items have reserve date equal to the current date
                            if (allCurrentDateReserve && confirm("Are you sure you want to approve these selected item(s)?")) {
                                // Send AJAX request to update item status to "Approved"
                                $.ajax({
                                    type: 'POST',
                                    url: 'ccsapproveborrowselected_item.php',
                                    data: { itemIds: itemIds }, // Send the array of item IDs
                                    dataType: 'json', // Expect JSON response
                                    success: function(response) {
                                        console.log('Success:', response); // Add this line for debugging
                                        // Handle success response
                                        if (response.success) {
                                            // No need to display any message here
                                            window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_success=Selected Item(s) successfully borrowed';
                                        } else {
                                            alert('Error: ' + response.error); // Show error message from PHP script
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response
                                        console.error(xhr.responseText); // Log error message
                                        // Redirect to the desired page with an error message
                                        window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_error=Error occurred while approving selected items';
                                    }
                                });
                            } else {
                                alert('Please select item(s) with reserve date equal to the current date.');
                            }
                        } else {
                            alert('Please select at least one item to approve.');
                        }
                    });

                    // Cancel selected items
                    $('#rejectBtn').click(function() {
                        // Get the IDs of the selected items
                        var itemIds = [];
                        $('input[name="itemIds[]"]:checked').each(function() {
                            itemIds.push($(this).val());
                        });

                        if (itemIds.length > 0) {
                            // Display confirmation dialog
                            if (confirm("Are you sure you want to cancel these selected item(s)?")) {
                                // Send AJAX request to update item status to "cancel"
                                $.ajax({
                                    type: 'POST',
                                    url: 'ccsrejectapproveselected_item.php',
                                    data: { itemIds: itemIds }, // Send the array of item IDs
                                    dataType: 'json', // Expect JSON response
                                    success: function(response) {
                                        // Handle success response
                                        if (response.success) {
                                            // Redirect to the desired page with a success message
                                            window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_success=Selected Item(s) rejected successfully';
                                        } else {
                                            alert('Error: ' + response.error); // Show error message from PHP script
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error response
                                        console.error(xhr.responseText); // Log error message
                                        // Redirect to the desired page with an error message
                                        window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_success=Selected Item(s) rejected successfully';
                                    }
                                });
                            }
                        } else {
                            alert('Please select at least one item to reject.');
                        }
                    });

                    // Set the minimum date for the "Date of Use" input to today
                    var today = new Date().toISOString().split('T')[0];
                    document.getElementById("dateOfUse").min = today;

// Handle click event for the Edit button
$(document).on('click', '.edit-btn', function() {
    // Get the itemId from the data attribute of the button
    var itemId = $(this).data('reserve-id');

    // Get the date and time from the table row
    var datetime = $(this).closest('td').data('datetime');

    // Split the datetime string into date and time
    var dateTimeParts = datetime.split(' ');
    var date = dateTimeParts[0];
    var time = dateTimeParts[1];

    // Populate the date and time inputs in the modal
    $('#dateOfUse').val(date);
    $('#timeOfUse').val(time);

    // Store the itemId in a hidden input field within the modal
    $('#itemId').val(itemId);

    // Show the modal
    $('#editModal').modal('show');
});

$('#saveChangesBtn').click(function() {
    // Get the itemId from the hidden input field
    var itemId = $('#itemId').val();

    // Get the updated date and time from the modal inputs
    var updatedDate = $('#dateOfUse').val();
    var updatedTime = $('#timeOfUse').val();

    // Combine date and time into a single string
    var updatedDateTime = updatedDate + ' ' + updatedTime;
    // Send AJAX request to update the datetimereserve in the database
    $.ajax({
        type: 'POST',
        url: 'ccsupdate_date_timeofreservation.php',
        data: {
            itemId: itemId,
            updatedDateTime: updatedDateTime
        },
        dataType: 'json',
        success: function(response) {
            // Handle success response
            if (response.success) {
                // Reload the current page
                window.location.reload();
                // Show a success message
                window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_success=Successfuly update the schedule.';

            } else {
                // Show an error message
                alert('Error: ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
            // Optionally, display an error message to the user
            window.location.reload();
            window.location.href = 'ccsstaffViewBorrower_allapprovereserve_items.php?borrowerId=<?php echo $borrowerId; ?>&msg_success=Successfuly update the schedule.';
        }
    });
});

});

</script>
