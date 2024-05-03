<?php
// Start the session
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page or display an error message
    header('Location: /inventory/logout.php'); // You may adjust the URL as needed
    exit();
}
include "adminfunctions.php";

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $usertype = $_POST['usertype'];
    $status = $_POST['status']; 
    $email = $_POST['email']; 

    // Check if ID or email already exists
    $checkQuery = "SELECT * FROM `tblusers` WHERE id = '$id' OR email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // ID or email already exists
        echo "<script>window.location.href='addusers.php?msg_fail=ID or email already exists';</script>";

    } else {
        // Set default password
        $password = "uclm-" . $id;

        // Proceed with insertion
        $sql = "INSERT INTO `tblusers`(`id`, `fname`, `lname`, `usertype`, `status`, `password`, `email`) VALUES ('$id','$fname','$lname','$usertype','$status','$password','$email')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>window.location.href='adminPage.php?msg_success=New staff created account successfully';</script>";
            exit();
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Staff</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="adminstyles.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <?php include('adminheader.php'); ?>
    <div class="container mt-5">
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
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Add New Staff</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">User ID<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="id" placeholder="User ID (Required)" required oninput="validateIdInput(event)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" placeholder="First Name (Required)" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name (Required)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="Email (Required)" required>
                            </div>

                            <div class="mb-3">
                                <label for="usertype" class="form-label">User type<span class="text-danger">*</span></label>
                                <select class="form-control" id="usertype" name="usertype" required>
                                    <option value="" selected disabled>Select user type</option>
                                    <option value="CCS Staff">CCS Staff</option>
                                    <option value="Dean">Dean</option>
                                </select>
                            </div>

                            <!-- Set default values for status and password -->
                            <input type="hidden" name="status" value="Active">
                            <input type="hidden" name="password" value=password>

                            <div class="text-end">
                                <a href="adminPage.php" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-success" name="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateIdInput(event) {
            const input = event.target;
            let value = input.value;

            // Remove leading zeros
            value = value.replace(/^0+/, '');

            // Remove non-numeric characters
            value = value.replace(/\D/g, '');

            // Ensure the value is a positive integer
            const intValue = parseInt(value);
            if (isNaN(intValue) || intValue <= 0) {
                input.value = '';
            } else {
                input.value = intValue;
            }
        }
    </script>
</body>

</html>
