<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	$testform_id = $_GET['test_id'];
	$testSQL = "SELECT tf.name,s.course_name,s.course_id FROM `testform` tf, `constraint` c,`subject` s WHERE tf.testform_id=".$testform_id." AND tf.constraint_id=c.constraint_id AND t.subject_id=s.subject_id";
	$testQuery = mysqli_query($conn, $testSQL);
	$testResult = mysqli_fetch_array($testQuery);
	
	$conn->close();
?>

<html>
	<head>
		<title><?php echo $testResult['name'].' Exam Result - MTC E-Testing';?></title>
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
				//$("#result_tab").DataTable();
				
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
					<a class="navbar-brand" href="index.html">E-Testing</a>
				</div>
				
				<ul class="nav navbar-top-links navbar-right">
					<!-- /.dropdown -->
					<li>
						<a class="" ><?php echo $userResult['fname']." ".$userResult['lname'];?></a>
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
							<a href="admin_home.php"><i class="fa fa-home"></i> Home</a>
						</li>
						
						<li>
							<a href="itembank.php"><i class="fa fa-files-o"></i> Item Bank<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li class="active">
									<a href="itembank.php">Overview</a>
								</li>
								<li>
									<a href="create_sub.php">Add Course</a>
								</li>
								<li>
									<a href="create_topic.php">Add Topic</a>
								</li>
								<li class="active">
									<a href="create_item.php">Add Item</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-sitemap"></i> Constraint<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#">Overview</a>
								</li>
								<li>
									<a href="#">Add Constraint</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-file-text-o"></i> Test Forms<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="testform.php">Overview</a>
								</li>
								<li>
									<a href="constr_man.php">Create Form</a>
								</li>
								<li>
									<a href="#">Search</a>
								</li>
							</ul>
						</li>
						
						<li class="active-menu">
							<a href="#"><i class="fa fa-pencil-square-o"></i> Examination<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li>
									<a href="#">Overview</a>
								</li>
								<li class="active">
									<a href="admin_sublist.php">Student Exam Result</a>
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
								<?php echo $testResult['name'].' Exam Result';?> <small><?php echo $testResult['topic_name'].', '.$testResult['course_id'].' - '.$testResult['course_name'];?></small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="#">Examination</a></li>
								<li><a href="admin_sublist.php">Student Exam Result</a></li>
								<li class="active"><?php echo $testResult['name'].' Exam Result';?></li>
							</ol>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Exam Details
								</div>
								<div class="panel-body">
								
									<div class="row">
										<div class="col-md-12">
											<!-- <label for="exam_detail">Details</label> -->
											<table id="exam_detail" class="table table-striped table-bordered table-hover" role="grid">
												<thead>
													<tr>
														<th colspan="4" class="text-center">Details</th>
													</tr>
													<tr>
														<th>Test Name</th>
														<th>Topic</th>
														<th>Subject</th>
														<th>Instructor</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $testResult['name'];?></td>
														<td><?php echo $testResult['topic_name'];?></td>
														<td><?php echo $testResult['course_id'].' - '.$testResult['course_name']?></td>
														<td><?php echo $userResult['fname'].' '.$userResult['lname'];?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<!-- <label for="result_tab">Student Score</label> -->
												<table id="result_tab" class="table table-striped table-bordered table-hover" role="grid">
													<thead>
														<tr>
															<th colspan="3" class="text-center">Student Score</th>
														</tr>
														<tr>
															<th>Student ID</th>
															<th>Examinee Name</th>
															<th>Score</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$conn = connectDB();
															
															$std_scores = [];
															
															$logUserSQL = "SELECT DISTINCT user_id FROM log_answer WHERE testform_id='".$testform_id."'";
															$logUserQuery = mysqli_query($conn,$logUserSQL);
															while($logUserResult = mysqli_fetch_array($logUserQuery)){
																$exnoSQL = "SELECT MAX(exam_no) ex_no FROM (SELECT * FROM log_answer WHERE user_id=".$logUserResult['user_id']." AND testform_id=".$testform_id.") logans_user";
																$exnoQuery = mysqli_query($conn,$exnoSQL);
																$ex_no = mysqli_fetch_array($exnoQuery);
																
																$logansQuery = mysqli_query($conn, "SELECT user_id,log_answer.item_id,answer,text_answer,choice_id FROM answer,log_answer WHERE user_id='".$logUserResult['user_id']."' AND testform_id='".$testform_id."' AND exam_no='".$ex_no['ex_no']."' AND answer.item_id=log_answer.item_id");
																$score = 0;
																$items = 0;
																while($logansResult = mysqli_fetch_array($logansQuery)){
																	if($logansResult['answer'] == $logansResult['choice_id']){
																		$score++;
																	}
																	$items++;
																}
																array_push($std_scores, $score);
																
																$stdQuery = mysqli_query($conn,"SELECT student_id,fname,lname FROM user_account WHERE user_id=".$logUserResult['user_id']);
																$stdResult = mysqli_fetch_array($stdQuery);
																echo '<tr><td class="col-md-2">'.$stdResult['student_id'].'</td>';
																echo '<td>'.$stdResult['fname'].' '.$stdResult['lname'].'</td>';
																echo '<td>'.$score.'/'.$items.'</td>';
																echo '</tr>';
															}
															
															function average($arr){
																if (!count($arr)) return 0;
																$sum = 0;
																for ($i = 0; $i < count($arr); $i++){
																	$sum += $arr[$i];
																}
																return $sum/count($arr);
															}
															
															$mean_score = number_format(average($std_scores), 2);
															$min_score = min($std_scores);
															$max_score = max($std_scores);
															$conn->close();
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<table class="table table-bordered table-hover">
												<thead>
													<tr>
														<th colspan="2" class="text-center">Statistics</th>
													</tr>
												</thead>
												<tbody>
													<?php
														echo '<tr><td>Min</td><td>'.$min_score.'</td></tr>';
														echo '<tr><td>Max</td><td>'.$max_score.'</td></tr>';
														echo '<tr><td>Mean</td><td>'.$mean_score.'</td></tr>';
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
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
	</body>
</html>	