<!-- ccssreturnsubmit_return.php -->
<?php
// Include necessary files
include('ccsfunctions.php');

// Retrieve form data if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $borrowerId = $_POST['borrowerId'];
    $returnRemarks = $_POST['returnRemarks'];
    $damagedItemCount = $_POST['damagedItemCount'];
    date_default_timezone_set('Asia/Manila');
    $datetimereturn = date("Y-m-d H:i:s");
    
    // Generate a unique return code
    $returnCode = generateReturnCode(); // Define the function to generate a return code

    // Retrieve approvereturnbyId from the session
    session_start(); // Start the session if not already started
    $approvereturnbyId = $_SESSION['staff_id'];

    // Update item statuses to 'Returned' for the given borrower ID
    $query = "UPDATE tblborrowingreports SET itemreqstatus = 'Returned', returnremarks = ?, datetimereturn = ?, itemcondition = ?, approvereturnbyid = ?, returncode = ? WHERE borrowerid = ? AND itemreqstatus = 'Approved'";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssisi", $returnRemarks, $datetimereturn, $damagedItemCount, $approvereturnbyId, $returnCode, $borrowerId);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Successfully updated item statuses

            // If there were damaged items, handle their submission here
            if ($damagedItemCount > 0) {
                // You can retrieve the proof of damage files and handle them accordingly
                // For example, move them to a specific directory and store their paths in the database
            }

            // Update the status of the corresponding items in tblitembrand to "Available"
            $update_query = "UPDATE tblitembrand SET status = 'Available' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Returned')";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, "i", $borrowerId);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            // Redirect back to the list of borrowers page or any other appropriate page
            echo "<script>window.location.href='ccsstaffReturnListofBorrowers.php?msg_success=Item Returned successfully';</script>";
            exit();
        } else {
            // Error executing the statement
            echo '<p class="text-danger">Error updating item statuses: ' . mysqli_error($con) . '</p>';
        }

        mysqli_stmt_close($stmt);
    } else {
        // Statement preparation failed
        echo '<p class="text-danger">Statement preparation failed: ' . mysqli_error($con) . '</p>';
    }
} else {
    // If the form is not submitted via POST method, redirect back to the form page
    header('Location: ccsstaffReturnListofBorrowers.php');
    exit();
}

// Function to generate a unique return code
function generateReturnCode() {
    // Generate a random alphanumeric return code
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $returnCode = '';
    $codeLength = 8;
    $maxIndex = strlen($characters) - 1;
    for ($i = 0; $i < $codeLength; $i++) {
        $returnCode .= $characters[rand(0, $maxIndex)];
    }
    return $returnCode;
}
?>
