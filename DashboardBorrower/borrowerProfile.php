<!-- borrowerProfile.php -->
<?php
session_start();
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user ID from the session
$borrowerId = $_SESSION['borrower_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveChangesBtn'])) {
    // Validate and sanitize input
    $currentPassword = mysqli_real_escape_string($con, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);
    $confirmNewPassword = mysqli_real_escape_string($con, $_POST['confirmNewPassword']);

    // Fetch the current password from the database
    $query = "SELECT password FROM tblusers WHERE id = $borrowerId";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPasswordFromDB = $row['password'];

        // Verify the current password
        if ($currentPassword === $currentPasswordFromDB) {
            // Check if the new password and confirm new password match
            if ($newPassword === $confirmNewPassword) {
                // Update the password in the database (without hashing)
                $updateQuery = "UPDATE tblusers SET password = '$newPassword' WHERE id = $borrowerId";
                $updateResult = mysqli_query($con, $updateQuery);

                if ($updateResult) {
                    // Password updated successfully
                    $msg_success = "Password updated successfully.";
                    header("Location: borrowerProfile.php?msg_success=" . urlencode($msg_success));
                    exit();
                } else {
                    $msg_fail = "Failed to update password. Please try again.";
                    header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
                    exit();
                }
            } else {
                $msg_fail = "New password and confirm new password do not match.";
                header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
                exit();
            }
        } else {
            $msg_fail = "Current password is incorrect.";
            header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
            exit();
        }
    } else {
        $msg_fail = "Failed to fetch user data. Please try again.";
        header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
        exit();
    }
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateImageBtn'])) {
    // Handle file upload
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];

        // Check for upload errors
        if ($fileError === 0) {
            // Move the uploaded file to the desired directory with the desired name
            $uploadDir = '/Inventory/images/imageofusers/';
            $newFileName = $borrowerId . '.png'; // Name the file as borrower ID with .png extension
            $destination = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpName, $destination)) {
                // Image uploaded successfully
                $msg_success = "Image updated successfully.";
                header("Location: borrowerProfile.php?msg_success=" . urlencode($msg_success));
                exit();
            } else {
                $msg_fail = "Error occurred while uploading image.";
                header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
                exit();
            }
        } else {
            $msg_fail = "Error occurred while uploading image: " . $fileError;
            header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
            exit();
        }
    } else {
        $msg_fail = "No image uploaded.";
        header("Location: borrowerProfile.php?msg_fail=" . urlencode($msg_fail));
        exit();
    }
}
// Query to count total borrowed items where approvebyid is not null and the count is greater than 0
$queryBorrowedItems = "SELECT COUNT(*) AS total_borrowed FROM tblborrowingreports WHERE borrowerid = ? AND approvebyid IS NOT NULL AND approvebyid != ''";
$stmtBorrowedItems = mysqli_prepare($con, $queryBorrowedItems);

if ($stmtBorrowedItems) {
    mysqli_stmt_bind_param($stmtBorrowedItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtBorrowedItems)) {
        $resultBorrowedItems = mysqli_stmt_get_result($stmtBorrowedItems);
        $rowBorrowedItems = mysqli_fetch_assoc($resultBorrowedItems);
        $totalBorrowedItems = $rowBorrowedItems['total_borrowed'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtBorrowedItems));
    }

    mysqli_stmt_close($stmtBorrowedItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}
// Query to count total returned items
$queryReturnedItems = "SELECT COUNT(*) AS total_returned FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Returned'";
$stmtReturnedItems = mysqli_prepare($con, $queryReturnedItems);

if ($stmtReturnedItems) {
    mysqli_stmt_bind_param($stmtReturnedItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtReturnedItems)) {
        $resultReturnedItems = mysqli_stmt_get_result($stmtReturnedItems);
        $rowReturnedItems = mysqli_fetch_assoc($resultReturnedItems);
        $totalReturnedItems = $rowReturnedItems['total_returned'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtReturnedItems));
    }

    mysqli_stmt_close($stmtReturnedItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}
// Query to count total approved items and request returns for the borrower
$queryApprovedItems = "SELECT COUNT(*) AS total_approved FROM tblborrowingreports WHERE borrowerid = ? AND (itemreqstatus = 'Approved' OR itemreqstatus = 'Request Return')";
$stmtApprovedItems = mysqli_prepare($con, $queryApprovedItems);

