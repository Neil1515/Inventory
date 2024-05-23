<!-- deanProfile.php -->
<?php
session_start();

// Assuming you have a valid database connection here
$servername = 'localhost';
$db_id = 'root';
$db_password = '';
$db_name = 'maininventorydb';

// Attempt to connect to the database
$con = mysqli_connect($servername, $db_id, $db_password, $db_name);

// Check for connection errors
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Retrieve user ID from the URL parameter
$deanId = $_SESSION['dean_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveChangesBtn'])) {
    // Validate and sanitize input
    $currentPassword = mysqli_real_escape_string($con, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
    $confirmNewPassword = mysqli_real_escape_string($con, $_POST['confirmNewPassword']);

    // Fetch the current password from the database
    $query = "SELECT password FROM tblusers WHERE id = $deanId";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPasswordFromDB = $row['password'];

        // Verify the current password
        if ($currentPassword === $currentPasswordFromDB) {
            // Check if the new password and confirm new password match
            if ($newPassword === $confirmNewPassword) {
                // Update the password in the database (without hashing)
                $updateQuery = "UPDATE tblusers SET password = '$newPassword' WHERE id = $deanId";
                $updateResult = mysqli_query($con, $updateQuery);

                if ($updateResult) {
                    // Password updated successfully
                    $msg_success = "Password updated successfully.";
                    header("Location: deanProfile.php?msg_success=" . urlencode($msg_success));
                    exit();
                } else {
                    $msg_fail = "Failed to update password. Please try again.";
                    header("Location: deanProfile.php?msg_fail=" . urlencode($msg_fail));
                    exit();
                }
            } else {
                $msg_fail = "New password and confirm new password do not match.";
                header("Location: deanProfile.php?msg_fail=" . urlencode($msg_fail));
                exit();
            }
        } else {
            $msg_fail = "Current password is incorrect.";
            header("Location: deanProfile.php?msg_fail=" . urlencode($msg_fail));
            exit();
        }
    } else {
        $msg_fail = "Failed to fetch user data. Please try again.";
        header("Location: deanProfile.php?msg_fail=" . urlencode($msg_fail));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="deanstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
            <?php include('deanheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->


            <!-- Main container on the right -->
            <div class="col-md-12">
                <?php
                if (isset($_GET["msg_success"])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_success"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                
                if (isset($_GET["msg_fail"])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_fail"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if (isset($_GET["msg"])) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo $_GET["msg"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                ?>
<!-- Modal HTML Structure -->
<div class="modal fade" id="changepassModal" tabindex="-1" aria-labelledby="changepassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changepassModalLabel">Change Password</h5>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Enter Current Password<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="currentPassword" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Enter New Password<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="newPassword" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Enter Confirm New Password<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="confirmNewPassword" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="saveChangesBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal HTML Structure -->
<div class="modal fade" id="changeimageModal" tabindex="-1" aria-labelledby="changeimageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeimageModalLabel">Change Password</h5>
                </div>
                <form method="post" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="saveChangesBtn">Update Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
               <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">User Profile</h5>
                            </div>
                            <div class="card-body">
                            <?php 
                            // Fetch user information based on the provided user ID
                            $query = "SELECT * FROM tblusers WHERE id = $deanId";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                // Check if any rows are returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Fetch the row
                                    $row = mysqli_fetch_assoc($result);
                                } else {
                                    // Output a message if no rows are returned
                                    echo "No user information found for ID: $deanId";
                                }
                                mysqli_free_result($result); // Free the result set
                            } else {
                                // Handle query execution failure
                                echo 'Query execution failed: ' . mysqli_error($con);
                            }

                            if (!empty($row)) : ?>
                                <div class="row">
                            <!-- Main container on the left -->
                            <div class="col-md-12">
                            <div class="row">
                                    <!-- Main container on the right -->
                                    <div class="col-md-12 text-center">
                                        <div class="mb-1">
                                            <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture" width='150'>
                                        </div>
                                    </div>
                                    <!-- Main container on the left -->
                                    <div class="col-md-4 align-items-center d-flex">
                                        <div class="mb-1">
                                            <!-- <a  class="btn btn-danger mb-1">Change Image</a>-->
                                            <a  href="deanDashboardPage.php" class="btn btn-danger mb-1">Back</a>
                                            <a class="btn btn-success" onclick="editPass('<?php echo $row['id']; ?>')">Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">First Name:</label>
                                    <p class="form-control"><?php echo $row['fname']; ?></p>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Last Name:</label>
                                    <p class="form-control"><?php echo $row['lname']; ?></p>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="mb-1">
                                    <label class="form-label">Email:</label>
                                    <p class="form-control"><?php echo $row['email']; ?></p>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">User Type:</label>
                                    <p class="form-control"><?php echo $row['usertype']; ?></p>
                                </div>
                                </div>
                                </div>
                            </div>

                            <?php else : ?>
                                <p>No user information found.</p>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editPass() {
    // Populate the modal with the subcategory ID and name
    $('#changepassModal').modal('show');
}
function editImage() {
    // Populate the modal with the subcategory ID and name
    $('#changepassModal').modal('show');
}
</script>
</body>
</html>
