<?php
session_start();
$custid = $_SESSION["custid"];
class Products
{
    private $con;
    function __construct()
    {
        include_once('../template/connect.php');
        $this->con = $link;
    }

    public function displayProducts($p, $f, $c, $sc, $b, $search)
    {
        $sql = 'SELECT *, count(r.pid), sum(r.rate) FROM product p JOIN category c ON c.catid=p.pcatid LEFT JOIN rating r ON r.pid=p.pid';

        // if($f != "" || $c != "" || $sc != "" || $b != "" || $search !=""){
        //     $sql = $sql. " WHERE ";
        // }
        
        if ($c != "") {
            $sql = $sql . " WHERE parentcatid=$c ";
            if ($sc != "") {
                $sql = $sql . "AND pcatid=$sc ";
            }
            if ($b != "") {
                $sql = $sql . "AND pbrandid=$b ";
            }
            if ($search != "") {
                $sql = $sql . "AND pname LIKE '%$search%'";
            }
        } else {
            if ($search != "") {
                $sql = $sql . " WHERE pname LIKE '%$search%'";
            }
        }
        $sql = $sql . " GROUP BY p.pid";
        if ($f != "") {
            $sql = $sql . " ORDER BY $f";
        }

        $getnumberofresult = $this->con->query($sql);
        $numofresult = [];
        if ($getnumberofresult) {
            if ($getnumberofresult->num_rows > 0) {
                $numofresult = [];
                while ($row = $getnumberofresult->fetch_assoc()) {
                    $numofresult[] = $row;
                }
            }
        }

        $_DATA["numofresult"] = $numofresult;

        $sql = $sql . " limit " . ($p) * 9 . ",9 ";
        $q = $this->con->query($sql);

        $productList = [];
        if ($q) {

            if ($q->num_rows > 0) {
                while ($row = $q->fetch_assoc()) {
                    $productList[] = $row;
                }
            }
        } else {
            return ["message" => "NO :( : $sql"];
        }
        $_DATA['products'] = $productList;
        return ['status' => 100, 'message' => $_DATA];
    }

    // public function displayFilteredProducts($cat, $brand, $orderby)
    // {
    //     $sql = 'SELECT * FROM product';
    //     if ($cat != "") {
    //         // $sql_brand = "SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE parentcatid=$cat GROUP BY brandid";
    //         $sql = $sql . " JOIN category ON category.catid=product.pcatid WHERE parentcatid=$cat ";
    //     }
    //     if ($brand != "") {
    //         $sql = $sql . " AND pbrandid=$brand";
    //     }
    //     if ($orderby != "") {
    //         $sql = $sql . " ORDER BY $orderby";
    //     }
    //     // SELECT * FROM product  JOIN category ON category.catid=product.pcatid WHERE parentcatid=1 ORDER BY pprice asc
    //     $q = $this->con->query($sql);

    //     $productList = [];
    //     if ($q->num_rows > 0) {
    //         while ($row = $q->fetch_assoc()) {
    //             $productList[] = $row;
    //         }
    //     }
    //     $_DATA['products'] = $productList;

    //     $sql = "SELECT brandid, brand, count(brandid) AS freq FROM product JOIN category ON category.catid=product.pcatid JOIN brand b ON pbrandid=brandid WHERE parentcatid=$cat GROUP BY brandid";
    //     $q = $this->con->query($sql);
    //     $brandList = [];
    //     if ($q->num_rows > 0) {
    //         while ($row = $q->fetch_assoc()) {
    //             $brandList[] = $row;
    //         }
    //     }

    //     $_DATA['brands'] = $brandList;

