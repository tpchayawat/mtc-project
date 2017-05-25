<?php
	session_start();
	
	include('connect_db.php');
	$conn = connectDB();
	
	/* $strSQL = "SELECT * FROM user_account WHERE username='".mysql_real_escape_string($_POST['username'])."' 
	AND password='".mysql_real_escape_string($_POST['password'])."'"; */
	$strSQL = "SELECT * FROM user_account WHERE username='".$_POST['username']."' 
	AND password='".$_POST['password']."'";
	$userQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($userQuery);
	if(!$userResult){
		echo "Username and Password Incorrect!";
	}
	else{
		$_SESSION["user_id"] = $userResult["user_id"];
		$_SESSION["type"] = $userResult["type"];
		$_SESSION["fname"] = $userResult["fname"];
		$_SESSION["lname"] = $userResult["lname"];
		
		// query course owner
		if($userResult["type"] != 0){
			$course_sql = "SELECT s.subject_id FROM subject s,course_owner owner"
						." WHERE s.subject_id=owner.subject_id"
						." AND owner.user_id=".$userResult["user_id"];
		}
		else{
			$course_sql = "SELECT s.subject_id FROM subject s";
		}
		
		// sql query
		if(!$cResult = $conn->query($course_sql)){
			echo $conn->error;
		}
		else{
			$courses = [];
			while($course = $cResult->fetch_array(MYSQLI_ASSOC)){
				array_push($courses, $course['subject_id']);
			}
			$_SESSION["courses"] = $courses;
			
			session_write_close();
		
			if($userResult["type"] == 0 || $userResult["type"] == 1){
				header("location:../admin_home_new.php");
			}
			else{
				header("location:../student_home.php");
			}
		}
		
	}
	$conn->close();
?>