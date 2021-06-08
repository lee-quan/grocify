<?php
session_start();
require "template/connect.php";

$custid = $_SESSION["custid"];

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
        table {
            display: flex;
            flex-flow: column;
            /* height: 100%; */
            width: 100%;
        }

        table thead {
            flex: 0 0 auto;
            width: calc(100% - 0.9em);
        }

        table tbody {
            /* body takes all the remaining available space */
            flex: 0 0 auto;
            display: block;
            overflow-y: scroll;
        }

        table tbody tr {
            width: 100%;
        }

        table thead,
        table tbody tr {
            display: table;
            table-layout: fixed;
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

    <div class="row shadow" style="background-color: white;margin: 3rem;">
        <div class="col-12 col-md-8">
            <div style="padding: 3rem 3rem 1rem 3rem;">
                <h3>
                    <p style="text-align:left; margin-bottom: 2rem;">
                        <strong>Shopping Cart</strong>
                        <span style="float:right;" class="numberofitems">

                        </span>
                    </p>
                </h3>
                <hr>
            </div>
            <div class="producttable" style="padding: 0 3rem 2rem 3rem;">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead style="text-align: center;">
                            <tr style="color: gray; font-size:smaller   ">
                                <th style="width: 35rem;"><small>PRODUCT DETAILS</small></th>
                                <th style="width: 16rem;"><small>QUANTITY</small></th>
                                <th><small>PRICE</small></th>
                                <th><small>TOTAL</small></th>
                            </tr>
                        </thead>
                        <tbody id="cartlist" style="    overflow-y: auto; overflow-x: hidden; height:376px">
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="" style="padding:3rem; color:black"><i class="fas fa-arrow-left"></i>&nbsp;Continue Shopping</a>
        </div>
        <div class="col-6 col-md-4" style="background-color: #f1f1f1; padding: 3rem 3rem 1rem 3rem;">
            <div>
                <h3>
                    <p style=" text-align:left; margin-bottom: 2rem;">
                        <Strong>Order Summary</Strong>
                    </p>
                </h3>
                <hr>
            </div>
            <div style="padding: 1rem 0 2rem 0;">
                <p style="text-align:left; margin-bottom: 2rem; padding-top: 1rem;">
                    <strong class="numberofitems"></strong>
                    <span style="float:right;" id="totalcost">
                    </span>
                </p>
                <div style="padding: 0 0 2rem 0; margin: 3rem 0 1rem 0;" class="form-group">
                    <h5 style="padding: 1rem 0 1rem;"><strong>SHHIPING</strong></h5>
                    <form name="ship" id="ship">
                        <select name="shippingmethod" id="shippingmethod" class="form-select">
                            <option value="0" selected>Standard Delivery (7 Days) - RM 4.50</option>
                            <option value="1">Economy Delivery (20+ Days) - RM 0.50</option>
                        </select>
                    </form>
                </div>
                <div style="padding: 0 0 2rem 0;" class="form-group">
                    <h5 style="padding: 1rem 0 1rem;"><strong>PROMO CODE</strong></h5>
                    <input type="text" class="form-control">
                </div>

                <button style="border: none; background-color:rgba(237, 171, 161); padding:1rem; color:white">APPLY</button>
            </div>
            <hr style="margin: 2rem 0 2rem 0">
            <div style="padding-top: 2rem;">
                <button type="button" class="btn btn-lg btn-block" style="width: 100%; background-color:black; color:white; padding:1rem; margin-bottom: 7rem;;" data-bs-toggle="modal" data-bs-target="#exampleModal">CHECK OUT</button>
            </div>
        </div>

    </div>

    <footer id="footer" class="section footer">
        <div class="container">
            <div class="footer-container">
                <div class="footer-center">
                    <h3>EXTRAS</h3>
                    <a href="#">Brands</a>
                    <a href="#">Gift Certificates</a>
                    <a href="#">Affiliate</a>
                    <a href="#">Specials</a>
                    <a href="#">Site Map</a>
                </div>
                <div class="footer-center">
                    <h3>INFORMATION</h3>
                    <a href="#">About Us</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Site Map</a>
                </div>
                <div class="footer-center">
                    <h3>MY ACCOUNT</h3>
                    <a href="#">My Account</a>
                    <a href="#">Order History</a>
                    <a href="#">Wish List</a>
                    <a href="#">blogletter</a>
                    <a href="#">Returns</a>
                </div>
                <div class="footer-center">
                    <h3>CONTACT US</h3>
                    <div>
                        <span>
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        42 Dream House, Dreammy street, 7131 Dreamville, USA
                    </div>
                    <div>
                        <span>
                            <i class="far fa-envelope"></i>
                        </span>
                        company@gmail.com
                    </div>
                    <div>
                        <span>
                            <i class="fas fa-phone"></i>
                        </span>
                        456-456-4512
                    </div>
                    <div>
                        <span>
                            <i class="far fa-paper-plane"></i>
                        </span>
                        Dream City, USA
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 shadow" style="padding: 3rem; margin-bottom:3rem;">
                        <div class="row addressdefault show" id="addressdefault" style="margin-bottom: 1rem;">
                            <h3 style="text-align: left;"><i class="fas fa-map-marker-alt"></i>&nbsp;<strong>Delivery Address</strong></h3>
                            <div class="col-10" id="addressdisplay">
                                <p style="padding: 1rem 0;">
                                    <?php
                                    $defaultaddress = $link->query("SELECT * FROM address WHERE custid=$custid AND defaultaddress=1");
                                    while ($row = $defaultaddress->fetch_assoc()) {
                                        echo $row["name"] . " " . $row["tel"] . " " . $row["address"] . ", " . $row["zip"] . ", " . $row["country"];
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-1">
                                <p style="padding: 1rem 0"><small style="color: gray;"><strong>Default</strong></small></p>
                            </div>
                            <div class="col-1">
                                <div style="display: block;">
                                    <button id="changeaddressbtn" style="padding: 1rem;background-color:pink; border: 1px solid pink; color:black;">change</button>
                                </div>
                            </div>
                        </div>
                        <div class="row addressedit" id="addressedit" style="margin-bottom: 1rem;">
                            <h3 style="text-align: left;"><i class="fas fa-map-marker-alt"></i>&nbsp;<strong>Delivery Address</strong>
                                <span style="float:right"><button>Manage Addresses</button></span>
                                <?php
                                $optionaddress = $link->query("SELECT * FROM address WHERE custid=$custid ORDER BY defaultaddress DESC");
                                while ($row = $optionaddress->fetch_assoc()) {
                                    $selected = "";
                                    if ($row["defaultaddress"] == 1) {
                                        $selected = "checked";
                                    }
                                    $string = $row["name"] . " " . $row["tel"] . " " . $row["address"] . ", " . $row["zip"] . ", " . $row["country"];
                                    echo "
                                    <div class='form-check' style='padding:1rem;'>
                                        <input class='form-check-input' type='radio' name='selectaddress' id='exampleRadios1' value='" . $row["addressid"] . "' $selected>
                                        <label class='form-check-label' for='exampleRadios1'>
                                            $string;
                                        </label>
                                    </div>";
                                }
                                ?>

                                <button id='submitaddressbtn' style="margin: 2rem 1rem; background-color:pink; border: 1px solid pink; color:black;">SUBMIT</button><button id='canceladdressbtn' style="margin: 2rem 1rem; background-color:white; border: 1px solid ; color:black;">CANCEL</button>
                            </h3>
                        </div>
                    </div>
                    <div class="col-12 shadow" style="padding: 3rem;">
                        <?php
                        function maskCreditCard($cc)
                        {

                            $cc_length = strlen($cc);
                            $finalcc = "";

                            for ($i = 0; $i < $cc_length - 4; $i++) {

                                if ($cc[$i] == '-') {
                                    $finalcc = $finalcc . '<i class="fas fa-minus"></i>';
                                } else {
                                    $finalcc = $finalcc . '<i class="fas fa-star-of-life"></i> ';
                                }
                            }

                            for ($i = $cc_length - 4; $i < $cc_length; $i++) {
                                $finalcc = $finalcc . $cc[$i];
                            }

                            return $finalcc;
                        }
                        $sql = "SELECT * FROM paymentmethod WHERE custid=$custid AND defaultcard=1";
                        $result = $link->query($sql);
                        $rowcnt = $result->num_rows;
                        if ($rowcnt == 0) {
                            echo '<h3 style="text-align: left;"><i class="fas fa-wallet"></i><strong>Payment Method</strong></h3>' . "<div style='text-align:center;'><span>You do not have any card. Go add a new card now. " . '<small><a href="bank.php" style="margin-left: 10rem; padding:1rem;background-color:pink; border: 1px solid pink; color:black;">Add New Card</a></small>' . "</span></div>";
                        } else {
                            echo '<h3 style="text-align: left;"><i class="fas fa-wallet"></i><strong>Payment Method</strong><small><a href="bank.php" style="margin-left: 10rem; padding:1rem;background-color:pink; border: 1px solid pink; color:black;">Change</a></small></h3>';
                            while ($row = $result->fetch_assoc()) {
                                $disable = "";
                                $default = "";
                                if ($row["defaultcard"] == 1) {
                                    $disable = "disabled";
                                    $default = "<p style='text-align:right; float :right; color: green;'>default</p>";
                                }
                                $mask = maskCreditCard($row["cardnumber"]);
                                echo "<div class='cardrow' style='display: flex; margin: 20px; padding: 4rem; background-color:#f8f8f8;'>
                                <div class='col1' style='flex: 20%; margin:auto;'>
                                <input type='hidden' value='".$row["paymentid"]."' id='paymentid'>
                                <img src='images/visa.png'>
                                </div>
                                <div class='col2' style='flex:40%; margin:auto;'>";
                                echo $mask;
                                echo "</div>";
                            }
                            echo $row["cardnumber"];
                        }
                        ?>
                    </div>
                </div>
                <div style="width: 40%; text-align:right; float:right; padding:3rem;">
                    <div class="row">
                        <div class="col-8" style="padding: 0;">
                            <p>Subtotal</p>
                            <p class="border-bottom">Shipping Total</p>
                            <p style="margin-top: 2rem;">Total Payment</p>

                        </div>
                        <div class="col-1" style="padding: 0;">
                            <p>RM</p>
                            <p class="border-bottom">RM</p>
                            <p style="margin-top:2rem;">RM</p>
                        </div>
                        <div class="col-3" style="padding: 0;">
                            <p id="subtotalcost"></p>
                            <p id="shippingcost" class="border-bottom"></p>
                            <p id="totalpayment" style="margin-top:1.6rem; font-size: 2rem"></p>
                        </div>
                    </div>
                    <button id="placeorder" class="btn btn-lg btn-block" style="width: 100%; background-color: black; color: white; padding: 1rem;">Place Order</button>
                        <button id="orderplace">Place Order</button>
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

<script>


</script>