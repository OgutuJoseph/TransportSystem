<?php

// Starting the session, to use and 
// store data in session variable  
session_start(); 
 
 
if (!isset($_SESSION['firstname'])) { 
	$_SESSION['msg'] = "You have to log in first"; 
	header('location: login.php'); 
} 
  
if (isset($_GET['logout'])) { 
	session_destroy(); 
	unset($_SESSION['firstname']); 
	header("location: login.php"); 
} 


// $query = "INSERT INTO users (firstname, lastname, email, password, phone, idno, photo) 
// 				VALUES('$firstname', '$lastname','$email', '$password', '$phone', '$idno', '$photo')"; 
		
// mysqli_query($db, $query);

if (!isset($_SESSION)) { 
	
	// Data sanitization to prevent SQL injection 
	// $firstname = ($_SESSION['firstname']);
	// $lastname = ($_SESSION['lastname']);

	$db = mysqli_connect('localhost', 'root', '', 'transport-system'); 

	$query = "SELECT firstname, lastname FROM users ORDER BY lastname";

	$results = mysqli_query($db, $query); 

	// $results = 1 means that one user with the 
	// entered username exists 
	if (mysqli_num_rows($results) == 1) { 
		
		// Storing username in session variable 
		$_SESSION['firstname'] = $firstname; 
		$_SESSION['lastname'] = $lastname; 
		  
	}
}
?> 
<?php 
include('server.php'); 
include "header.php";
?> 
<div class="container">
<div class="row">

<div class="row">
     <div class="col-md-12">
		  <div class="container">  
			<?php if (isset($_SESSION['success'])) : ?> 
			<div class="error success hidden" > 
			  <h3> 
			  <?php
				echo $_SESSION['success']; 
				unset($_SESSION['success']); 
			  ?> 
			  </h3> 
			</div> 
			<?php endif ?> 

			<!-- information of the user logged in -->
			<!-- welcome message for the logged in user -->
			<?php if (isset($_SESSION['firstname'])) : ?> 
			<p> Welcome <strong> <?php echo $_SESSION['firstname']; ?> </strong> </p> 
			<p> <a href="index.php?logout='1'" style="color: red;"> Click here to Logout </a> </p>
			<hr> 
			<p> <a href="index.php" > Back to Home</a> </p> 
			<?php endif ?>  
		  </div> 
		  
	</div>
  </div>
    <hr>
 	             <div class="d-flex justify-content-center form_container"> 
				
				</div>
				<div>
				<h2>Client Listings</h2>
				<hr>
					<table class="table table-striped table-responsive">
					  <thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Destination</th>
							<th>ID No</th> 
							<th>Travel Date</th>
							<th>Return Date</th>
							<th>Amount Paid</th>
							<th>Category</th>
							<th>Type</th>  
						</tr>					
						</thead>
						<tbody>
						<?php
						$connection = mysqli_connect("localhost", "root");
						$db = mysqli_select_db($connection,'transport-system');				

						$query = "SELECT * FROM `bookings` ";
						$query_run = mysqli_query($connection,$query);

						while($row = mysqli_fetch_array($query_run))
						{
							?>
							<tr>
								<td> <?php echo $row['firstname'] ?></td>
								<td> <?php echo $row['lastname'] ?></td>
								<td> <?php echo $row['destination'] ?></td>
								<td> <?php echo $row['idno'] ?></td> 
								<td> <?php echo $row['travel_date'] ?></td>
								<td> <?php echo $row['return_date'] ?></td>
								<td> <?php echo $row['amount_paid'] ?></td>
								<td> <?php echo $row['ticket_category'] ?></td> 
								<td> <?php echo $row['ticket_type'] ?></td>  
							</tr>

							<?php
							}
						
						?>
						</tbody>
					</table>
		</div>
		</div>
</body> 
</html> 
