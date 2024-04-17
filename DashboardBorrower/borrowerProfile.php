<!-- borrowerProfile.php -->
<?php
session_start();
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user ID from the URL parameter
$borrowerId = $_SESSION['borrower_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="borrowerstyles.css">
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
                            $query = "SELECT * FROM tblusers WHERE id = $BorrowerId";
                            $result = mysqli_query($con, $query);

                            if ($result) {
                                // Check if any rows are returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Fetch the row
                                    $row = mysqli_fetch_assoc($result);
                                } else {
                                    // Output a message if no rows are returned
                                    echo "No user information found for ID: $BorrowerId";
                                }
                                mysqli_free_result($result); // Free the result set
                            } else {
                                // Handle query execution failure
                                echo 'Query execution failed: ' . mysqli_error($con);
                            }

                            if (!empty($row)) : ?>
                                <div class="row">
                            <!-- Main container on the left -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name:</label>
                                    <p class="form-control"><?php echo $row['fname']; ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Last Name:</label>
                                    <p class="form-control"><?php echo $row['lname']; ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <p class="form-control"><?php echo $row['email']; ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gender:</label>
                                    <p class="form-control"><?php echo $row['gender']; ?></p>
                                </div>
                            </div>
                            <!-- Main container on the right -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <p class="form-control"><?php echo $row['department']; ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User Type:</label>
                                    <p class="form-control"><?php echo $row['usertype']; ?></p>
                                </div>
                                <div class="row">
                                    <!-- Main container on the right -->
                                    <div class="col-md-4 text-center">
                                        <div class="mb-3">
                                            <img src="/inventory/images/profile-user.png" alt="userpicture" class="userpicture" width='160'>
                                        </div>
                                    </div>
                                    <!-- Main container on the left -->
                                    <div class="col-md-4 align-items-center d-flex">
                                        <div class="mb-3">
                                            <!-- <a href="#" class="btn btn-danger mb-1">Change Image</a>-->
                                            <a href="#" class="btn btn-success mb-1">Change Password</a>
                                        </div>
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
    </div>
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