if ($stmtApprovedItems) {
    mysqli_stmt_bind_param($stmtApprovedItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtApprovedItems)) {
        $resultApprovedItems = mysqli_stmt_get_result($stmtApprovedItems);
        $rowApprovedItems = mysqli_fetch_assoc($resultApprovedItems);
        $totalApprovedItems = $rowApprovedItems['total_approved'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtApprovedItems));
    }

    mysqli_stmt_close($stmtApprovedItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}

// Query to count total pending borrow items for the borrower
$queryPendingBorrowItems = "SELECT COUNT(*) AS total_pending_borrow FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Borrow'";
$stmtPendingBorrowItems = mysqli_prepare($con, $queryPendingBorrowItems);

if ($stmtPendingBorrowItems) {
    mysqli_stmt_bind_param($stmtPendingBorrowItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtPendingBorrowItems)) {
        $resultPendingBorrowItems = mysqli_stmt_get_result($stmtPendingBorrowItems);
        $rowPendingBorrowItems = mysqli_fetch_assoc($resultPendingBorrowItems);
        $totalPendingBorrowItems = $rowPendingBorrowItems['total_pending_borrow'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingBorrowItems));
    }

    mysqli_stmt_close($stmtPendingBorrowItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}

// Query to count total pending reserve items for the borrower
$queryPendingReserveItems = "SELECT COUNT(*) AS total_pending_reserve FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Pending Reserve'";
$stmtPendingReserveItems = mysqli_prepare($con, $queryPendingReserveItems);

if ($stmtPendingReserveItems) {
    mysqli_stmt_bind_param($stmtPendingReserveItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtPendingReserveItems)) {
        $resultPendingReserveItems = mysqli_stmt_get_result($stmtPendingReserveItems);
        $rowPendingReserveItems = mysqli_fetch_assoc($resultPendingReserveItems);
        $totalPendingReserveItems = $rowPendingReserveItems['total_pending_reserve'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtPendingReserveItems));
    }

    mysqli_stmt_close($stmtPendingReserveItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}

// Query to count total damage or lost items for the borrower
$queryDamageLostItems = "SELECT COUNT(*) AS total_damage_lost FROM tblborrowingreports WHERE borrowerid = ? AND returnitemcondition IN ('Damage', 'Lost')";
$stmtDamageLostItems = mysqli_prepare($con, $queryDamageLostItems);

if ($stmtDamageLostItems) {
    mysqli_stmt_bind_param($stmtDamageLostItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtDamageLostItems)) {
        $resultDamageLostItems = mysqli_stmt_get_result($stmtDamageLostItems);
        $rowDamageLostItems = mysqli_fetch_assoc($resultDamageLostItems);
        $totalDamageLostItems = $rowDamageLostItems['total_damage_lost'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtDamageLostItems));
    }

    mysqli_stmt_close($stmtDamageLostItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
}

// Query to count total approved reserve items for the borrower
$queryApprovedReserveItems = "SELECT COUNT(*) AS total_approved_reserve FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Approve Reserve'";
$stmtApprovedReserveItems = mysqli_prepare($con, $queryApprovedReserveItems);

