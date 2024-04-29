<!-- borrowerConfirmBorrowRequest.php -->
<?php
session_start();

// Include necessary files
include('bwerfunctions.php');

// Check if the user is logged in
if (!isset($_SESSION['borrower_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /Inventory/index.php');
    exit();
}

// Retrieve user information based on the logged-in user ID
$query = "SELECT * FROM tblusers WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $borrowerId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Valid user, retrieve user information
            $row = mysqli_fetch_assoc($result);
        } else {
            // Handle the case when user information is not found
            // You might want to redirect or display an error message
            die('User information not found');
        }
    } else {
        die('Statement execution failed: ' . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
} else {
    die('Statement preparation failed: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm Borrow Request</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
        <!-- Header at the top -->
        <div class="row">      
            <?php include('bwerheader.php'); ?>
        </div>
        <!-- Sidebar on the left and Main container on the right -->
        <div class="row">
            <!-- Sidebar on the left -->
            <div class="col-md-2">
                <?php include('bwersidebar.php'); ?>
            </div>
            <!-- Main container on the right -->
            <div class="col-md-10">
                <?php
                if (isset($_GET["msg_success"])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_success"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                
                if (isset($_GET["msg_fail"])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $_GET["msg_fail"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if (isset($_GET["msg"])) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                    echo $_GET["msg"];
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                //include('bwerdashboardpage.php');
                ?>
                <!-- Modal HTML Structure -->
                <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noteModalLabel">Note</h5>
                                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                            </div>
                            <div class="modal-body">
                                <!-- Image -->
                                <div class="text-center mb-3">
                                    <img src="\Inventory\images\sadItemsnotes3.jpg" class="img-fluid" alt="Return of Damaged Goods">
                                </div>  
                                <!-- Checkbox for agreement -->
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="agreementCheckbox">
                                    <label class="form-check-label" for="agreementCheckbox">
                                        I agree to the terms and conditions
                                    </label>
                                </div>        
                                <!-- Note -->
                                <p class="text-danger">Any deformation or lost/damage of items borrowed are subject to replacement on your account.</p>
                            </div>
                            <div class="modal-footer">
                                <!-- Disabled Confirm button initially -->
                                <button type="button" class="btn btn-success" id="confirmButton" data-bs-dismiss="modal" disabled>Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('bwerconfirmborrowrequest.php');?>        
            </div>
        </div>
    </div>
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
         //Show the modal when the page loads
        $('#noteModal').modal('show');
    });
     // Select the checkbox and Confirm button
    var agreementCheckbox = document.getElementById('agreementCheckbox');
    var confirmButton = document.getElementById('confirmButton');
    // Add event listener to the checkbox
    agreementCheckbox.addEventListener('change', function () {
        // Enable Confirm button if checkbox is checked, otherwise disable it
        confirmButton.disabled = !this.checked;
    });
    
    (function($) {
        showSwal = function(type) {
            'use strict';
            if (type === 'success-message') {
                swal({
                    title: 'Successfully!',
                    text: 'Successfully Requesting Borrow',
                    type: 'success',
                    })
            } else {
                swal("Error occurred!");
            }
        }
    })(jQuery);
</script>

</body>
</html>
