<?php require "../template/connect.php" ?>
<?php
if (isset($_POST["addcat"])) {
    $nullornot = $_POST["categoryselection"];
    $inputcat = $_POST["inputcat"];
    $count = count($_POST["inputcat"]);
    if ($nullornot == 0) {
        //validation
        $i = 0;
        $lastinsertid = 0;
        while ($i < $count) {
            if ($i == 0) {
                $sql = "INSERT INTO category (cat) VALUES ('$inputcat[$i]')";
                $insert = $link->query($sql);
                $lastinsertid = $link->insert_id;

                $update = $link->query("UPDATE category SET parentcatid=$lastinsertid WHERE catid=$lastinsertid");
            } else {
                $sql = "INSERT INTO category (parentcatid,cat) VALUES ($lastinsertid,'$inputcat[$i]')";
                echo $sql . "\n";
                $insert = $link->query($sql);
            }
            $i++;
        }
    } else {
        $i = 0;
        while ($i < $count) {
            $sql = "INSERT INTO category (parentcatid,cat) VALUES ($nullornot,'$inputcat[$i]')";
            $insert = $link->query($sql);
            $i++;
        }
    }
}

if (isset($_GET["action"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    $delete = $link->query("DELETE FROM category WHERE catid=$id");
    if ($delete) {
        header("location: categories.php");
    }
}
if (isset($_POST["update"])) {
    echo "HEHE";
    $name = $_POST["e_cat_title"];
    $id = $_POST["catid"];
    $update = $link->query("UPDATE category SET cat='$name' WHERE catid=$id");
}
?>