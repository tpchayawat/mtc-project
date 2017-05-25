<?php
	include('include/connect_db.php');
	
	if(isset($_POST["get_testform_data"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$data = $_POST["get_testform_data"];
		$u_id = $data['u_id'];
		$tf_id = $data['tf_id'];
		
		$tfSQL = "SELECT c.constraint_id,tf.testform_id,c.total_form,c.total_item,i.*,p.a,p.b,p.time,ic.cat_name 
					FROM item i,`constraint` c,testform tf,form f,item_param p,user_account u,item_category ic,answer ans 
					WHERE c.constraint_id=tf.constraint_id AND tf.testform_id=f.testform_id AND f.item_id=p.item_id 
					AND c.user_create=u.user_id AND f.item_id=i.item_id AND i.cat_id=ic.cat_id AND i.item_id=ans.item_id
					AND tf.testform_id=".$tf_id." AND c.user_create=".$u_id;
			
		/*	
			[0] = constraint data
			[0][1] = constraint_id , [0][2] = testform_id , [0][3] = totalform , [0][4] = totalitem
			[1] = item data
			[1][i][0] = item_data
			[1][i][1] = item_param , [1][i][1][0] = a , [1][i][1][1] = b , [1][i][1][2] = time
		*/
		$tf_data = [];
		$item_data = [];
		$isFirst = false;
		
		$tfQuery = mysqli_query($conn,$tfSQL);
		while($tfResult = mysqli_fetch_array($tfQuery)){
			if(!$isFirst){
				$constr_data = [$tfResult['constraint_id'],$tfResult['testform_id'],$tfResult['total_form'],$tfResult['total_item']];
				array_push($tf_data,$constr_data);
				$isFirst = true;
			}
			$item = [];
			$item_info = [$tfResult['item_id'],$tfResult['cat_name'],$tfResult['question'],$tfResult['pic_link']];
			array_push($item,$item_info);
			$param = [$tfResult['a'],$tfResult['b'],$tfResult['time']];
			array_push($item,$param);
			array_push($item_data,$item);
		}
		array_push($tf_data,$item_data);
		
		echo json_encode($tf_data);
		$conn->close();
	}
	
	if(isset($_POST["get_testform_data2"]) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
		$conn = connectDB();
		$data = $_POST["get_testform_data2"];
		$tf_id = $data['tf_id'];
		$itemset = array();
		//$tfset = [];
		//$isDone = false;
		
		//$objQuery = mysqli_query($conn, "SELECT i.item_id,i.cat_id,i.question,p.a,p.b,p.time FROM item i,item_param p WHERE i.topic_id=$t_id AND i.item_id=p.item_id");
		$objQuery = mysqli_query($conn, "SELECT i.*,p.a,p.b,p.time,ic.cat_name,a.choice_id 
											FROM item i,item_param p,answer a,item_category ic,testform tf,`constraint` c,form f  
											WHERE tf.testform_id=$tf_id AND c.constraint_id=tf.constraint_id 
												AND tf.testform_id=f.testform_id AND f.item_id=i.item_id AND i.item_id=p.item_id 
												AND i.item_id=a.item_id AND i.cat_id=ic.cat_id");
											
		while($itemResult = mysqli_fetch_array($objQuery)){
			
			/* if(!$isDone){
				$tf_info = ['constraint_id'=>$itemResult['constraint_id'],'testform_id'=>$itemResult['testform_id']
							,'name'=>$itemResult['name'],'total_item'=>$itemResult['total_item'],'total_form'=>$itemResult['total_form']
							,'subject_id'=>$itemResult['subject_id']];
				//array_push($tf_info, $item);
				$isDone = true;
			} */
			
			$item = array();
			$choice = array();
			//$chQuery = mysqli_query($conn, "SELECT `order`,`content` FROM choice WHERE item_id=".$paramResult['item_id']); ****
			$chQuery = mysqli_query($conn, "SELECT * FROM choice WHERE item_id=".$itemResult['item_id']);
			while($chResult = mysqli_fetch_array($chQuery)){
				//array_push($choice,$chResult['content']);  ****
				array_push($choice,$chResult);
			}
			array_push($item, $itemResult);	// item[0] = item data
			array_push($item, $choice);			// item[1] = choices of item
			array_push($itemset, $item);
		}
		
		//array_push($tfset, $tf_info);	// ifset[0] = testform info
		//array_push($tfset, $itemset);	// ifset[1] = itemset data
			
		echo json_encode($itemset);

		$conn->close();
	}
?>