<?php
// adminPage.php
session_start();
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

include('adminfunctions.php');

$search = isset($_GET["search"]) ? $_GET["search"] : '';
$sql = "SELECT * FROM `tblusers` WHERE usertype NOT IN ('Admin') AND status NOT IN ('Pending') AND (id LIKE '%$search%' OR lname LIKE '%$search%' OR usertype LIKE '%$search%')";
$result = mysqli_query($conn, $sql);

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="adminstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        // Disable caching to prevent going back to the page
        window.onload = function () {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.table tbody tr');

            searchInput.addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();

                tableRows.forEach(function (row) {
                    const rowData = row.textContent.toLowerCase();
                    row.style.display = rowData.includes(searchValue) ? '' : 'none';
                });
            });
        });

        function confirmResetPassword(userId) {
            var confirmReset = confirm("Are you sure you want to reset the password for user ID " + userId + "?");

            if (confirmReset) {
                window.location.href = "resetpassword.php?id=" + userId;
            }
        }

        function confirmDeleteUser(userId) {
            var confirmDelete = confirm("Are you sure you want to delete user ID " + userId + "?");

            if (confirmDelete) {
                window.location.href = "deleteuser.php?id=" + userId;
            }
        }
    </script>
</head>

<body>
    <?php
    // Check if there is a login error
    if (isset($loginError) && $loginError) {
        echo '<p style="color: red;">Login required. Please log in.</p>';
    }
    // Checking if $result is set and not empty
    if ($result && mysqli_num_rows($result) > 0) {
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
        echo '<a href="addusers.php" class="btn btn-primary btn-block btn-add-new me-2">Add Staff</a>';
        echo '<a href="adminreportedborrower.php" class="btn btn-success btn-block btn-add-new">Reported Account ('. $pendingCount .' pending)</a>';
        echo '</div>';
        echo '<div class="col-md-3 text-end">';
        echo '<form action="" method="GET" class="input-group">';
        echo '<input type="text" class="form-control search-input " placeholder="Search" name="search" id="searchInput">';
        echo '</form>';
        echo '</div>';
        echo '</div>';

        echo '<table class="table table-hover">';
        echo '<thead class="table-dark ">';
        echo '<tr>';
        echo '<th scope="col">ID</th>';
        echo '<th scope="col">First Name</th>';
        echo '<th scope="col">Last Name</th>';
        echo '<th scope="col">Email</th>';
        echo '<th scope="col">User Type</th>';
        echo '<th scope="col">Status</th>';
        echo '<th class="text-center" scope="col">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["fname"] . '</td>';
            echo '<td>' . $row["lname"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["usertype"] . '</td>';
            echo '<td class="' . (strtolower($row["status"]) === 'active' ? 'text-success' : 'text-danger') . '">' . $row["status"] . '</td>';
            echo '<td class="text-center">';
            echo '<a href="edit.php?id=' . $row["id"] . '" class="link-dark"><i class="fa-solid fa-pen-to-square fs-7 me-2"></i></a>';
            echo '<a href="javascript:void(0);" onclick="confirmResetPassword(' . $row["id"] . ')" class="link-dark"><i class="fa-solid fa-key fs-7 me-2"></i></a>';
            //echo ' <a href="javascript:void(0);" onclick="confirmDeleteUser(' . $row["id"] . ')" class="link-dark"><i class="fa-solid fa-trash fs-7"></i></a>';
            echo '</td>';
            echo ' </tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p>Error: Admin ID not provided.</p>';
        echo '<a href="/inventory/logout.php" class="logout-btn" img src="logout.png" alt="Logout Icon">Back</a>';
        echo '<style>
            .animated-gif {
                margin-top: 10px;
                max-width: 100%; /* Ensure the image doesn\'t exceed its original size */
                height: 200px; /* Maintain the aspect ratio */
                border-radius: 10px; /* Add a border-radius for rounded corners */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle box shadow for depth */
            }
        </style>';
        echo '<img class="animated-gif" src="\Sawocanteen\images\1639995795_20883_gif-url.gif" alt="Animated GIF">';
    }
    ?>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
