<?php session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <link rel="shortcut icon" href="assets/images/logoo.ico">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="style2.css">

    <link rel="icon" href="Favicon.png">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    </head>
   <body>
    <main>
      <header id="header">
        <div class="overlay overlay-lg"></div>

        <nav>
          <div class="container">
            <div class="logo">
              <img src="./img/logo.png" alt="" />
            </div>

            <div class="links">
              <ul>
                <li>
                <a href="index.html">Home</a>
                </li>
                <li>
                <a href="index.html#portfolio">Products</a>
                </li>
                <li>
                  <a href="index.html#aboutus">About Us</a>
                </li>
                <li>
                  <a href="index.html#services">Services</a>
                </li>
                <li>
                  <a href="index.html#contact">Contact Us</a>
                </li>
                <li>
                  <a href="faqs1.php">FAQS</a>
                </li>
                <li>
                  <a href="#hireme" class="active">LOGIN</a>
                </li>
              </ul>
            </div>

            <div class="hamburger-menu">
              <div class="bar"></div>
            </div>
          </div>
        </nav>
      </header>

    <title>Recover Password</title>
</head>
<body>

<br><br>
<p style="text-align: center; font-size: 25px; font-weight: bold;">Forgot Password?</p>
<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="container"> <!-- Add the "container" class to center the content -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color: #37404a;">
                <div class="text-center" style="color: white;">
                <p style="text-align: center; font-size: 18px;">Please enter your email to change your password.</p>
                    <div class="card-body">
                        <form action="#" method="POST" name="recover_psw">
                        <div class="form-group row">
    <label for="email_address" style="color: white;"> <i class="fa-solid fa-envelope"></i> Email Address:&nbsp;&nbsp; </label>
    <div class="form-control-center">
        <input type="text" id="email_address" class="form-control" name="email" required autofocus size="25">
    </div>
</div>

<div class="form-group row justify-content-center"> <!-- Center the content -->
    <div class="col-md-6">
   <!-- Adjust the width here -->
   <input type="submit" value="Submit" name="recover" class="btn btn-primary" style="background-color: #ce8e17;">

</div> <!-- Add Bootstrap button styles -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>

<?php 
    if(isset($_POST["recover"])){
        include('mysql_connect.php'); // connection to MySQL
        $email = $_POST["email"];

        $sql = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
        $query = mysqli_num_rows($sql);
        $fetch = mysqli_fetch_assoc($sql);
        $row = mysqli_fetch_assoc($sql);

        if(mysqli_num_rows($sql) <= 0){
            ?>
            <script>
                alert("<?php  echo "Sorry, no emails exists "?>");
            </script>
            <?php
        }else if($fetch["status"] == 0){
            ?>
               <script>
                   alert("Sorry, your account must verify first, before you recover your password !");
                   window.location.replace("index.php");
               </script>
           <?php
        }else{
            // generate token by binaryhexa 
            $token = bin2hex(random_bytes(50));

            //session_start ();
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';

            // h-hotel account
            $mail->Username='tekuno.space@gmail.com';
            $mail->Password='tomc vgby fire ytio';

            // send by h-hotel email
            $mail->setFrom('tekuno.space@gmail.com', 'Password Reset');
            // get email from input
            $mail->addAddress($_POST["email"]);
            //$mail->addReplyTo('lamkaizhe16@gmail.com');

            // HTML body
            $mail->isHTML(true);
            $mail->Subject="Recover your password";
            $mail->Body="<b>My Dear Customer</b>
            <h3>We received a request to reset your password.</h3>
            <p>Kindly click the below link to reset your password</p>
            https://tekuno.tech/reset_pass.php
            <br><br>
            <p>With regrads,</p>
            <b>Kat&Ren Construction Supply</b>";

            if(!$mail->send()){
                ?>
                    <script>
                        alert("<?php echo " Invalid Email "?>");
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        window.location.replace("login.php");
                        alert("<?php echo "Kindly check your email for reset password"?>");
                    </script>
                <?php
            }
        }
    }


?>
   <br><br><br>
            <footer class="footer">
      <div class="container">
        <div class="grid-4">
          <div class="grid-4-col footer-about">
            <h3 class="title-sm">About</h3>
            <p class="text">
              Kat & Ren Coco Lumber and Construction Supply is a hardware shop that provides with high quality construction materials.
            </p>
          </div>

          <div class="grid-4-col footer-links">
            <h3 class="title-sm">Links</h3>
            <ul>
              <li>
              <a href="index.html#portfolio">Products</a>
              </li>
              <li>
                <a href="index.html#aboutus">About Us</a>
              </li>
              <li>
              <a href="index.html#services">Services</a>
              </li>
              <li>
                <a href="index.html#contact">Contact Us</a>
              </li>
              <li>
                <a href="#login">Login</a>
              </li>
              <li>
                <a href="faqs1.php">FAQS</a>
              </li>
            </ul>
          </div>

          <div class="grid-4-col footer-links">
            <h3 class="title-sm">Services</h3>
            <ul>
              <li>
                <a href="index.html#services">Product Sales</a>
              </li>
              <li>
                <a href="index.html#services">Product Delivery</a>
              </li>
              <li>
                <a href="index.html#services">Bulk Purchase Discounts</a>
              </li>
              <li>
                <a href="index.html#services">Payment Option</a>
              </li>
            </ul>
          </div>

          <div class="grid-4-col footer-newsletter">
            <div class="footer-input-wrap">
                <input type="email" class="footer-input" placeholder="tekuno.space@gmail.com" disabled />
                <a href="#" class="input-arrow">
                    <i class="fas fa-angle-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="bottom-footer">
          <div class="copyright">
            <p class="text">
              Copyright&copy;2023 All rights reserved | Made by
              <span class="split-text" data-text="FORUM"><a
                href="https://dopedevelopers.com/" class="tekuno-link">TEKUNO</a>
 
            </p>
          </div>

          <div class="followme-wrap">
            <div class="followme">
              <h3>Follow Us</h3>
              <span class="footer-line"></span>
              <div class="social-media">
                <a href="https://www.facebook.com/RenPlasteringSand?mibextid=ZbWKwL">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </div>
            </div>

            <div class="back-btn-wrap">
              <a href="#" class="back-btn">
                <i class="fas fa-chevron-up"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <script src="main.js"></script>
  </body>
</html>