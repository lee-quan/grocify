<?php include "./templates/top.php"; ?>

<?php include "./templates/navbar.php"; ?>
<?php include "loginregister.php";?>

<div class="container">
	<div class="row justify-content-center" style="margin:100px 0;">
		<div class="col-md-4">
			<h4>Admin Login</h4>
			<p class="message"></p>
			<form method="POST">
			  <div class="form-group">
			    <label for="email">Email address</label>
			    <input type="email" class="form-control" name="email" id="email"  placeholder="Enter email">
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
			  </div>
			  <input type="hidden" name="admin_login" value="1">
			  <button type="submit" class="btn btn-primary login-btn" name="login">Submit</button>
			</form>
		</div>
	</div>
</div>





<?php include "./templates/footer.php"; ?>

