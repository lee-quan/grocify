<?php

session_start();
require_once "template/connect.php";
if(! isset($_SESSION["custid"])){
    header("location: login.php");
}
?>

$id = $_SESSION["custid"];
$result = $link->query("SELECT * FROM user WHERE custid=$id LIMIT 1");
if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $gender = $row["gender"];
        $dateofbirth = $row["dateofbirth"];
    }
}
$male = $female = "";
if ($gender == "Male") {
    $male = "checked";
} else if ($gender == "Female") {
    $female = "checked";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname1 = $lastname1 = $email1 = $gender1 = $dateofbirth1 = "";
    $firstname1 = $_POST["firstname"]; 
    $lastname1 = $_POST["lastname"]; 
    $email1 = $_POST["email"]; 
    $gender1 = $_POST["gender"]; 
    $dateofbirth1 = $_POST["dob"]; 
    echo $gender1." ".$dateofbirth1;
    $sql = "UPDATE user SET firstname='$firstname1', lastname='$lastname1', email='$email1', gender='$gender1', dateofbirth='$dateofbirth1' WHERE custid=$id LIMIT 1";
    echo $sql;
    $update = $link -> query($sql);
    if($update){
        header("location: account.php");
    }else{
        echo "NO";
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

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h2 class="profile">My Profile<br><small id="text1">Manage and protect your account.</small><input type="submit" style="float:right;"></input></h2>

                <hr>
                <br>
                <!-- <form method="POST" class="personalform"> -->
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
                            <div style="position: relative;">
                                <input type="text" class="form-group" style="position: absolute; top: 0;" value=<?php echo $firstname; ?> name="firstname">
                                <input type="text" class="form-group" style="position: absolute; top: 5rem;" value=<?php echo $lastname; ?> name="lastname">
                                <input type="text" class="form-group" style="position: absolute; top: 10rem;" value=<?php echo $email; ?> name="email">
                                <div class="form-check form-check-inline" style="position: absolute; top:16rem">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox1" value="Male" name="gender" <?php echo $male; ?>>
                                    <label class="form-check-label" for="inlineCheckbox1">Male</label>
                                </div>
                                <div class="form-check form-check-inline" style="position: absolute; top:16rem; left: 8rem;">
                                    <input class="form-check-input" type="radio" id="inlineCheckbox2" value="Female" name="gender" <?php echo $female; ?>>
                                    <label class="form-check-label" for="inlineCheckbox2">Female</label>
                                </div>
                                <input type="date" class="form-group" style="position: absolute; top: 21rem;" value=<?php echo $dateofbirth; ?> name="dob">
                            </div>
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