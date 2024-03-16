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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css " href="adminstyles.css">
</head>

<body>
    <?php include('adminheader.php');?>
    <div class="container">
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

            // Check if $row is defined before accessing its values
            if (isset($row)) {
                if (isset($_POST["submit"])) {
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $usertype = $_POST['usertype'];
                    $status = $_POST['status'];

                    $sql = "UPDATE `tblusers` SET `fname`='$fname', `lname`='$lname', `usertype`='$usertype', `status`='$status' WHERE id = $id";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        header("Location: adminPage.php?msg=Data updated successfully");
                        exit();
                    } else {
                        echo "Failed: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "User not found.";
            }

            mysqli_close($conn);
        ?>

        <div class="container mt-4">
            <form action="" method="post" enctype="multipart/form-data" style="max-width: 400px; margin: auto;">

                <?php if (isset($row)): ?>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="(Required)" value="<?php echo $row['fname'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="(Required)" value="<?php echo $row['lname'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="usertype" class="form-label">User type:</label>
                        <select class="form-control" id="usertype" name="usertype">
                            <option value="CCS Staff" <?php if ($row['usertype'] == 'CCS Staff') echo 'selected'; ?>>CCS Staff</option>
                            <option value="Dean" <?php if ($row['usertype'] == 'Dean') echo 'selected'; ?>>Dean</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Active" <?php if ($row['status'] == 'Active') echo 'selected'; ?>>Active</option>
                            <option value="Inactive" <?php if ($row['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" name="submit">Update</button>
                        <a href="adminPage.php" class="btn btn-danger">Cancel</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>
