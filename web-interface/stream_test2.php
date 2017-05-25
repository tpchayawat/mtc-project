<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	
	// test exec
	$cmd = "java -jar collect_res_test.jar 5 1 1";
	pclose(popen("start /B ". $cmd, "r"));
	//shell_exec($cmd);
?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>TEST - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script src='assets/js/d3/d3.min.js'></script>
		<script src='assets/js/nvd3/build/nv.d3.min.js'></script>
		<link href="assets/js/nvd3/build/nv.d3.min.css" rel="stylesheet" type="text/css"/>
		
		<script src='assets/js/jquery.redirect.js'></script>
		
		<script src='assets/js/bootstrap-slider.min.js'></script>
		<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet" type="text/css"/>
		
		<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
		
		<script type="text/javascript">
			
			function initFeed(){
				$.ajax({
					url: 'stream_test.php',
					data: {init:1},
					type: 'POST',
					success: function(response){
						$('#test').append(response);
					}
				});
			}
			
			function updateFeed(){
				$.ajax({
					url: 'stream_test.php',
					data: {init:0},
					type: 'POST',
					success: function(response){
						$('#test').append(response);
						setTimeout(updateFeed,3000);
					}
				});
			}
			
			
			var lastResult = 0;
			var isDone = false;
			function readFeed(){
				if(!isDone){
					$.ajax({
						url: 'stream_test3.php',
						data: {constr_id:5},
						type: 'POST',
						success: function(response){
							//alert(response);
							var result = JSON.parse(response);
							lastResult = result[result.length-1];
							$('#test').html(lastResult);
							setTimeout(readFeed,2000);
						}
					});
				}
				if(lastResult == 4){isDone = true;}
				//alert(lastResult);
			}
			//initFeed();
			//updateFeed();
			//readFeed();
			
			$(document).ready(function(){
			
				//$("#test").load("stream_test.php");
				
				/*setInterval(function(){
					//jQuery code..
					$.ajax({
						url: 'url_to_get_feeds',
						data: {}, //if need put some param on request
						success: function(callback){
							//logic to put call content to html
							//callback recive all content gerenated on the page 'url_to_get_feeds'
							$('body').append(callback)
						}
					})
				});*/
				$('#check_status').click(function(){
					readFeed();
				});
				
			});
		</script>
	</head>
	
	<body>
		<img src="assets/img/black_ribbon_bottom_left.png" class="black-ribbon stick-bottom stick-left"/>
		<?php
			//$page_title = "Home - MTC System";
			//$page_description = "Home for Administrator";
			include("include/header.php");
			include("include/navigation.php");
		?>
		<!-- Main Content -->
		<div class="container-fluid">
			<div class="side-body">
				<!-- Page Header -->
				<div class="row">
					<div class="col-md-12">
						<h1 class="page-header">
							TESTs <small>test</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="testform_new.php">Test Forms</a></li>
							<li class="active">Constructor Monitor</li>
						</ol>
					</div>
				</div>
				
				<!-- Contents -->
				<div class="row">
					<div class="col-md-12">
						
						<div class="panel panel-default">
							<div class="panel-heading">
								Current Construction
							</div>
							<div class="panel-body">
								<div id="test"></div>
								<button type="button" id="check_status"> CHECK STATUS </button>
							</div>
						</div>
						
					</div>
				</div>
				<!-- End Contents -->
			</div>
		</div>
	</body>
</html>											