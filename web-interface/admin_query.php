<?php
	include('include/connect_db.php');
	
	if(isset($_POST['user_sel']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$uid = $_POST['user_sel'];
		
		$conn = connectDB();
		
		$selUserSQL = "SELECT * FROM user_account";
		if(!$selUserResult = $conn->query($selUserSQL)){
			echo $conn->error;
		}
		else{
			while($user = $selUserResult->fetch_array(MYSQLI_ASSOC)){
				if($uid == $user['user_id']){
					echo json_encode($user);
				}
			}
		}
	}
	
	if(isset($_POST["addu"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		
		//$isEdit = $_POST['addu']['isEdit'];
		$param = $_POST['addu']['udata'];
		$udata = array();
		parse_str($param, $udata);
		
		//if($isEdit == 0){
		if(!isSet($_POST['addu']['user_sel'])){
			$addu_sql = "INSERT INTO user_account (username,password,type,fname,lname,email,department) VALUES ('".$udata['username']."','".$udata['password']
					."','".$udata['role_id']."','".$udata['fname']."','".$udata['lname']."','".$udata['email']."','".$udata['depart']."')";
		}
		else{
			$user_sel = $_POST['addu']['user_sel'];
			$addu_sql = "UPDATE user_account SET username='".$udata['username']."',password='".$udata['password']
					."',type='".$udata['role_id']."',fname='".$udata['fname']."',lname='".$udata['lname']."',email='".$udata['email']."',department='".$udata['depart']."' "
					."WHERE user_id=".$user_sel;
		}
		
		//echo json_encode($addu_sql);
		$conn = connectDB();
		if($conn->query($addu_sql)){
			if(!isSet($_POST['addu']['user_sel']))
				echo json_encode("Success! User has been added.");
			else
				echo json_encode("Success! User has been updated.");
		}
		else
			echo "Fail! Cannot add user\n".$conn->error;
		
		$conn->close();
	}
	else{
		/* $data = $_POST['addu'];
		$param = array();
		parse_str($data, $param);
		echo json_encode($param); */
	}
	
	if(isset($_POST["addcourse"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		
		// course data
		$isEdit = $_POST["addcourse"]["isEdit"];
		$cuser = $_POST["addcourse"]["cuser"];
		$param = $_POST["addcourse"]["cdata"];
		$cdata = array();
		parse_str($param, $cdata);
		// user data
		
		// sql query
		$conn = connectDB();
		$isError = false;
		if($isEdit == 0){ // create
			$course_sql = "INSERT INTO subject (course_name,course_id,definition,user_create) VALUES ('".$cdata['cname']."','".$cdata['cid']."','".$cdata['cdef']."','".$cuser."')";
			if($conn->query($course_sql)){
				$last_sub_id = $conn->insert_id;
				// get all admin to assign
				if($adminResult = $conn->query("SELECT user_id FROM user_account WHERE type=0")){
					while($admin = $adminResult->fetch_array(MYSQLI_ASSOC)){
						// assign course_owner
						$assign_sql = "INSERT INTO course_owner (subject_id,user_id,adder_user) VALUES ('".$last_sub_id."','".$admin['user_id']."','".$cuser."')";
						if(!$conn->query($assign_sql))
							$isError = true;
					}
				}
			}
			else
				$isEdit = true;
		}
		else{ // edit
			$course_sql = "UPDATE subject SET course_name='".$cdata['cname']."',course_id='".$cdata['cid']."',definition='".$cdata['cdef']."' WHERE subject_id=".$cdata['sid'];
			if(!$conn->query($course_sql))
				$isEdit = true;
		}
		
		if(!$isError)
			echo "Success! Course has been created";
		else
			echo "Fail! Cannot create Course\n".mysql_error();

		$conn->close();
	}
	
	if(isset($_POST["getInstr"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$instrSQL = "SELECT * FROM user_account u,course_owner own 
					WHERE u.user_id=own.user_id 
					AND own.subject_id=".$_POST["getInstr"];
		$conn = connectDB();
		if(!$instrResult = $conn->query($instrSQL)){
			echo $conn->error;
		}
		else{
			$instr_set = [];
			while($row = $instrResult->fetch_array(MYSQLI_ASSOC)){
				$instr = array('fname'=>$row['fname'], 'lname'=>$row['lname'], 'user_id'=>$row['user_id'], 'type'=>$row['type']);
				array_push($instr_set, $instr);
			}
			echo json_encode($instr_set);
		}
		$conn->close();
	}
	
	if(isset($_POST["assigncourse"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		
		//echo json_encode($_POST["addcourse"]);
		$as_data = $_POST["assigncourse"];
		$sub_id = $as_data['sub_id'];
		$u_id = $as_data['u_id'];
		$adder = $as_data['adder'];
		$isError = false;
		
		$conn = connectDB();
		foreach($u_id as $id){
			$assign_sql = "INSERT INTO course_owner (subject_id,user_id,adder_user) VALUES ('".$sub_id."','".$id."','".$adder."')";
			if(!$conn->query($assign_sql))
				$isError = true;
		}
		
		if(!$isError)
			echo "Success! User has been assigned";
		else
			echo "Fail! Cannot assign user\n".$conn->error;

		$conn->close();
	}
?>