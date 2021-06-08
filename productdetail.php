<?php
session_start();
require "template/connect.php";

if (isset($_GET["pid"])) {
    $pid = $_GET["pid"];
}
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
        <div class="container-fluid">
            <div class="row justify-content-center" style="margin-bottom: 2rem;">

                <div class="col-xl-11" style="height:fit-content">

                    <div class="row justify-content-left border-bottom">
                        <div class="col" id="imagebox">
                            <!-- <img class='shadow' style='height:540px; width:540px; margin:0 0 3rem 5rem;' src='admin/productimage/"+value.picture+"' alt=''> -->
                        </div>
                        <div class="col-md-6" id="productbox" style="padding: 1rem 0 0 1rem;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <h4 style="text-align: center;"><strong>REVIEWS</strong></h4>
                <div class="container-fluid" style="padding: 2rem 4rem 1rem 4rem;">
                    <div class="row">
                        
                        <div class="col border-end" id="commentsection">
                            <!-- <h4><strong>REVIEWS</strong></h4>
                            <div class="comment" style="padding: 1rem 0 2rem 0; position:relative">
                                <div style="display:inline-block;vertical-align:top; margin-right:20px;">
                                    <img src="images/tacc1157_05_faceright_10k_rgb.jpeg" style="width: 60px; height:60px; border-radius:50%;" alt="">
                                </div>
                                <div style="display:inline-block; max-width:570px">
                                    <div class="star-ratings-css comment">
                                        <div class="star-ratings-css-top" style="width: 84%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>

                                        <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                    </div>
                                    <p>message message messagemessage message message messagemessage message message messagemessage message message messagemessage message message messagemessage message message messagemessage message message messagemessage message message messagemessage message message messagemessage</p>
                                </div>
                                <div style="display:inline-block; width:49rem; text-align:right; position:absolute; top:1rem; right:1rem">
                                    <p style="font-size: 1.2rem;"><strong>KOK WE LONG </strong><span style="color: gray;">--<em> 2019-04-05</em></span></p>
                                </div>
                            </div>
                            <hr> -->

                        </div>
                        <div class="col" style="line-height: 5rem;">
                            <h4><strong>ADD A REVIEW</strong></h4>
                            <div style="padding-left: 2rem;">

                                <?php
                                if (isset($_SESSION["custid"])) {
                                    echo '<div style="display: inline-block;">
                                     Your Rating:
                                 </div>
                                 <div id="full-stars-example-two" style="display: inline-block;">
                                     <div class="rating-group">
                                         <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
                                         <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                         <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                                         <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                         <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                                         <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                         <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                                         <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                         <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                                         <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                         <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                                     </div>
                                 </div>
                                 <div>
                                     Your Review
                                 </div>
                                 <div>
                                     <textarea name="" id="commentforreview" cols="70" rows="5" style="line-height: 2rem; padding: 1rem;"></textarea>
                                 </div>
                                 <button id="submitreviewbtn" style="border:none; background-color:rgba(237, 171, 161); padding:1rem; border-radius:10%; line-height:2rem" value="' . $pid . '">
                                     SUBMIT
                                 </button>';
                                } else {
                                    echo 'Please login to continue...';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
              echo `<div class="row">
              <div class="col-9" style="width:90%;">
                <input id="shoppinglistname" type="text" name="shoppinglist" placeholder="Enter new shopping list.." class="form-control name_list">
              </div>
              <div class="col-3" style="width:10%;">
                <button style='font-size:2rem;' type="button" id="addshoppinglistbtn" class="btn btn-success">+</button>
              </div>
            </div>`;
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