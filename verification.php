<?php session_start()
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
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="design5.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title>Verification</title>

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
                  <a href="login.php" class="active">LOGIN</a>
                </li>
              </ul>
            </div>

            <div class="hamburger-menu">
              <div class="bar"></div>
            </div>
          </div>
        </nav>
      </header>
</head>
<body>

<br><br>
<p style="text-align: center; font-size: 25px; font-weight: bold;"> Email Verification Code</p>
<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card" style="background-color: #37404a;">
            <div class="text-center" style="color: white;">
                <p style="text-align: center; font-size: 18px;">Please enter the verification code sent from your email.</p>
                    <div class="card-body">
</div>
</div>
                        <form action="#" method="POST">
                            <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right" style="color: white; white-space: nowrap;"> <i class="fa-regular fa-envelope-open"></i> OTP Code:</label>
                                <div class="col-md-6">
                                <input type="text" id="otp" class="form-control" name="otp_code" required oninput="restrictToNumber(this)">
                                <span class="note" style="display: none; color: orange;">Please enter numbers only.</span>
                                </div>

                            </div>
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Verify" name="verify" class="btn btn-primary" style="background-color: #ce8e17;">
                            </div>
                    </div>
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
    include('mysql_connect.php'); // connection to MySQL
    if(isset($_POST["verify"])){
        $otp = $_SESSION['otp'];
        $email = $_SESSION['mail'];
        $otp_code = $_POST['otp_code'];

        if($otp != $otp_code){
            ?>
           <script>
               alert("Invalid OTP code");
           </script>
           <?php
        }else{
            mysqli_query($conn, "UPDATE tb_user SET status = 1 WHERE email = '$email'");
            ?>
             <script>
                 alert("Verfiy account done, you may sign in now");
                   window.location.replace("login.php");
             </script>
             <?php
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
              <a href="index.php#portfolio">Products</a>
              </li>
              <li>
                <a href="index.php#aboutus">About Us</a>
              </li>
              <li>
              <a href="index.php#services">Services</a>
              </li>
              <li>
                <a href="index.php#contact">Contact Us</a>
              </li>
              <li>
                <a href="login.php">Login</a>
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
                <a href="index.php#services">Product Sales</a>
              </li>
              <li>
                <a href="index.php#services">Product Delivery</a>
              </li>
              <li>
                <a href="index.php#services">Bulk Purchase Discounts</a>
              </li>
              <li>
                <a href="index.php#services">Payment Option</a>
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
    
    <script>
    function restrictToNumber(input) {
        var phoneNumberNote = input.parentNode.querySelector('.note');
        var inputValue = input.value;
        var numbersOnly = inputValue.replace(/[^0-9]/g, '');

        if (inputValue !== numbersOnly) {
            phoneNumberNote.style.display = 'block';
        } else {
            phoneNumberNote.style.display = 'none';
        }

        input.value = numbersOnly;
    }
</script>

  </body>
</html>