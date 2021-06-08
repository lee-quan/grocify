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
    <style>
        .modal table {
            display: flex;
            flex-flow: column;
            /* height: 100%; */
            width: 100%;
        }

        .modal table thead {
            flex: 0 0 auto;
            width: calc(100% - 0.9em);
        }

        .modal table tbody {
            /* body takes all the remaining available space */
            flex: 0 0 auto;
            display: block;
            overflow-y: scroll;
        }

        .modal table tbody tr {
            width: 100%;
        }

        .modal table thead,
        .modal table tbody tr {
            display: table;
            table-layout: fixed;
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


            <h2 class="profile">Orders</h2>

            <hr>
            <br>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Order At</th>
                            <th scope="col">Shipping Method</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="max-width: 20%;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ordertable">

                    </tbody>
                </table>
            </div>
            </main>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <!-- Modal -->
            <div class="modal fade" id="order_List" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Order Details</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="orderhead">

                            <h4 class="modal-title" id="ordertitle">Order ID - </h4>
                            <h4 id="ordertime">Order Created At: 2020/20/10 20:10:20</h4>
                            <h4 id="orderdeliverto">Delivered to: </h4>

                            <table class="table">
                                <thead style="text-align: center;">
                                    <tr style="color: gray; font-size:smaller   ">
                                        <th style="width: 16rem;"><small>PRODUCT DETAILS</small></th>
                                        <th><small>QUANTITY</small></th>
                                        <th><small>PRICE</small></th>
                                        <th><small>TOTAL</small></th>
                                    </tr>
                                </thead>
                                <tbody id="orderproductlist" style=" overflow-y: auto; overflow-x: hidden; height:376px">
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php require "template/footer.php"?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


            <!-- Glidejs Script -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

            <!-- Custom Script -->

            <script src="./js/index.js"></script>
            <script src="./js/profile.js"></script>
</body>

</html>