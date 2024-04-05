    <!-- ccsreturnsubmit_return.php -->
    <?php
    // Include necessary files
    include('ccsfunctions.php');

    // Retrieve form data if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $borrowerId = $_POST['borrowerId'];
        $returnRemarks = $_POST['returnRemarks'];

        // Initialize $returnItemConditionStr outside of the conditional block
        $returnItemConditionStr = "No Issue"; // Default value if no item condition is selected

        // Check if returnItemCondition is set and is an array
        if (isset($_POST['returnItemCondition']) && is_array($_POST['returnItemCondition'])) {
            // Initialize arrays to hold damaged and lost item conditions
            $damagedItems = [];
            $lostItems = [];

            // Check each item condition
            foreach ($_POST['returnItemCondition'] as $itemCondition) {
                if ($itemCondition === "Damage") {
                    $damagedItems[] = "Damage"; // Add damaged item condition to the array
                } elseif ($itemCondition === "Lost") {
                    $lostItems[] = "Lost"; // Add lost item condition to the array
                }
            }

            // Check if there are any lost items
            if (!empty($lostItems)) {
                $returnItemConditionStr = "Lost"; // If there are lost items, set the return condition to "Lost"
            } elseif (!empty($damagedItems)) {
                // If there are no lost items but there are damaged items, concatenate them
                $returnItemConditionStr = implode(', ', $damagedItems);
            }
        }



        // Set timezone
        date_default_timezone_set('Asia/Manila');
        $datetimereturn = date("Y-m-d H:i:s");

        // Generate a unique return code
        $returnCode = generateReturnCode();

        // Retrieve approvereturnbyId from the session
        session_start(); // Start the session if not already started
        $approvereturnbyId = $_SESSION['staff_id'];

        // Prepare and execute update statement for updating item statuses
        $query = "UPDATE tblborrowingreports SET itemreqstatus = 'Returned', returnremarks = ?, datetimereturn = ?, returnitemcondition = ?, approvereturnbyid = ?, returncode = ? WHERE borrowerid = ? AND itemreqstatus = 'Approved'";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            // Bind parameters including return item condition
            mysqli_stmt_bind_param($stmt, "sssssi", $returnRemarks, $datetimereturn, $returnItemConditionStr, $approvereturnbyId, $returnCode, $borrowerId);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Update the status of the corresponding items in tblitembrand to "Available"
                $update_query = "UPDATE tblitembrand SET status = 'Available' WHERE id IN (SELECT itemid FROM tblborrowingreports WHERE borrowerid = ? AND itemreqstatus = 'Returned')";
                $update_stmt = mysqli_prepare($con, $update_query);
                mysqli_stmt_bind_param($update_stmt, "i", $borrowerId);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // Redirect back to the list of borrowers page or any other appropriate page
                header("Location: ccsstaffReturnListofBorrowers.php?msg_success=Item Returned successfully");
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
