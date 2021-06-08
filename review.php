<?php

session_start();
require_once "template/connect.php";
$id = $_SESSION["custid"];

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
        .container1 {
            background-color: rgb(255 237 235);
            width: 100%;
            padding-top: 3rem;
            margin: 0 auto;
            position: relative;
            padding-bottom: 3rem;
        }

        #contact input[type="text"],
        #contact input[type="email"],
        #contact input[type="tel"],
        #contact input[type="url"],
        #contact textarea,
        #contact button[type="submit"] {
            font: 400 12px/16px "Roboto", Helvetica, Arial, sans-serif;
        }

        #contact {
            margin-bottom: 3rem;
            width: 60%;
            background: #F9F9F9;
            padding: 25px;
            margin: auto;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        #contact h3 {
            display: block;
            font-size: 30px;
            font-weight: 300;
            margin-bottom: 10px;
        }

        #contact h4 {
            margin: 5px 0 15px;
            display: block;
            font-size: 13px;
            font-weight: 400;
        }

        fieldset {
            border: medium none !important;
            margin: 0 0 10px;
            min-width: 100%;
            padding: 0;
            width: 100%;
        }

        #contact input[type="text"],
        #contact input[type="email"],
        #contact input[type="tel"],
        #contact input[type="url"],
        #contact textarea {
            width: 100%;
            border: 1px solid #ccc;
            background: #FFF;
            margin: 0 0 5px;
            padding: 10px;
        }

        #contact input[type="text"]:hover,
        #contact input[type="email"]:hover,
        #contact input[type="tel"]:hover,
        #contact input[type="url"]:hover,
        #contact textarea:hover {
            -webkit-transition: border-color 0.3s ease-in-out;
            -moz-transition: border-color 0.3s ease-in-out;
            transition: border-color 0.3s ease-in-out;
            border: 1px solid #aaa;
        }

        #contact textarea {
            height: 100px;
            max-width: 100%;
            resize: none;
        }

        #contact button[type="submit"] {
            cursor: pointer;
            width: 100%;
            border: none;
            background: #26272b;
            color: #FFF;
            margin: 0 0 5px;
            padding: 10px;
            font-size: 15px;
        }

        #contact button[type="submit"]:active {
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .copyright {
            text-align: center;
        }

        #contact input:focus,
        #contact textarea:focus {
            outline: 0;
            border: 1px solid #aaa;
        }

        ::-webkit-input-placeholder {
            color: #888;
        }

        :-moz-placeholder {
            color: #888;
        }

        ::-moz-placeholder {
            color: #888;
        }

        :-ms-input-placeholder {
            color: #888;
        }

        .rating {
            position: absolute;
            margin-left: 100px;
            display: flex;
            flex-direction: row-reverse;
            margin-top: 10px;
            top: 24rem;
            left: 40rem;
        }

        .rating input {
            display: none;
        }

        .rating label {
            position: relative;
            width: 0;
            height: 120px;
            cursor: pointer;
            transition: 0.5s;
            /* filter: grayscale(1);     */
            text-align: center;
            opacity: 0;
            color: black;
        }

        .rating:hover label {
            width: 100px;
            opacity: 0.2;
        }

        .rating input:hover+label h4,
        .rating input:checked+label h4 {
            opacity: 1;
            width: 100px;
            /* filter: grayscale(0); */
            color: black;
        }

        .rating input:hover+label,
        .rating input:checked+label {
            transform: translateY(0) scale(1);
            opacity: 1;
            color: black;
        }

        .rating label i {
            width: 90px;
        }

        .rating .far {
            font-size: 50px;
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
            ?>

            <main>
                <div class="container1">
                    <div id="contact">
                        <h3>Grocify Feedback Form</h3>
                        <div class="rating">
                            <input type="radio" name="emoji" id="emoji5" value="5">
                            <label for="emoji5">
                                <i class="far fa-angry" id="angry"></i>
                                <h4>Angry</h4>
                            </label>
                            <input type="radio" name="emoji" id="emoji4" value="4">
                            <label for="emoji4">
                                <i class="far fa-frown" id="sad"></i>
                                <h4>Sad</h4>
                            </label>
                            <input type="radio" name="emoji" id="emoji3"  value="3">
                            <label for="emoji3">
                                <i class="far fa-meh" id="neutral"></i>
                                <h4>Neutral</h4>
                            </label>
                            <input type="radio" name="emoji" id="emoji2" value="2" >
                            <label for="emoji2">
                                <i class="far fa-smile-beam" id="happy"></i>
                                <h4>Happy</h4>
                            </label>
                            <input type="radio" name="emoji" id="emoji1" checked value="1">
                            <label for="emoji1">
                                <i class="far fa-laugh-squint" id="satisfactory"></i>
                                <h4>Satisfactory</h4>
                            </label>
                        </div>
                        <fieldset>
                            <input id='namefb' placeholder="Your name" type="text" tabindex="1" required autofocus>
                        </fieldset>
                        <fieldset>
                            <input id='emailfb' placeholder="Your Email Address" type="email" tabindex="2" required>
                        </fieldset>
                        <fieldset>
                            <input id='phonenumfb' placeholder="Your Phone Number (optional)" type="tel" tabindex="3" required>
                        </fieldset>
                        <label style="font-size: 1.5rem">How are you feeling now?</label>
                        <label style="position: absolute; top: 31rem;left: 31rem; font-size: 1.5rem;">Tell us why..</label>
                        <fieldset style="margin-top: 5rem;">
                            <textarea id='messagefb' placeholder="Type your message here.." tabindex="5" required></textarea>
                        </fieldset>
                        <fieldset>
                            <button name="submit" type="submit" id="submitfeedbackbtn" data-submit="...Sending">Submit</button>
                        </fieldset>
                        <p class="copyright"><a href="index.html" title="">GROCIFY</a></p>
                    </div>
                </div>




            </main>
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