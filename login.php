<?php
session_start();
include("mysql_connect.php");

// Function to log actions to the audit trail
function logAction($conn, $admin_id, $role, $action)
{
  $action = mysqli_real_escape_string($conn, $action);
  $role = mysqli_real_escape_string($conn, $role);
  $query = "INSERT INTO audit_trail (admin_id, role, action) VALUES ('$admin_id', '$role', '$action')";
  mysqli_query($conn, $query);
}

// Function to log actions to the audit trail
function logAction1($conn, $user_id, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $query = "INSERT INTO audit_user (user_id, action) VALUES ('$user_id', '$action')";
    mysqli_query($conn, $query);
}


if (isset($_POST['submit'])) {
  $em = $_POST['email'];
  $ps = $_POST['password'];

  // Use prepared statements to prevent SQL injection
  $query_user = "SELECT * FROM tb_user WHERE email = ? AND password = ?";
  $stmt_user = mysqli_prepare($conn, $query_user);
  mysqli_stmt_bind_param($stmt_user, "ss", $em, $ps);
  mysqli_stmt_execute($stmt_user);
  $user_result = mysqli_stmt_get_result($stmt_user);

  $query_admin = "SELECT * FROM tb_admin WHERE email = ? AND password = ?";
  $stmt_admin = mysqli_prepare($conn, $query_admin);
  mysqli_stmt_bind_param($stmt_admin, "ss", $em, $ps);
  mysqli_stmt_execute($stmt_admin);
  $admin_result = mysqli_stmt_get_result($stmt_admin);

  if (mysqli_num_rows($user_result)) {
    $user = mysqli_fetch_assoc($user_result);

    if ($user['status'] != 1) {
      // Account is not verified
      echo '<div class="alert alert-danger" role="alert">
              This user email is not verified. Please check your email for the OTP.
            </div>';
    } else {
      // Account is verified
      $_SESSION['user_id'] = $user['user_id'];
      // Log the login action to the audit trail
      $action = "User {$user['user_id']} logged in";
      logAction1($conn, $user['user_id'], $action); // Use logAction1 for user actions
      // Redirect after successful login
      header("Location: dashboard-customer.php");
      exit();
    }
  } elseif (mysqli_num_rows($admin_result)) {
    $admin = mysqli_fetch_assoc($admin_result);
    $role = $admin['role'];
    
     // Log the login action to the audit trail
    $action = "Logged in";
    logAction($conn, $admin['admin_id'], $role, $action);
    // Set the session ID once
    $_SESSION['admin_id'] = $admin['admin_id'];

    // Redirect based on admin's role
    if ($role == "Admin") {
      header("Location: dashboard.php");
    } elseif ($role == "Inventory Manager") {
      header("Location: dashboard-inventory.php");
    } elseif ($role == "Order Manager") {
      header("Location: dashboard-order.php");
    } elseif ($role == "Customer Management") {
      header("Location: dashboard-role-customer.php");
    }
    exit();
  } else {
    echo '<div class="alert alert-danger" role="alert">
            Username or Password is incorrect!
          </div>';
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <link rel="shortcut icon" href="assets/images/logo.ico">
  <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="css/login1.css">

  <!-- App favicon -->
  <link rel="shortcut icon" href="assets/images/logoo.ico">

  <title>Login</title>
</head>

<body>
  <div class="half">
    <div class="bg order-1 order-md-2" style="background-image: url('img/bgg.jpg');"></div>
    <div class="contents order-2 order-md-1">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <div class="form-block">
              <div class="logo-container">
                <a href="login.php" style="display: flex; justify-content: center; align-items: center;">
                  <span><img src="assets/images/logo.png" alt="" height="100"></span>
                </a>
              </div>
              <br>

              <div class="text-center mb-5">
                <h3 style="font-family: 'Arial', sans-serif; font-weight: bold; color: white;">Login</h3>
              </div>

              <form action="login.php" method="post">
              <div class="form-group first">
                  <label for="email" style="color: white;"> <i class="fa-solid fa-envelope"></i> Email Address: </label>
                  <input type="text" class="form-control" name="email" placeholder="Enter your email address">
                </div>
                <div class="form-group last mb-3">
                  <label for="password" style="color: white;"> <i class="fas fa-lock"></i> Password: </label>
                  <div class="input-group">
                    <input type="password" class="form-control" placeholder="Enter your password" id="password" name="password">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="mdi mdi-eye" style="color: white;"></i></button>
                    </div>
                  </div>
                </div>



                <div class="d-sm-flex justify-content-center mb-5 align-items-center">
                  <span><a href="recover_pass.php" class="forgot-pass" style="color: white;">Forgot Password</a></span>
                </div>

                <input type="submit" name="submit" value="Log In" class="btn btn-block btn-primary">
              </form>

              <div class="row mt-3">
                <div class="col-12 text-center">
                  <p style="color: white;"><span>Don't have an account?</span> <a href="register.php" style="color: white;"><b>Sign Up</b></a></p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);

      // Update the button's icon based on the password visibility
      togglePassword.innerHTML = type === 'password' ? '<i class="mdi mdi-eye"></i>' : '<i class="mdi mdi-eye-off"></i>';
    });
  </script>

</body>

</html>