<?php
// deanDashboardPage.php
// Start the session
session_start();

// Check if dean ID is set in the session
if (!isset($_SESSION['dean_id'])) {
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
$adminId = $_SESSION['dean_id'];
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

// Query to fetch categories
$queryitems = "SELECT * FROM tblitembrand ORDER BY categoryname";
$resultitems = mysqli_query($con, $queryitems);
?>
<style>
        /*colors for each status */
        .status-available {
            color: green;

        }
        .status-reserve {
            color: olive;
        }
        .status-borrowed {
            color: blue;
        }
        .status-missing {
            color: red;
            font-weight: bold;
        }
        .status-missing-row {
            background-color: rgba(255, 0, 0, 0.2); /* Transparent red background */
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .ccs-main-container {
            display: flex;
            justify-content: center;
        }
    </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dean Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <link rel="stylesheet" type="text/css" href="deanstyles.css">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">
                <?php include('deanheader.php'); ?>
        </div>
        <div class="row">
            <?php
            // Display success, fail, and warning messages
            foreach (['success', 'fail', 'warning'] as $msgType) {
                if (isset($_GET["msg_$msgType"])) {
                    echo "<div class='alert alert-$msgType alert-dismissible fade show' role='alert'>";
                    echo $_GET["msg_$msgType"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
            }
            ?>
            <h4 class="col-md text-start">Items Details</h4>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Item Brand</th> 
                        <th scope="col">Subcategory Name</th>                                             
                        <th scope="col">Model No</th>
                        <th scope="col">Serial No</th>
                        <th scope="col">Date Purchased</th>
                        <th scope="col">Unit Cost</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentCategory = null;
                    while ($row = mysqli_fetch_assoc($resultitems)) {
                        // Check if the category has changed
                        if ($currentCategory != $row['categoryname']) {
                            // Display the category name row with a class for click event
                            echo "<tr class='category-row'><td colspan='9' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td></tr>";
                            $currentCategory = $row['categoryname'];
                        }

                        // Display the subcategory and other item details with a class for toggling
                        echo "<tr class='item-details-row";
                        // Add class for highlighting missing items
                        if ($row['status'] == 'Missing') {
                            echo " status-missing-row";
                        }
                        echo "'>";
                        echo "<td></td>";                   
                        echo "<td>{$row['itembrand']}</td>";
                        echo "<td>{$row['subcategoryname']}</td>";                        
                        echo "<td>{$row['modelno']}</td>";
                        echo "<td>{$row['serialno']}</td>";   
                        echo "<td>{$row['datepurchased']}</td>"; 
                        echo "<td><a>₱</a>{$row['unitcost']}</td>";                  
                        echo "<td>{$row['remarks']}</td>";
                        // Add class to status based on its value
                        $statusClass = '';
                        switch ($row['status']) {
                            case 'Available':
                                $statusClass = 'status-available';
                                break;
                            case 'Reserve':
                                $statusClass = 'status-reserve';
                                break;
                            case 'Borrowed':
                                $statusClass = 'status-borrowed';
                                break;
                            case 'Missing':
                                $statusClass = 'status-missing';
                                break;
                        }
                        echo "<td class='$statusClass'>{$row['status']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<!-- Add this script to include jQuery before your custom script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Bootstrap and Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
