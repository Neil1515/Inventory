<!-- bwerconfirmreserverequest.php -->
<?php
include "bwerfunctions.php";

$borrowerId = $_SESSION['borrower_id'];
// Fetch user data from tblusers based on staffId
$sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
$stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

if ($stmtSelectUser) {
    mysqli_stmt_bind_param($stmtSelectUser, "i", $borrowerId);
    mysqli_stmt_execute($stmtSelectUser);
    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $borrowername = $rowUser['fname'] . ' ' . $rowUser['lname'];
    } else {
        // Log the error instead of displaying to users
        error_log("Failed to fetch user data: " . mysqli_error($con));
    }

    mysqli_stmt_close($stmtSelectUser);
} else {
    // Log the error instead of displaying to users
    error_log("Statement preparation failed for user data: " . mysqli_error($con));
}

// Initialize $itemsArray
$itemsArray = array();

// Check if items are passed via URL parameters
if(isset($_GET['items'])) {
    // Decode the JSON data
    $itemsJSON = urldecode($_GET['items']);
    $itemsArray = json_decode($itemsJSON, true); // Convert JSON string to associative array
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestReserve'])) {
    // Initialize variables
    $itemreqstatus = "Pending Reserve";
    // Set the timezone to Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // Get the current date and time in the Philippines timezone
    $datetimereqreservation = date("Y-m-d H:i:s");

    // Concatenate dateOfUse and timeOfUse to form datetimereserve
    $dateOfUse = $_POST['dateOfUse'];
    $timeOfUse = $_POST['timeOfUse'];
    $datetimereserve = date("Y-m-d H:i:s", strtotime("$dateOfUse $timeOfUse"));
    
    // Iterate over the items in the $itemsArray
    foreach ($itemsArray as $item) {
        // Check if the item exists in tblitembrand and is available for borrowing
        $query = "SELECT id FROM tblitembrand WHERE subcategoryname = ? AND itembrand = ? AND borrowable = 'Yes' AND status = 'Available'";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ss", $item['subcategoryname'], $item['itembrand']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // If matching items are found
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $itemId);

            // Determine the quantity to reserve
            $quantityToReserve = $item['count'];

            // Loop through the results and reserve the specified quantity
            while (mysqli_stmt_fetch($stmt) && $quantityToReserve > 0) {
                // Insert a new record into tblborrowingreports
                $query_insert = "INSERT INTO tblborrowingreports (itemid, borrowerid, itemreqstatus, datetimereqreservation, reservelocation, reservepurpose, datetimereserve) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($con, $query_insert);
                mysqli_stmt_bind_param($stmt_insert, "sssssss", $itemId, $_SESSION['borrower_id'], $itemreqstatus, $datetimereqreservation, $_POST['location'], $_POST['purpose'], $datetimereserve);
                mysqli_stmt_execute($stmt_insert);

                // Update the status of the item to "Pending Reserve" in tblitembrand
                $query_update = "UPDATE tblitembrand SET status = ? WHERE id = ?";
                $stmt_update = mysqli_prepare($con, $query_update);
                mysqli_stmt_bind_param($stmt_update, "ss", $itemreqstatus, $itemId);
                mysqli_stmt_execute($stmt_update);

                // Decrease the quantity to reserve
                $quantityToReserve--;
            }
        } else {
            // Log an error or handle the case where the item is not available for reserve
            error_log("Item not available for reserve: " . $item['subcategoryname'] . " - " . $item['itembrand']);
        }
    }
    // Optionally, you can redirect the user to a confirmation page
    echo "<script>window.location.href='borrowerDashboardPage.php?msg_success=Successfully Requesting Reservation, Please await for CCS Staff for approval';</script>";
    exit();
} else {
    error_log("Invalid form submission for reserving items.");
}
?>

<main class="ccs-main-container">
    <form action="" method="post" enctype="multipart/form-data" name="requestBorrowForm">
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-9"> <!-- Left side -->
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <h3 class="text-start"><i class="fas fa-tachometer-alt me-2"></i>Confirmation of Reservation Request</h3>
                            <div class="text-end">
                                <!--<input type="text" class="form-control search-input mb-1" placeholder="Search" name="search" id="searchInput">-->
                                <!--<a href="borrowerDashboardPage.php" class="btn btn-danger">Cancel</a>-->
                            </div>
                        </div>
                    </div>
                    <h6 class="text-danger">Note: Any deformation or lost/damage of items borrowed are subject to replacement on your account.</h6>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-2">
                        <?php
                        // Display each item in the same format as cards
                        foreach($itemsArray as $item) {
                            // Check if an image exists
                            $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $item['subcategoryname'] . '.png';
                            if (!file_exists($imagePath)) {
                                // Use a default image if no image is uploaded
                                $imagePath = '/inventory/SubcategoryItemsimages/defaultimageitem.png';
                            }
                            // Output the item details in the card format
                            echo '
                            <div class="col mb-4">
                                <div class="card h-100">
                                    <div class="text-center"> <!-- Center the image -->
                                        <img src="' . $imagePath . '" class="card-img-top" alt="Item Image" style="max-width: 80px; max-height: 80px;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">' . $item['subcategoryname'] . '</h5>';
                            // Check if item brand exists and is not empty before displaying
                            if(isset($item['itembrand']) && !empty($item['itembrand'])) {
                                echo '<p class="card-text">Item Description <br>' . $item['itembrand'] . '</p>';
                            }

                            echo '<p class="card-text">Quantity: ' . $item['count'] . '</p>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-3"> <!-- Right side -->
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Reserve Form</h3>
                            <div class="mb-3">
                                <label for="dateOfUse" class="form-label">Date of Use<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dateOfUse" name="dateOfUse" required>
                            </div>
                            <div class="mb-3">
                                <label for="timeOfUse" class="form-label">Time of Use<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="timeOfUse" name="timeOfUse" required>
                            </div>
                            <div class="mb-3">
                                <label for="purpose" class="form-label">Purpose<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                                <textarea class="form-control" id="location" name="location" rows="3" required></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="borrowerDashboardPage.php" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success" name="requestReserve">Confirm Request</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
         $(document).ready(function() {
        // Set the minimum date for the "Date of Use" input to today
        var today = new Date().toISOString().split('T')[0];
        document.getElementById("dateOfUse").min = today;
        
        // Function to set the minimum time for the "Time of Use" input
        function setMinTime() {
            var selectedDate = document.getElementById("dateOfUse").value;
            var currentDate = new Date().toISOString().split('T')[0];

            if (selectedDate === currentDate) {
                // If the selected date is the current date, set the minimum time to the current time
                var currentTime = new Date();
                var currentHour = currentTime.getHours();
                var currentMinute = currentTime.getMinutes();
                var formattedCurrentTime = (currentHour < 10 ? '0' : '') + currentHour + ':' + (currentMinute < 10 ? '0' : '') + currentMinute;
                document.getElementById("timeOfUse").min = formattedCurrentTime;
            } else {
                // If the selected date is not the current date, there is no minimum time restriction
                document.getElementById("timeOfUse").removeAttribute("min");
            }
        }

        // Call setMinTime function when the "Date of Use" input changes
        $("#dateOfUse").change(setMinTime);

        // Call setMinTime function initially to set the minimum time based on the initial value of the "Date of Use" input
        setMinTime();
        
        });
    </script>
</main>
