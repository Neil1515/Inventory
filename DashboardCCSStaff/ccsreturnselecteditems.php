<!-- ccsreturnselecteditems.php -->

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
if (!isset($_GET['borrower_id']) || !isset($_GET['selected_itemsid'])) {
    // Handle the case when borrower ID or selected items ID is not provided
    echo "Borrower ID or Selected Items ID not provided.";
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

// Retrieve selected items
$selectedItemsIds = explode(",", $_GET['selected_itemsid']);
$selectedItems = array();

foreach ($selectedItemsIds as $itemId) {
    $query = "SELECT i.*, r.itemreqstatus ,  r.returnitemcondition 
              FROM tblitembrand AS i
              LEFT JOIN tblborrowingreports AS r ON i.id = r.itemid 
              WHERE i.id = ? AND (r.itemreqstatus = 'Approved' OR r.itemreqstatus = 'Request Return')";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $itemId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Fetch subcategory details
                $subcategoryQuery = "SELECT * FROM tblsubcategory WHERE subcategoryname = ?";
                $subcategoryStmt = mysqli_prepare($con, $subcategoryQuery);

                if ($subcategoryStmt) {
                    mysqli_stmt_bind_param($subcategoryStmt, "s", $row['subcategoryname']);
                    if (mysqli_stmt_execute($subcategoryStmt)) {
                        $subcategoryResult = mysqli_stmt_get_result($subcategoryStmt);
                        $subcategoryRow = mysqli_fetch_assoc($subcategoryResult);
                        $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $subcategoryRow['subcategoryname'] . '.png';
                    } else {
                        $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                    }
                    mysqli_stmt_close($subcategoryStmt);
                } else {
                    $imagePath = 'inventory/SubcategoryItemsimages/defaultimageitem.png';
                }

                $row['imagePath'] = $imagePath;
                $selectedItems[] = $row;
            }
        } else {
            echo "Failed to execute the statement: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the statement: " . mysqli_error($con);
    }
}
?>

