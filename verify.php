<?php
// Include config file
require "template/connect.php";
$message = "";
if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $result = $link->query("SELECT status, token FROM user WHERE status=0 AND token='$token' LIMIT 1");
    $result1 = $link->query("SELECT status, token FROM user WHERE status=1 AND token='$token' LIMIT 1");
    if ($result->num_rows == 1 && $result1->num_rows == 0) {
        $update = $link->query("UPDATE user SET status=1 WHERE token='$token' LIMIT 1");
        $message = "Your account has been verified. You may now login.";
    } else if ($result1->num_rows == 1) {
        $message = "This account is already verified!";
    }
} else {
    $message = "Opps... Something went wrong!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Glidejs StyleSheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.min.css" />

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- StyleSheet -->
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/loginSignup.css" />
    <title>Grocify</title>

</head>

<body>
    <?php require "template/header.php" ?>
    <div style="margin: 9rem auto 0; padding: 1rem;"></div>

    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-10 shadow" style="margin-bottom: 5rem; padding:3rem">
            <?php
            echo $message
            ?>
        </div>
    </div>

    <?php require "template/footer.php"?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Custom Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/index.js"></script>

</body>

</html>