<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	$conn->close();
?>

<html>
	<head>
		<title>History Exam Result - MTC E-Testing</title>
		<meta charset="utf-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- Custom Styles-->
		<link href="assets/css/custom-styles.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		<!-- Table Styles -->
		<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		<script src="assets/js/custom-scripts.js"></script>
		<script src="assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#result_tab").DataTable();
				
			});
		</script>
	</head>
	<body>
	
		<div id="wrapper">
			<nav class="navbar navbar-default top-navbar" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">MTC</a>
				</div>
				
				<ul class="nav navbar-top-links navbar-right">
					<!-- /.dropdown -->
					<li>
						<a class="" ><?php echo $userResult['student_id'].", ".$userResult['fname']." ".$userResult['lname'];?></a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
							<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $userResult['fname'];?></a>
							<li class="divider"></li>
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
							</li>
							<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
							</li>
							<li class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
							</li>
						</ul>
						<!-- /.dropdown-user -->
					</li>
					<!-- /.dropdown -->
				</ul>
			</nav>
			<!--/. NAV TOP  -->
			<nav class="navbar-default navbar-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav" id="main-menu">
						
						<li>
							<a href="student_home.php"><i class="fa fa-home"></i> Home</a>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-pencil-square-o"></i> Examination<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="select_testform_table.php">Choose Subject</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-check-square-o"></i> Result<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li>
									<a href="#">Overview</a>
								</li>
								<li>
									<a class="active-menu" href="exam_result.php">History Exam Result</a>
								</li>
							</ul>
						</li>
						
					</ul>
					
				</div>
				
			</nav>
			<!-- /. NAV SIDE  -->
			<div id="page-wrapper">
				<div id="page-inner">
					<div class="row">
						<div class="col-md-12">
							<h1 class="page-header">
								History Exam Result <small>Check out the past of exam result</small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="student_home.php">Home</a></li>
								<li><a href="#">Result</a></li>
								<li class="active">History Exam Result</li>
							</ol>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Select Test Form
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="result_tab" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<th>Subject</th>
															<th>Topic</th>
															<th>Form Name</th>
															<th>No. of time</th>
															<th>Score</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$conn = connectDB();
															
															
															$formQuery = mysqli_query($conn, "SELECT DISTINCT testform_id FROM log_answer WHERE user_id='".$userResult['user_id']."'");
															while($formResult = mysqli_fetch_array($formQuery)){
																$examNoQuery = mysqli_query($conn, "SELECT DISTINCT exam_no FROM log_answer WHERE user_id='".$userResult['user_id']."' AND testform_id='".$formResult['testform_id']."'");
																while($examNoResult = mysqli_fetch_array($examNoQuery)){
																	$logansQuery = mysqli_query($conn, "SELECT user_id,log_answer.item_id,answer,text_answer,choice_id FROM answer,log_answer WHERE user_id='".$userResult['user_id']."' AND testform_id='".$formResult['testform_id']."' AND exam_no='".$examNoResult['exam_no']."' AND answer.item_id=log_answer.item_id");
																	$score = 0;
																	$items = 0;
																	while($logansResult = mysqli_fetch_array($logansQuery)){
																		if($logansResult['answer'] == $logansResult['choice_id']){
																			$score++;
																		}
																		$items++;
																	}
																	
																	$tfNameQuery = mysqli_query($conn, "SELECT * FROM testform WHERE testform_id='".$formResult['testform_id']."'");
																	$tfNameResult = mysqli_fetch_array($tfNameQuery);
																	$nameQuery = mysqli_query($conn, "SELECT topic_name,course_id,course_name FROM `topic`,`constraint`,`subject` WHERE constraint.constraint_id='".$tfNameResult['constraint_id']."' AND constraint.topic_id=topic.topic_id AND topic.subject_id=subject.subject_id");
																	$nameResult = mysqli_fetch_array($nameQuery);
																	
																	
																	echo '<tr><td>'.$nameResult['course_id'].' '.$nameResult['course_name'].'</td>';
																	echo '<td>'.$nameResult['topic_name'].'</td>';
																	echo '<td>'.$tfNameResult['name'].'</td>';
																	echo '<td>'.$examNoResult['exam_no'].'</td>';
																	echo '<td>'.$score.'/'.$items.'</td>';
																	echo '</tr>';
																}
															}
															$conn->close();
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
	</body>
</html>	