<!-- ccsusersreserveitems.php -->
<?php
// Output the container and search input
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="d-flex justify-content-between">';
echo '<h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>List of Pending Reservation</h3>';
echo '<div class="text-end">';
echo '<input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">';
echo '</div>';
echo '</div>';
echo '<div class="">';
echo '<a href="ccsstaffUsersPendingReserveItems.php"  class="btn btn-danger me-2">Pending Reservation</a>';
echo '<a href="ccsstaffUsersApproveReserveItems.php"  class="btn btn-primary">Accepted Reservation</a>';
echo '</div>';
echo '<div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 g-1">';

 // Fetch unique borrower IDs with pending requests
 $queryBorrowers = "SELECT DISTINCT borrowerid FROM tblborrowingreports WHERE itemreqstatus = 'Pending Reserve'";
 $resultBorrowers = mysqli_query($con, $queryBorrowers);


 $cardCount = 0; // Track the number of cards displayed

 if ($resultBorrowers && mysqli_num_rows($resultBorrowers) > 0) {
     // Iterate through each borrower
     while ($rowBorrower = mysqli_fetch_assoc($resultBorrowers)) {
         $borrowerId = $rowBorrower['borrowerid'];

         // Count the number of items requested by the current borrower
         $queryItemCount = "SELECT COUNT(itemid) AS itemCount FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Reserve'";
         $stmtItemCount = mysqli_prepare($con, $queryItemCount);

         if ($stmtItemCount) {
             mysqli_stmt_bind_param($stmtItemCount, "i", $borrowerId);

             if (mysqli_stmt_execute($stmtItemCount)) {
                 $resultItemCount = mysqli_stmt_get_result($stmtItemCount);
                 $rowItemCount = mysqli_fetch_assoc($resultItemCount);

                 // Valid borrower details, fetch the borrower details and display them in a card
                 $queryBorrowerDetails = "SELECT * FROM tblusers WHERE id = ?";
                 $stmtBorrowerDetails = mysqli_prepare($con, $queryBorrowerDetails);

                 if ($stmtBorrowerDetails) {
                     mysqli_stmt_bind_param($stmtBorrowerDetails, "i", $borrowerId);

                     if (mysqli_stmt_execute($stmtBorrowerDetails)) {
                         $resultBorrowerDetails = mysqli_stmt_get_result($stmtBorrowerDetails);

                         if ($resultBorrowerDetails && mysqli_num_rows($resultBorrowerDetails) > 0) {
                             $borrowerDetails = mysqli_fetch_assoc($resultBorrowerDetails);
                             $cardCount++; // Increment card count
             ?>
                             <div class="card me-2">
                                 <div class="card-body">
                                     <h5 class="card-title">Borrower ID: <?php echo $borrowerDetails['id']; ?></h5>
                                     <p class="card-text">Name: <?php echo $borrowerDetails['fname'] . ' ' . $borrowerDetails['lname']; ?></p>
                                     <p class="card-text">Type: <?php echo $borrowerDetails['usertype']; ?></p>
                                     <p class="card-text">Number of item(s): <?php echo $rowItemCount['itemCount']; ?></p>

                                     <!-- Display the item IDs with pending status and their subcategories with quantity -->
                                     <?php
                                     $queryPendingItems = "SELECT br.itemid, ib.subcategoryname
                                         FROM tblborrowingreports br
                                         INNER JOIN tblitembrand ib ON br.itemid = ib.id
                                         WHERE br.borrowerid = ? AND br.itemreqstatus = 'Pending Reserve'";
                                     $stmtPendingItems = mysqli_prepare($con, $queryPendingItems);

                                     if ($stmtPendingItems) {
                                         mysqli_stmt_bind_param($stmtPendingItems, "i", $borrowerId);

                                         if (mysqli_stmt_execute($stmtPendingItems)) {
                                             $resultPendingItems = mysqli_stmt_get_result($stmtPendingItems);

                                             if ($resultPendingItems && mysqli_num_rows($resultPendingItems) > 0) {
                                                 $itemCounts = array();

                                                 while ($rowPendingItem = mysqli_fetch_assoc($resultPendingItems)) {
                                                     $subcategory = $rowPendingItem['subcategoryname'];

                                                     // Increment the count for each subcategory
                                                     if (isset($itemCounts[$subcategory])) {
                                                         $itemCounts[$subcategory]++;
                                                     } else {
                                                         $itemCounts[$subcategory] = 1;
                                                     }
                                                 }

                                                 echo '<p class="card-text">Pending reserve item(s): ';
                                                 foreach ($itemCounts as $subcategory => $count) {
                                                     echo $subcategory;

                                                     // Display quantity if greater than 1
                                                     if ($count > 1) {
                                                         echo '(' . $count . ')';
                                                     }

                                                     echo ', ';
                                                 }
                                                 echo '</p>';
                                             } else {
                                                 echo '<p class="card-text">No items with pending status.</p>';
                                             }
                                         } else {
                                             die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingItems));
                                         }

                                         mysqli_stmt_close($stmtPendingItems);
                                     } else {
                                         die('Statement preparation failed: ' . mysqli_error($con));
                                     }
                                     ?>
                                 </div>
                         <div class='text-end me-1'>
                             <a  class='btn btn-danger mb-1' onclick="rejectAllItemsToThisBorrowerId(<?php echo $borrowerId; ?>)">Reject All</a>
                             <a  class='btn btn-primary mb-1' onclick="approveAllItemsToThisBorrowerId(<?php echo $borrowerId; ?>)">Accept All</a>
                             <a href='ccsstaffViewBorrower_allreserve_items.php?borrowerId=<?php echo $borrowerId; ?>' class='btn btn-success mb-1'>View <?php echo $rowItemCount['itemCount']; ?> Items</a>
                         </div>
                     </div>
                         <?php
                     } else {
                         echo "<p class='alert alert-warning'>No details found for borrower ID: {$borrowerId}</p>";
                     }
                 } else {
                     die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowerDetails));
                 }
                 mysqli_stmt_close($stmtBorrowerDetails);
             } else {
                 die('Statement preparation failed: ' . mysqli_error($con));
             }
         } else {
             die('Statement execution failed: ' . mysqli_stmt_error($stmtItemCount));
         }
         mysqli_stmt_close($stmtItemCount);
     } else {
         die('Statement preparation failed: ' . mysqli_error($con));
     }
 }
} else {
 echo '<div class="col-md-10">';
 echo '<p class="alert alert-info">No borrowers with pending requests found.</p>';
 echo '</div>';
}

