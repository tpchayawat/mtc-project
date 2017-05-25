<?php
	session_start();
	
	include('connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE username='".mysql_real_escape_string($_POST['username'])."' 
	AND password='".mysql_real_escape_string($_POST['password'])."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$objResult = mysqli_fetch_array($objQuery);
	if(!$objResult){
		echo "Username and Password Incorrect!";
	}
	else{
		$_SESSION["user_id"] = $objResult["user_id"];
		$_SESSION["status"] = $objResult["type"];

		session_write_close();
		
		if($objResult["type"] == 0){
			header("location:admin_home.php");
		}
		else{
			header("location:student_home.php");
		}
	}
	$conn->close();
?>