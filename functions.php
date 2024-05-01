<!-- functions.php -->
<?php
// Initialize the loginError variable
$loginError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a valid database connection here
    $servername = 'localhost';
    $db_id = 'root';
    $db_password = '';
    $db_name = 'maininventorydb';

    // Attempt to connect to the database
    $con = mysqli_connect($servername, $db_id, $db_password, $db_name);

    // Check for connection errors
    if (!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Handle form submission
    $id = mysqli_real_escape_string($con, $_POST['id']); // Use mysqli_real_escape_string for input validation
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Perform SQL query to validate user credentials using prepared statement
    $query = "SELECT * FROM tblusers WHERE (id = ? OR email = ?) AND password = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $id, $id, $password);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                // Valid credentials
                $row = mysqli_fetch_assoc($result);
                $usertype = $row['usertype'];
                $status = $row['status'];

                if ($status === 'Active') {
                    // Redirect based on usertype
                    switch ($usertype) {
                        case 'Admin':
                            // Store admin id in session
                            $_SESSION['admin_id'] = $row['id'];
                            header('Location: DashboardAdmin/adminPage.php');
                            exit();
                        case 'CCS Staff':
                        case 'Dean':
                            $_SESSION['staff_id'] = $row['id'];
                            header('Location: DashboardCCSStaff/ccsstaffDashboardPage.php');
                            exit();
                        
                            //$_SESSION['dean_id'] = $row['id'];
                           // header('Location: DashboardDean/deanDashboardPage.php');
                            //exit();
                        case 'Student':
                        case 'Employee':
                            $_SESSION['borrower_id'] = $row['id'];
                            header('Location: DashboardBorrower/borrowerDashboardPage.php');
                            exit();
                        default:
                            // Redirect to a default location or show an error
                            header('Location: index.php');
                            exit();
                    }
                } elseif ($status === 'Pending') {
                    $loginError = true;
                    $inactiveMessage = "Your account is pending. Please await approval from CCS staff.";
                } else {
                    // Inactive status, set loginError to true and display a message
                    $loginError = true;
                    $inactiveMessage = "Your account is inactive. Please contact the admin for access.";
                }
            } else {
                // Invalid credentials, set loginError to true
                $loginError = true;
            }
        } else {
            die('Statement execution failed: ' . mysqli_stmt_error($stmt));
        }
    } else {
        die('Statement preparation failed: ' . mysqli_error($con));
    }

    // Close the database connection
    mysqli_close($con);
}
?>
