<?php
session_start();
$custid = $_SESSION["custid"];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

class Profile
{
    private $con;
    function __construct()
    {
        include_once('../template/connect.php');
        $this->con = $link;
    }

    public function resetPassword($email)
    {
        $sql = "SELECT * FROM user WHERE email='$email'";
        $q = $this->con->query($sql);
        if ($q->num_rows == 0) {
            return ["status" => 998, "message" => "This email does not exist in the databse."];
        } else {
            while ($row = $q->fetch_assoc()) {
                $firstname = $row["firstname"];
                $custid = $row["custid"];
            }
            $token = md5(time());
            $sql = "UPDATE user SET resetpassword='$token'";
            $q = $this->con->query($sql);
            if ($q) {

                $mail = new PHPMailer(true);
                $subject = "Reset Password";
                $message = "You can reset the password by clicking the link " . "\n" . "http://localhost/grocify/resetpassword.php?token=$token" . ".";
                $to = $email;
                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'leequan1101@gmail.com';                     //SMTP username
                    $mail->Password   = 'leequan001120';                               //SMTP password
                    $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom('leequan1101@gmail.com', 'Grocify');
                    $mail->addAddress($to, $firstname);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    $mail->send();

                    return ["status" => 999, "message" => "An email has been sent to your email to reset your password."];
                } catch (Exception $e) {
                    return ["status" => 999, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
                }
            }
        }
    }

    public function displayOrders($custid)
    {
        $sql = "SELECT * FROM `order` a JOIN orderstatus o ON o.orderstatusid= a.orderstatus JOIN shippingmethod s ON s.shippingid=a.shippingmethod JOIN address on address.addressid= a.addressid WHERE a.custid=$custid ORDER BY a.ordertime DESC";
        $q = $this->con->query($sql);

        if ($q) {
            $orders = [];
            if ($q->num_rows > 0) {
                while ($row = $q->fetch_assoc()) {
                    $orders[] = $row;
                }
            }
        }
        $_DATA["orders"] = $orders;

        return ["status" => 200, "message" => $_DATA];
    }
    public function displayProductList($custid, $orderid)
    {
        $sql = "SELECT * FROM orderdetails o JOIN product p ON p.pid=o.pid WHERE orderid='$orderid' AND custid=$custid";
        $q = $this->con->query($sql);
        if ($q) {
            $productList = [];
            if ($q->num_rows) {
                while ($row = $q->fetch_assoc()) {
                    $productList[] = $row;
                }
            }
            $_DATA["productList"] = $productList;
            return ["status" => 201, "message" => $_DATA];
        }
    }

    public function addNewCard($custid, $name, $cardnum, $expirydate, $cvv)
    {
        $sql = "SELECT * FROM paymentmethod WHERE custid=$custid";
        $q = $this->con->query($sql);
        if ($q->num_rows == 0) {
            $defaultcard = 1;
        } else {
            $defaultcard = 0;
        }
        $paymentid = md5(time());
        $sql = "INSERT INTO paymentmethod (paymentid, custid, nameoncard, cardnumber, expirydate,cvv,defaultcard) VALUES ('$paymentid',$custid, '$name','$cardnum','$expirydate',$cvv,$defaultcard)";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 202, "message" => "New card added!"];
        }
    }
    public function displayCard($custid)
    {
        $sql = "SELECT * FROM paymentmethod WHERE custid=$custid ORDER BY defaultcard DESC, timeadded";
        $q = $this->con->query($sql);
        $cardList = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $cardList[] = $row;
            }
        } else {
            return ["status" => 204, "message" => "no card"];
        }
        $_DATA["cardList"] = $cardList;
        return ["status" => 203, "message" => $_DATA];
    }

    public function deleteCard($paymentid)
    {
        $sql = "DELETE FROM paymentmethod WHERE paymentid='$paymentid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 205, "message" => "The card is deleted!"];
        } else {
            return ["message" => $sql];
        }
    }

    public function defaultCard($paymentid, $custid)
    {
        $sql = "UPDATE paymentmethod SET defaultcard=0 WHERE custid=$custid";
        $q = $this->con->query($sql);

        $sql = "UPDATE paymentmethod SET defaultcard=1 WHERE paymentid='$paymentid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 206, "message" => "Default card changed!"];
        } else {
            return ["message" => $sql];
        }
    }

    public function displayAddress($custid)
    {
        $sql = "SELECT * FROM address WHERE custid=$custid ORDER BY defaultaddress DESC, timeadded";
        $q = $this->con->query($sql);
        $addressList = [];
        if ($q->num_rows > 0) {
            while ($row = $q->fetch_assoc()) {
                $addressList[] = $row;
            }
        } else {
            return ["status" => 208, "message" => "no address"];
        }

        $_DATA["addressList"] = $addressList;
        return ["status" => 207, "message" => $_DATA];
    }
    public function addNewAddress($custid, $name, $address, $zip, $country, $phonenumber)
    {
        $sql = "SELECT * FROM address WHERE custid=$custid";
        $q = $this->con->query($sql);
        if ($q->num_rows == 0) {
            $defaultaddress = 1;
        } else {
            $defaultaddress = 0;
        }

        $addressid = md5(time());

        $sql = "INSERT INTO address (addressid,custid,name,address,zip,country,tel,defaultaddress) VALUES ('$addressid',$custid,'$name','$address','$zip','$country','$phonenumber',$defaultaddress)";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 209, "message" => "New Address Added!"];
        }
    }
    public function deleteAddress($addressid)
    {
        $sql = "DELETE FROM address WHERE addressid='$addressid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 210, "message" => "The address is deleted.."];
        }
    }

    public function defaultAddress($addressid, $custid)
    {
        $sql = "UPDATE address SET defaultaddress=0 WHERE custid=$custid";
        $q = $this->con->query($sql);

        $sql = "UPDATE address SET defaultaddress=1 WHERE addressid='$addressid'";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 211, "message" => "Default address changed!"];
        } else {
            return ["message" => $sql];
        }
    }

    public function submitFeedback($name, $email, $tel, $message, $feeling)
    {
        $id = uniqid(time());
        $sql = "INSERT INTO feedback (feedbackid,name,email,feeling,phone,message) VALUES ('$id','$name','$email','$feeling','$tel','$message')";
        $q = $this->con->query($sql);
        if ($q) {
            return ["status" => 212, "message" => "Submitted!"];
        }
    }
}

