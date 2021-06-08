<?php

session_start();
require_once "template/connect.php";

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

</head>


<body>

    <div class="container-fluid">
        <div class="row">

            <?php
            include "template/header.php";

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                $custid = $_SESSION["custid"];
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

            <h2 class="profile">My Profile <small style="font-size: 1.5rem; color:gray">Manage and protect your account.</small><a href="editdetail.php" class="btn btn-primary btn-sm" style="float:right;">Edit</a></h2>
            
            <hr>
            <br>
            <?php 
            
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

                    <div class="row">
                        <div class="col-6" style="text-align:right; padding: 1rem;">
                                    <h3>First Name: </h3><br>
                                    <h3>Last Name: </h3><br>
                                    <h3>Email: </h3><br>
                                    <h3>Gender: </h3><br>
                                    <h3>Date of Birth: </h3><br>
                        </div>
                        <div class="col-6" style="text-align:left; padding: 1rem;">
                        <?php
                            $id = $_SESSION["custid"];
                            $result = $link->query("SELECT * FROM user WHERE custid=$id");
                            if ($result->num_rows == 1) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<h3>".$row["firstname"] ."</h3>". "<br>" 
                                    . "<h3>".$row["lastname"] ."</h3>". "<br>" 
                                    . "<h3>".$row["email"] ."</h3>". "<br>" 
                                    . "<h3>".$row["gender"]."</h3>". "<br>" 
                                    . "<h3>".$row["dateofbirth"] ."</h3>". "<br>";
                                }
                            }

                            ?>
                        </div>
                    </div>

                </main>
            </form>
            </main>
            <?php require "template/footer.php"?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


            <!-- Glidejs Script -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

            <!-- Custom Script -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="./js/index.js"></script>
</body>

</html>