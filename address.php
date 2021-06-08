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
    <link rel="stylesheet" href="./css/address.css">

    <style>
        .form-control {
            display: inline-table;
            margin: 1rem 0 1rem 0;

        }
        input{
            height: 4rem;   
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
            <h2 class="profile">My Address
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="float: right;">
                    Add New Address
                </button>
            </h2>

            <hr>

            <div id="addresscontainer"></div>


        </div>
    </div>

    </main>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
                    </div>
                    <div class="modal-body">
                        <div class="innerbody">
                            <div class="addressdetails row">
                                <div class="col-12">
                                    <input class="form-control" id="name" type="Text" name="name" class="addressinput" placeholder="Name" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="address" name="address" class="addressinput" placeholder="Address" cols="50" rows="4"></textarea>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="zip" type="text" name="zip" class="addressinput" placeholder="Postal Code or Zip (Optional)">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="country" type="text" name="country" class="addressinput" placeholder="Country">
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="phonenumber" type="text" name="tel" class="addressinput" placeholder="Phone Number">
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="addnewaddressbtn" class="btn btn-primary">Add New Address</button>
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