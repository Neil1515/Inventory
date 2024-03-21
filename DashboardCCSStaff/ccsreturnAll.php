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
$query = "SELECT br.id, br.itemid, ib.itembrand, ib.subcategoryname, ib.serialno 
          FROM tblborrowingreports br 
          INNER JOIN tblitembrand ib ON br.itemid = ib.id 
          WHERE br.borrowerid = ? AND br.itemreqstatus = 'Approved'";
$stmt = mysqli_prepare($con, $query);
$borrowerId = $_GET['borrower_id'];

// Initialize count for damaged items
$damagedItemCount = 0;

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
echo '<div class="row row-cols-1 row-cols-md-3 g-1">';

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $index = 0; // Initialize index for unique identifiers
            while ($row = mysqli_fetch_assoc($result)) {
                $index++; // Increment index for each item
                ?>
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $row['subcategoryname']; ?>
                                <!-- Icon for damaged item (initially hidden) -->
                                <i class="fas fa-exclamation-circle text-danger" id="damageIcon<?php echo $index; ?>" data-bs-toggle="tooltip" data-bs-placement="top" style="display: none;" title="Item is damaged"></i>
                            </h5>
                            <p class="card-text"><?php echo $row['itembrand']; ?></p>
                            <p class="card-text">Serial No: <?php echo $row['serialno']; ?></p>
                            <!-- Dropdown for item issues -->
                            <select class="form-select form-select-sm mt-2" aria-label="Item Issue" id="itemIssue<?php echo $index; ?>" onchange="toggleDamageIcon(<?php echo $index; ?>)">
                                <option value="No Issue">No Issue</option>
                                <option value="Damage">Damage</option> <!-- Change this option value -->
                            </select>
                            <!-- Upload input for proof of damage (initially hidden) -->
                            <div id="proofOfDamage<?php echo $index; ?>" style="display: none;">
                                <label for="damageProof<?php echo $index; ?>" class="form-label mt-3">Upload Proof of item Defective<span class="text-danger">*</span></label>
                                <input type="file" class="form-control mt-2" id="damageProof<?php echo $index; ?>" accept="image/*" required>
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

echo '</div>'; // Close the items row

echo '</div>'; // Close the left column

// Close the right column
// Right column for return details
echo '<div class="col-md-3">';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<h3 class="card-title mb-3">Return Details</h3>';
// Add your return details form or input fields here
echo '<form method="post" action="ccssreturnsubmit_return.php">'; // Change the action to your submission endpoint
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
echo '<div class="mb-1">';
echo '<label class="form-label">Number of damaged items:</label>';
echo '<input type="text" class="form-control" id="damagedItemCount" name="damagedItemCount" value="' . $damagedItemCount . '" readonly>'; // Add name="damagedItemCount"
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
<script>
    var damagedItemCount = <?php echo $damagedItemCount; ?>; // Initialize damaged item count

    function toggleDamageIcon(index) {
        var itemIssue = document.getElementById("itemIssue" + index);
        var damageIcon = document.getElementById("damageIcon" + index);
        var proofOfDamage = document.getElementById("proofOfDamage" + index);

        if (itemIssue.value === "Damage") {
            damageIcon.style.display = "inline"; // Show the icon if "Damage" is selected
            proofOfDamage.style.display = "block"; // Show the upload input for proof of damage
            damagedItemCount++; // Increment damaged item count
        } else {
            damageIcon.style.display = "none"; // Hide the icon otherwise
            proofOfDamage.style.display = "none"; // Hide the upload input
            if (damagedItemCount > 0) {
                damagedItemCount--; // Decrement damaged item count (if it's greater than 0)
            }
        }
        // Update the count displayed in the input field
        document.getElementById("damagedItemCount").value = damagedItemCount;
    }

    // Function to update the current time
    function updateCurrentTime() {
        var currentTimeElement = document.getElementById('currentTime');
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Determine if it's AM or PM
        var meridiem = (hours < 12) ? 'AM' : 'PM';

        // Convert 24-hour format to 12-hour format
        hours = (hours % 12) || 12;

        // Add leading zeros to single-digit hours, minutes, and seconds
        hours = (hours < 10 ? '0' : '') + hours;
        minutes = (minutes < 10 ? '0' : '') + minutes;
        seconds = (seconds < 10 ? '0' : '') + seconds;

        // Set the value of the input field to the current time
        currentTimeElement.value = hours + ':' + minutes + ':' + seconds + ' ' + meridiem;
    }

    // Call the updateCurrentTime function initially to set the current time
    updateCurrentTime();

    // Update the current time every second
    setInterval(updateCurrentTime, 1000);
</script>
