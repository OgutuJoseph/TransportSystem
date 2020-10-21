<?php 

// Starting the session, necessary 
// for using session variables 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

// Declaring and hoisting the variables 
$firstname = ""; 
$lastname = ""; 
$email = ""; 
$phone = ""; 
$idno = ""; 
$photo = ""; 
$destination = "";
$amount_paid = "";
$travel_date = "";
$return_date = "";
$ticket_category = "";
$ticket_type = "";
$errors = array(); 
$_SESSION['success'] = ""; 

// DBMS connection code -> hostname, 
// username, password, database name 
$db = mysqli_connect('localhost', 'root', '', 'transport-system'); 

// Registration code 
if (isset($_POST['reg_user'])) { 

	// Receiving the values entered and storing 
	// in the variables 
	// Data sanitization is done to prevent 
	// SQL injections 

	$target = "uploads/".basename($_FILES['photo']['name']);

	$firstname = mysqli_real_escape_string($db, $_POST['firstname']); 
	$lastname = mysqli_real_escape_string($db, $_POST['lastname']); 
	$email = mysqli_real_escape_string($db, $_POST['email']); 
	$phone = mysqli_real_escape_string($db, $_POST['phone']); 
	$idno = mysqli_real_escape_string($db, $_POST['idno']); 
	$photo 		= $_FILES['photo']['name'];
	// $photo = mysqli_real_escape_string($db, $_POST['photo']); 
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']); 
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']); 

	// Ensuring that the user has not left any input field blank 
	// error messages will be displayed for every blank input 
	if (empty($firstname)) { array_push($errors, "First Name is required"); } 
	if (empty($lastname)) { array_push($errors, "Last Name is required"); } 
	if (empty($email)) { array_push($errors, "Email is required"); } 
	if (empty($phone)) { array_push($errors, "Phone is required"); } 
	if (empty($idno)) { array_push($errors, "ID Number is required"); } 
	if (empty($photo)) { array_push($errors, "Photo is required"); } 
	if (empty($password_1)) { array_push($errors, "Password is required"); } 

	if ($password_1 != $password_2) { 
		array_push($errors, "The two passwords do not match"); 
		// Checking if the passwords match 
	} 

	// If the form is error free, then register the user 
	if (count($errors) == 0) { 
		
		// Password encryption to increase data security 
		$password = md5($password_1); 
		
		// Inserting data into table 
		$query = "INSERT INTO users (firstname, lastname, email, password, phone, idno, photo) 
				VALUES('$firstname', '$lastname','$email', '$password', '$phone', '$idno', '$photo')"; 
		
		mysqli_query($db, $query); 
		move_uploaded_file($_FILES['photo']['tmp_name'], $target);

		// if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
		// 		echo 'Uploaded successfully';
		// 	}
		// 	else{
		// 		echo 'fail';
		// 	}

		// Storing username of the logged in user, 
		// in the session variable 
		$_SESSION['firstname'] = $firstname; 
		$_SESSION['lastname'] = $lastname;
		$_SESSION['idno'] = $idno;
		
		$query = "SELECT * FROM users WHERE email= 
				'$firstname' AND password='$password'"; 
		$results = mysqli_query($db, $query); 

		
		     while ($row = $results->fetch_assoc()) {
				 $_SESSION['firstname'] = $row["firstname"];
				 $_SESSION['lastname'] = $row["lastname"];
				 $_SESSION['idno'] = $row["idno"];
				 $_SESSION['email'] = $row["email"];
			 }

		
		// Welcome message 
		$_SESSION['success'] = "You have logged in"; 
		
		// Page on which the user will be 
		// redirected after logging in 
		header('location: index.php'); 
	} 
} 

// User login 
if (isset($_POST['login_user'])) { 
	
	// Data sanitization to prevent SQL injection 
	$firstname = mysqli_real_escape_string($db, $_POST['firstname']); 
	$password = mysqli_real_escape_string($db, $_POST['password']); 

	// Error message if the input field is left blank 
	if (empty($firstname)) { 
		array_push($errors, "email is required"); 
	} 
	if (empty($password)) { 
		array_push($errors, "Password is required"); 
	} 

	// Checking for the errors 
	if (count($errors) == 0) { 
		
		// Password matching 
		$password = md5($password); 
		
		$query = "SELECT * FROM users WHERE email= 
				'$firstname' AND password='$password'"; 
		$results = mysqli_query($db, $query); 

		// $results = 1 means that one user with the 
		// entered username exists 
		if (mysqli_num_rows($results) == 1) { 
			
			// Storing username in session variable 
			
			$_SESSION['firstname'] = $firstname; 
			$_SESSION['lastname'] = $lastname; 
			$_SESSION['idno'] = $idno; 
			
			 while ($row = $results->fetch_assoc()) {
				 $_SESSION['firstname'] = $row["firstname"];
				 $_SESSION['lastname'] = $row["lastname"];
				 $_SESSION['idno'] = $row["idno"];
				 $_SESSION['email'] = $row["email"];
			 }

			
			// Welcome message 
			$_SESSION['success'] = "You have logged in!"; 
			
			// Page on which the user is sent 
			// to after logging in 
			header('location: index.php'); 
		} 
		else { 
			
			// If the username and password doesn't match 
			array_push($errors, "Incorrect Login Details. Try Again"); 
		} 
	} 
} 

//booking
if (isset($_POST['booking'])) { 

	// Receiving the values entered and storing 
	// in the variables 
	// Data sanitization is done to prevent 
	// SQL injections 
	$firstname = mysqli_real_escape_string($db, $_POST['firstname']); 
	$lastname = mysqli_real_escape_string($db, $_POST['lastname']);  
	$idno = mysqli_real_escape_string($db, $_POST['idno']);
	$destination = mysqli_real_escape_string($db, $_POST['destination']);
	$amount_paid = mysqli_real_escape_string($db, $_POST['amount_paid']);
	$travel_date = mysqli_real_escape_string($db, $_POST['travel_date']);
	$return_date = mysqli_real_escape_string($db, $_POST['return_date']);
	$ticket_category = mysqli_real_escape_string($db, $_POST['ticket_category']);
	$ticket_type = mysqli_real_escape_string($db, $_POST['ticket_type']);


	// Ensuring that the user has not left any input field blank 
	// error messages will be displayed for every blank input 
	if (empty($firstname)) { array_push($errors, "First Name is required"); } 
	if (empty($lastname)) { array_push($errors, "Last Name is required"); }
	if (empty($idno)) { array_push($errors, "ID Number is required"); }  
	if (empty($destination)) { array_push($errors, "Destination is required"); } 
	if (empty($amount_paid)) { array_push($errors, "Amount Paid is required"); } 
	if (empty($travel_date)) { array_push($errors, "Travel Date is required"); } 
	if (empty($ticket_category)) { array_push($errors, "Ticket Category is required"); } 
	if (empty($ticket_type)) { array_push($errors, "Ticket Type is required"); }  

	
	if (count($errors) == 0) { 
		 
		// Inserting data into table 
		$query = "INSERT INTO bookings (firstname, lastname, idno, destination, amount_paid, travel_date, return_date, ticket_category, ticket_type) 
				VALUES('$firstname', '$lastname','$idno', '$destination', '$amount_paid', '$travel_date', '$return_date', '$ticket_category', '$ticket_type')"; 
		
		mysqli_query($db, $query); 
 
		// Welcome message 
		$_SESSION['success'] = "Booking Successful"; 
		
		// Page on which the user will be 
		// redirected after logging in 
		header('location: bookings.php'); 
	} 
}

?> 
