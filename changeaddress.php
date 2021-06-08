<?php
session_start();
require "template/connect.php";
$custid =$_SESSION["custid"];

if(isset($_POST["addressid"])){
    $id=$_POST["addressid"];
}
$retrieve = $link->query("SELECT * FROM address WHERE custid=$custid AND addressid='$id'");
while ($row = $retrieve->fetch_assoc()) {
    echo $row["name"] . " " . $row["tel"] . " " . $row["address"] . ", " . $row["zip"] . ", " . $row["country"];
}
?>
