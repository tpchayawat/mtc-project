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
		<title>Student Exam Result - MTC E-Testing</title>
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
				
				//$("#form_tab").DataTable();
				
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
								Student Exam Result <small>Subject list</small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="#">Examination</a></li>
								<li class="active">Student Exam Result</li>
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
									<div class="table-responsive">
										<table id="form_tab" class="table table-striped table-bordered table-hover" role="grid">
											<thead>
												<tr>
													<th >Subject</th>
													<th >Topic</th>
													<th >Test Name</th>
													<th >Description</th>
													<th class="text-center">Exam Result</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$conn = connectDB();
													
													$subQuery = mysqli_query($conn, "SELECT * FROM subject WHERE user_create='".$userResult['user_id']."'");
													while($subResult = mysqli_fetch_array($subQuery)){
														$topicQuery = mysqli_query($conn, "SELECT * FROM topic WHERE topic.subject_id=".$subResult['subject_id']);
														//while($topicResult = mysqli_fetch_array($topicQuery)){
															//echo '<td>'.$topicResult['topic_name'].'</td>';
															//$formQuery = mysqli_query($conn, "SELECT `testform_id`,`name`,`note` FROM `testform`,`constraint` WHERE `constraint`.`topic_id`=".$topicResult['topic_id']." AND `constraint`.`constraint_id`=`testform`.`constraint_id`");
															$formQuery = mysqli_query($conn, "SELECT `testform_id`,`name`,`note` FROM `testform`,`constraint` WHERE `constraint`.`subject_id`=".$subResult['subject_id']." AND `constraint`.`constraint_id`=`testform`.`constraint_id`");
															
															while($formResult = mysqli_fetch_array($formQuery)){
																echo '<tr><td>'.$subResult['course_id'].' '.$subResult['course_name'].'</td>';
																echo '<td>-</td>';
																echo '<td>'.$formResult['name'].'</td>';
																echo '<td>'.$formResult['note'].'</td>';
																echo "<td><a id='enter_sub' href='std_result.php?test_id=".$formResult['testform_id']."'><div class='text-center'>Check</div></a></td>";
																echo '</tr>';
															}
														//}
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
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
	</body>
</html>	