<!-- registrationform.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMS Register</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" type="x-icon" href="/Inventory/images/imsicon.png">
    <!-- Bootstrap and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center mt-1">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registration</span></h3>
                    </div>
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
                    ?>
                    <div class="card-body">
                        <form action="process_registration.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="department" name="department" value="">    
                            <!--<div class="mb-1">
                                <span for="Id" class="form-label">Student/Employee ID<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="Id" name="Id" required>
                            </div>-->
                            <div class="mb-1">
                                <label for="Id" class="form-label">Student/Employee ID<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="Id" name="Id" required oninput="validateIdInput(event)">
                            </div>
                            <div class="mb-1">
                                <label for="firstName" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-1">
                                <label for="lastName" class="form-label">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                            <div class="mb-1">
                                <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                <option value=""selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                            </div>
                            <div class="mb-1">
                                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required onkeyup="checkPasswordStrength()">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="mb-1">
                                    <div id="password-strength" class="form-text"></div>
                                </div>
                            </div>

                            <div class="mb-1">
                                <label for="userType" class="form-label">User Type<span class="text-danger">*</span></label>
                                <select class="form-select" id="userType" name="userType" required>
                                <option value="" selected disabled>Select User type</option>
                                    <option value="Student">Student</option>
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <p for="department" class="form-label">Department<span class="text-danger">*</span></p>
                                <select class="form-select" id="departmentSelect" name="department" required onchange="showOtherInput()">
                                    <option value="" selected disabled>Select Department</option>
                                    <option value="College of Business & Accountancy">College of Business & Accountancy</option>
                                    <option value="College of Criminology">College of Criminology</option>
                                    <option value="College of Computer Studies">College of Computer Studies</option>
                                    <option value="College of Customs Administration">College of Customs Administration</option>
                                    <option value="College of Engineering">College of Engineering</option>
                                    <option value="College of Hotel & Restaurant Management">College of Hotel & Restaurant Management</option>
                                    <option value="College of Maritime Education">College of Maritime Education</option>
                                    <option value="College of Marine Transportation">College of Marine Transportation</option>
                                    <option value="College of Nursing">College of Nursing</option>
                                    <option value="College of Teacher Education">College of Teacher Education</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>

                            <div class="mb-1" id="otherDepartmentInput" style="display: none;">
                                <label for="otherDepartment" class="form-label">Other Department<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="otherDepartment" name="otherDepartment">
                            </div>
                            <div class="mb-2">
                                <label for="idImage" class="form-label">Upload Image of Valid ID<span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="idImage" name="idImage" accept="image/*" required>
                                <small class="form-text text-muted">Please make sure the uploaded image is clear and readable.</small>
                            </div>

                            <div class="text-end">
                                <a href="index.php" class="btn btn-danger">Go to login</a>
                                <button type="submit" id="registerButton" class="btn btn-primary" onclick="showSwal('success-message')" disabled>Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    function showOtherInput() {
        var departmentSelect = document.getElementById("departmentSelect");
        var otherDepartmentInput = document.getElementById("otherDepartmentInput");
        var otherDepartmentTextbox = document.getElementById("otherDepartment");

        if (departmentSelect.value === "Others") {
            otherDepartmentInput.style.display = "block";
            otherDepartmentTextbox.setAttribute("required", "required");
            // Set the department hidden input value to the value of the Other Department input
            document.getElementById("department").value = otherDepartmentTextbox.value;
            // Clear the Other Department input value
            otherDepartmentTextbox.value = "";
        } else {
            otherDepartmentInput.style.display = "none";
            otherDepartmentTextbox.removeAttribute("required");
            // Clear the department hidden input value
            document.getElementById("department").value = "";
        }
    }
    function checkPasswordStrength() {
        var password = document.getElementById('password').value;
        var passwordStrength = document.getElementById('password-strength');
        var weakRegex = /^(?=.*[a-zA-Z])(?=.*[0-9]).{8,}$/;
        var midRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
        var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
        var registerButton = document.getElementById('registerButton');

        if (strongRegex.test(password)) {
            passwordStrength.innerHTML = '<span style="color:green">Strong!</span>';
            registerButton.disabled = false;
        } else if (midRegex.test(password)) {
            passwordStrength.innerHTML = '<span style="color:orange">Medium!</span>';
            registerButton.disabled = false;
        } else if (weakRegex.test(password)) {
            passwordStrength.innerHTML = '<span style="color:red">Weak!</span>';
            registerButton.disabled = true;
        } else {
            passwordStrength.innerHTML = '<span style="color:red">Password must be at least 8 characters and contain at least one letter and one number.</span>';
            registerButton.disabled = true;
        }
    }

        document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        var icon = this.querySelector("i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
    function validateIdInput(event) {
    const input = event.target;
    let value = input.value;

    // Remove leading zeros
    value = value.replace(/^0+/, '');

    // Remove non-numeric characters
    value = value.replace(/\D/g, '');

    // Ensure the value is a positive integer
    const intValue = parseInt(value);
    if (isNaN(intValue) || intValue <= 0) {
        input.value = '';
    } else {
        input.value = intValue;
    }
}
</script>

<style>  
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding:1px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-size: cover;
    background-position: center;
    background-image: url('images/hdbackgroundimage.png');
}
.card{
   
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
    </style>
    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
