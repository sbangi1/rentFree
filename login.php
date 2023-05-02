<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
	<title>Login</title>
</head>
<body>
	<div class="container">
		<div class="title">Login</div>
		<div class="content">
			<form method="post" action="validator.php">				
				<div class="user-details">

					<div class="input-box">
						<label class="details">Username</label>
						<input type=" text" name="username" id="username" placeholder="Username" required>
					</div>
					<div class="input-box">
						<label class="details">Password</label>
						<input type="password" name="password1" id="password1" placeholder="Password" required>
					</div>
				</div>
				
				<div class="button">
					<button type="submit" name="login">Login</button>
				</div>
				<p> Not a Member? <a href="register.php">Sign up</a> </p>
			</form>
</body>
</html>