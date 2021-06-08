<?php require "../template/connect.php" ?>
<?php

    if(isset($_GET["action"]) && isset($_GET["id"]) ){
        $id=$_GET["id"];
        $delete = $link->query("DELETE FROM brand WHERE brandid=$id");
        if($delete){
            header("location: brands.php");
        }
    }
    if(isset($_POST["addbrand"])){
        $name = $_POST["brand_title"];
        $insert = $link->query("INSERT INTO brand (brand) VALUES ('$name')");
    }

    if(isset($_POST["update"])){
        $name = $_POST["e_brand_title"];
        $id = $_POST["brandid"];
        $update = $link->query("UPDATE brand SET brand='$name' WHERE brandid=$id");
    }
?>