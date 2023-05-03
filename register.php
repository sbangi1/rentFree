<?php include('registerSQL.php') ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="register.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
  </head>
  <body>
    <div class="container">
		<div class="title">Register</div>
		<div class="content">
			<form method="post" action="registerSQL.php">

				<div class="user-details">

					<div class="input-box">
						<label class="details">First Name</label>
						<input type="text" name="fName" id="fName" placeholder="First Name" required>
					</div>

					<div class="input-box">
						<label class="details">Last Name</label>
						<input type=" text" name="lName" id="lName" placeholder="Last Name" required>
					</div>

					<div class="input-box">
						<label class="details">Username</label>
						<input type=" text" name="username" id="username" placeholder="Username" required>
					</div>

					<div class="input-box">
						<label>Email</label>
						<input type="email" name="email" id="email" placeholder="Email" required>
					</div>

					<div class="input-box">
						<label class="details">Password</label>
						<input type="password" name="password1" id="password1" placeholder="Password" required>
					</div>

					<div class="input-box">
						<label class="details">Confirm password</label>
						<input type="password" name="password2" id="password2" placeholder="Confirm Password" required>
					</div>
				</div>

				<div class="gender-details">
					<input type="radio" name="gender" id="dot-1" value="buyer" required>
					<input type="radio" name="gender" id="dot-2" value="seller">
					<input type="radio" name="gender" id="dot-3" value="admin">
					<span class="gender-title">User</span>
					<br>
					<div class="category">
						<label for="dot-1">
							<span class="dot one"></span>
							<span class="gender">Buyer</span>
						</label>
						<label for="dot-2">
							<span class="dot two"></span>
							<span class="gender">Seller</span>
						</label>
						<label for="dot-3">
							<span class="dot three"></span>
							<span class="gender">Admin</span>
						</label>
					</div>
				</div>
				<br>
				<div class="button">
					<button type="submit" name="register">Register</button>
				</div>
				<p> Already a member? <a href="login.php">Sign in</a> </p>
			</form>
  </body>
</html>