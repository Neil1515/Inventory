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
$query = "SELECT br.id, br.itemid, ib.itembrand, ib.subcategoryname, ib.serialno, ib.itemcondition 
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
<div class="ccs-main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="text-start"> 
                    <?php
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
                                ?> 
                    </i><?php echo $borrowerName; ?></h3>
                    <div class="text-end">
                        <a href="ccsstaffReturnListofBorrowers.php" class="btn btn-danger me-2">Back</a>
                        <button href="#" type="button" class="btn btn-success clear-btn" id="returnSelectedItemsBtn" disabled onclick="returnSelectedItems()">Return Selected Items</button>

                    </div>
                </div>

                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Description</th>
                            <th scope="col">Serial number</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) { ?>
                            <tr> 
                                <?php
                                $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $item['subcategoryname'] . '.png';
                                if (file_exists($imagePath)) {
                                    echo "<td class='text-center'><img src='{$imagePath}' alt='Subcategory Image' width='50'></td>";
                                } else {
                                    echo "<td class='text-center'><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                                }
                                ?>
                                <td><?php echo $item['subcategoryname']; ?></td>
                                <td><?php echo $item['itembrand']; ?></td>
                                <td><?php echo $item['serialno']; ?></td>
                                <td><input type="checkbox" value="<?php echo $item['id']; ?>"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
<!-- Add this script after including jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Listen for changes in the checkboxes
        $('.table').on('change', 'input[type="checkbox"]', function () {
            // Check if any checkbox is checked
            if ($('input[type="checkbox"]:checked').length > 0) {
                // Enable the button if at least one checkbox is checked
                $('#returnSelectedItemsBtn').prop('disabled', false);
            } else {
                // Disable the button if no checkbox is checked
                $('#returnSelectedItemsBtn').prop('disabled', true);
            }
        });
    });

    function returnSelectedItems() {
    var selectedItems = [];
    $('input[type="checkbox"]:checked').each(function() {
        selectedItems.push($(this).val());
    });
    var borrowerId = "<?php echo $borrowerId; ?>";
    var url = 'ccsstaffReturnSelectedItems.php?borrower_id=' + borrowerId + '&selected_itemsid=' + selectedItems.join(',');
    window.location.href = url;
}



</script>
