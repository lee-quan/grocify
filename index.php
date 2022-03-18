<?php
session_start();
require "template/connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

  <!-- Glidejs StyleSheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.min.css" />

  <!-- Animate CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- StyleSheet -->
  <link rel="stylesheet" href="./css/styles.css" />
  <title>GROCIFY</title>
</head>

<body>
  <?php require "template/header.php" ?>

  <!-- Main -->
  <main>
    <!-- Hero -->
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
      $custid = $_SESSION["custid"];
      $result = $link->query("SELECT status FROM user WHERE status=0 AND custid=$custid LIMIT 1");
      if ($result->num_rows == 1) {
        echo '<div style="padding: 1rem;">';
      }else{
        echo '<div style="padding:1rem; margin:9rem auto 0;">';
      }
    }else{
      echo '<div style="padding:1rem; margin:9rem auto 0;">';
    }
    
    ?>
      <section class="hero">
        <div class="glide glide1" id="glide1">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides glide__hero">
              <li class="glide__slide">
                <img src="./images/raya1.gif" class="special_01" alt="" style="width: 100%; height: 40rem;">
              </li>
              <li class="glide__slide">
                <img src="./images/raya.gif" class="special_01" alt="" style="width: 100%; height: 40rem;">
              </li>
            </ul>
          </div>

        </div>
      </section>
    </div>


    <!-- Category -->
    <section class="section category">
      <div class="title-container">
        <div class="section-titles">
          <div class="section-title active">
            <span class="dot"></span>
            <h1 class="primary-title">Featured Products</h1>
            <span class="dot"></span>
          </div>
        </div>
      </div>
      <div class="category-center container">

        <div class="category-box">
          <img src="./images/dryandcannedfood.jfif" alt="">
          <div class="content">
            <h2>Dry & Canned Goods</h2>
            <span>4 Products</span>
            <a href="#">shop now</a>
          </div>
          <a href="#">shop now</a>
        </div>
        <div class="category-box">
          <img src="./images/meatandseafood.jfif" alt="">
          <div class="content">
            <h2>Meat & Seafood</h2>
            <span>4 Products</span>
            <a href="#">shop now</a>
          </div>

        </div>
        <div class="category-box">
          <img src="./images/freshproduce.jfif" alt="">
          <div class="content">
            <h2>Fresh Produce</h2>
            <span>3 Products</span>
            <a href="#">shop now</a>
          </div>

        </div>
        <div class="category-box">
          <img src="./images/beverages.jfif" alt="">
          <div class="content">
            <h2>Drinks</h2>
            <span>5 Products</span>
            <a href="#">shop now</a>
          </div>

        </div>
        <div class="category-box">
          <img src="./images/dairyandeggs.jfif" alt="">
          <div class="content">
            <h2>Dairy & Eggs</h2>
            <span>4 Products</span>
            <a href="#">shop now</a>
          </div>

        </div>


      </div>
    </section>

    <!-- Grid -->
    <!-- <section class="gallary container">
      <figure class="gallary-item item-1">
        <img src="./images/grid_1.jpg" alt="" class="gallary-img">
        <div class="content">
          <h2>Our Popular Products</h2>
          <a href="#">View more</a>
        </div>
      </figure>

      <figure class="gallary-item item-2">
        <img src="./images/grid_2.jpg" alt="" class="gallary-img">
        <div class="content">
          <h2>Winter Collections</h2>
        </div>
      </figure>

      <figure class="gallary-item item-3">
        <img src="./images/grid_3.jpg" alt="" class="gallary-img">
        <div class="content">
          <h2>Summer Collections</h2>
        </div>
      </figure>

      <figure class="gallary-item item-4">
        <img src="./images/grid_4.jpg" alt="" class="gallary-img">
        <div class="content">
          <h2>Up to 70% OFF Spring Sale!</h2>
        </div>
      </figure>
    </section> -->

    <!-- All Products -->
    <section class="section" id="shop">
      <<div class="title-container">
        <div class="section-titles">
          <div class="section-title active">
            <span class="dot"></span>
            <h1 class="primary-title">Popular Brands</h1>
            <span class="dot"></span>
          </div>
        </div>
        </div>
    </section>

    <div class="section brands container">
      <div class="glide" id="glide2">
        <div class="glide__track" data-glide-el="track">
          <ul class="glide__slides">
            <li class="glide__slide">
              <img src="./images/keluarga.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="./images/maggi.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="./images/dutchlady.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="./images/nestle.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="./images/cj.png" cla alt="">
            </li>

          </ul>
        </div>
      </div>
    </div>


    <!-- blog -->
    <section class="section blog" id="blog">
      <div class="title-container">
        <div class="section-titles">
          <div class="section-title active">
            <span class="dot"></span>
            <h1 class="primary-title">Latest News</h1>
            <span class="dot"></span>
          </div>
        </div>
      </div>

      <div class="blog-container container">
        <div class="glide" id="glide3">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide">
                <div class="blog-card">
                  <div class="card-header">
                    <img src="images/Website-Cover_Website-Cover-1400x793.png" alt="" width="400" height="400">
                  </div>

                  <div class="card-footer">
                    <h3>Kitchen Hacks Like A Pro!</h3>
                    <span>By Admin</span>
                    <p>Ever wonder how food bloggers or chefs manage to make their food looks so appetizing? Trust these
                      professionals to have more than one trick up their sleeves......</p>
                    <a href="#"><button>Read More</button></a>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="blog-card">
                  <div class="card-header">
                    <img src="images/grocery2.jpg" alt="" width="400" height="400">
                  </div>
                  <div class="card-footer">
                    <h3>Everyday essentials under RM20</h3>
                    <span>By Admin</span>
                    <p>You don't need a big wallet to afford high-quality products that combine good function and
                      design. Here you'll find everyday essentials to complete every room in your home, all under RM20.
                    </p>
                    <a href="#"><button>Read More</button></a>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="blog-card">
                  <div class="card-header">
                    <img src="images/flat-design-hari-raya-aidalfitri-white-crescent-moon_23-2148534326.jpg" alt="" width="400" height="400">
                  </div>
                  <div class="card-footer">
                    <h3>Raya your way with Grocify</h3>
                    <span>By Admin</span>
                    <p>This year's Hari Raya may be celebrated in a slightly different atmosphere, whether it's big or
                      small, online or offline, but it will truly be memorable. Discover our latest products to get your
                      home Raya-ready.</p>
                    <a href="#"><button>Read More</button></a>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="blog-card">
                  <div class="card-header">
                    <img src="images/3-follow-golden-rule.gif" alt="" width="400" height="400">
                  </div>
                  <div class="card-footer">
                    <h3>We do our part. Please, do your part.</h3>
                    <span>By Admin</span>
                    <p>Physical distancing helps limit the spread of COVID-19. Keep a distance of at least 1m from each
                      other and avoid spending time in crowded places.
                      Protect yourself and others.​ Break the chain of transmission.</p>
                    <a href="#"><button>Read More</button></a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Facility -->
    <section class="facility section" id="facility">
      <h2 class="title" style="font-weight: 700;">Why Choose Us?</h2>
      </div>
      <div class="facility-contianer container">
        <div class="facility-box">
          <div class="facility-icon">
            <i class="fas fa-plane"></i>
          </div>
          <p>FREE SHIPPING WORLD WIDE</p>
        </div>

        <div class="facility-box">
          <div class="facility-icon">
            <i class="far fa-clock"></i>
          </div>
          <p>SAVE TIME AND VALUE FOR MONEY</p>
        </div>

        <div class="facility-box">
          <div class="facility-icon">
            <i class="far fa-credit-card"></i>
          </div>
          <p>MANY PAYMENT GATWAYS</p>
        </div>

        <div class="facility-box">
          <div class="facility-icon">
            <i class="fas fa-headset"></i>
          </div>
          <p>24/7 ONLINE SUPPORT</p>
        </div>
      </div>
    </section>
  </main>

  <!-- PopUp
  <div class="popup">
    <div class="popup-content">
      <div class="popup-close">
        <i class="fas fa-times"></i>
      </div>
      <div class="popup-left">
        <div class="popup-img">
          <img  src="./images/cat2.jpg" alt="popup">
        </div>
      </div>
      <div class="popup-right">
        <div class="right-content">
          <h1>Get Discount <span>30%</span> Off</h1>
          <p>Sign up to our blogletter and save 30% for you next purchase. No spam, we promise!
          </p>
          <form action="#">
            <input type="email" placeholder="Enter your email..." class="popup-form">
            <a href="#">Subscribe</a>
          </form>
        </div>
      </div>
    </div>
  </div> -->


  <?php require "template/footer.php"?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


  <!-- Glidejs Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

  <!-- Custom Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./js/product.js"></script>
  <script src="./js/slider.js"></script>
  <script src="./js/index.js"></script>
</body>

</html>
