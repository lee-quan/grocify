<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column" style="align-items: center;">

      <?php


      $uri = $_SERVER['REQUEST_URI'];
      $uriAr = explode("/", $uri);
      $page = end($uriAr);

      ?>


      <li class="nav-item" style="margin-bottom: 1rem;">
        <a class="nav-link <?php echo ($page == '' || $page == 'account.php') ? 'active' : ''; ?>" href="account.php">
          <span data-feather="home"></span>
          Profile <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item" style="margin-bottom: 1rem;">
        <a class="nav-link <?php echo ($page == 'bank.php') ? 'active' : ''; ?>" href="bank.php">
          <span data-feather="file"></span>
          Bank and Cards
        </a>
      </li>
      <li class="nav-item" style="margin-bottom: 1rem;">
        <a class="nav-link <?php echo ($page == 'address.php') ? 'active' : ''; ?>" href="address.php">
          <span data-feather="shopping-cart"></span>
          Address
        </a>
      </li>
      <li class="nav-item" style="margin-bottom: 1rem;">
        <a class="nav-link <?php echo ($page == 'password.php') ? 'active' : ''; ?>" href="password.php">
          <span data-feather="shopping-cart"></span>
          Password
        </a>
      </li>
      <li class="nav-item" style="margin-bottom: 20rem;">
        <a class="nav-link <?php echo ($page == 'order.php') ? 'active' : ''; ?>" href="order.php">
          <span data-feather="shopping-cart"></span>
          Orders
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php  echo ($page == 'logout.php') ? 'active' : ''; ?>" href="logout.php">
          <span data-feather="shopping-cart"></span>
          Logout
        </a>
      </li>

    </ul>


  </div>
</nav>


<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  