if ($stmtApprovedReserveItems) {
    mysqli_stmt_bind_param($stmtApprovedReserveItems, "s", $borrowerId);

    if (mysqli_stmt_execute($stmtApprovedReserveItems)) {
        $resultApprovedReserveItems = mysqli_stmt_get_result($stmtApprovedReserveItems);
        $rowApprovedReserveItems = mysqli_fetch_assoc($resultApprovedReserveItems);
        $totalApprovedReserveItems = $rowApprovedReserveItems['total_approved_reserve'];
    } else {
        // Handle query execution failure
        die('Statement execution failed: ' . mysqli_stmt_error($stmtApprovedReserveItems));
    }

    mysqli_stmt_close($stmtApprovedReserveItems);
} else {
    // Handle statement preparation failure
    die('Statement preparation failed: ' . mysqli_error($con));
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
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        a {
            text-decoration: none;
        }
        .hoverable-card:hover .card {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
            <?php include('bwerheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('bwersidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
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
                <!--  Modal HTML Structure -->
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
                <!-- Change Image Modal -->
                <div class="modal fade" id="changeimageModal" tabindex="-1" aria-labelledby="changeimageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changeimageModalLabel">Update Image</h5>
                            </div>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <img src="" alt="Image" id="userImage" style="max-width: 150px;">
                                    </div>
                                    <div class="mb-2">
                                        <label for="image" class="form-label">Upload New Image<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="updateImageBtn">Update Image</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php 
                            // Fetch user information based on the provided user ID
                            $query = "SELECT * FROM tblusers WHERE id = $borrowerId";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                // Check if any rows are returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Fetch the row
                                    $row = mysqli_fetch_assoc($result);
                                } else {
                                    // Output a message if no rows are returned
                                    echo "No user information found for ID: $borrowerId";
                                }
                                mysqli_free_result($result); // Free the result set
                            } else {
                                // Handle query execution failure
                                echo 'Query execution failed: ' . mysqli_error($con);
                            }

                            if (!empty($row)) : ?>
               <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">User Profile</h5>
                                <div>
                                    <a href="javascript:history.back()" class="btn btn-danger mx-1"><i class="fas fa-arrow-left"></i> Back</a>
                                    <a class="btn btn-primary mx-1" onclick="editImage('<?php echo $row['id']; ?>')"><i class="fas fa-image"></i> Change Profile Picture</a>
                                    <a class="btn btn-success mx-1" onclick="editPass('<?php echo $row['id']; ?>')"><i class="fas fa-key"></i> Change Password</a>
                                </div>
                            </div>
                            <div class="card-body">
                            
                            <div class="row align-items-center">
                            <!-- Main container on the left -->
                            
                                    <!-- Main container on the right -->
                                    <div class="col-md-4 text-center">
                                    <div>
                                    <?php
                                    // Display profile picture
                                    if (!empty($borrowerId)) {
                                        $profileImagePath = "/inventory/images/imageofusers/{$borrowerId}.png";
                                        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profileImagePath)) {
                                            echo '<img src="' . $profileImagePath . '?' . time() . '" class="img-fluid rounded-circle " width="250" height="250">';
                                        } else {
                                            echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" class="img-fluid rounded-circle" width="150" height="150">';
                                        }
                                    } else {
                                        echo '<img src="/inventory/images/imageofusers/profile-user.png?' . time() . '" class="img-fluid rounded-circle" width="150" height="150">';
                                    }
                                    ?>
                                    </div>
                                    </div>
                                    
                            <!-- Main container on the right -->
                            <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><h6>Name: <?php echo $row['fname'] .' '. $row['lname']; ?></li></h6>
                                    <li class="list-group-item">Email: <?php echo $row['email']; ?></li>
                                    <li class="list-group-item">User Type: <?php echo $row['usertype']; ?></li>
                                    <li class="list-group-item">Department: <?php echo $row['department']; ?></li>
                                    <li class="list-group-item">Gender: <?php echo $row['gender']; ?></li>
                                    <li class="list-group-item">Total Item Borrowed: <?php echo $totalBorrowedItems ?></li>
                                    <li class="list-group-item">Total Item Returned: <?php echo $totalReturnedItems ?></li>
                                    <li class="list-group-item">Total Item (Damage/Lost): <?php echo $totalDamageLostItems ?></li>
                                </ul>
                            </div>
                             <!-- Circular cards -->
                            <div class="row mt-4">
                                <div class="col-md-3 mt-2">
                                    <a href="borrowerItemsBorrowed.php" class="hoverable-card">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">Borrowed Items</h5>
                                                <h3 class="card-text"><?php echo $totalApprovedItems ?></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <a href="borrowerPendingborrowItems.php" class="hoverable-card">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">Pending Borrow</h5>
                                                <h3 class="card-text"><?php echo $totalPendingBorrowItems ?></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <a href="borrowerAcceptedReserve.php" class="hoverable-card">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">Accepted Reserve</h5>
                                                <h3 class="card-text"><?php echo $totalApprovedReserveItems ?></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <a href="borrowerPendingReserve.php" class="hoverable-card">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">Pending Reserve</h5>
                                                <h3 class="card-text"><?php echo $totalPendingReserveItems  ?></h3>
                                            </div>
                                        </div>
                                    </a>
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
        $('#changeimageModal').modal('show');

        // Function to handle file input change
        $("#image").change(function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#userImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Get the URL of the current image
        var currentImageUrl = '<?php echo !empty($row['id']) ? "/inventory/images/imageofusers/" . $row['id'] . ".png" . "?" . time() : "/inventory/images/profile-user.png" . "?" . time(); ?>';

        // Set the src attribute of the userImage to the current image URL
        $('#userImage').attr('src', currentImageUrl);

    }
</script>
</body>
</html>
