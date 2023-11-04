<?php session_start(); ?>
<?php
include('mysql_connect.php'); // connection to MySQL

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['register'])) {

    // check if the form has been submitted
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $bdate = $_POST['bdate'];
    $contact = $_POST['contact'];
    $barangay = $_POST['barangay'];
    $postal = $_POST['postal'];
    $houseNo = $_POST['houseNo'];
    $street = $_POST['street'];
    $village = $_POST['village'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];


    // Check if password and confirm password match
    if ($pass !== $confirm) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Passwords do not match!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } else {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'")) > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                This Email already exists!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        } else {
            $status = 0;
            // Insert the data into the database
            $query = mysqli_query($conn, "INSERT INTO tb_user (user_id, lastName, firstName, middleName, gender, bdate, contact, barangay, postal, houseNo, street, village, email, password, confirm, status) VALUES(' ','$lastName', '$firstName', '$middleName', '$gender','$bdate','$contact','$barangay','$postal','$houseNo','$street','$village','$email','$pass','$confirm', '$status')");

            if ($query) {
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;
                $mail = new PHPMailer;


                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'tekuno.space@gmail.com';  // Your SMTP username
                $mail->Password = 'tomc vgby fire ytio';  // Your SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption
                $mail->Port = 587; // TCP port to connect to

                // Email content
                $mail->setFrom('tekuno.space@gmail.com', 'OTP Verification'); // Replace with your email and name
                $mail->addAddress($_POST["email"]);

                $mail->isHTML(true);
                $mail->Subject = 'Registration Code';
                $mail->Body = "<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
                    <p>With regrads,</p>
                    <b>Kat&Ren Construction Supply</b>
                    <br><br>
                    Thank you for registering on our website!";

                // Send email
                if (!$mail->send()) {
?>
                    <script>
                        alert("<?php echo "Register Failed, Invalid Email " ?>");
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                        window.location.replace('verification.php');
                    </script>
<?php
                }
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/regis.css"> <!-- Your custom CSS -->
     <link rel="shortcut icon" href="assets/images/logoo.ico">

</head>
<style>
    /* The message box is shown when the user clicks on the password field */
    #message {
        display: none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 15px;
        margin-top: 9px;
    }

    #message p {
        padding: 9px 30px;
        font-size: 14px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: green;
    }

    /*copy & paste symbol*/
    .valid:before {
        position: relative;
        left: -35px;
        content: "✅";
    }

    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "❌";
    }
</style>