    //     return ['status' => 101, 'message' => $_DATA];
    // }
    public function displayProductDetails($pid)
    {
        $sql = "SELECT *,count(r.pid) as 'numofreviews', sum(r.rate) as 'sumofreviews' FROM product p JOIN (SELECT a.catid as 'catid', a.parentcatid as 'parentcatid', b.cat as 'parentcat', a.cat as 'cat' FROM category a LEFT JOIN category b ON a.parentcatid=b.catid ORDER BY a.parentcatid, a.catid) c1 ON p.pcatid=c1.catid JOIN brand b ON p.pbrandid=b.brandid LEFT JOIN rating r ON r.pid=p.pid WHERE p.pid=$pid group by p.pid";
        $q = $this->con->query($sql);

        $productdetails = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $productdetails[] = $row;
            }
        }

        $_DATA['productdetails'] = $productdetails;

        $sql = "SELECT * FROM rating r JOIN user a ON a.custid= r.custid WHERE pid=$pid";
        $q = $this->con->query($sql);
        $comments = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $comments[] = $row;
            }
        }
        $_DATA['comments']= $comments;

        return ['status' => 103, 'message' => $_DATA];
    }

    public function addtocart($pid, $quantity, $custid)
    {
        if (!isset($_SESSION["custid"])) {
            return ['status' => 104, 'message' => "Please login to continue.."];
        }
        $cartid = md5(time());
        $sql = "INSERT INTO cart (cartid,custid,pid, quantity) VALUES ('$cartid',$custid, $pid, $quantity)";
        $q = $this->con->query($sql);
        if ($q) {
            return ['status' => 104, 'message' => "Added to Cart!"];
        }
    }



    public function displayCart($custid)
    {
        $sql = "SELECT *,quantity*pprice AS 'totalcost' FROM cart c JOIN (SELECT * FROM product p JOIN category cat ON p.pcatid=cat.catid) a ON a.pid = c.pid WHERE custid=$custid";
        $q = $this->con->query($sql);
        $cartlist = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $cartlist[] = $row;
            }
        }

        $_DATA['cart'] = $cartlist;
        return ['status' => 105, 'message' => $_DATA];
    }

    public function updateCart($cartid, $quantity)
    {
        $sql = "UPDATE cart SET quantity=$quantity WHERE cartid='$cartid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ['status' => 106, 'message' => "updated"];
        } else {
            return ['status' => 107, 'message' => $sql];
        }
    }

    public function removeFromCart($cartid)
    {
        $sql = "DELETE FROM cart WHERE cartid='$cartid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["message" => "success"];
        } else {
            return ["message" => $sql];
        }
    }

    public function createOrder($addressid, $paymentid, $shippingmethod, $totalCost, $custid)
    {
        $sql = "SELECT * FROM cart WHERE custid=$custid";
        $q = $this->con->query($sql);
        if ($q->num_rows == 0) {
            return ['status' => 109, 'message' => "Your cart is empty..."];
        }
        $orderid = uniqid(time());
        $days = 0;
        if ($shippingmethod == "0") {
            $days = 7;
        } else if ($shippingmethod == "1") {
            $days = 20;
        }

        $date = date('Y-m-d', strtotime('+' . $days . ' days', strtotime(date("Y-m-d"))));

        $sql = "INSERT INTO `order` (orderid, custid, requiredtime, cost, addressid, paymentid,shippingmethod) VALUES ('$orderid',$custid, '$date', $totalCost,'$addressid','$paymentid',$shippingmethod)";
        $q = $this->con->query($sql);
        if ($q) {
            $sql = "SELECT * FROM cart WHERE custid=$custid";
            $q = $this->con->query($sql);
            while ($row = $q->fetch_assoc()) {
                $sql1 = "INSERT INTO orderdetails (orderid, custid, pid, quantity) VALUES ('$orderid',$custid," . $row["pid"] . "," . $row["quantity"] . ")";
                $q1 = $this->con->query($sql1);
            }
            $sql1 = "DELETE FROM cart WHERE custid=$custid";
            $q1 = $this->con->query($sql1);
            if ($q1) {
                return ['status' => 109, "message" => "Payment made successfully. New order created!"];
            }
        } else {
            return ["message" => $sql];
        }
    }

    public function displayMiniShoppingList($custid)
    {
        // $sql = "SELECT * FROM shoppinglist WHERE custid=$custid";
        $sql = "SELECT *, a.shoppinglistid as 'sid', count(b.shoppinglistid) as 'count' FROM shoppinglist a LEFT JOIN shoppinglistdetails b ON a.shoppinglistid=b.shoppinglistid WHERE custid=$custid GROUP BY a.shoppinglistid ORDER BY timeadded";
        $q = $this->con->query($sql);
        $shoppinglist = [];
        if ($q) {
            if ($q->num_rows > 0) {
                while ($row = $q->fetch_assoc()) {
                    $shoppinglist[] = $row;
                }
            }
        }
        $_DATA["shoppinglist"] = $shoppinglist;

        $sql = "SELECT * FROM shoppinglistdetails s JOIN product p ON s.pid = p.pid ORDER BY timeadded";
        $q = $this->con->query($sql);
        $shoppinglistdetails = [];
        if ($q) {
            if ($q->num_rows > 0) {
                while ($row = $q->fetch_assoc()) {
                    $shoppinglistdetails[] = $row;
                }
            }
        }
        $_DATA["shoppinglistdetails"] = $shoppinglistdetails;
        return ["status" => 110, "message" => $_DATA];
    }

    public function addNewShoppingList($shoppinglist, $custid)
    {
        $shoppinglistid = md5(time());
        $sql = "INSERT INTO shoppinglist (shoppinglistid, custid,shoppinglist) VALUES ('$shoppinglistid',$custid, '$shoppinglist')";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 111, "message" => "Added New List!"];
        }
    }

    public function addToShoppingList($sid, $pid, $quantity)
    {
        $sdetailsid = md5(time());
        $sql = "INSERT INTO shoppinglistdetails (sdetailsid, shoppinglistid,pid,quantity) VALUES ('$sdetailsid  ','$sid',$pid,$quantity)";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 112, "message" => "Successfully Added into the List!"];
        }
    }

    public function updateShoppingList($sdetailsid, $quantity)
    {
        $sql = "UPDATE shoppinglistdetails SET quantity=$quantity WHERE sdetailsid='$sdetailsid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 113, "message" => "Changed!"];
        }
    }

    public function deleteFromShoppingList($sdetailsid)
    {
        $sql = "DELETE FROM shoppinglistdetails WHERE sdetailsid='$sdetailsid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 114, "message" => "Deleted!"];
        }
    }

    public function addToCartFromShoppingList($sdetailsid, $custid)
    {
        $sql = "SELECT * FROM shoppinglistdetails WHERE sdetailsid='$sdetailsid'";
        $q = $this->con->query($sql);
        $cartid = md5(time());
        while ($row = $q->fetch_assoc()) {
            $sql1 = "INSERT INTO cart (cartid,custid,pid, quantity) VALUES ('$cartid',$custid," . $row["pid"] . "," . $row["quantity"] . ")";
        }
        $q1 = $this->con->query($sql1);

        if ($q1) {
            return ["status" => 115, "message" => "Added to Cart!"];
        }
    }

    public function addAllToCartFromShoppingList($shoppinglistid, $custid)
    {
        $sql = "SELECT * FROM shoppinglist a RIGHT JOIN shoppinglistdetails b ON a.shoppinglistid =b.shoppinglistid WHERE a.shoppinglistid='$shoppinglistid'";
        $q = $this->con->query($sql);
        
        $counter=0;
        while ($row = $q->fetch_assoc()) {
            $cartid = md5(time().$row["sdetailsid"]);
            $sql1 = "INSERT INTO cart (cartid,custid,pid, quantity) VALUES ('$cartid',$custid," . $row["pid"] . "," . $row["quantity"] . ")";
            $q1 = $this->con->query($sql1);
                $counter = $counter . " 1. " . $sql1; 

              
            
        }
        return ["status" => 116, "message" => $counter];
    }

    public function deleteShoppingList($shoppinglistid, $custid){
        $sql1 = "SELECT * FROM shoppinglistdetails WHERE shoppinglistid='$shoppinglistid'";
        // return ["status" => 117, "message" => $sql1];
        $q1 = $this -> con->query($sql1);
        if($q1->num_rows>0){
            $sql = "DELETE FROM shoppinglistdetails WHERE shoppinglistid='$shoppinglistid'";
            $q = $this->con->query($sql);
         
            $sql = "DELETE FROM shoppinglist WHERE shoppinglistid='$shoppinglistid'";
            $q = $this->con->query($sql);   
        }else{
            $sql = "DELETE FROM shoppinglist WHERE shoppinglistid='$shoppinglistid'";
            $q = $this->con->query($sql);
        }
        return ["status" => 117, "message" => "The list is deleted.."];
    }
    
    public function submitReview($productid,$star, $custid,$message){
        $sql = "INSERT INTO rating (pid,custid,rate, message) VALUES ($productid,$custid,$star, '$message')";
            // return ["status" => 118, "message" => $sql];
        
        $q = $this -> con -> query ($sql);
        if($q){
            return ["status" => 118, "message" => "Thank you for submitting your review for this product!"];
        }
        
    }
}




