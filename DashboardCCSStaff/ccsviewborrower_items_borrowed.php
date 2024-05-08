<!-- ccsviewborrower_items_borrowed.php -->
<?php
// Include necessary files
include('ccsfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user information based on the logged-in user ID
$staffId = $_SESSION['staff_id'];

$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $staffId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
            $staffName = $row['fname'] . ' ' . $row['lname']; // Concatenate first name and last name
            $approvereturnbyId = $row['id']; // staff id
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

// Retrieve the borrower ID from the URL parameter
if (!isset($_GET['borrower_id'])) {
    // Handle the case when borrower ID is not provided
    echo "Borrower ID not provided.";
    exit();
}

// Retrieve the borrower's name from the tblusers table based on the borrower ID
$query = "SELECT CONCAT(fname, ' ', lname) AS borrower_name FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
$borrowerId = $_GET['borrower_id'];

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $borrowerName = $row['borrower_name'];
        } else {
            $borrowerName = "Unknown Borrower";
        }
    } else {
        $borrowerName = "Unknown Borrower";
    }
    mysqli_stmt_close($stmt);
} else {
    $borrowerName = "Unknown Borrower";
}

// Fetch items borrowed by the borrower where itemreqstatus is 'Approved'
$query = "SELECT br.id, br.itemid, br.itemreqstatus, ib.itembrand, ib.subcategoryname, ib.serialno, ib.itemcondition 
          FROM tblborrowingreports br 
          INNER JOIN tblitembrand ib ON br.itemid = ib.id 
          WHERE br.borrowerid = ? AND (br.itemreqstatus = 'Approved' OR br.itemreqstatus = 'Request return')";
$stmt = mysqli_prepare($con, $query);
$borrowerId = $_GET['borrower_id'];

// Initialize an empty array to store items
$items = array();

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through the fetched items and store them in the $items array
            while ($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
        }
    } else {
        // Handle the case when statement execution fails
        echo "Failed to execute the statement: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    // Handle the case when statement preparation fails
    echo "Failed to prepare the statement: " . mysqli_error($con);
}

?>
<!-- Load jQuery in the head section -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

<div class="ccs-main-container">
    <!-- Your PHP code for fetching borrower information and items -->

    <!-- Borrower Details Section -->
    <div class="container">
        <!-- Borrower header with profile image -->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="text-start">
                        <?php
                        // Reusable function to render profile image
                        function renderProfileImage($borrowerId)
                        {
                            $profileImagePath = "/inventory/images/imageofusers/" . $borrowerId . ".png";
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                                echo '<img src="' . $profileImagePath . '?' . time() . '" width="50">';
                            } else {
                                echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" width="50">';
                            }
                        }

                        // Render profile image for borrower
                        renderProfileImage($borrowerId);
                        ?>
                        <a href="ccstaffBorrowerProfile.php?borrower_id=<?php echo $borrowerId ?>" style='text-decoration: none;'><?php echo $borrowerName; ?></a>
                    </h3>
                    <div class="text-end">
                    <a href="javascript:history.back()" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Back</a>
                        <button type="button" class="btn btn-success clear-btn" id="returnSelectedItemsBtn"  onclick="returnSelectedItems()">Return Selected Items</button>
                    </div>
                </div>

                <!-- Table displaying borrower's items -->
                <?php if (!empty($items)) { ?>
                    <table class="table">
                        <!-- Table header -->
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Serial number</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody>
                            <?php foreach ($items as $item) { ?>
                                <tr class="align-middle">
                                    <!-- Render item details -->
                                    <td class='text-center '>
                                        <?php
                                        $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $item['subcategoryname'] . '.png';
                                        if (file_exists($imagePath)) {
                                            echo "<img src='{$imagePath}' alt='Subcategory Image' width='50'>";
                                        } else {
                                            echo "<img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $item['subcategoryname']; ?></td>
                                    <td><?php echo $item['itembrand']; ?></td>
                                    <td><span class="text-danger"><?php echo $item['serialno']; ?></span></td>
                                    <td><?php echo $item['itemreqstatus'] === 'Approved' ? '---' : $item['itemreqstatus']; ?></td>
                                    <!-- Automatically check the checkbox if itemreqstatus is 'Request Return' -->
                                    <td><input type="checkbox" value="<?php echo $item['itemid']; ?>" <?php echo $item['itemreqstatus'] === 'Request Return' ? 'checked' : ''; ?>></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                <?php } else { ?>
                    <p class="text-center mt-2">No borrowed items found for <?php echo $borrowerName; ?></p>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<!-- Modal for Note -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel">Note</h5>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            </div>
            <div class="modal-body">
                <!-- Image -->
                <div class="text-center mb-3">
                    <img src="\Inventory\images\serialcheckpoint.png" class="img-fluid border border-danger" alt="Return of Damaged Goods" style="border-radius: 5px;">
                </div>
                <!-- Checkbox for agreement -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreementCheckbox">
                    <label class="form-check-label" for="agreementCheckbox">
                        I agree to the terms and conditions
                    </label>
                </div>
                <!-- Note -->
                <p class="text-danger">Please ensure that the serial number of the returned items match the original items.</p>
            </div>
            <div class="modal-footer">
                <!-- Disabled Confirm button initially -->
                <button type="button" class="btn btn-success" id="confirmButton" data-bs-dismiss="modal" disabled>Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript code for modal interaction -->
<script>
    $(document).ready(function () {
    // Show the modal when the page loads
    $('#noteModal').modal('show');

    // Select the checkbox and Confirm button
    var agreementCheckbox = document.getElementById('agreementCheckbox');
    var confirmButton = document.getElementById('confirmButton');

    // Add event listener to the checkbox
    agreementCheckbox.addEventListener('change', function () {
        // Enable Confirm button if checkbox is checked, otherwise disable it
        confirmButton.disabled = !this.checked;
    });

    // Check if there are items with status 'Request Return'
    var itemsWithRequestReturn = $('.table input[type="checkbox"][value!="on"][checked]').length;

    // Disable the button if no items have status 'Request Return'
    if (itemsWithRequestReturn === 0) {
        $('#returnSelectedItemsBtn').prop('disabled', true);
    }

    // Listen for changes in the checkboxes
    $('.table').on('change', 'input[type="checkbox"]', function () {
        // Check if any checkbox is checked
        if ($('.table input[type="checkbox"]:checked').length > 0) {
            // Enable the button if at least one checkbox is checked
            $('#returnSelectedItemsBtn').prop('disabled', false);
        } else {
            // Disable the button if no checkbox is checked
            $('#returnSelectedItemsBtn').prop('disabled', true);
        }
    });
});

   // Function to handle returning selected items
function returnSelectedItems() {
    var selectedItems = [];
    $('input[type="checkbox"]:checked').each(function () {
        var itemId = $(this).val();
        // Check if the value is not equal to "on" (or any other invalid value)
        if (itemId !== "on") {
            selectedItems.push(itemId);
        }
    });
    var borrowerId = "<?php echo $borrowerId; ?>";
    var url = 'ccsstaffReturnSelectedItems.php?borrower_id=' + borrowerId + '&selected_itemsid=' + selectedItems.join(',');
    window.location.href = url;
}

</script>
