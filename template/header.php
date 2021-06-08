<?php
session_start();
require "template/connect.php";

?>

<nav class="navigationbar">
  <div class="inner-width">
    <a href="#home" class="logo">
      <h1>GRO<span>C</span>IFY</h1>
    </a>
    <button class="menu-toggler">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="navigationbar-menu">
      <a href="home.php">Home</a>
      <a href="product.php">Products</a>
      <a href="contactus.php">Contact Us</a>
      <a href="review.php">Review</a>
    </div>
    <div class="nav-icons">
      <?php
      if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        echo "<a href='account.php'><span><i class='fas fa-user'></i></span></a>";
        echo "<a href='shoppinglist.php'><span><i class='fas fa-heart'></i></span></a>";
        echo "<a href='shoppingcart.php'><span><i class='fas fa-shopping-basket'></i></span></a>";
      } else {
        echo "<a href='login.php' style='color:black;'>Login / Register</a>";
      }
      ?>
    </div>

  </div>
</nav>
<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
  $custid = $_SESSION["custid"];
  $result = $link->query("SELECT status,email FROM user WHERE status=0 AND custid=$custid LIMIT 1");
  if ($result->num_rows == 1) {
    while($row = $result->fetch_assoc()) {
      $email = $row["email"];
    }
    $domain = substr($email, strpos($email, '@') + 1);
   $message= "Your account has not been verified. Please<a href='http://$domain' style='color: red;'> verify </a>your account or change your email address.";
   echo '<div class="alert alert-danger" style="margin-top: 9rem; margin-left: 1rem; margin-right:1rem; text-align:center">' . $message . '</div>';
  }
}
?>