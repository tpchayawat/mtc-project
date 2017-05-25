<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	
	$conn = connectDB();
	$curConstrSQL = "SELECT c.*,s.course_id,s.course_name FROM `constraint` c,subject s WHERE c.user_create=".$_SESSION['user_id']
					." AND c.mode=1 ORDER BY constraint_id DESC LIMIT 1";
	$curConstrResult = $conn->query($curConstrSQL);
	
	if ($curConstrResult->num_rows > 0) {
		$curConstr = $curConstrResult->fetch_assoc();
	}
	else{
		echo "0 results";
	}
?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Automatic Create Forms - MTC E-Testing</title>
		
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
			
			var label = ["Ready","Initiating","Combining","Collecting","Done"];
			
			var lastResult = 0;
			var isDone = false;
			function readFeed(){
				if(lastResult == 4){
					isDone = true;
					alert("Construction Completed");
					$('#start').hide();
					$('#result').removeClass('disabled').show();
				}
				if(!isDone){
					$.ajax({
						url: 'constr_query.php',
						//data: {constr_id:5},
						data: {constr_id:<?php echo $curConstr['constraint_id'];?>},
						type: 'POST',
						success: function(response){
							//alert(response);
							var result = JSON.parse(response);
							lastResult = result[result.length-1];
							if($('#status').text() != lastResult){
								if(lastResult > 1)
									moveStep();
								$('#status').html(label[lastResult]);
							}
							setTimeout(readFeed,2000);
						}
					});
				}
			}
			
			function moveStep(){
				var next = $('.bs-wizard').closest('div').find('.active').removeClass('active').toggleClass('complete');
				$(next).next().removeClass('disabled').toggleClass('active');
			}
		
			$(document).ready(function(){
				
				$('#result').addClass('disabled').hide();
				
				$('#start').click(function(){
					$('#start').addClass('disabled');
					var order = {start: 1,
						constr_data : {
							constr_id : <?php echo $curConstr['constraint_id'];?>,
							sub_id : <?php echo $curConstr['subject_id'];?>,
							topic_id : <?php echo $curConstr['topic_id'];?>
						}
					};
					$.ajax({
						url: 'constr_query.php',
						//data: {constr_id:5},
						data: order,
						type: 'POST',
						success: function(result){
							//alert(result);
							if(result == 1){
								alert("Construction Start");
								readFeed();
							}
						}
					});
				});
				
				$('#result').click(function(){
					$.redirect("auto_result.php",{});
				});
				
				//$('#next').click(function(){
				/*$('#status').change(function(){
					//$('.bs-wizard-step').toggleClass('complete');
					//$('.bs-wizard').closest('div').find('.active').next().css("background-color","red");
					var next = $('.bs-wizard').closest('div').find('.active').removeClass('active').toggleClass('complete');
					$(next).next().removeClass('disabled').toggleClass('active');
				});*/
				
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
							Constructor Monitor <small>Automatic Method</small>
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
						
						<div class="row text-center" style="border-bottom:0;">
							<div id="status" style="font-size: 100px;">Ready</div><br>
							<!-- <div style="font-size: 16px;">Progressing</div>-->
							<div>
								<button id="start" class="btn btn-primary btn-lg">Start</button>
								<button id="result" class="btn btn-success btn-lg">See Result</button>
							</div>
						</div>
						<!-- STEP PROGRESS BAR -->
						<div class="row bs-wizard" style="border-bottom:0;border-top:0;">
							<div class="col-xs-3 bs-wizard-step active">
							  <div class="text-center bs-wizard-stepnum">Initiate</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Loading item bank and form constraints.</div>
							</div>
							
							<div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Combine</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Creating the possible form which match the form constraint</div>
							</div>
							
							<div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
							  <div class="text-center bs-wizard-stepnum">Collect</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Finding multiple forms which match the form constraint</div>
							</div>
							
							<div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
							  <div class="text-center bs-wizard-stepnum">Finish</div>
							  <div class="progress"><div class="progress-bar"></div></div>
							  <a href="#" class="bs-wizard-dot"></a>
							  <div class="bs-wizard-info text-center">Multiple forms construction completed</div>
							</div>
						</div>
						<!-- END STEP PROGRESS BAR -->
						
						<div class="panel panel-default">
							<div class="panel-heading">
								Current Construction
							</div>
							<div class="panel-body">
								<!-- Current Constraint Contents -->
								<?php
									//echo "<h1>Constraint ID: ".$_POST["constr_id"]."</h1>";
									//$constr_id = $_POST["constr_id"];
									/* $conn = connectDB();
									$curConstrSQL = "SELECT c.*,s.course_id,s.course_name FROM `constraint` c,subject s WHERE c.user_create=".$_SESSION['user_id']
													." AND c.mode=1 ORDER BY constraint_id DESC LIMIT 1";
									$curConstrResult = $conn->query($curConstrSQL);
									
									if ($curConstrResult->num_rows > 0) {
										$curConstr = $curConstrResult->fetch_assoc(); */
										
										echo '<div class="row"><div class="col-sm-6">';
										echo '<b>Constraint Name: </b>'.$curConstr['constraint_name'].'<br>';
										echo '<b>Course: </b>'.$curConstr['course_name'].'<br>';
										echo '<b>Difficulty Level Target: </b>'.$curConstr['difficulty_target'].'</div>';
										echo '<div class="col-sm-6">';
										echo '<b>Total Items: </b>'.$curConstr['total_item'].'<br>';
										echo '<b>Total Forms: </b>'.$curConstr['total_form'].'<br>';
										echo '<b>Duplicate Rate: </b>'.$curConstr['duplicate_rate'].'</div>';
										echo '</div>';
										echo '<div class="row"><div class="col-sm-6">';
										echo '<b>Note: </b>'.$curConstr['note'].'</div>';
										echo '</div>';
										
									/* } else {
										echo "0 results";
									} */
								?>
								<!-- END Current Constraint Contents -->
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								Recent Construction
							</div>
							<div class="panel-body">
								<!-- Form Contents -->
								<?php
									//echo "<h1>Constraint ID: ".$_POST["constr_id"]."</h1>";
								?>
								<!-- /Form Contents -->
							</div>
						</div>
						
					</div>
				</div>
				<!-- End Contents -->
			</div>
		</div>
	</body>
</html>											