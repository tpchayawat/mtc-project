<?php
	include('include/connect_db.php');
	
	if(isset($_POST['logans'])){
		$ansset = $_POST['logans'];
		
		date_default_timezone_set("Asia/Bangkok");
		$s_time = $ansset["s_time"];
		//$start_time = date('Y-m-d H:i:s', $s_time);
		$s_time = substr($s_time, 0, strpos($s_time, '('));
		$start_time = date('Y-m-d H:i:s', strtotime($s_time));
		
		$conn = connectDB();
		
		$insLogans = 'INSERT INTO log_answer (user_id,testform_id,exam_no,item_id,answer,start_time) VALUES ("'.$ansset["user_id"].'","'.$ansset["tf_id"].'","'.$ansset["exam_no"].'","'.$ansset["item_id"].'","'.$ansset["textans"].'","'.$start_time.'")';
		if(!$conn->query($insLogans)){
			echo json_encode($conn->error);
		}
		else{
			$submit_time = time();
			echo json_encode($submit_time);
		}
		$conn->close();
	}
	
	if(isset($_POST['check_score'])){
		$check = $_POST['check_score'];
		$user_id = $check['user_id'];
		$testform_id = $check['tf_id'];
		$exam_no = $check['exam_no'];
		
		$conn = connectDB();
		$sql = 'SELECT user_id,log_answer.item_id,answer,text_answer,choice_id FROM answer,log_answer WHERE log_answer.user_id='.$user_id.' AND log_answer.testform_id="'.$testform_id.'" AND log_answer.exam_no="'.$exam_no.'" AND answer.item_id=log_answer.item_id';
		$objQuery = mysqli_query($conn, $sql);
		$score = 0;
		while($objResult = mysqli_fetch_array($objQuery)){
			if($objResult['answer'] == $objResult['choice_id']){
				$score++;
			}
		}
		echo json_encode($score);
		
		$conn->close();
	}
?>