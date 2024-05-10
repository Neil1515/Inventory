<!-- process_registration.php -->
<?php
include('DBfunction.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize inputs
    $id = mysqli_real_escape_string($con, $_POST['Id']);
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $userType = mysqli_real_escape_string($con, $_POST['userType']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
   
    date_default_timezone_set('Asia/Manila');
    $datetimeregister = date("Y-m-d H:i:s");

    // Check if the ID or email already exists
    $checkExistingQuery = "SELECT id, email FROM tblusers WHERE id = ? OR email = ?";
    $checkExistingStmt = mysqli_prepare($con, $checkExistingQuery);

    if ($checkExistingStmt) {
        mysqli_stmt_bind_param($checkExistingStmt, "ss", $id, $email);
        mysqli_stmt_execute($checkExistingStmt);
        mysqli_stmt_store_result($checkExistingStmt);
        
        // Bind the result variables
        mysqli_stmt_bind_result($checkExistingStmt, $existingId, $existingEmail);
        
        if (mysqli_stmt_num_rows($checkExistingStmt) > 0) {
            // Fetch the results
            mysqli_stmt_fetch($checkExistingStmt);
        
            if ($existingId == $id && $existingEmail == $email) {
                $errorMsg = "User with ID $id and email $email already exists. Please choose different credentials.";
            } elseif ($existingId == $id) {
                $errorMsg = "User with ID $id already exists. Please choose a different ID.";
            } else {
                $errorMsg = "User with email $email already exists. Please choose a different email.";
            }
            echo "<script>window.location.href='registrationform.php?msg_fail=$errorMsg&existing_id=$id';</script>";
            exit();
        }
        
        mysqli_stmt_close($checkExistingStmt);
    } else {
        echo "Failed to prepare checkExisting statement: " . mysqli_error($con);
        exit();
    }
    
    // Process the image upload
    $targetDir = "images/validIDimages/";
    $newFileName = $id . "." . strtolower(pathinfo($_FILES['idImage']['name'], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $newFileName;

    if (!move_uploaded_file($_FILES['idImage']['tmp_name'], $targetFile)) {
        echo "Error uploading file.";
        exit();
    }

    // Set the status to "Pending"
    $status = "Pending";

    // Get the password from the form input
    $password = $_POST['password'];

   // Encrypt the password using password_hash
   //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // If department is "Others", use the value from the "Other Department" field
    if ($department === "Others") {
        $department = mysqli_real_escape_string($con, $_POST['otherDepartment']);
    }

     // Use prepared statement to avoid SQL injection
    $insertQuery = "INSERT INTO tblusers (id, password, usertype, fname, lname, email, gender, department, status, datetimeregister) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($con, $insertQuery);

    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, "ssssssssss", $id, $password, $userType, $firstName, $lastName, $email, $gender, $department, $status, $datetimeregister);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "<script>window.location.href='index.php?msg_success={$lastName} please await approval from CCS staff and Dean.';</script>";
            exit();
        } else {
            echo "Failed: " . mysqli_error($con);
            exit();
        }

        mysqli_stmt_close($insertStmt);
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
        exit();
    }
}
?>
