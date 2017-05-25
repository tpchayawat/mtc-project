<?php
	// start construction
	if(isset($_POST['start'])){
		if($_POST['start'] == 1){
			$cmd = "java -jar collect_res_test.jar 5 1 1";
			pclose(popen("start /B ". $cmd, "r"));
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