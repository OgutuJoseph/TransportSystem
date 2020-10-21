<?php include('server.php') ?> 
<!DOCTYPE html> 
<html> 
<head> 
	<title> 
		Transport System
	</title> 
	<link rel="stylesheet" type="text/css"
					href="style.css"> 
</head> 

<body> 
	<div class="header"> 
		<h2>Register</h2> 
	</div> 
	 
	<form method="post" action="register.php" enctype="multipart/form-data"> 

		<?php include('error.php'); ?> 

		<div class="input-group"> 
			<label>Enter First Name</label> 
			<input type="text" name="firstname"
				value="<?php echo $firstname; ?>"> 
		</div> 
		<div class="input-group"> 
			<label>Enter Last Name</label> 
			<input type="text" name="lastname"
				value="<?php echo $lastname; ?>"> 
		</div> 
		<div class="input-group"> 
			<label>Email</label> 
			<input type="email" name="email"
				value="<?php echo $email; ?>"> 
		</div> 
		<div class="input-group"> 
			<label>Enter Password</label> 
			<input type="password" name="password_1"> 
		</div> 
		<div class="input-group"> 
			<label>Confirm password</label> 
			<input type="password" name="password_2"> 
		</div> 
		<div class="input-group"> 
			<label>Enter ID Number</label> 
			<input type="text" name="idno"
				value="<?php echo $idno; ?>"> 
		</div> 
		<div class="input-group"> 
			<label>Enter Phone Number</label> 
			<input type="text" name="phone"
				value="<?php echo $phone; ?>"> 
		</div> 
		<div class="input-group"> 
			<label>Photo</label> 
			<input type="file" name="photo"
				value="<?php echo $photo; ?>"> 
		</div> 
		<div class="input-group"> 
			<button type="submit" class="btn"
								name="reg_user"> 
				Register 
			</button> 
		</div> 
		<p> 
			Already having an account? 
			<a href="login.php"> 
				Login Here! 
			</a> 
		</p> 
	</form> 
</body> 
</html> 
