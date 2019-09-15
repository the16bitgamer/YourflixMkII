<?php
	$servername = "localhost";
	$username = "pi";
	$password = "raspberry";
	$dbname = "Pi_YourFlix_Data";
	
	$time = date("Y-m-d G:i:s");
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	$update = "UPDATE Pi_TimeSheet SET Time = '".$time."' WHERE (Time_Log = 'Last Updated');";
	$results = $conn->query($update);
	$conn->close();
	
	$output = exec('python3 /var/www/html/php/python/UpdateDb.py');
	
	echo $output;
?>