if (isset($_POST["displayOrder"])) {
    $p = new Profile();
    echo json_encode($p->displayOrders($custid));
}
if (isset($_POST["checkorder"])) {
    $p = new Profile();
    $orderid = $_POST["id"];
    echo json_encode($p->displayProductList($custid, $orderid));
}
// name: nameoncard, cardnum: cardnumber, expirydate: expirydate, cvv: cvv
if (isset($_POST["addnewcard"])) {
    $p = new Profile();
    $name = $_POST["name"];
    $cardnum = $_POST["cardnum"];
    $expirydate = $_POST["expirydate"];
    $cvv = $_POST["cvv"];
    echo json_encode($p->addNewCard($custid, $name, $cardnum, $expirydate, $cvv));
}
if (isset($_POST["displaycard"])) {
    $p = new Profile();
    echo json_encode($p->displayCard($custid));
}

if (isset($_POST["deletecard"])) {
    $p = new Profile();
    $paymentid = $_POST["payid"];
    echo json_encode($p->deleteCard($paymentid));
}
if (isset($_POST["defaultcard"])) {
    $p = new Profile();
    $paymentid = $_POST["payid"];
    echo json_encode($p->defaultCard($paymentid, $custid));
}


if (isset($_POST["displayaddress"])) {
    $p = new Profile();
    echo json_encode($p->displayAddress($custid));
}

if (isset($_POST["addnewaddress"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $zip = $_POST["zip"];
    $country = $_POST["country"];
    $phonenumber = $_POST["phonenumber"];
    $p = new Profile();
    echo json_encode($p->addNewAddress($custid, $name, $address, $zip, $country, $phonenumber));
}

if (isset($_POST["deleteaddress"])) {
    $p = new Profile();
    $addressid = $_POST["addressid"];
    echo json_encode($p->deleteAddress($addressid));
}
if (isset($_POST["defaultaddress"])) {
    $p = new Profile();
    $addressid = $_POST["aid"];
    echo json_encode($p->defaultAddress($addressid, $custid));
}

// submitfeedback:1, namefb:name, emailfb:email, telfb:tel, messagefb:message, feelingfb: feeling

if (isset($_POST["submitfeedback"])) {
    $name = $_POST["namefb"];
    $email = $_POST["emailfb"];
    $tel = $_POST["telfb"];
    $message = $_POST["messagefb"];
    $feeling = $_POST["feelingfb"];
    $p = new Profile();
    echo json_encode($p->submitFeedback($name, $email, $tel, $message, $feeling));
}

if (isset($_POST["resetpassword"])) {
    $email = $_POST["email"];
    // echo $email;
    $p = new Profile();
    echo json_encode($p->resetPassword($email));
}
