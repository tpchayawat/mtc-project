<?php
	header("Content-Type: text/html;charset=UTF-8");
	include('include/connect_db.php');
	
	if(isset($_POST["checkDup_sub"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$dupsub_data = $_POST["checkDup_sub"];
		$cid = $dupsub_data['cid'];
		$cname = $dupsub_data['cname'];
		$dupID = FALSE;
		$dupName = FALSE;
		
		$sid = ($dupsub_data['sid']==""? -1 : $dupsub_data['sid']);
		
		$dupsubSql = "SELECT * FROM subject";
		$dupsubQuery = mysqli_query($conn,$dupsubSql);
		while($dupsubResult = mysqli_fetch_array($dupsubQuery)){
			if($cid == $dupsubResult['course_id'] && $sid!=$dupsubResult['subject_id']){
				$dupID = TRUE;
			}
			if($cname == $dupsubResult['course_name'] && $sid!=$dupsubResult['subject_id']){
				$dupName = TRUE;
			}
			if($dupID || $dupName)break;
		}
		$dup_data = array("id"=>$dupID,"name"=>$dupName);
		echo json_encode($dup_data);
		$conn->close();
	}
	
	if(isset($_POST["checkDup_topic"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$duptopic_data = $_POST["checkDup_topic"];
		$tname = $duptopic_data['tname'];
		$dupName = FALSE;
		
		$tid = ($duptopic_data['tid']==""? -1 : $duptopic_data['tid']);
		
		$duptopicSql = "SELECT * FROM topic";
		$duptopicQuery = mysqli_query($conn,$duptopicSql);
		while($duptopicResult = mysqli_fetch_array($duptopicQuery)){
			if($tname == $duptopicResult['topic_name'] && $tid!=$duptopicResult['topic_id']){
				$dupName = TRUE;
			}
			if($dupName)break;
		}
		$dup_data = array("name"=>$dupName);
		echo json_encode($dup_data);
		$conn->close();
	}
	
	if(isset($_POST["add_sub"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$s_data = $_POST["add_sub"];
		
		if($s_data['isEdit']==0) //echo json_encode('not edit');
			$subSQL = "INSERT INTO subject (course_name,course_id,definition,user_create) VALUES ('".$s_data['cname']."','".$s_data['cid']."','".$s_data['cdef']."','".$s_data['user']."')";
		else //echo json_encode('edit');
			$subSQL = "UPDATE subject SET course_name='".$s_data['cname']."',course_id='".$s_data['cid']."',definition='".$s_data['cdef']."' WHERE subject_id=".$s_data['sid'];
		
		if($conn->query($subSQL))
			echo json_encode("Success! Subject has been added");
		else
			echo json_encode("Fail! Cannot add subject");

		$conn->close();
	}
	
	if(isset($_POST["add_topic"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$t_data = $_POST["add_topic"];
		
		if($t_data['isEdit']==0)
			$topicSQL = "INSERT INTO topic (topic_name,definition,objective,subject_id,user_create) VALUES ('".$t_data['tname']."','".$t_data['tdef']."','".$t_data['tobj']."','".$t_data['sub_id']."','".$t_data['user']."')";
		else
			$topicSQL = "UPDATE topic SET topic_name='".$t_data['tname']."',definition='".$t_data['tdef']."',objective='".$t_data['tobj']."' WHERE topic_id=".$t_data['tid'];
		
		if($conn->query($topicSQL))
			echo json_encode("Success! Topic has been added");
		else
			echo json_encode("Fail! Cannot add topic");

		$conn->close();
	}
	
	if(isset($_POST["add_item"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$item_data = $_POST["add_item"];
		$pic = NULL;
		if($item_data['pic'] != '')
			$pic = $item_data['pic'];
		$itemSql = "INSERT INTO item (cat_id,type,question,pic_link,refer,author_id,topic_id,subject_id) VALUES ('".$item_data['cat_id']."','".$item_data['ans_type']."','".$item_data['ques_text']."','".$item_data['pic']."','".$item_data['refer']."','".$item_data['user']."','".$item_data['topic_id']."','".$item_data['sub_id']."')";
		if($conn->query($itemSql)){
		//if(true){
			$last_ins_item = $conn->insert_id;
			$paramSql = "INSERT INTO item_param (a,b,time,item_id) VALUES ('".$item_data['param_a']."','".$item_data['param_b']."','".$item_data['param_t']."','".$last_ins_item."')";
			if($conn->query($paramSql)){
			//if(true){
				$choices = $item_data['choices'];
				$ca = $item_data['correctans'];
				$i = 1;
				foreach($choices as &$ch){
					$choiceSql = "INSERT INTO `choice` (`order`,`item_id`,`content`) VALUES ('".$i."','".$last_ins_item."','".$ch."')";
					//echo json_encode($choiceSql);
					$conn->query($choiceSql);
					if($i == $ca){
						$ch_id = $conn->insert_id;
						$cansSql = "INSERT INTO `answer` (`item_id`,`choice_id`) VALUES ('".$last_ins_item."','".$ch_id."')";
						$conn->query($cansSql);
					}
					$i++;
				}

				// send item_id back, if error send 0 back
				echo json_encode($last_ins_item);
				//echo json_encode("Success! Item has been added");
			}
			else{echo json_encode(0);}
			//else{echo json_encode("Failure! Cannot add Item");}
		}
		else{echo json_encode(0);}
		//else{echo json_encode("Failure! Cannot add Item");}

		$conn->close();
	}
	
	// upload image
	if(isset($_POST["pic_id"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		if (0 < $_FILES['file']['error']){
			echo json_encode('Error: ' . $_FILES['file']['error'] . '<br>');
		}
		else{
			// upload part
			$file_path = pathinfo($_FILES["file"]["name"]);
			$dirname = $_POST['pic_id'];
			$target = 'uploads/'.$dirname.'/img_'.$dirname.'.'.$file_path["extension"];
			mkdir('uploads/'.$dirname,0777,TRUE);
			move_uploaded_file($_FILES['file']['tmp_name'], $target);
			//rename($target, $dirname);
			// update image link
			$conn = connectDB();
			$sql = "UPDATE item SET pic_link='".$target."' WHERE item_id=".$dirname;
			if($conn->query($sql)){
				echo json_encode("image uploaded");
			}
			else{echo json_encode("Update path FAIL");}
			$conn->close();
		}
	}
	
	// upload text file to import item
	if(isset($_POST['subject_id']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		if (0 < $_FILES['file']['error']){
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else{
			$sub_id = $_POST["subject_id"];
			$topic_id = $_POST["topic_id"];
			// exec part
			exec("java -jar item_import.jar ".$sub_id." ".$topic_id." ".$_FILES['file']['tmp_name']." 2>&1", $output);
			//exec("java -jar test_file.jar ".$sub_id." ".$topic_id." ".$_FILES['file']['tmp_name']." 2>&1", $output);
			//exec("java -jar hello.jar 2>&1", $output);
			echo $output;
			//echo $sub_id." ".$topic_id;
		}
	}
	
	if(isset($_POST["get_item_data"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$u_id = $_POST["get_item_data"];
		
		$itemSQL = "SELECT i.item_id,s.subject_id,s.course_name,s.course_id,t.topic_id,t.topic_name,p.a,p.b,p.time 
					FROM item_param p,item i,subject s,topic t,user_account u,course_owner owner 
					WHERE owner.user_id=".$u_id." AND s.subject_id=owner.subject_id
					AND s.subject_id=t.subject_id AND t.topic_id=i.topic_id AND i.item_id=p.item_id
					GROUP BY item_id";
		
		$itemQuery = mysqli_query($conn,$itemSQL);
		$items_param = [];
		while($itemResult = mysqli_fetch_array($itemQuery)){
			$item = array("s_id"=>$itemResult['subject_id'],"c_name"=>$itemResult['course_name'],"c_id"=>$itemResult['course_id'],
							"t_id"=>$itemResult['topic_id'],"t_name"=>$itemResult['topic_name'],
							"a"=>$itemResult['a'],"b"=>$itemResult['b'],"time"=>$itemResult['time']);
			array_push($items_param,$item);
			/*$item = array($itemResult['subject_id'],$itemResult['topic_id'],$itemResult['a'],$itemResult['b'],$itemResult['time']);
			array_push($items_param,$item);*/
		}
		echo json_encode($items_param);
		$conn->close();
	}

?>