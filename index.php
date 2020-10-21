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
 
include "header.php";
?>
   <div class="container">
    <div class="row">
    <?php 
    include "meRaviQr/qrlib.php";
    include "config.php";
    if(isset($_POST['create']))
    {
    $firstname = $_POST['firstname'];
    $idno =  $_POST['idno']; 
    $qrImgName = "meravi".rand();
    $lastname =  $_POST['lastname'];
    $destination =  $_POST['destination'];
    $amount_paid =  $_POST['amount_paid']; 
    $travel_date =  $_POST['travel_date'];
    $return_date =  $_POST['return_date'];
    $ticket_category =  $_POST['ticket_category'];
    $ticket_type =  $_POST['ticket_type'];  
    if($idno=="")
    {
      echo "<script>alert('Please ID Number');</script>";
    }
    elseif($firstname=="")
    {
      echo "<script>alert('Please Enter Your First Name');</script>";
    }
    elseif($lastname=="")
    {
      echo "<script>alert('Please Enter Your Last Name');</script>";
    }
    elseif($destination=="")
    {
      echo "<script>alert('Please Enter Your Destination');</script>";
    }
    elseif($amount_paid=="")
    {
      echo "<script>alert('Please Enter Amount Paid');</script>";
    }
    elseif($travel_date=="")
    {
      echo "<script>alert('Please Enter Your Travel Date');</script>";
    }
    elseif($return_date=="")
    {
      echo "<script>alert('Please Enter Your Return Date');</script>";
    }
    elseif($ticket_category=="")
    {
      echo "<script>alert('Please Pick Ticket Category');</script>";
    }
    elseif($ticket_type=="")
    {
      echo "<script>alert('Please Pick Ticket Type');</script>";
    }
    else
    {
		
    $dev = "Developed by Transport System";
    $final = $idno.$dev;
    $qrs = QRcode::png($final,"userQr/$qrImgName.png","H","3","3");
    $qrimage = $qrImgName.".png";
    $workDir = $_SERVER['HTTP_HOST'];
	
    $qrlink = $workDir."/qrcode".$qrImgName.".png";
    $insQr = $meravi->insertQr($firstname,$final,$qrimage,$qrlink,$lastname,$destination,$amount_paid,$travel_date,$return_date,$ticket_category,$ticket_type);
    if($insQr==true)
    {
      echo "<script>alert('Thank You $firstname. Booking was Successfull. View QR Code.'); window.location='index.php?success=$qrimage';</script>"; 
    
				function sanitize_my_email($field) {
						$field = filter_var($field, FILTER_SANITIZE_EMAIL);
						if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
							return true;
						} else {
							return false;
						}
				}
				
				$to_email =$_SESSION['email'];
				$subject = 'Your QR CODE';
				$message = 'YOUR QR IS GENERATED LOG BACK AND VERIFY IT';
				$headers = 'From: noreply @ bookings.com';

				//check if the email address is invalid $secure_check
				$secure_check = sanitize_my_email($to_email);
				if ($secure_check == false) {
					echo "Invalid data, cant send info";
				} else { //send email 
					mail($to_email, $subject, $message, $headers);
					echo "email is sent";
				}
   }
    else
    {
      echo "<script>alert('cant create QR Code');</script>";
    }
    }
  }
  ?>
  <?php 
  if(isset($_GET['success']))
  {
  ?>
  <div class="row">
   <div class="container">
  <div id="qrSucc">
    <div class="modal-content animate container">
      <?php 
      ?>
 
      <img width="100%" src="userQr/<?php echo $_GET['success']; ?>" alt="">
      <?php 
      $workDir = $_SERVER['HTTP_HOST'];
      $qrlink = $workDir."/userQr/".$_GET['success'];
      ?>
     
      <input class="hidden" type="text" value="<?php echo $qrlink; ?>" readonly>
      <br><br>
      <a href="download.php?download=<?php echo $_GET['success']; ?>">Download Now</a>
      <br>
      <br><br>
      <a href="index.php">Go Back To Make New Booking</a>
    
    </div>
  </div>
  </div>
  </div>
  <?php
  }
  else
  {
    ?> 
 <div class="row">
     <div class="col-md-12">
		  <div class="container">  
			<?php if (isset($_SESSION['success'])) : ?> 
			<div class="error success" > 
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
			<p> <a href="bookings.php" > Bookings History</a> </p> 

			<?php endif ?>  
		  </div> 
		  
	</div>
  </div>
    <hr>
    <form class="modal-content animate" method="post" enctype="multipart/form-data">
    <div class="container">
	    <h2 class="text-success"> Booking Screen</h2>
		<hr>
      <div class="input-group hidden"> 
        <label>First Name</label> 
        <?php if (isset($_SESSION['firstname'])) : ?> 
        <input name="firstname" value="<?php echo $_SESSION['firstname']; ?>" readonly="">
        <?php endif ?> 
      </div> 
      <div class="input-group hidden"> 
        <label>Last Name</label> 
        <?php if (isset($_SESSION['lastname'])) : ?> 
        <input name="lastname" value="<?php echo $_SESSION['lastname']; ?>" readonly="">
        <?php endif ?> 
      </div> 
      <div class="input-group hidden"> 
        <label>ID NO</label> 
        <?php if (isset($_SESSION['idno'])) : ?> 
        <input name="idno" value="<?php echo $_SESSION['idno']; ?>" readonly="">
        <?php endif ?> 
      </div>
      <div class="input-group"> 
        <label>Destination</label> 
        <input type="text" name="destination" value="<?php if(isset($_POST['create'])){ echo $_POST['destination']; } ?>"> 
      </div> 
	  
	  <div class="row"> 
        <div class="col-sm-12">
          <label for="ticket_category"><b>Ticket Category   </b></label>
           <input type="radio" name="ticket_category" value="VVIP" class="radio" <?php if (isset($_POST['ticket_category']) && $_POST['ticket_category'] == 'VVIP'): ?>checked='checked'<?php endif; ?> /> VVIP
          <input type="radio" name="ticket_category" value="VIP"  class="radio" <?php if (isset($_POST['ticket_category']) && $_POST['ticket_category'] ==  'VIP'): ?>checked='checked'<?php endif; ?> /> VIP
          <input type="radio" name="ticket_category" value="Regular"  class="radio" <?php if (isset($_POST['ticket_category']) && $_POST['ticket_category'] ==  'Regualr'): ?>checked='checked'<?php endif; ?> /> Regular
        </div>
      </div>
	 
      <div class="row"> 
        <div class="col-sm-12">
          <label for="firstname"><b>Ticket Type   </b></label>
          <input type="radio" name="ticket_type" required
          <?php if (isset($ticket_type) && $ticket_type=="One Way") echo "checked";?>
          value="One Way">One Way
          <input type="radio" name="ticket_type" 
          <?php if (isset($ticket_type) && $ticket_type=="VIP") echo "checked";?>
          value="Return Ticket">Return Ticket 
        </div>
      </div>
      <div class="input-group"> 
        <label>Amount Paid</label> 
        <input type="text" name=amount_paid value="<?php if(isset($_POST['create'])){ echo $_POST['amount_paid']; } ?>"> 
      </div> 
      <div class="input-group"> 
        <label>Travel Date</label> 
        <input type="date" name="travel_date" value="<?php if(isset($_POST['create'])){ echo $_POST['travel_date']; } ?>"> 
      </div> 
      <div class="input-group"> 
        <label>Return Date</label> 
        <input type="date" name="return_date" value="<?php if(isset($_POST['create'])){ echo $_POST['travel_date']; } ?>"> 
      </div>  
      
        
      <input class="btn btn-success" type="submit" value="Book" name="create">
    
    </div>
  </form>

    <?php 
  }
   ?>
</div>
</div>
</div>
<script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>


