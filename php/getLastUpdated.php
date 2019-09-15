<?php
// Format example '1970-01-01 00:00:01.000000'

	$currentTime = date("Y-m-d G:i:s");
	
	//Time in Minutes
	$delay = 10;

	$servername = "localhost";
	$username = "pi";
	$password = "raspberry";
	$dbname = "Pi_YourFlix_Data";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		echo "False";
		die("Connection failed: " . $conn->connect_error);
	}
	$request = "SELECT Time FROM Pi_TimeSheet WHERE Time_Log = 'Last Updated';";
	$result = $conn->query($request);
	$conn->close();
	
	$pulledDate = mysqli_fetch_array($result);
	
	if(implode(null,$pulledDate) == null)
	{
		$sql = "INSERT INTO Pi_TimeSheet (Time_Log, Time) VALUES ('Last Updated', '".$currentTime."');";
		$conn->query($sql);
		echo "True";
	}
	else
	{	
		$mysqldate = strtotime($pulledDate[0]);
		$mysqldate = $mysqldate + (60 * $delay);
		$phpdate = date( 'Y-m-d G:i:s', $mysqldate );
		
		if($currentTime > $phpdate)
			echo "True";
		else
			echo "False";
	}	
?>