<?php
// deanDashboardPage.php
// Start the session
session_start();
include('deanfunction.php');
// Check if dean ID is set in the session
if (!isset($_SESSION['dean_id'])) {
    // Redirect to the login page or display an error message
    header('Location: /inventory/logout.php'); // You may adjust the URL as needed
    exit();
}

// Retrieve user information based on the logged-in user ID
$deanId = $_SESSION['dean_id'];
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $deanId);

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
            <?php
// Query to fetch categories
$queryitems = "SELECT id, itembrand, categoryname, subcategoryname, modelno, serialno, datepurchased, unitcost, assignfor, COUNT(*) as quantity FROM tblitembrand GROUP BY itembrand, subcategoryname, modelno, serialno, datepurchased, unitcost, assignfor ORDER BY categoryname, assignfor, subcategoryname, itembrand";
$resultitems = mysqli_query($con, $queryitems);

?>
<!-- Add this script to include jQuery before your custom script -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Your custom script -->
<script>
    $(document).ready(function() {
        // Event listener for the search input
        $('#searchInput').on('input', function() {
            // Get the search query value
            var searchQuery = $(this).val().toLowerCase();

            // Iterate through each row in the table body
            $('.item-details-row').each(function() {
                var rowContent = $(this).text().toLowerCase();

                // Check if any column contains the search query
                if (rowContent.includes(searchQuery)) {
                    // Show the row if it contains the search query
                    $(this).show();
                } else {
                    // Hide the row if it doesn't contain the search query
                    $(this).hide();
                }
            });
        });

        // Use event delegation for the click event on a parent container
        $('.table').on('click', '.category-row', function() {
            $(this).nextUntil('.category-row').toggle();
        });
    });
</script>
<main class="ccs-main-container">
    <div class="container ">
    <?php include('deanheader.php'); ?>
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-2">
                <h3 class="text-start"><i class='fas fa-tachometer-alt me-2'></i>List of CCS Inventory Properties</h3>
            <div class="text-end">
                <input type="text" class="form-control search-input" placeholder="Search" name="search" id="searchInput">
            </div>
        
        </div>
        <div class="table-responsive row">
            <table class="table">
            <thead class="table-dark">
                
                    <tr> 
                        <th scope="col">Image</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Item Name</th> 
                        <th scope="col">Item Description</th>                                             
                        <th scope="col">Model No</th>
                        <th scope="col">Serial No</th> 
                        <th scope="col">Date of Purchase</th>             
                        <th scope="col">Per Unit Cost</th>
                    </tr>
            </thead>
            <?php
                    $currentCategory = null;
                    $currentAssignFor = null;
                    
                    while ($row = mysqli_fetch_assoc($resultitems)) {
                        // Check if the category has changed
                        if ($currentCategory != $row['categoryname']) {
                            // Display the category name row with a class for click event
                            echo "<tr class='category-row text-center'>
                                    <td colspan='9' style='background-color: azure;'><strong>{$row['categoryname']}</strong></td>  
                                  </tr>";
                    
                            $currentCategory = $row['categoryname'];
                        }
                    
                        // Check if the assignfor is not empty and has changed
                        if (!empty($row['assignfor']) && $currentAssignFor != $row['assignfor']) {
                            // Display the assignfor row with a class for click event
                            echo "<tr class='assignfor-row'>
                                    <td colspan='9' style='background-color: gray;'><i class='fas fa-chalkboard-teacher me-2'></i><strong>{$row['assignfor']}</strong></td>  
                                  </tr>";
                    
                            $currentAssignFor = $row['assignfor'];
                        }
                    
                        // Display the subcategory and other item details
                        echo "<tr class='item-details-row'>";
                        $imagePath = '../DashboardCCSStaff/inventory/SubcategoryItemsimages/' . $row['subcategoryname'] . '.png';
                        if (file_exists($imagePath)) {
                            echo "<td><img src='{$imagePath}' alt='Subcategory Image' width='45'></td>";
                        } else {
                            echo "<td><img src='/inventory/SubcategoryItemsimages/defaultimageitem.png' alt='Default Image' width='50'></td>";
                        }
                    
                        echo "<td class='text-center'>{$row['quantity']}</td>";
                        echo "<td>{$row['subcategoryname']}</td>";
                        echo "<td>{$row['itembrand']}</td>";
                        echo "<td class='text-center'>{$row['modelno']}</td>";
                        echo "<td class='text-center'>{$row['serialno']}</td>";
                    
                        $datepurchased = new DateTime($row['datepurchased']);
                        echo "<td class='text-center'>{$datepurchased->format('m-d-Y')}</td>";
                        echo "<td class='text-center'>{$row['unitcost']}</td>";
                        echo "</tr>";
                    }
                    ?>
            <tbody>
            </tbody>
        </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</main>