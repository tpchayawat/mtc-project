<?php
	function connectDB(){
		$servername = "localhost";
		$username = "root";
		$password = "toptop";
		$dbname = "mtc_project";
			
		// Create connection
		$con = new mysqli($servername, $username, $password, $dbname);
			
		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}
		else
			return $con;
	}
?>