<?php

session_start();
require_once "template/connect.php";
$id = $_SESSION["custid"];
if(! isset($_SESSION["custid"])){
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/myaccount.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/bank.css">
    <style>
        .form-control{
            display: inline-table;
        }

        button{
            border:none;
            background-color: transparent;
            font-size:small;
            text-decoration-line: underline;
        }
    </style>
</head>


<body>

    <div class="container-fluid">
        <div class="row">

            <?php
            include "template/header.php";

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                $result = $link->query("SELECT status FROM user WHERE status=0 AND custid=$custid LIMIT 1");
                if ($result->num_rows == 1) {
                    echo '<div style="padding: 1rem;"></div>';
                } else {
                    echo '<div style="padding:1rem; margin:9rem auto 0;"></div>';
                }
            } else {
                echo '<div style="padding:1rem; margin:9rem auto 0;"></div>';
            }
            include "template/sidebar.php";
            ?>
            <div style="position: relative;">
                <h2 class="profile">Payment Method
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">
                        Add New Card
                    </button>
                </h2>
            </div>

            <hr>
            <div id="cardcontainer"></div>
 
        </div>
    </div>

</main>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment Method</h5>
                    </div>
                    <div class="modal-body">
                        <div class="innerbody">
                            <div class="message">
                                <p>Your card details are protected. <i class="fas fa-shield-alt" id="shield"></i><br>
                                    <span>We partner with CyberSource, a VISA company to ensure that your card details are kept safe and secure. Shopee will not have access to your card info.</span>
                                </p>

                            </div>
                            <div class="carddetails">
                                <h3>Card Details</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <input class="form-control" id="nameoncard" type="Text" name="nameoncard" class="cardinput" placeholder="Name on Card">
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control"  id="cardnumber1" type="text" placeholder="xxxx" style="width: 45px;" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        <input class="form-control"  id="cardnumber2" type="text" placeholder="xxxx" style="width: 45px;" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        <input class="form-control"  id="cardnumber3" type="text" placeholder="xxxx" style="width: 45px;" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        <input class="form-control"  id="cardnumber4" type="text" placeholder="xxxx" style="width: 45px;" maxlength="4" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                        <!-- <i class="fab fa-cc-mastercard" id="mastercard"></i>
                                    <i class="fab fa-cc-visa" id="visa"></i>
                                    <i class="fab fa-cc-amex" id="amex"></i> -->
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control"  style="width: 117px;"  id="expirydate" type="text" name="expirydate" class="cardinput" placeholder="Expiry Date (MM/YY)">
                                        <input class="form-control"   id="cvv" type="text" name="cvv" class="cardinput" placeholder="cvv" style="width: 45px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input class="btn btn-primary" value="Add New Card" id="addnewcardbtn" >
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
    <script src="./js/index.js"></script>
    <script src="./js/profile.js"></script>
</body>

</html>