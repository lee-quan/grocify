<?php
session_start();
require "template/connect.php";

if(! isset($_SESSION["custid"])){
    header("location: login.php");
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
    <style>
        button {
            border: none;
            background-color: transparent;
            padding: 1rem;
        }
    </style>
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
            } else {
                echo '<div style="padding:1rem; margin:9rem auto 0;">';
            }
        } else {
            echo '<div style="padding:1rem; margin:9rem auto 0;">';
        }

        ?>
        <div class="shadow" style="margin: 4rem; padding:3rem;">
            <h1>My Shopping List <button id="addnewshoppinglistbtn"><i class="fas fa-plus"></i></button></h1>

            <hr>
            <table>
                <table class="table table-borderless">
                    <tbody style="vertical-align: middle;" id="shoppinglistpage">


                    </tbody>
                </table>
            </table>
        </div>
        </div>



    </main>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-9" style="width:90%;">
                            <input id="shoppinglistname" type="text" name="shoppinglist" placeholder="Enter new shopping list.." class="form-control name_list">
                        </div>
                        <div class="col-3" style="width:10%;">
                            <button style="font-size:2rem;" type="button" id="addshoppinglistbtn" class="btn btn-success">+</button>
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
    <script src="./js/product.js"></script>
    <script src="./js/index.js"></script>
</body>

</html>