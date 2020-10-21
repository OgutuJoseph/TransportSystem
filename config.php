<?php 
class RaviKoQr
{
  public $server = "localhost";
  public $user = "root";
  public $pass = "";
  public $dbname = "transport-system";
	public $conn;
  public function __construct()
  {
  	$this->conn= new mysqli($this->server,$this->user,$this->pass,$this->dbname);
  	if($this->conn->connect_error)
  	{
  		die("connection failed");
  	}
  }
 	public function insertQr($firstname,$final,$qrimage,$qrlink,$lastname,$destination,$amount_paid,$travel_date,$return_date,$ticket_category,$ticket_type)
 	{
 			$sql = "INSERT INTO bookings(firstname,idno,qrImg,qrlink,lastname,destination,amount_paid,travel_date,return_date,ticket_category,ticket_type) VALUES('$firstname','$final','$qrimage','$qrlink','$lastname','$destination','$amount_paid','$travel_date','$return_date','$ticket_category','$ticket_type')";
 			$query = $this->conn->query($sql);
 			return $query;

 	
 	}
 	public function displayImg()
 	{
 		$sql = "SELECT qrimg,qrlink from bookings where qrimg='$qrimage'";

 	}
}
$meravi = new RaviKoQr();