if (isset($_POST['productdetails_id'])) {
    $p = new Products();
    $pid = $_POST['productdetails_id'];
    // echo "HALLELUJAH";
    echo json_encode($p->displayProductDetails($pid));
}

if (isset($_POST['addtocart'])) {
    $pid = $_POST["productid"];
    $quantity = $_POST["quantity"];
    $p = new Products();
    echo json_encode($p->addtocart($pid, $quantity, $custid));
}

if (isset($_POST['displayCart'])) {
    $p = new Products();
    echo json_encode($p->displayCart($custid));
}

if (isset($_POST['updateCart'])) {
    $p = new Products();

    $cartid = $_POST["cart"];
    $quantity = $_POST["quantity"];
    echo json_encode($p->updateCart($cartid, $quantity));
}

if (isset($_POST['deletecart'])) {
    $p = new Products();
    $cartid = $_POST["cart"];
    echo json_encode($p->removeFromCart($cartid));
}

if (isset($_POST["address"]) && isset($_POST["payment"]) && isset($_POST["shipping"]) && isset($_POST["total"])) {
    $p = new Products();
    $addressid = $_POST["address"];
    $paymentid = $_POST["payment"];
    $shippingmethod = $_POST["shipping"];
    $totalCost = $_POST["total"];
    echo json_encode($p->createOrder($addressid, $paymentid, $shippingmethod, $totalCost, $custid));
}

