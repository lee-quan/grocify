<?php

session_start();
require_once "template/connect.php";


$id = $_SESSION["custid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $realpassword = $password = $newpassword = $newconfirmpassword = "";
    $password_err = $newpassword_err = $newconfirmpassword_err = "";
    $password = $_POST["password"];
    $newpassword = $_POST["newpassword"];
    $newconfirmpassword = $_POST["newconfirmpassword"];
    $sql = "SELECT password FROM user WHERE custid=$id";
    $result = $link->query($sql);
    while ($row = $result->fetch_assoc()) {
        $realpassword = $row["password"];
    }

    if (password_verify($password, $realpassword)) {
        if ($newpassword == $newconfirmpassword) {  
            if (strlen($newpassword) < 6) {
                $newpassword_err = "Password must have at least 6 characters.";
            } else {
                $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $updatenewpassword = $link->query("UPDATE user SET password='$param_password' WHERE custid=$id");
                if ($updatenewpassword) {
                }
            }
        } else {
        }
        // $2y$10$YwrAcHTgVAXYtELMh9hFdun0qUB3sOfMz7Z9D66A5LtCCHVig54X.
        // $2y$10$YjxmFlh6ReKUyYmRUHZTtO4NjztMhJvsutKerYnp0.8E3gGRNMJEu
    } else {
        echo $realpassword;
    }
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


            <h2 class="profile">Change Your Password</h2>

            <hr>
            <br>
            <!-- <form method="POST" class="personalform"> -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

                <div class="row">
                    <div style="margin: auto; text-align:center;">
                        <form method="post" class="personalform">
                            <ol>
                                <li style="padding: 2rem;">
                                    <label for="FirstName">Current Password:</label>
                                    <input type="password" size="20" name="password" value="">
                                </li>
                                <li style="padding: 1rem;">
                                    <label for="LastName">New Password:</label>
                                    <input type="password" size="20" name="newpassword" value="">
                                </li>
                                <li style="padding: 1rem;">
                                    <label for="Telephone">Confirm Password:</label>
                                    <input type="password" size="20" name="newconfirmpassword" value="">
                                </li>

                                <input type='submit' name='action' value='update'>

                            </ol>
                        </form>
                    </div>
                </div>
            </main>
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