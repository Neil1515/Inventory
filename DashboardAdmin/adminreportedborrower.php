<!-- adminreportedborrower.php -->
<?php
// adminPage.php
session_start();
include('adminfunctions.php');
// Check if admin ID is set in the session
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page or display an error message
    header('Location: /inventory/logout.php'); // You may adjust the URL as needed
    exit();
}
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

// Retrieve user information based on the logged-in user ID
$adminId = $_SESSION['admin_id'];
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $adminId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
// Query to count the number of pending reports
$queryCountPendingReports = "SELECT COUNT(*) AS pending_count FROM tblreportborroweracc WHERE status = 'Pending'";
$resultCountPendingReports = mysqli_query($con, $queryCountPendingReports);
if($resultCountPendingReports) {
    $row = mysqli_fetch_assoc($resultCountPendingReports);
    $pendingCount = $row['pending_count'];
} else {
    // Handle query execution failure
    $pendingCount = 0; // Default value if query fails
}

// Fetch reported users from the database
$queryReportedUsers = "SELECT * FROM tblreportborroweracc ORDER BY id DESC";
$resultReportedUsers = mysqli_query($con, $queryReportedUsers);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="adminstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
    // Check if there is a login error
    if (isset($loginError) && $loginError) {
        echo '<p style="color: red;">Login required. Please log in.</p>';
    }
        include('adminheader.php');
        echo '<div class="container-fluid">';
        if (isset($_GET["msg"])) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo $_GET["msg"];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
        }
        echo '<div class="row mb-2">';
        echo '<div class="col-md-9 mb-1">';
        echo '<a href="adminPage.php" class="btn btn-danger me-2"><i class="fas fa-arrow-left"></i> Back</a>';
        echo '<a href="adminreportedborrower.php" class="btn btn-success btn-block btn-add-new">Reported Account ('. $pendingCount .' pending)</a>';
        echo '</div>';
        echo '<div class="col-md-3 text-end">';
        echo '<form action="" method="GET" class="input-group">';
        echo '<input type="text" class="form-control search-input " placeholder="Search" name="search" id="searchInput">';
        echo '</form>';
        echo '</div>';
        echo '</div>';

// Check if there are reported users
if ($resultReportedUsers && mysqli_num_rows($resultReportedUsers) > 0) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-hover">';
    echo '<thead class="table-dark">';
    echo '<tr>';
    echo '<th>Reported by</th>';
    echo '<th>Reported to</th>';
    echo '<th>Reason</th>';
    echo '<th class="text-center">Status</th>';
    echo '<th class="text-center">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    // Fetch and display each reported user
    while ($row = mysqli_fetch_assoc($resultReportedUsers)) {
        // Fetch reported by user's name
        $reportedByQuery = "SELECT fname, lname FROM tblusers WHERE id = ?";
        $reportedByStmt = mysqli_prepare($con, $reportedByQuery);
        mysqli_stmt_bind_param($reportedByStmt, "s", $row['staffid']);
        mysqli_stmt_execute($reportedByStmt);
        $reportedByResult = mysqli_stmt_get_result($reportedByStmt);
        $reportedByRow = mysqli_fetch_assoc($reportedByResult);

        // Fetch reported to user's name
        $reportedToQuery = "SELECT fname, lname FROM tblusers WHERE id = ?";
        $reportedToStmt = mysqli_prepare($con, $reportedToQuery);
        mysqli_stmt_bind_param($reportedToStmt, "s", $row['borrowerid']);
        mysqli_stmt_execute($reportedToStmt);
        $reportedToResult = mysqli_stmt_get_result($reportedToStmt);
        $reportedToRow = mysqli_fetch_assoc($reportedToResult);

        echo '<tr>';
        echo '<td>' . $reportedByRow['fname'] . ' ' . $reportedByRow['lname'] . '</td>';
        echo '<td>' . $reportedToRow['fname'] . ' ' . $reportedToRow['lname'] . '</td>';
        echo '<td>' . $row['reason'] . '</td>';
        echo '<td class="text-center">' . $row['status'] . '</td>';
        echo '<td class="text-center">';
        // Conditionally display action buttons based on the status
        if ($row['status'] === 'Pending') {
            // Display both Approve and Decline buttons
            echo '<form action="adminprocess_report.php" method="post">';
            echo '<input type="hidden" name="report_id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="decline_report" class="btn btn-danger me-2">Decline</button>';
            echo '<button type="submit" name="approve_report" class="btn btn-success">Approve</button>';
            echo '</form>';
        }else if ($row['status'] === 'Approved') {
            echo '<form action="adminprocess_report.php" method="post">';
            echo '<input type="hidden" name="report_id" value="' . $row['id'] . '">';
            echo '<button type="submit" name="unblock_report" class="btn btn-danger me-2">Unblock</button>';
            echo '</form>';
        }else if ($row['status'] === 'Declined') {
            // Display both Approve and Decline buttons
            echo '---';
        }else if ($row['status'] === 'Unblock') {
        // Display both Approve and Decline buttons
        echo '---';
        }else {
            // Display only the status
            echo $row['status'];
        }
        
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    // No reported users found
    echo '<div class="alert alert-info" role="alert">No reported users.</div>';
}

?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
