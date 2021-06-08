<?php require "../template/connect.php" ?>
<?php
if (isset($_POST["submit"])) {
    $pname = $pbrand = $pcat = $pdes = $pquantity = $pprice = $pkeywords = $ppicture = "";
    $pname = $_POST["pname"];
    $pbrand = $_POST["pbrand"];
    $pcat = $_POST["pcat"];
    $pdes = $_POST["pdescription"];
    $pquantity = $_POST["pquantity"];
    $pprice = $_POST["pprice"];
    $pkeywords = $_POST["pkeywords"];

    $name = explode(".", $_FILES["image"]["name"]);
    $ext = end($name);
    $temp = $_FILES["image"]["tmp_name"];
    $destination = "productimage/";
    $ppicture = md5(time()).".".end($name);
    $sql ="INSERT INTO product (pname, pbrandid, pcatid, pdescription, pquantity, pprice, pkeywords, picture) VALUES ('$pname',$pbrand,$pcat,'$pdes',$pquantity,$pprice,'$pkeywords', '$ppicture')";
    $insert = $link->query($sql);
    echo $sql;
    if (move_uploaded_file($temp, $destination . $ppicture)) {
    } else {
        echo "NO123";
    }

}

if(isset($_POST["update"])){
    $newpname = $newpbrand = $newpcat = $newpdes = $newpquantity = $newpprice = $newpkeywords = $newppicture = "";
    $newpname = $_POST["e_product_name"];
    $newpbrand = $_POST["e_brand_id"];
    $newpcat = $_POST["e_category_id"];
    $newpdes = $_POST["e_product_desc"];
    $newpquantity = $_POST["e_product_qty"];
    $newpprice = $_POST["e_product_price"];
    $newpkeywords = $_POST["e_product_keywords"];
    $pid = $_POST["pid"];
    $currentpicture = $_POST["currentpicture"];
    $sql="UPDATE product SET pname='$newpname',pbrandid=$newpbrand,pcatid=$newpcat,pdescription='$newpdes',pquantity=$newpquantity,pprice=$newpprice,pkeywords='$newpkeywords'";
    
    if($_FILES["e_product_image"]["name"]==""){
        $sql = $sql." WHERE pid=$pid";
        echo $sql;
        $update = $link->query($sql);
    }else{

        $ext =end(explode(".", $_FILES["e_product_image"]["name"]));
        $newppicture= md5(time()).".".$ext;
        $temp = $_FILES["e_product_image"]["tmp_name"];
        $destination = "productimage/";
        if (move_uploaded_file($temp, $destination . $newppicture)) {
        } else {
            echo "NO123";
        }
        $sql = $sql.",picture = '$newppicture' WHERE pid=$pid";
        $update = $link->query($sql);
        unlink($currentpicture);
    }
}
if(isset($_GET["action"]) && isset($_GET["id"]) && isset($_GET["picture"]) ){
    $id=$_GET["id"];
    $picture = $_GET["picture"];
    $sql = "DELETE FROM product WHERE pid=$id";
    echo $sql;
    $delete = $link->query($sql);
    unlink($picture);
    if($delete){
        header("location: product.php");
    }
}
?>