// if(isset($_POST["page"]) && isset($_POST["filter"]) && isset($_POST["category"]) && isset($_POST["subcategory"]) && isset($_POST["brand"]) ){
if (isset($_POST["page"])) {
    $p = new Products();
    $page = $_POST["page"];
    $filter = $_POST["filter"];
    $category = $_POST["cat"];
    $subcategory = $_POST["subcat"];
    $brand = $_POST["br"];
    $search = $_POST["srch"];
    // echo "hi";
    // echo $page." ".$filter." ". $category . " " . $subcategory . " ". $brand;
    echo json_encode($p->displayProducts($page, $filter, $category, $subcategory, $brand, $search));
}

if (isset($_POST["displayminishoppinglist"])) {
    $p = new Products();
    echo json_encode($p->displayMiniShoppingList($custid));
}

if (isset($_POST["addnewshoppinglist"])) {
    $shoppinglist = $_POST["shoplist"];
    $p = new Products();
    echo json_encode($p->addNewShoppingList($shoppinglist, $custid));
}

if (isset($_POST["addtoshoppinglist"])) {
    $sid = $_POST["sid"];
    $pid = $_POST["pid"];
    $quantity = $_POST["quantity"];
    $p = new Products();
    echo json_encode($p->addToShoppingList($sid, $pid, $quantity));
}

if (isset($_POST["updatelist"])) {
    $p = new Products();

    $sdetailsid = $_POST["sdetailid"];
    $quantity = $_POST["quantity"];
    echo json_encode($p->updateShoppingList($sdetailsid, $quantity));
}

if (isset($_POST["deletefromshoppinglist"])) {
    $p = new Products();
    $sdetailsid = $_POST["sdetailid"];
    echo json_encode($p->deleteFromShoppingList($sdetailsid));
}

if (isset($_POST["addtocartfromshoppinglist"])) {
    $p = new Products();
    $sdetailsid = $_POST["sdetailid"];
    echo json_encode($p->addToCartFromShoppingList($sdetailsid, $custid));
}

if (isset($_POST["addalltocart"])) {
    $p = new Products();
    $shoppinglistid = $_POST["shoppinglistid"];
    echo json_encode($p->addAllToCartFromShoppingList($shoppinglistid, $custid));
}

if (isset($_POST["deleteshoppinglist"])) {
    $p = new Products();
    $shoppinglistid = $_POST["shoppinglistid"];
    echo json_encode($p->deleteShoppingList($shoppinglistid, $custid));
}

// submitreview:1, productid:pid, star:review
if (isset($_POST["submitreview"])) {
    $p = new Products();
    $productid = $_POST["productid"];
    $star = $_POST["star"];
    $message = $_POST["message"];
    echo json_encode($p->submitReview($productid,$star, $custid, $message));
}
