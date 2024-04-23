<?php
// Start the session
session_start();

include "adminfunctions.php";

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $usertype = $_POST['usertype'];
    $status = $_POST['status']; 
    $email = $_POST['email']; 

    // Set default password
    $password = "uclm-" . $id;

    $sql = "INSERT INTO `tblusers`(`id`, `fname`, `lname`, `usertype`, `status`, `password`, `email`) VALUES ('$id','$fname','$lname','$usertype','$status','$password','$email')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: adminPage.php?msg=New staff created account successfully");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
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
    <link rel="shortcut icon" type="image/x-icon" href="/Inventory/images/imsicon.png"> <!-- Corrected typo in 'short icon' -->
    <link rel="stylesheet" type="text/css" href="adminstyles.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    
</head>

<body>
    <?php if (!isset($_SESSION['admin_id'])) {
        // Redirect to the login page or display an error message
        header('Location: /inventory/logout.php'); // You may adjust the URL as needed
        exit();
    }?>
    <?php include('adminheader.php'); ?>
    <div class="container">
        <div class="text-center mb-4">
            <h3>Add New Staff</h3>
        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="">
                     <div class="mb-3">
                        <label class="form-label">User ID<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="id" placeholder="User ID (Required)" required>
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

                <div class="text-end mb-3">    
                    <a href="adminPage.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
