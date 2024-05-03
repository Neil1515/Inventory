<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /inventory/index.php');
    exit();
}
include('adminfunctions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Users Details</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="adminstyles.css">
</head>

<body>
    <div class="container">
        <?php include('adminheader.php');?>
        
        <div class="text-center mt-4">
            <h3>Edit User Information</h3>
        </div>

        <?php
            include "adminfunctions.php";
            $id = isset($_GET["id"]) ? $_GET["id"] : null;

            if ($id !== null) {
                $sql = "SELECT * FROM `tblusers` WHERE id = $id LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                } else {
                    echo "Failed: " . mysqli_error($conn);
                }
            }


if (isset($row)) {
    if (isset($_POST["submit"])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $usertype = $_POST['usertype'];
        $status = $_POST['status'];
        $email = $_POST['email'];
        $gender = $_POST['gender']; // Added gender

        // Check if the email already exists for another user
        $checkQuery = "SELECT * FROM `tblusers` WHERE email = '$email' AND id != $id";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Email already exists for another user
            echo "<script>window.location.href='edit.php?id=$id&msg_fail=Email already exists for another user';</script>";
            exit();
        } else {
            // Proceed with the update
            $sql = "UPDATE `tblusers` SET `fname`='$fname', `lname`='$lname', `usertype`='$usertype', `status`='$status', `email`='$email', `gender`='$gender' WHERE id = $id"; // Added gender

            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: adminPage.php?msg=Data updated successfully");
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        }
    }
} else {
    echo "User not found.";
}

mysqli_close($conn);
?>
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
        <div class="container mt-4">
            <form action="" method="post" enctype="multipart/form-data" style="max-width: 400px; margin: auto;">

                <?php if (isset($row)): ?>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="(Required)" value="<?php echo $row['fname'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="(Required)" value="<?php echo $row['lname'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="lname" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="(Required)" value="<?php echo $row['email'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="usertype" class="form-label">User type<span class="text-danger">*</span></label>
                        <select class="form-control" id="usertype" name="usertype">
                            <option value="CCS Staff" <?php if ($row['usertype'] == 'CCS Staff') echo 'selected'; ?>>CCS Staff</option>
                            <option value="Dean" <?php if ($row['usertype'] == 'Dean') echo 'selected'; ?>>Dean</option>
                            <option value="Employee" <?php if ($row['usertype'] == 'Employee') echo 'selected'; ?>>Employee</option>
                            <option value="Student" <?php if ($row['usertype'] == 'Student') echo 'selected'; ?>>Student</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status">
                            <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                            <option value="Blocked" <?php if ($row['status'] == 'Blocked') echo 'selected'; ?>>Blocked</option>
                        </select>
                    </div>

                    <div class="text-end mb-3">
                        <a href="adminPage.php" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
