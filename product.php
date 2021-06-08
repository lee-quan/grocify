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
  <link rel="stylesheet" href="./css/product.css" />
  <title>GROCIFY</title>
  <style>
    .filter.active {
      font-weight: bold;
    }

    .group {
      padding: 1rem;
    }
  </style>
</head>

<body>
  <?php require "template/header.php" ?>

  <!-- Main -->
  <main>
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
      $custid = $_SESSION["custid"];
      $result = $link->query("SELECT status FROM user WHERE status=0 AND custid=$custid LIMIT 1");
      if ($result->num_rows == 1) {
        echo '<div style="padding: 1rem;">';
      } else {
        echo '<div style="padding:1rem; margin:9rem auto 0;">';
      }
    } else {
      echo '<div style="padding:1rem; margin:9rem auto 0;">';
    }

    ?>
    </div>
  </main>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block sidebar" style="padding: 2rem;">
        <div class="sidebar-sticky">
          <div style="padding: 1rem; padding-bottom:1.5rem; padding-right:1.5rem; position:relative;">
            <p style="text-align:left; margin-bottom: 0;">
              <strong>FILTERS</strong>
              <span style="float:right;">
                <a href="" id="resetbtn" style="font-size:10px">RESET</a>
              </span>
            </p>
          </div>
          <hr style="width: 90%; margin:auto; margin:top;">

          <div class="categories" style="padding: 1rem; padding-top:1.5rem; display:inline-block; position:relative;">
            <button id="categorybtn" style="border: none; background-color:transparent; width:100%; text-align:left">Categories</button>
            <nav>
              <ul class="dropdowncat" id="dropdowncategory">

                <?php

                $retrievecategory = $link->query("SELECT * FROM category WHERE catid=parentcatid");

                if (isset($_GET["category"])) {
                  $parentcatid = $_GET["category"];
                  echo '<li class="cat"><a href="product.php" class="catbtn">All Categories</a></li>';
                } else {
                  echo '<li class="cat"><a href="product.php" class="catbtn active">All Categories</a></li>';
                }
                while ($row = $retrievecategory->fetch_assoc()) {
                  if ($row["parentcatid"] == $parentcatid) {
                    $active = "active";
                  } else {
                    $active = "";
                  }
                  echo "<li class='cat" . $row["parentcatid"] . "'><a href='product.php?category=" . $row["parentcatid"] . "' class='catbtn $active'>" . $row["cat"] . "</a></li>";
                }
                ?>
              </ul>
            </nav>
            <div id="brandlist"></div>
          </div>
        </div>
      </nav>

      <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4" style="padding-top: 3rem ;">
        <div class="row">
          <div class="col-md-a3">
            <div class="input-group">
              <div class="form-outline">
                <input type="search" id="form1" class="form-control" />
              </div>
              <button type="button" class="btn btn-primary" disabled>
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">PRICE
            <span style="margin-left: 2rem;">
              <button style="width: 11rem;" class="filter" value=" pprice ASC">Low to High</button>&nbsp;
              <span style="border-left: 1px solid gray;"></span>&nbsp;
              <button class="filter" style=" margin-right: 5rem;" value=" pprice DESC">High to low</button>
            </span>
          </div>
          <div class="col">
            SORT BY
            <span style="margin-left: 2rem;">
              <button style="width: 11rem;" class="filter" value=" dateadded">Newest</button>&nbsp;
              <span style="border-left: 1px solid gray;"></span>&nbsp;
              <button style="width: 11rem;" class="filter" value=" amountsold">Popularity</button>&nbsp;
              <span style="border-left: 1px solid gray;"></span>&nbsp;
              <button class="filter" value=" sum(rate) DESC">Rating</button>
            </span>
          </div>
        </div>
        <div class="row">
          <ul>
            <?php
            $parentcat = $_GET["category"];
            $subcat = $_GET["subcategory"];
            $q = $link->query("SELECT * FROM category WHERE parentcatid=$parentcat");
            $counter = 0;
            if ($q->num_rows > 0) {
              while ($row = $q->fetch_assoc()) {
                if ($counter == 0) {
                  if (isset($_GET["subcategory"])) {
                    echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn' href='product.php?category=" . $row["catid"] . "'>" . $row["cat"] . "</a></li> >";
                  } else {
                    echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn active' href='product.php?category=" . $row["catid"] . "'>" . $row["cat"] . "</a></li> >";
                  }
                } else {

                  if ($subcat == $row["catid"]) {
                    echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn active' href='product.php?category=$parentcat&subcategory=" . $row["catid"] . "'>" . $row["cat"] . "</a></li>";
                  } else {
                    echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn'href='product.php?category=$parentcat&subcategory=" . $row["catid"] . "'>" . $row["cat"] . "</a></li>";
                  }
                }

                $counter = $counter + 1;
              }
            }
            ?>
          </ul>
        </div>
        <div class="row">
          <ul>
            <?php
            $activeall = $active = "";
            if (isset($_GET["brand"])) {
              $brandid = $_GET["brand"];
              $activeall = "";
              $active = "active";
            } else {
              $activeall = "active";
              $active = "";
            }
            if (isset($_GET["subcategory"])) {
              $parentcat = $_GET["category"];
              $cat = $_GET["subcategory"];
              $q = $link->query("SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE catid=$cat GROUP BY brandid");
              $q1 = $link->query("SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE catid=$cat");
              if ($q->num_rows > 0) {
                while ($row = $q1->fetch_assoc()) {
                  echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn $activeall' href='product.php?category=$parentcat&subcategory=$cat'>All Brands (" . $row["freq"] . ")</a></li> >";
                }
                while ($row = $q->fetch_assoc()) {
                  if ($row["brandid"] != $brandid) {
                    $active = "";
                  } else {
                    $active = "active";
                  }
                  echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn $active' href='product.php?category=$parentcat&subcategory=$cat&brand=" . $row["brandid"] . "'>" . $row["brand"] . " (" . $row["freq"] . ")</a></li>";
                }
              }
            } else {
              $parentcat = $_GET["category"];
              $q = $link->query("SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE parentcatid=$parentcat GROUP BY brandid");
              $q1 = $link->query("SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE parentcatid=$parentcat");
              if ($q->num_rows > 0) {
                while ($row = $q1->fetch_assoc()) {
                  echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn $activeall' href='product.php?category=$parentcat'>All Brands (" . $row["freq"] . ")</a></li> >";
                }
                while ($row = $q->fetch_assoc()) {
                  if ($row["brandid"] != $brandid) {
                    $active = "";
                  } else {
                    $active = "active";
                  }
                  echo "<li style='display: inline-block;margin: 0 10px;'><a class='catbtn $active' href='product.php?category=$parentcat&brand=" . $row["brandid"] . "'>" . $row["brand"] . " (" . $row["freq"] . ")</a></li>";
                }
              }
            }
            ?>
          </ul>
        </div>

        <!-- PRODUCT LIST -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3" style="item-align:center">
          <div class="container">
            <div id="productlist">
              <?php
              $parentcat = $_GET["category"];
              $cat = $_GET["subcategory"];
              $brand = $_GET["brand"];
              $sql = "SELECT * FROM product ";
              if (isset($_GET["category"])) {
                $sql = $sql . "JOIN category ON category.catid=product.pcatid WHERE parentcatid=$parentcat ";
                if (isset($_GET["subcategory"])) {
                  $sql = $sql . "AND pcatid=$cat ";
                }

                if (isset($_GET["brand"])) {
                  $sql = $sql . " AND pbrandid=$brand ";
                }
              }
              $getnumofresult = $link->query($sql);
              $sql = $sql . "limit 0,9";

              $q = $link->query($sql);
              if ($q->num_rows > 0) {
                $numrows = $q->num_rows;
                $counter = 0;
                while ($row = $q->fetch_assoc()) {
                  if ($counter == 0) {
                    echo "<div class='row'>";
                  }
                  echo "<div class='col-sm shadow 123' style='text-align:center;'>";
                  echo "<a href='productdetail.php?pid=" . $row["pid"] . "'><img src='admin/productimage/" . $row["picture"] . "' alt=''></a>";
                  echo "<div class='productinfo'>";
                  echo "<h4>" . $row["pname"] . "</h4>";

                  $price = number_format($row["pprice"], 2, '.', '');

                  echo "<p>RM $price</p>";
                  echo "</div>";

                  echo "<div class='productbtn'>";
                  echo "<button class='addbtn'><i class='fas fa-plus'></i></button>";
                  echo "<input style='margin:0 0.5rem 0 0.5rem' type='number' id='quantity" . $row["pid"] . "' max='99' maxlength='2' value='1' oninput='javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);'>";
                  echo "<button class='minusbtn'><i class='fas fa-minus'></i></button>";
                  echo "<div style='margin-top: 1rem;'>";
                  echo "<button style='margin-right:0.5rem' value='" . $row["pid"] . "' class='addtocartbutton'>Add to cart&nbsp;&nbsp;&nbsp;<i class='fas fa-cart-plus'></i></button>";
                  echo "<button class='addtolistbtn' value='" . $row["pid"] . "'><i class='fas fa-heart'></i></i></button>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                  $counter = $counter + 1;
                  $numrows = $numrows - 1;
                  if ($counter == 3 || $numrows == 0) {
                    $counter = 0;
                    echo "</div>";
                  }
                }
              }
              ?>
            </div>
            <div class="row justify-content-center" id="pagenum">
              <?php
              $numofresult = $getnumofresult->num_rows;
              echo "<ul style='text-align: center;'>";
              for ($i = 0; $i < ceil($numofresult / 9); $i++) {
                echo "<li style='display: inline-block;margin: 0 10px;'><button class='pagination' value='$i'>" . $i + 1 . "</button></li>";
              }
              echo "</ul>";
              ?>
            </div>
          </div>


        </div>
      </main>
    </div>

  </div>

  <div class="modal fade" id="shoppinglist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Shopping List</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <?php 
            if(isset($_SESSION["custid"])){
              echo '<div class="row">
              <div class="col-9" style="width:90%;">
                <input id="shoppinglistname" type="text" name="shoppinglist" placeholder="Enter new shopping list.." class="form-control name_list">
              </div>
              <div class="col-3" style="width:10%;">
                <button style="font-size:2rem;" type="button" id="addshoppinglistbtn" class="btn btn-success">+</button>
              </div>
            </div>';
            }else{
              echo 'Please login to continue....';
            }
          ?>
          <div class="col-12">
            <div class="group">
              <table class="table table-borderless">
                <tbody style="vertical-align: middle;" id="shoppinglistmodal">

                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php require "template/footer.php"?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


  <!-- Glidejs Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

  <!-- Custom Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/index.js"></script>
  <script src="js/product.js"></script>
</body>

</html>