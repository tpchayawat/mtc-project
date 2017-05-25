<?php
	header("Content-Type: text/html;charset=UTF-8");
	include('include/connect_db.php');
	
	if(isset($_POST["add_sub"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$t_data = $_POST["add_sub"];

		$conn->query("INSERT INTO subject (course_name,course_id,definition,user_create) VALUES ('".$t_data['cname']."','".$t_data['cid']."','".$t_data['cdef']."','".$t_data['user']."')");

		echo json_encode("Success! Subject has been added");

		$conn->close();
	}
	
	if(isset($_POST["add_topic"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$t_data = $_POST["add_topic"];

		$objQuery = mysqli_query($conn, "INSERT INTO topic (topic_name,definition,subject_id,user_create) VALUES ('".$t_data['tname']."','".$t_data['tdef']."','".$t_data['sub_id']."','".$t_data['user']."')");

		echo json_encode("Success! Topic has been added");

		$conn->close();
	}
	
	if(isset($_POST["sub_id"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$sub_id = $_POST["sub_id"];
		$data = array();

		$objQuery = mysqli_query($conn, "SELECT * FROM topic WHERE subject_id=".$sub_id);
		while($objResult = mysqli_fetch_array($objQuery)){
			array_push($data, $objResult);
		}
		echo json_encode($data);

		$conn->close();
	}
	
	/*if(isset($_POST["topic_id"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$t_id = $_POST["topic_id"];
		$item = array();

		$objQuery = mysqli_query($conn, "SELECT i.question,p.a,p.b,p.time FROM item i,item_param p WHERE i.topic_id=$t_id AND i.item_id=p.item_id");
		while($objResult = mysqli_fetch_array($objQuery)){
			array_push($item, $objResult);
		}
		echo json_encode($item);

		$conn->close();
	}*/
	
	if(isset($_POST["topic_id"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$t_id = $_POST["topic_id"];
		$itemset = array();
		
		//$objQuery = mysqli_query($conn, "SELECT i.item_id,i.cat_id,i.question,p.a,p.b,p.time FROM item i,item_param p WHERE i.topic_id=$t_id AND i.item_id=p.item_id");
		$objQuery = mysqli_query($conn, "SELECT i.*,p.a,p.b,p.time,ic.cat_name,a.choice_id FROM item i,item_param p,answer a,item_category ic WHERE i.topic_id=$t_id AND i.item_id=p.item_id AND i.item_id=a.item_id AND i.cat_id=ic.cat_id");
		while($paramResult = mysqli_fetch_array($objQuery)){
			$item = array();
			$choice = array();
			//$chQuery = mysqli_query($conn, "SELECT `order`,`content` FROM choice WHERE item_id=".$paramResult['item_id']); ****
			$chQuery = mysqli_query($conn, "SELECT * FROM choice WHERE item_id=".$paramResult['item_id']);
			while($chResult = mysqli_fetch_array($chQuery)){
				//array_push($choice,$chResult['content']);  ****
				array_push($choice,$chResult);
			}
			array_push($item, $paramResult);	// item[0] = item data
			array_push($item, $choice);			// item[1] = choices of item
			array_push($itemset, $item);
		}
		echo json_encode($itemset);

		$conn->close();
	}
	
	if(isset($_POST["submit_man"])){
		$conn = connectDB();
		$data = $_POST["submit_man"];
		$insConstr = "INSERT INTO `constraint` (`total_item`,`total_form`,`subject_id`,`note`,user_create) VALUES ('".$data['total_item']."','".$data['total_form']."','".$data['s_id']."','".$data['note']."','".$data['user']."')";

		if($conn->query($insConstr) === TRUE){
			$last_constr_id = $conn->insert_id;
			$insTestForm = "INSERT INTO testform SET constraint_id='".$last_constr_id."',name='".$data['testform_name']."'";
			if($conn->query($insTestForm) === TRUE){
				$last_testform_id = $conn->insert_id;
				$itemset = $data['selected_item'];
				if($data['shuffle'] != 0)
					shuffle($itemset);
				foreach($itemset as &$item){
					$conn->query("INSERT INTO form SET form_id='".$last_testform_id."', testform_id='".$last_testform_id."', item_id='".$item."'");
				}
				echo json_encode("Construction completed");
			}
		}
		else{
			$isSucc = $a;
			echo json_encode("Cannot construct test form");
		}
		
		$conn->close();
		
		//echo json_encode($data['selected_item']);
	}
	
	// ##### AUTO CONSTRUCTION #####
	if(isset($_POST["submit_auto"])){
		$conn = connectDB();
		$data = $_POST["submit_auto"];
		$insConstr = "INSERT INTO `constraint` (constraint_name,mode,difficulty_target,total_item,total_form,duplicate_rate,topic_id,subject_id,note,user_create)"
						." VALUES ('".$data['name']."',1,'".$data['df_target']."','".$data['total_item']."','".$data['total_form']."','".$data['dup_rate']."','"
						.$data['t_id']."','".$data['s_id']."','".$data['note']."','".$data['user']."')";

		if($conn->query($insConstr) === TRUE){
		//if(TRUE){
			$last_constr_id = $conn->insert_id;
			//$last_constr_id = 1;
			$const_id = $last_constr_id;
			$result = array("isSuccess"=>1,"constr_id"=>$last_constr_id,"user"=>$data['user']);
			// exec here
			//$cmd = "java -jar stream_test.jar "."$last_constr_id ".$data['s_id']." ".$data['t_id'];
			//exec($cmd, $output);
			echo json_encode($result);
		}
		else{
			echo json_encode(array("isSuccess"=>0,"error"=>$conn->error));
		}
		
		$conn->close();
		
		//echo json_encode($data['selected_item']);
	}
	
	// start construction
	if(isset($_POST['start'])){
		if($_POST['start'] == 1){
			$constr_data = $_POST['constr_data'];
			$constr_id = $_POST['constr_data']['constr_id'];
			$subject_id = $_POST['constr_data']['sub_id'];
			$topic_id = $_POST['constr_data']['topic_id'];
			/*
				FORM CONSTRAINT PARAMETER
				ARGS[0]: CONSTRAINT_ID, ARGS[1]: SUBJECT_ID, ARGS[2]: TOPIC_ID
				CONSTRUCTION PARAMETER
				ARGS[3]: LOOP, ARGS[4]: NUMBER OF WORKERS
			*/
			$cmd = "java -jar mtc_version_1-1.jar ".$constr_id." ".$subject_id." ".$topic_id." 3000 4";
			// for windows
			pclose(popen("start /B ". $cmd, "r"));
			// for unix
			// exec($cmd." > /dev/null 2>/dev/null &");
			
			echo 1;
		}
	}
	
	// live feedind
	if(isset($_POST['constr_id'])){
		$constr_id = $_POST['constr_id'];
		//$constr_id = 5;
		$text_buffer = [];
		$myfile = fopen("C:\\xampp\\htdocs\\mtc-project\\tmp\constr\\tmp-constr-".$constr_id.".txt", "r") or die("Unable to open file!");
		//echo fgets($myfile);
		while(!feof($myfile)) {
			//echo fgets($myfile) . "<br>";
			$str = fgets($myfile);
			array_push($text_buffer,preg_replace('/\s+/', '', $str));
		}
		fclose($myfile);
		
		//json_encode($text_buffer);
		echo json_encode($text_buffer);
	}
	
?>