// Close the container div
echo '</div>';
echo '</div>';
echo '</div>';
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
 function approveAllItemsToThisBorrowerId(borrowerId) {
     if (confirm('Are you sure you want to approve all items to this user?')) {
         // Send an AJAX request to approve all items
         $.ajax({
             type: 'GET',
             url: 'ccsapproveborrower_allreserve_items.php',
             data: { borrowerId: borrowerId },
             success: function (response) {
                 handleApprovalResponse(response);
             },
             error: function (xhr, status, error) {
                 console.error('AJAX request failed. Status: ' + status + ', Error: ' + error);
             }
         });
     }
 }

 function handleApprovalResponse(response) {
     console.log(response);

     // Handle the response accordingly
     if (response.includes('Items approved successfully')) {
         //alert('Items approved successfully!');
         // You can also update the UI dynamically if needed
         window.location.href = 'ccsstaffUsersPendingReserveItems.php?msg_success=Items approved successfully by ';
     } else {
         alert('Error: ' + response);
     }
 }

 function rejectAllItemsToThisBorrowerId(borrowerId) {
     if (confirm('Are you sure you want to reject all items to this user?')) {
         // Send an AJAX request to reject all items
         $.ajax({
             type: 'GET',
             url: 'ccsrejectborrower_allreserve_items.php',
             data: { borrowerId: borrowerId },
             success: function (response) {
                 handleRejectResponse(response);
             },
             error: function (xhr, status, error) {
                 console.error('AJAX request failed. Status: ' + status + ', Error: ' + error);
             }
         });
     }
 }

 function handleRejectResponse(response) {
     console.log(response);

     // Handle the response accordingly
     if (response.includes('Items reject successfully')) {
         //alert('Items reject successfully!');
         // You can also update the UI dynamically if needed
         window.location.href = 'ccsstaffUsersPendingReserveItems.php?msg_success=Items reject successfully ';
     } else {
         alert('Error: ' + response);
     }
 }
</script>
<style>
 .card:hover {
     background-color: azure;
     transition: background-color 0.3s ease-in-out;
     cursor: pointer;
 }
</style>