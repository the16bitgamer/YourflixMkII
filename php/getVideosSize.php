<?php
	$servername = "localhost";
	$username = "pi";
	$password = "raspberry";
	$dbname = "Pi_YourFlix_Data";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	$request = "SELECT COUNT(*) FROM YourFlix_VideoInfo";
	$result = $conn->query($request);
	$conn->close();
	
	$count = mysqli_fetch_array($result);
	echo $count[0];
?>