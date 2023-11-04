<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kat & Ren Coco Lumber and Construction Supply</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
      <link rel="stylesheet" href="./css/design2.css" />
  <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico" >
  </head>
  <body>
    <main>
      <header id="header">
        <div class="overlay overlay-lg">
        </div>

        <nav>
          <div class="container">
            <div class="logo">
              <img src="./img/logo.png" alt="" />
            </div>

            <div class="links">
              <ul>
                <li>
                  <a href="#header">Home</a>
                </li>
                <li>
                  <a href="#portfolio">Products</a>
                </li>
                <li>
                  <a href="#aboutus">About Us</a>
                </li>
                <li>
                  <a href="#services">Services</a>
                </li>
                <li>
                  <a href="#contact">Contact Us</a>
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

</body>
</html>
      </header> 
        <div class="column-2 image">
          <img src="./img/header.jpg" class="img-element z-index" alt="" />
        </div>
      </div> 
<br>      
<!-- Add this code before the <section class="portfolio section" id="portfolio"> -->
  <section class="image-carousel">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="./img/1p.png" alt="Carousel Slide 1" />
        </div>
        <div class="swiper-slide">
          <img src="./img/2p.png" alt="Carousel Slide 2" />
        </div>
        <div class="swiper-slide">
          <img src="./img/3p.png" alt="Carousel Slide 3" />
        </div>
      </div>
  <script>
    // Initialize Swiper for the carousel with cube effect and custom icons
    var swiper = new Swiper(".swiper-container", {
      slidesPerView: 1,
      loop: true,
      effect: "cube",
      cubeEffect: {
        slideShadows: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
    
  </script>
  <BR>
            <section class="portfolio section" id="portfolio">
              <div class="background-bg">
                <div class="overlay overlay-sm">
                  <img src="./img/shapes/half-circle.png" class="shape half-circle1" alt="" />
                  <img src="./img/shapes/half-circle.png" class="shape half-circle2" alt="" />
                  <img src="./img/shapes/wave.png" class="shape wave" alt="" />
                  <img src="./img/shapes/circle.png" class="shape circle" alt="" />
                  <img src="./img/shapes/triangle.png" class="shape triangle" alt="" />
                  <img src="./img/shapes/x.png" class="shape xshape" alt="" />
                </div>
              </div>
            
              <div class="container">
                <div class="section-header">
                  <h3 class="title" data-title="HARDWARE TOOLS">PRODUCTS</h3>
                </div>
              
                <div class="section-body">
                  <div class="filter">
                    <button class="filter-btn active" data-filter="*">All</button>
                  </div>
                  <div class="grid">
                    <div class="grid-item logo-design">
                      <div class="gallery-image">
                        <img src="./img/portfolio/c1.jpg" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                            <center><h3>COCO LUMBER</h3></center>
                            <center><h5>₱100.00 - 150.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item webdev">
                      <div class="gallery-image">
                        <img src="./img/portfolio/pvc.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                            <center><h3>PVC</h3></center>
                            <center><h5>₱50.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item ui webdev">
                      <div class="gallery-image">
                        <img src="./img/portfolio/pc.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                            <center><h3>PVC Clamp</h3></center>
                            <center><h5>₱95.00 - ₱105.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item ui">
                      <div class="gallery-image">
                        <img src="./img/portfolio/wc.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>Water Meter</h3></center>
                        <center><h5>₱220.00 - ₱250.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item logo-design">
                      <div class="gallery-image">
                        <img src="./img/portfolio/br.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>Blind Rivets</h3></center>
                        <center><h5>₱470.00 - ₱940.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item appdev">
                      <div class="gallery-image">
                        <img src="./img/portfolio/ph.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>PVC Hose Coupling</h3></center>
                         <center><h5>₱25.00 - ₱30.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item logo-design">
                      <div class="gallery-image">
                        <img src="./img/portfolio/bg.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>Butane Gas</h3></center>
                        <center><h5>₱75.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item appdev ui">
                      <div class="gallery-image">
                        <img src="./img/portfolio/ks.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>Kitchen Stain Stainless</h3></center>
                        <center><h5>₱350.00 - ₱380.00</h5></center>
                          </div>
                          <a href="login.php" class="btn">Add to Cart</a>
                        </div>
                      </div>
                    </div>
                    <div class="grid-item ui webdev">
                      <div class="gallery-image">
                        <img src="./img/portfolio/tt.png" alt="" />
                        <div class="img-overlay">
                          <div class="img-description">
                          <center><h3>Teflon Tape</h3></center>
                        <center><h5>₱5.00 - ₱8.00</h5></center>
                  </div>
                  <a href="login.php" class="btn">Add to Cart</a>
            </section>
    
      <section class="services section" id="services">
        <div class="container">
          <div class="section-header">
            <h3 class="title" data-title="What We Offer">Services</h3>
            <p class="text">
              We offer high-quality hardware and construction supply products essential for 
              enhancing your projects' durability and functionality.
            </p>
          </div>

          <div class="cards">
            <div class="card-wrap">
              <img
                src="./img/shapes/points3.png"
                class="points points1 points-sq"
                alt=""
              />
              <div class="card" data-card="UI/UX">
                <div class="card-content z-index">
                  <img src="./img/ps1.png" class="icon" alt="" />
                  <h3 class="title-sm">Product Sales</h3>
                  <p class="text">
                    Our main service is selling construction and hardware products and 
                    equipment to contractors, builders, and others. 
                  </p>
                </div>
              </div>
            </div>
            
            <div class="card-wrap">
              <div class="card" data-card="Code">
                <div class="card-content z-index">
                  <img src="./img/pd1.png" class="icon" alt="" />
                  <h3 class="title-sm">Product Delivery</h3>
                  <p class="text">
                    Provide safe and efficient product delivery within Pasig area only, 
                    ensuring that customers' purchased items are transported securely.
                  </p>
                </div>
              </div>
            </div>

            <div class="card-wrap">
              <div class="card" data-card="Code">
                <div class="card-content z-index">
                  <img src="./img/bpd1.png" class="icon" alt="" />
                  <h3 class="title-sm">Bulk Purchase Discounts</h3>
                  <p class="text">
                    Offer bulk purchase discounts to construction companies and contractors who buy large quantities.
                  </p>
                </div>
              </div>
            </div>

            <div class="card-wrap">
              <img
                src="./img/shapes/points3.png"
                class="points points2 points-sq"
                alt=""
              />
              <div class="card" data-card="App">
                <div class="card-content z-index">
                  <img src="./img/po1.png" class="icon" alt="" />
                  <h3 class="title-sm">Payment Option</h3>
                  <p class="text">
                    We accept Gcash as the mode of payment for your convenience. 
                    It's a hassle-free and secure way to complete your transactions.
                  </p>
        </div>
      </section>
      <section class="aboutus section" id="aboutus">
      <div class="header-content">
        <div class="container grid-2">
          <div class="column-1">
            <h1 class="header-title">ABOUT US</h1>
            <p class="text">    
          Kat & Ren Coco Lumber and Construction Supply, owned by Ferdinand Mendoza, 
          has been trusted in the construction industry for the past 13 years. 
          Our company is a one-stop goal for all your hardware and construction needs.
          With a strong commitment to quality and customer satisfaction, 
          the company has consistently provided clients with top-quality lumber and 
          construction supplies to help you complete your projects efficiently and successfully.
            </p>
      </div>
      <div class="column-2 image">
        <img
          src="./img/shapes/points2.png"
          class="points points2"
          alt=""
        />
        <img src="./img/cover.png" class="img-element z-index" alt="" />
      </div>
    </div>

      <section class="contact" id="contact">
        <div class="container">
          <div class="contact-box">
            <div class="contact-info">
              <h3 class="title">Get in touch</h3>
              <p class="text">
                If you need our assistance, we invite you to fill out the forms on our website. 
                Our team is available to answer any questions or concerns.
              </p>
              <div class="information-wrap">
                <div class="information">
                  <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <p class="info-text">83 Urbano Velasco Ave. 
                    Pinagbuhatan, Pasig City</p>
                </div>

                <div class="information">
                  <div class="contact-icon">
                    <i class="fas fa-paper-plane"></i>
                  </div>
                  <p class="info-text">tekuno.space@gmail.com</p>
                </div>

                <div class="information">
                  <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                  </div>
                  <p class="info-text">02-8907-26-05</p>
                </div>
              </div>
            </div>

            <div class="contact-form">
              <h3 class="title">Contact Us</h3>
              <div class="row">
                <input
                  type="text"
                  class="contact-input"
                  placeholder="First Name"
                />
                <input
                  type="text"
                  class="contact-input"
                  placeholder="Last Name"
                />
              </div>

              <div class="row">
                <input type="text" class="contact-input" placeholder="Phone" />
                <input type="email" class="contact-input" placeholder="Email" />
              </div>

              <div class="row">
                <textarea
                  name="message"
                  class="contact-input textarea"
                  placeholder="Message"
                ></textarea>
              </div>
              <a href="#" class="btn">Send</a>
            </div>
          </div>
        </div>
      </section>
    </main>

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
                <a href="#portfolio">Products</a>
              </li>
              <li>
                <a href="#aboutus">About Us</a>
              </li>
              <li>
                <a href="#services">Services</a>
              </li>
              <li>
                <a href="#contact">Contact Us</a>
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
                <a href="#services">Product Sales</a>
              </li>
              <li>
                <a href="#services">Product Delivery</a>
              </li>
              <li>
                <a href="#services">Bulk Purchase Discounts</a>
              </li>
              <li>
                <a href="#services">Payment Option</a>
              </li>
            </ul>
          </div>

          <div class="grid-4-col footer-newstletter">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/isotope.pkgd.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="./js/app.js"></script>
  </body>
</html>
