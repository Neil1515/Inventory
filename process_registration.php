<!-- process_registration.php -->
<?php
include('DBfunction.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['Id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $userType = $_POST['userType'];
    $department = $_POST['department'];
   
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
    
        // If the ID or email already exists, pass it to the registration form
        if (mysqli_stmt_num_rows($checkExistingStmt) > 0) {
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
    }
    
    

    // Process the image upload
    $targetDir = "images/validIDimages/";

    // Get the file extension
    $imageFileType = strtolower(pathinfo($_FILES['idImage']['name'], PATHINFO_EXTENSION));

    // Construct the new file name with the user ID
    $newFileName = $id . "." . $imageFileType;
    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($_FILES['idImage']['tmp_name'], $targetFile)) {
        // File was uploaded successfully
        echo $targetFile;
    } else {
        // Error uploading file
        echo "Error uploading file.";
    }

    // Set the status to "Pending"
    $status = "Pending";
    $password = "uclm-" . $id;

    // If department is "Others", use the value from the "Other Department" field
    if ($department === "Others") {
        $department = $_POST['otherDepartment'];
    }

    // Use prepared statement to avoid SQL injection
    $insertQuery = "INSERT INTO tblusers (id, password, usertype, fname, lname, email, gender, department, status, datetimeregister) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($con, $insertQuery);

    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, "ssssssssss", $id, $password, $userType, $firstName, $lastName, $email, $gender, $department, $status, $datetimeregister);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "<script>window.location.href='registrationform.php?msg_success={$lastName} please await approval from CCS staff or the Dean.';</script>";
            exit();
        } else {
            echo "Failed: " . mysqli_error($con);
        }

        mysqli_stmt_close($insertStmt);
    } else {
        echo "Failed to prepare statement: " . mysqli_error($con);
    }
}
?>
