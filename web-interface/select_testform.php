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
		<title>Select Test Form</title>
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
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});
				
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
						
						<li class="active-menu">
							<a href="#"><i class="fa fa-pencil-square-o"></i> Examination<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li>
									<a href="select_testform.php">Choose Subject</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-check-square-o"></i> Result<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#">Overview</a>
								</li>
								<li>
									<a href="#">Subject</a>
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
								Choose Subject <small>Pick test form to enter exam</small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="student_home.php">Home</a></li>
								<li><a href="#">Examination</a></li>
								<li class="active">Choose Subject</li>
							</ol>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							Select Test Form
						</div>
						<div class="panel-body">
							<h4>Subject List</h4>
							<ul>
							<?php
								$conn = connectDB();
								
								$subQuery = mysqli_query($conn, "SELECT * FROM subject");
								while($subResult = mysqli_fetch_array($subQuery)){
									echo '<li>'.$subResult['course_id'].' '.$subResult['course_name'];
									$topicQuery = mysqli_query($conn, "SELECT * FROM topic WHERE topic.subject_id=".$subResult['subject_id']);
									while($topicResult = mysqli_fetch_array($topicQuery)){
										echo '<ul><li>'.$topicResult['topic_name'];
										$formQuery = mysqli_query($conn, "SELECT `testform_id`,`name` FROM `testform`,`constraint` WHERE `constraint`.`topic_id`=".$topicResult['topic_id']." AND `constraint`.`constraint_id`=`testform`.`constraint_id`");
										echo "<ul>";
										while($formResult = mysqli_fetch_array($formQuery)){
											echo "<li><a href='#' onClick=\"MyWindow=window.open('exam_sheet_js.php?sub_id=".$subResult['subject_id']."&testform_id=".$formResult['testform_id']."','Exam Sheet',width=600,height=800);if(window.focus){MyWindow.focus()}return false;\">".$formResult['name']."</a></li>";
										}
										echo "</ul></li></ul>";
									}
									echo "</li>";
								}
								$conn->close();
							?>
							</ul>
						</div>
						<!-- Paginate -->
						<!-- <div class="panel-footer">
							<button type="button" id="abc">test</button>
						</div> -->
						<!-- /Paginate -->
					</div>
					
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
	</body>
</html>	