<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMS Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/Inventory/styles1.css">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body>
<div class="login-container">
    <form action="" method="post">
        <div class="logo-container">
            <img src="images/imsicon.png" alt="Logo" class="logo">
        </div>
        <h3 class="mt-2">INVENTORY MANAGEMENT SYSTEM</h3>
        <div class="form-group">
            <label for="id">ID Number or Email</label>
            <input type="text" id="id" name="id">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-container">
                <input type="password" id="password" name="password">
            </div>
            <div class="input-container mt-1">  
                <a class="show-password" onclick="togglePasswordVisibility()">👁️ Show Password</a>
                <!--<label id="showPasswordLabel"> Show Password</label>-->
            </div>
        </div>

        <?php
        session_start(); // Start the session
        include('functions.php'); 

        if ($loginError) {
            if (isset($inactiveMessage)) {
                echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">';
                echo '<h6>' . $inactiveMessage . '</h6>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">';
                echo '<h6">Invalid Login Credentials.</h6>';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>';
                echo '</div>';
            }           
        } elseif (isset($loginError) && $loginError) {
            echo '<p style="color: red;">Login failed. Please check your credentials.</p>';
        }
        if (isset($_GET["msg_success"])) {
            echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">';
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
        ?>
        <input type="submit" value="Login" class="mt-1">
    </form>
    <div class="register-label">
        <label>Don't have an account? <a href="/Inventory/registrationform.php">Register</a></label>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var showPasswordButton = document.querySelector('.show-password');
        var showPasswordLabel = document.getElementById('showPasswordLabel');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showPasswordButton.innerHTML = '👀 Hide Password'; 
            //showPasswordLabel.innerHTML = ' ';
        } else {
            passwordInput.type = 'password';
            showPasswordButton.innerHTML = '👁️ Show Password'; 
            //showPasswordLabel.innerHTML = ' ';
        }
    }
</script>
<style>
    .register-label {
    margin-top: 10px; /* Adjust the top margin as needed */
    text-align: center;
}
.show-password
{
    text-align: center;
    font-size: 17px; /* Adjust the font size as needed */
    color: black; 
    color: #007bff; /* Adjust the link color as needed */
    text-decoration: none;
}
.register-label label {
    font-size: 14px; /* Adjust the font size as needed */
    color: #333; /* Adjust the color as needed */
}

.register-label a {
    color: #007bff; /* Adjust the link color as needed */
    text-decoration: none;
}

.register-label a:hover {
    text-decoration: underline;
}

    </style>
        <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
