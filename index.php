<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMS Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/Inventory/styles1.css">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    
</head>
<body>
<div class="login-container">
    <form action="" method="post">
        <div class="logo-container">
            <img src="images/imsicon.png" alt="Logo" class="logo">
        </div>
        <h3>INVENTORY MANAGEMENT SYSTEM</h3>
        <div class="form-group">
            <label for="id">ID Number or Email</label>
            <input type="text" id="id" name="id">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-container">
                <input type="password" id="password" name="password">
                <span class="show-password" onclick="togglePasswordVisibility()">👁️</span>
                <label id="showPasswordLabel"> Show Password</label>
            </div>
        </div>

        <?php
        session_start(); // Start the session
        include('functions.php'); 

        if ($loginError) {
            if (isset($inactiveMessage)) {
                echo '<p style="color: red; text-align: center;">' . $inactiveMessage . '</p>';
            } else {
                echo '<p style="color: red; text-align: center;">Invalid Login Credentials</p>';
            }           
        } elseif (isset($loginError) && $loginError) {
            echo '<p style="color: red;">Login failed. Please check your credentials.</p>';
        }
        ?>
        <input type="submit" value="Login">
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
            showPasswordButton.innerHTML = '👀'; 
            showPasswordLabel.innerHTML = ' Hide Password';
        } else {
            passwordInput.type = 'password';
            showPasswordButton.innerHTML = '👁️'; 
            showPasswordLabel.innerHTML = ' Show Password';
        }
    }
</script>
<style>
    
    .register-label {
    margin-top: 10px; /* Adjust the top margin as needed */
    text-align: center;
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
</body>
</html>
