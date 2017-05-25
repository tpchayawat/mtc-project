<?php
	$cmd = "java -jar collect_res_test.jar 5 1 1";
	
	/*echo '<pre>';
	passthru($cmd);
	echo '</pre>';*/
	
	/* if(isset($_POST['init'])){
		$init = $_POST['init'];
		//echo $init;
		
		if($init == 1){
			//echo "start ";
			//while (@ ob_end_flush()); // end all output buffers if any
			//$handle = popen($cmd, 'r');
		}
		else if($init == 0){
			echo "update ";
			/*if(!feof($handle)){
				echo fread($handle, 4096);
				@ flush();
			}
			pclose($handle);
		}
	} */
	
	//$cmd = "ping 127.0.0.1";
	ob_implicit_flush(true);ob_end_flush();
	
	$descriptorspec = array(
	   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
	   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
	   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
	);
	flush();
	$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), NULL);
	echo "<pre>";
	if (is_resource($process)) {
		while ($s = fgets($pipes[1])) {
			print "<pre>".$s."</pre>";
			flush();
		}
		//echo stream_get_contents($pipes[1]);
	}
	echo "</pre>";
	
	proc_close($process);
?>