<body>

    <!-- Logo-->
    <div class="container">
        <div class="logo-container">
            <a href="index.html">
                <span><img src="assets/images/custo.png" alt="" height="80"></span>
            </a>
        </div>
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
            <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
        </div>
        <div class="content">
            <form action="#" method="post" name="register">
                <div class="row mb-3">
                    <span class="title">Personal Details</span>

                    <div class="col-md-4">
                        <label for="lastname" class="form-label"><i class="fas fa-user"></i>Last Name</label>
                        <input class="form-control" type="text" name="lastName" id="lastNameInput" placeholder="Enter your Last Name" oninput="restrictToLettersWithSingleSpace(this)" required>
                        <span class="note" style="display: none; color: red;">Please enter letters only</span>
                    </div>

                    <div class="col-md-4">
                        <label for="firstname" class="form-label">First Name</label>
                        <input class="form-control" type="text" name="firstName" id="firstNameInput" placeholder="Enter your First Name" oninput="restrictToLettersWithSingleSpace(this)" required>
                        <span class="note" style="display: none; color: red;">Please enter letters only.</span>
                    </div>

                    <div class="col-md-4">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input class="form-control" type="text" name="middleName" id="middleNameInput" placeholder="Enter your Middle Name" oninput="restrictToLettersWithSingleSpace(this)">
                        <span class=" note" style="display: none; color: red;">Please enter letters only.</span>
                        <small class="form-text text-muted">If you do not have a middle name, you can leave this field blank.</small>
                    </div>

                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <span class="details">Birthdate</span>
                        <input type="date" class="form-control" name="bdate" id="bdate" required>
                    </div>

                    <div class="col-md-4">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input class="form-control" type="text" name="contact" id="phoneNumberInput" placeholder="Enter your Contact Number" required oninput="restrictToNumbers(this)">
                        <span class="note" style="display: none; color: red;">Please enter a valid 11-digit number without symbols or letters.</span>
                    </div>

                    <div class="col-md-4">
                        <label for="City" class="form-label">City</label>
                        <input type="text" class="form-control" name="city" placeholder="City of Pasig" value="City of Pasig" disabled>
                    </div>

                    <div class="col-md-4">
                        <label for="barangay" class="form-label">Barangay</label>
                        <select name="barangay" class="form-control" required>
                            <option value="" disabled selected>Select your barangay</option>
                            <option value="Bagong Ilog">Bagong Ilog</option>
                            <option value="Bagong Katipunan">Bagong Katipunan</option>
                            <option value="Bambang">Bambang</option>
                            <option value="Buting">Buting</option>
                            <option value="Caniogan">Caniogan</option>
                            <option value="Dela Paz">Dela Paz</option>
                            <option value="Kalawaan">Kalawaan</option>
                            <option value="Kapasigan">Kapasigan</option>
                            <option value="Kapitolyo">Kapitolyo</option>
                            <option value="Malinao">Malinao</option>
                            <option value="Manggahan">Manggahan</option>
                            <option value="Maybunga">Maybunga</option>
                            <option value="Oranbo">Oranbo</option>
                            <option value="Palatiw">Palatiw</option>
                            <option value="Pinagbuhatan">Pinagbuhatan</option>
                            <option value="Pineda">Pineda</option>
                            <option value="Rosario">Rosario</option>
                            <option value="Sagad">Sagad</option>
                            <option value="San Antonio">San Antonio</option>
                            <option value="San Joaquin">San Joaquin</option>
                            <option value="San Jose">San Jose</option>
                            <option value="San Miguel">San Miguel</option>
                            <option value="San Nicolas">San Nicolas</option>
                            <option value="Santa Cruz">Santa Cruz</option>
                            <option value="Santa Lucia">Santa Lucia</option>
                            <option value="Santa Rosa">Santa Rosa</option>
                            <option value="Santo Tomas">Santo Tomas</option>
                            <option value="Santolan">Santolan</option>
                            <option value="Sumilang">Sumilang</option>
                            <option value="Ugong">Ugong</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="postal" class="form-label">Postal Code</label>
                        <input class="form-control" type="text" name="postal" id="postalInput" placeholder="Enter your Postal Code" oninput="restrictToNum(this)" required>
                        <span class="note" style="display: none; color: red;">Please enter a valid 4-digit postal code without symbols or letters.</span>
                    </div>

                    <div class="col-md-4">
                        <label for="houseNo" class="form-label">House/Building No.</label>
                        <input class="form-control" type="text" name="houseNo" placeholder="Enter House/Building No." required>
                    </div>

                    <div class="col-md-4">
                        <label for="street" class="form-label">Street Name</label>
                        <input class="form-control" type="text" name="street" placeholder="Enter Street Name" required>
                    </div>

                    <div class="col-md-4">
                        <label for="village" class="form-label">Village/District</label>
                        <input class="form-control" type="text" name="village" placeholder="Enter Villag/District">
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="col-md-4">
                        <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
                        </div>
                        <div id="message">
                            <h6>Password must contain:</h6>
                            <p id="letter" class="invalid">At least one letter</p>
                            <p id="capital" class="invalid">At least one capital letter</p>
                            <p id="number" class="invalid">At least one number</p>
                            <p id="special" class="invalid">At least one special character</p>
                            <p id="length" class="invalid">Minimum 8 characters</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="confirmPassword" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm" id="confirmPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*(),.?\:{}|<>]).{8,}" placeholder="Confirm your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>

                </div>
                <div class="button-container">
                    <button type="submit" name="register" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</button>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Already have an account? <a href="index.php" class="text-muted ms-1"><b>Log In</b></a></p>
                    </div> <!-- end col-->
                </div>


            </form>
        </div>
    </div>

    <script>
        function show() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <script>
        var myInput = document.getElementById("password");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if (myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if (myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if (myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            var specialCharacters = /[!@#$%^&*(),.?\:{}|<>]/g;
            if (myInput.value.match(specialCharacters)) {
                special.classList.remove("invalid");
                special.classList.add("valid");
            } else {
                special.classList.remove("valid");
                special.classList.add("invalid");
            }

            // Validate length
            if (myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        }
    </script>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePasswordButton.querySelector('i').classList.toggle('fa-eye');
            togglePasswordButton.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

    <script>
        const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        toggleConfirmPasswordButton.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            toggleConfirmPasswordButton.querySelector('i').classList.toggle('fa-eye');
            toggleConfirmPasswordButton.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

    <script>
        // Function to show the success modal
        function showSuccessModal() {
            $('#successModal').modal('show');
        }
    </script>

    <script>
        function restrictToLettersWithSingleSpace(input) {
            var lastNameNote = input.parentNode.querySelector('.note');
            var inputValue = input.value;

            // Replace multiple spaces with a single space
            inputValue = inputValue.replace(/  +/g, ' ');

            // Remove any non-letter characters except spaces
            var lettersOnly = inputValue.replace(/[^A-Za-z ]/g, '');

            if (inputValue !== lettersOnly && inputValue.trim() !== '') {
                lastNameNote.style.display = 'block';
            } else {
                lastNameNote.style.display = 'none';
            }

            input.value = lettersOnly;
        }
    </script>


    <script>
        function restrictToLettersWithSingleSpace(input) {
            var firstNameNote = input.parentNode.querySelector('.note');
            var inputValue = input.value;

            // Replace multiple spaces with a single space
            inputValue = inputValue.replace(/  +/g, ' ');

            // Remove any non-letter characters except spaces
            var lettersOnly = inputValue.replace(/[^A-Za-z ]/g, '');

            if (inputValue !== lettersOnly && inputValue.trim() !== '') {
                firstNameNote.style.display = 'block';
            } else {
                firstNameNote.style.display = 'none';
            }

            input.value = lettersOnly;
        }
    </script>

    <script>
        function restrictToLettersWithSingleSpace(input) {
            var middleNameNote = input.parentNode.querySelector('.note');
            var inputValue = input.value;

            // Replace multiple spaces with a single space
            inputValue = inputValue.replace(/  +/g, ' ');

            // Remove any non-letter characters except spaces
            var lettersOnly = inputValue.replace(/[^A-Za-z ]/g, '');

            if (inputValue !== lettersOnly && inputValue.trim() !== '') {
                middleNameNote.style.display = 'block';
            } else {
                middleNameNote.style.display = 'none';
            }

            input.value = lettersOnly;
        }
    </script>

    <script>
        var input = document.getElementById("bdate");

        input.addEventListener("input", function() {
            var selectedDate = new Date(this.value);
            var currentDate = new Date();
            var minDate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());

            if (selectedDate > minDate) {
                this.setCustomValidity("You must be at least 18 years old.");
            } else {
                this.setCustomValidity("");
            }
        });
    </script>

    <script>
        function restrictToNumbers(input) {
            var phoneNumberNote = input.parentNode.querySelector('.note');
            var inputValue = input.value;
            var numbersOnly = inputValue.replace(/[^0-9]/g, '').slice(0, 11);

            if (inputValue !== numbersOnly || inputValue.length !== 11) {
                phoneNumberNote.style.display = 'block';
            } else {
                phoneNumberNote.style.display = 'none';
            }

            input.value = numbersOnly;
        }
    </script>

    <script>
        function restrictToNum(input) {
            var postalNote = input.parentNode.querySelector('.note');
            var inputValue = input.value;
            var numbersOnly = inputValue.replace(/[^0-9]/g, '').slice(0, 4);

            if (inputValue !== numbersOnly || inputValue.length !== 4) {
                postalNote.style.display = 'block';
            } else {
                postalNote.style.display = 'none';
            }

            input.value = numbersOnly;
        }
    </script>
</body>

</html>