<form id="returnselectedForm" method="post" action="ccssreturnsubmit_selectedreturn.php" onsubmit="submitForm(); return false;">
<!-- Output the container and selected items in card format -->
<div class="ccs-main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-9"> <!-- Left column for items -->
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="text-start"> <i class="fas fa-user me-2"></i><?php echo $borrowerName; ?></h3>
                    <div class="text-end"></div>
                </div>
                <div class="row">
                <?php foreach ($selectedItems as $index => $item) { ?>
                    <div class="col-md-4">
                        <div class="card mt-1">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['subcategoryname']; ?>                                <!-- Icons for damaged and lost items, initially hidden -->
                                <i class="fas fa-exclamation-circle text-danger damage-icon" style="display: none;" title="Item is damaged"></i>
                                <i class="fas fa-times-circle text-danger lost-icon" style="display: none;" title="Item is lost"></i></h5>
                                <div class="text-center">
                                    <img src="<?php echo $item['imagePath']; ?>" alt="Image" width="100" height="100">
                                </div>
                                <h7 class="card-text"><?php echo $item['itembrand']; ?><br></h7>
                                <h7 class="card-text">Serial No: <span class="text-danger"><?php echo $item['serialno']; ?><br></span></h7>
                                <h7 class="card-text">Previous Condition: <?php echo $item['itemcondition']; ?><br></h7>
                                <h7 class="text-muted">Current Condition<br></h7>
                                <!-- Select return condition dropdown -->
                                <select class="form-select form-select-sm mt-2 itemIssue" aria-label="Item Issue" name="returnItemCondition[<?php echo $index; ?>]" onchange="toggleDamageProof(<?php echo $index; ?>)">
                                    <option value="No Issue" <?php echo ($item['returnitemcondition'] === "No Issue" ? "selected" : ""); ?>>No Issue</option>
                                    <option value="Damage" <?php echo ($item['returnitemcondition'] === "Damage" ? "selected" : ""); ?>>Damage</option>
                                    <option value="Lost" <?php echo ($item['returnitemcondition'] === "Lost" ? "selected" : ""); ?>>Lost</option>
                                </select>
                                <!-- Upload input for proof of damage (initially hidden) -->
                                <div id="proofOfDamage<?php echo $index; ?>" style="display: none;">
                                    <label for="damageProof<?php echo $index; ?>" class="form-label mt-1">Upload Proof of item Damage<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control mt-1 damage-proof-file" id="damageProof<?php echo $index; ?>" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div> <!-- Close col-md-9 -->
            <div class="col-md-3"> <!-- Right column for return details -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Process of Return</h3>
                        <!-- Return details form -->
                            <div class="mb-1">
                                <label class="form-label">Received By:</label>
                                <input type="text" class="form-control" value="<?php echo $staffName; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date:</label>
                                <input type="text" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly> <!-- Display current date -->
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Time:</label>
                                <input type="text" class="form-control" id="currentTime" readonly> <!-- Display current time -->
                            </div>
                            <div class="mb-3">
                                <label for="returnRemarks" class="form-label">Return Remarks<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="returnRemarks" name="returnRemarks" rows="8" required></textarea> <!-- Add name="returnRemarks" -->
                            </div>
                            <!-- Hidden inputs for borrower ID and approvereturnbyId -->
                            <input type="hidden" name="borrowerId" value="<?php echo $borrowerId; ?>">
                            <input type="hidden" name="approvereturnbyId" value="<?php echo $approvereturnbyId; ?>">
                            <input type="hidden" name="returnItemCondition[]" value="No Issue" id="returnItemCondition<?php echo $index; ?>">

                            <!-- Hidden input for selected items ID -->
                            <input type="hidden" name="selectedItemsId" value="<?php echo implode(",", $selectedItemsIds); ?>">
                            <div class="text-end">
                                <a href="ccsstaffViewUnreturnItems.php?borrower_id=<?php echo $borrowerId; ?>" class="btn btn-danger me-2">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </div>
                </div>
            </div> <!-- Close col-md-3 -->
        </div> <!-- Close row -->
    </div> <!-- Close container -->
</div> <!-- Close ccs-main-container -->
</form>
<script>
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

// Get all dropdowns with the class "itemIssue"
var itemIssueDropdowns = document.querySelectorAll(".itemIssue");

// Loop through each dropdown
itemIssueDropdowns.forEach(function(dropdown, index) {
    // Add change event listener to each dropdown
    dropdown.addEventListener("change", function() {
        // Get the selected value
        var selectedValue = this.value;
        // Find the nearest card body
        var cardBody = this.closest(".card-body");
        // Find the icons for damaged and lost items within the card body
        var damageIcon = cardBody.querySelector(".damage-icon");
        var lostIcon = cardBody.querySelector(".lost-icon");
        // Show or hide the icons based on the selected value
        if (selectedValue === "Damage") {
            damageIcon.style.display = "inline-block";
            lostIcon.style.display = "none";
            // Call the toggleDamageProof function with the current index
            toggleDamageProof(index);
        } else if (selectedValue === "Lost") {
            damageIcon.style.display = "none";
            lostIcon.style.display = "inline-block";
        } else {
            damageIcon.style.display = "none";
            lostIcon.style.display = "none";
        }
    });
});

// Function to toggle the display of the proof of damage section
// Function to toggle the display of the proof of damage section and update the hidden input field value
function toggleDamageProof(index) {
    // Get the selected value of the dropdown
    var selectedItemCondition = document.querySelectorAll('.itemIssue')[index].value;
    // Get the "Upload Proof of item Damage" section for the corresponding item
    var damageProofSection = document.getElementById('proofOfDamage' + index);
    // Get the hidden input field for return item condition
    var returnItemConditionInput = document.getElementById('returnItemCondition' + index);
    // Toggle the display based on the selected value
    if (selectedItemCondition === 'Damage') {
        damageProofSection.style.display = 'block'; // Show the section
    } else {
        damageProofSection.style.display = 'none'; // Hide the section
    }
    // Update the hidden input field value
    returnItemConditionInput.value = selectedItemCondition;
}


// Get all file inputs for proof of damage
var damageProofFiles = document.querySelectorAll(".damage-proof-file");

// Loop through each file input
damageProofFiles.forEach(function(fileInput) {
    // Add change event listener to each file input
    fileInput.addEventListener("change", function() {
        // Your code to handle file upload goes here
    });
});

</script>
