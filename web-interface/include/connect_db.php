<?php
	function connectDB(){
		$servername = "localhost";
		$username = "root";
		$password = "toptop";
		$dbname = "mtc_project";
			
		// Create connection
		$con = new mysqli($servername, $username, $password, $dbname);
		mysqli_set_charset($con,"utf8");
			
		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}
		else
			return $con;
	}
?>