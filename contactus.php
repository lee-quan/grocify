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
    <link rel="stylesheet" href="./css/styles.css">

    <style>
        .accordion {
            max-width: 100%;
        }

        .contentbx {
            position: relative;
        }

        .label {
            position: relative;
            padding: 10px;
            background-color: var(--greyalt);
            cursor: pointer;
            border: 1px solid #FF6F61;
            border-radius: 50px;
        }

        .row {
            text-align: center;
            /* margin-top: 30px; */
            margin-bottom: 30px;
        }

        .accordion .contentbx.active .label::before {
            content: '\2796'
        }

        .accordion .contentbx .label::before {
            content: '\02795';
            top: 50%;
            position: absolute;
            right: 20px;
            transform: translateY(-50%);
            font-size: 1.4rem;
        }

        .content {
            position: relative;
            padding: 10px;
            background-color: var(--white);
            overflow: hidden;
            opacity: 0;
            max-height: 0;
            /* overflow-y: auto; */
            transition: 0.3s ease-in-out;
            font-size: 1.3rem;
        }

        .active .content {
            opacity: 1;
            max-height: 100px;
        }
        body{
            background-color: rgba(237, 171, 161);
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

            <main class="main">
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.9008927214313!2d101.65165271431339!3d3.120909954197014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb47024217187%3A0x1e85ebc65d47d641!2sUniversiti%20Malaya!5e0!3m2!1sen!2smy!4v1618758327298!5m2!1sen!2smy" width="100%" height="600" style="border:1px solid black;" allowfullscreen="true" loading="lazy"></iframe>
                </div>


                <div class="container">
                    <div class="row">
                        <div class="">
                            <h3>FREQUENTLY ASKED QUESTIONS</h3>
                            <div class="accordion">
                                <div class="contentbx">
                                    <div class="label">Which area does Grocify deliver to?</div>
                                    <div class="content">
                                        <p>We deliver to all states within Peninsular Malaysia via courier services.</p>
                                    </div>
                                </div>


                                <div class="contentbx">
                                    <div class="label">Where can I view my sales receipt?</div>
                                    <div class="content">
                                        <p>After making payment your receipt and invoice is automatically emailed to the
                                            email
                                            address your provided during check out. Kindly check the spam/junk folder if you
                                            can’t find it in your inbox.</p>
                                    </div>
                                </div>


                                <div class="contentbx">
                                    <div class="label">When will I receive my order?</div>
                                    <div class="content">
                                        <p>Our business hours are Monday – Saturday, 8am – 6pm. Your orders will be
                                            processed
                                            immediately. You will be notified prior to delivery time. You can check your
                                            order
                                            status <a href="#">HERE</a>.</p>
                                    </div>
                                </div>


                                <div class="contentbx">
                                    <div class="label">What is the Refund/Exchange policy?</div>
                                    <div class="content">
                                        <p>After receiving your order and payment you may cancel your order by contacting
                                            our
                                            Customer Service agent 1 hour before delivery time to cancel. All refund will be
                                            processed within 7 – 14 days and bank in to account of origin.
                                            <br>
                                            You are to check all goods upon arrival to ensure there are no defects and/or
                                            expired products. Once you have accepted the goods from our delivery driver
                                            there
                                            will be no exchange nor refund available to you.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
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

<script>
    var acc = document.getElementsByClassName("contentbx");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle('active')
        })
    }
</script>