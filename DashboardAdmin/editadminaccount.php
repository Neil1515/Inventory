<!-- editadminaccount.php -->
<?php
// Start the session
session_start();
// Check if admin ID is set in the session
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page or display an error message
    header('Location: /inventory/logout.php'); // You may adjust the URL as needed
    exit();
}

// Include necessary files
include('adminfunctions.php');


// Fetch admin's name from the database
$adminId = $_SESSION['admin_id'];
$fetchAdminNameQuery = "SELECT fname FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($conn, $fetchAdminNameQuery);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $adminId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $adminName = $row['fname'];
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($conn));
}

/// Handle password change form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminId = $_SESSION['admin_id'];
    $oldPassword = mysqli_real_escape_string($conn, $_POST['old_password']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirmNewPassword = mysqli_real_escape_string($conn, $_POST['confirm_new_password']);

    // Validate old password
    $query = "SELECT password FROM tblusers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $adminId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                // Verify the old password
                if (password_verify($oldPassword, $hashedPassword)) {
                    // Old password is correct, proceed with password change
                    if ($newPassword === $confirmNewPassword) {
                        // Hash the new password
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                        // Update the password in the database
                        $updateQuery = "UPDATE tblusers SET password = ? WHERE id = ?";
                        $updateStmt = mysqli_prepare($conn, $updateQuery);
                
                        if ($updateStmt) {
                            mysqli_stmt_bind_param($updateStmt, "ss", $hashedNewPassword, $adminId);
                
                            if (mysqli_stmt_execute($updateStmt)) {
                                $changePasswordSuccess = true;
                            } else {
                                $changePasswordError = 'Failed to update password: ' . mysqli_stmt_error($updateStmt);
                            }
                
                            mysqli_stmt_close($updateStmt);
                        } else {
                            $changePasswordError = 'Statement preparation failed: ' . mysqli_error($conn);
                        }
                    } else {
                        $changePasswordError = 'New password and confirm new password do not match.';
                    }
                } else {
                    $changePasswordError = 'Incorrect old password.';
                }
            }
        } else {
            die('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    } else {
        $changePasswordError = 'Statement preparation failed: ' . mysqli_error($conn);
    }
}


// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="adminstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit Admin Account</title>
    <!-- Include your CSS stylesheets and other meta tags as needed -->
</head>
<body>
<?php include('adminheader.php'); ?>
<div class="container">
    <h2>Change password for <?php echo $adminName; ?></h2>
    <?php if (isset($changePasswordSuccess) && $changePasswordSuccess): ?>
        <div class="alert alert-success" role="alert">
            Password changed successfully!
        </div>
    <?php endif; ?>

    <?php if (isset($changePasswordError)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $changePasswordError; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="old_password" class="form-label">Old Password</label>
            <input type="password" class="form-control" id="old_password" name="old_password" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_new_password" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
        <a href="adminPage.php" class="btn btn-danger">Cancel</a>
    </form>
</div>

</body>
</html>
