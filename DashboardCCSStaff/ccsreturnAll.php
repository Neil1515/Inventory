<!-- ccsreturnAll.php -->
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
$query = "SELECT br.id, br.itemid, ib.itembrand, ib.subcategoryname, ib.serialno, ib.itemcondition 
          FROM tblborrowingreports br 
          INNER JOIN tblitembrand ib ON br.itemid = ib.id 
          WHERE br.borrowerid = ? AND (br.itemreqstatus = 'Approved' OR br.itemreqstatus = 'Request return')";
$stmt = mysqli_prepare($con, $query);
$borrowerId = $_GET['borrower_id'];

// Initialize count for damaged items
$damagedItemCount = 0;

// Initialize count for lost items
$lostItemCount = 0;

// Output the container and search input
echo '<div class="ccs-main-container">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-md-9">'; // Left column for items
echo '<div class="d-flex justify-content-between align-items-center mb-1">';
echo '<h3 class="text-start"> <i class="fas fa-user me-2"></i>' . $borrowerName . '</h3>';
echo '<div class="text-end">';
echo '</div>';
echo '</div>';
// Create a div to display the error message
echo '<form id="returnForm" method="post" action="ccssreturnsubmit_return.php" onsubmit="submitForm(); return false;">'; 
echo '<div id="errorMessage" class="alert alert-danger" style="display: none;">Proof of damage item is required.</div>';
echo '<div class="row row-cols-1 row-cols-md-3 g-1">';

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $index = 0; // Initialize index for unique identifiers
            while ($row = mysqli_fetch_assoc($result)) {
                $index++; // Increment index for each item

                // Fetch subcategory information for the current item
                $sqlSubcategory = "SELECT subcategoryname FROM `tblitembrand` WHERE id = ?";
                $stmtSubcategory = mysqli_prepare($con, $sqlSubcategory);

                if ($stmtSubcategory) {
                    mysqli_stmt_bind_param($stmtSubcategory, "i", $row['itemid']);
                    mysqli_stmt_execute($stmtSubcategory);
                    $resultSubcategory = mysqli_stmt_get_result($stmtSubcategory);

                    if ($resultSubcategory) {
                        // Fetch subcategory details
                        $rowSubcategory = mysqli_fetch_assoc($resultSubcategory);

                        // Construct the image path based on subcategory information
                        $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $rowSubcategory['subcategoryname'] . '.png';
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
                ?>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $row['subcategoryname']; ?>
                                <!-- Icon for damaged item (initially hidden) -->
                                <i class="fas fa-exclamation-circle text-danger" id="damageIcon<?php echo $index; ?>" data-bs-toggle="tooltip" data-bs-placement="top" style="display: none;" title="Item is damaged"></i>
                                <!-- Icon for lost item (initially hidden) -->
                                <i class="fas fa-times-circle text-danger" id="lostIcon<?php echo $index; ?>" data-bs-toggle="tooltip" data-bs-placement="top" style="display: none;" title="Item is lost"></i>
                            </h5>
                            <div class="text-center">
                                <img src="<?php echo $imagePath; ?>" alt="Image" width="100" height="100">
                            </div>
                            <h7 class="card-text"><?php echo $row['itembrand']; ?><br></h7>
                            <h7 class="card-text">Serial No: <?php echo $row['serialno']; ?><br></h7>
                            <h7 class="card-text">Previous Condition: <?php echo $row['itemcondition']; ?><br></h7>
            
                            <!-- Dropdown for item issues return item condition-->
                            <h7 class="text-muted">Current Condition<br></h7>
                            <select class="form-select form-select-sm mt-2" aria-label="Item Issue" name="returnItemCondition[]" id="itemIssue<?php echo $index; ?>" onchange="toggleDamageIcon(<?php echo $index; ?>)">
                                <option value="No Issue" <?php if ($row['itemcondition'] === "No Issue") echo "selected"; ?>>No Issue</option>
                                <option value="Damage" <?php if ($row['itemcondition'] === "Damage") echo "selected"; ?>>Damage</option>
                                <option value="Lost" <?php if ($row['itemcondition'] === "Lost") echo "selected"; ?>>Lost</option>
                            </select>
                            <!-- Upload input for proof of damage (initially hidden) -->
                            <div id="proofOfDamage<?php echo $index; ?>" style="display: none;">
                                <label for="damageProof<?php echo $index; ?>" class="form-label mt-3">Upload Proof of item Damage<span class="text-danger">*</span></label>
                                <input type="file" class="form-control mt-2" id="damageProof<?php echo $index; ?>" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            // No items found with the specified borrower ID and status
            echo '<p class="text-muted">No items borrowed by borrower ID: ' . $borrowerId . ' with status "Approved".</p>';
        }
    } else {
        // Error executing the statement
        echo '<p class="text-danger">Error executing statement: ' . mysqli_error($con) . '</p>';
    }

    mysqli_stmt_close($stmt);
} else {
    // Statement preparation failed
    echo '<p class="text-danger">Statement preparation failed: ' . mysqli_error($con) . '</p>';
}
// Close the items row
echo '</div>'; // Close the items row

echo '</div>'; // Close the left column

