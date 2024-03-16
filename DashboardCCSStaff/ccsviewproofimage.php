<!-- ccsviewproofimage.php -->
<?php
session_start();
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




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Proof Image</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="staffstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">
            <?php include('ccsheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('ccssidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-5">
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
                if (isset($_GET['userId'])) {
                    $userId = $_GET['userId'];
                
                    $query = "SELECT * FROM tblusers WHERE id = ?";
                    $stmt = mysqli_prepare($con, $query);
                
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "s", $userId);
                
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                
                            if ($result && mysqli_num_rows($result) > 0) {
                                // Valid user, retrieve user information
                                $row = mysqli_fetch_assoc($result);
                
                                // Fetch and display the proof image for the user
                                $validImageExtensions = ['jpg', 'jpeg', 'png'];  // Add more if needed
                                $proofImageName = "{$row['id']}.{$validImageExtensions[0]}"; // Use the first valid extension by default
                                $proofImagePath = "/Inventory/images/validIDimages/{$proofImageName}";
                
                                foreach ($validImageExtensions as $extension) {
                                    $imagePath = "/Inventory/images/validIDimages/{$row['id']}.{$extension}";
                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                        $proofImageName = "{$row['id']}.{$extension}";
                                        $proofImagePath = $imagePath;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                $staffname = '';

                $addedbyid = $_SESSION['staff_id'];

                // Fetch user data from tblusers based on staffId
                $sqlSelectUser = "SELECT fname, lname FROM `tblusers` WHERE id = ?";
                $stmtSelectUser = mysqli_prepare($con, $sqlSelectUser);

                if ($stmtSelectUser) {
                    mysqli_stmt_bind_param($stmtSelectUser, "i", $addedbyid);
                    mysqli_stmt_execute($stmtSelectUser);
                    $resultUser = mysqli_stmt_get_result($stmtSelectUser);

                    if ($resultUser) {
                        $rowUser = mysqli_fetch_assoc($resultUser);
                        $approveby = $rowUser['fname'] . ' ' . $rowUser['lname'];
                    } else {
                        // Log the error instead of displaying to users
                        error_log("Failed to fetch user data: " . mysqli_error($con));
                    }

                    mysqli_stmt_close($stmtSelectUser);
                } else {
                    // Log the error instead of displaying to users
                    error_log("Statement preparation failed for user data: " . mysqli_error($con));
                }
                ?>
                <div class="card text">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $proofImagePath)) {
                                    echo "<img src='{$proofImagePath}' alt='Proof Image' class='img-fluid rounded'> ";
                                } else {
                                    echo "<p class='text-center'>No proof image available.</p>";
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title">User Details</h5>
                                <span class="card-text mb-5">
                                    <strong><i class="fas fa-id-badge me-2"></i><?php echo $row['usertype']; ?> ID:</strong> <?php echo $row['id']; ?><br>
                                    <strong><i class="fas fa-user me-2"></i>Name:</strong> <?php echo $row['fname'] .$row['lname']; ?><br>
                                    
                                    <strong><i class="fas fa-user-tag me-2"></i>Type:</strong> <?php echo $row['usertype']; ?><br>
                                    <strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?php echo $row['email']; ?><br>
                                    <strong><i class="fas fa-venus-mars me-2"></i>Gender:</strong> <?php echo $row['gender']; ?><br>
                                    <strong><i class="fas fa-building me-2"></i>Department:</strong> <?php echo $row['department']; ?>
                                    <div class='text-end mb-2'>
                                        <a href='ccsstaffPendingAccounts.php' class='btn btn-success '>Cancel</a>
                                        <a href='#' class='btn btn-danger '>Reject</a>
                                        <a href="#" class='btn btn-primary' onclick="confirmApprove('<?php echo $row['id']; ?>', '<?php echo $approveby; ?>')">Approve</a>
                                    </div>
                            </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VB

KQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
    function confirmApprove(userId, approveby) {
        // Show a confirmation alert
        var isConfirmed = confirm('Are you sure you want to approve this user?');

        // If the user clicks "OK" in the alert, redirect to updateUserStatus.php
        if (isConfirmed) {
            window.location.href = 'updateUserStatus.php?userId=' + userId + '&approveby=' + approveby;
        }
    }
</script>