// Close the right column
// Right column for return details
echo '<div class="col-md-3">';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<h3 class="card-title mb-3">Process of Return</h3>';
// Add your return details form or input fields here
//echo '<form method="post" action="ccssreturnsubmit_return.php">'; 
//echo '<form method="post" action="ccssreturnsubmit_return.php">'; 
echo '<div class="mb-1">';
echo '<label class="form-label">Received By:</label>';
echo '<input type="text" class="form-control" value="' . $staffName . '" readonly>';
echo '</div>';
echo '<div class="mb-3">';
echo '<label class="form-label">Date:</label>';
echo '<input type="text" class="form-control" value="' . date("Y-m-d") . '" readonly>'; // Display current date
echo '</div>';
echo '<div class="mb-1">';
echo '<label class="form-label">Time:</label>';
echo '<input type="text" class="form-control" id="currentTime" readonly>'; // Display current time
echo '</div>';

echo '<div class="mb-3">';
echo '<label for="returnRemarks" class="form-label">Return Remarks<span class="text-danger">*</span></label>';
echo '<textarea class="form-control" id="returnRemarks" name="returnRemarks" rows="5" required></textarea>'; // Add name="returnRemarks"
echo '</div>';

echo '<div class="mb-2">';
echo '<label>No. Damage items: <span id="damagedItemCount">' . $damagedItemCount . '</span></label>';
echo '</div>';
echo '<div class="mb-2">';
echo '<label>No. Lost items: <span id="lostItemCount">' . $lostItemCount . '</span></label>';
echo '</div>';

echo '<input type="hidden" name="borrowerId" value="' . $borrowerId . '">'; // Add hidden input for borrower ID
echo '<input type="hidden" name="approvereturnbyId" value="' . $approvereturnbyId . '">'; // Add hidden input for approvereturnbyId
echo '<div class="text-end">';
echo '<a href="ccsstaffReturnListofBorrowers.php"  class="btn btn-danger me-2">Back</a>';
echo '<button type="submit" class="btn btn-primary">Submit</button>';
echo '</div>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
?>
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
<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
// Function to toggle damage icon and update item counts and return item condition
function toggleDamageIcon(index) {
    var itemIssue = document.getElementById("itemIssue" + index);
    var damageIcon = document.getElementById("damageIcon" + index);
    var lostIcon = document.getElementById("lostIcon" + index);
    var proofOfDamage = document.getElementById("proofOfDamage" + index);
    var returnItemCondition = document.getElementsByName("returnItemCondition[]")[index - 1]; // Get the corresponding return item condition element

    if (itemIssue.value === "Damage") {
        damageIcon.style.display = "inline";
        lostIcon.style.display = "none";
        proofOfDamage.style.display = "block";
        returnItemCondition.value = "Damage"; // Update return item condition value
    } else if (itemIssue.value === "Lost") {
        damageIcon.style.display = "none";
        lostIcon.style.display = "inline";
        proofOfDamage.style.display = "none";
        returnItemCondition.value = "Lost"; // Update return item condition value
    } else {
        damageIcon.style.display = "none";
        lostIcon.style.display = "none";
        proofOfDamage.style.display = "none";
        returnItemCondition.value = "No Issue"; // Update return item condition value
    }

    updateItemCount(); // Update item counts
}




    // Function to update the item counts based on dropdown selection
    function updateItemCount() {
        var damagedItemCount = 0;
        var lostItemCount = 0;

        for (var index = 1; index <= <?php echo $index; ?>; index++) {
            var itemIssue = document.getElementById("itemIssue" + index);

            if (itemIssue.value === "Damage") {
                damagedItemCount++;
            } else if (itemIssue.value === "Lost") {
                lostItemCount++;
            }
        }

        // Update the counts displayed
        document.getElementById("damagedItemCount").innerText = damagedItemCount;
        document.getElementById("lostItemCount").innerText = lostItemCount;
    }

    // Function to update the current time
    function updateCurrentTime() {
        var currentTimeElement = document.getElementById('currentTime');
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        var meridiem = (hours < 12) ? 'AM' : 'PM';
        hours = (hours % 12) || 12;
        hours = (hours < 10 ? '0' : '') + hours;
        minutes = (minutes < 10 ? '0' : '') + minutes;
        seconds = (seconds < 10 ? '0' : '') + seconds;

        currentTimeElement.value = hours + ':' + minutes + ':' + seconds + ' ' + meridiem;
    }

    // Call the updateCurrentTime function initially to set the current time
    updateCurrentTime();

    // Update the current time every second
    setInterval(updateCurrentTime, 1000);

    // Function to validate the form before submission
    function validateForm() {
    var itemIssues = document.querySelectorAll("[id^='itemIssue']");
    var isValid = true;

    // Check each item
    itemIssues.forEach(function(itemIssue, index) {
        var proofOfDamage = document.getElementById("damageProof" + (index + 1)); // Get the file input associated with the current item

        // If the item issue is "Damage" and no proof of damage is provided, mark the form as invalid
        if (itemIssue.value === "Damage" && (!proofOfDamage || !proofOfDamage.files || proofOfDamage.files.length === 0)) {
            isValid = false;
            // Display a message to the user indicating that proof of damage is required
            console.error("Proof of damage is required for item " + (index + 1));
        }
    });

    return isValid;
    }

    function submitForm() {
        if (validateForm()) {
            // If the form is valid, submit the form
            document.querySelector("form").submit();
        } else {
            // If the form is not valid, prevent submission and display an error message
            console.error("Form submission aborted due to validation errors.");
            // Show the error message
            document.getElementById('errorMessage').style.display = 'block';
            // Scroll to the top of the page to make the error message visible
            window.scrollTo(0, 0);
        }
    }
   // Your JavaScript code here
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
});
        
</script>
