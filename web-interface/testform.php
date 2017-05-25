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

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Test Forms - MTC E-Testing</title>
		
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
		
		<script src='assets/js/d3/d3.min.js'></script>
		<script src='assets/js/nvd3/build/nv.d3.min.js'></script>
		<link href="assets/js/nvd3/build/nv.d3.min.css" rel="stylesheet" type="text/css"/>
		
		<script src="assets/js/custom-scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
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
									<li>
										<a href="itembank.php">Overview</a>
									</li>
									<li>
										<a href="create_sub.php">Add Course</a>
									</li>
									<li>
										<a href="create_topic.php">Add Topic</a>
									</li>
									<li>
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
							
							<li class="active-menu">
								<a href="#"><i class="fa fa-file-text-o"></i> Test Forms<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse in">
									<li class="active">
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
							
							<li>
								<a href="#"><i class="fa fa-pencil-square-o"></i> Examination<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="#">Overview</a>
									</li>
									<li>
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
									Test Forms <small>Overview</small>
								</h1>
								<ol class="breadcrumb">
									<li><a href="admin_home.php">Home</a></li>
									<li><a href="itembank.php">Test Forms</a></li>
									<li class="active">Overview</li>
								</ol>
							</div>
						</div>
						<!-- BODY -->
						
						<div class="row">
							<div class="col-md-12">
								<div class="panel-group" id="accordion">
									<?php
										$conn = connectDB();
										
										// outter subjects accordion
										$subSQL = "SELECT sub.* FROM subject sub,user_account user WHERE sub.user_create=user.user_id AND user.user_id=".$userResult['user_id'];
										$subQuery = mysqli_query($conn, $subSQL);
										$c_sub = 1;
										$i = 1;
										while($subObj=mysqli_fetch_array($subQuery)){
											echo '<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title" style="display:inline;">
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">'.$subObj['course_id'].' - '.$subObj['course_name'].'</a>
														</h4>
														&nbsp;&nbsp;
														<a href="sub_edit.php?sid='.$subObj['subject_id'].'" style="font-weight:normal;">Edit</a>
													</div>
													<div id="collapse'.$i++.'" class="panel-collapse collapse in">
														<div class="panel-body">';
											
											echo '<div class="row"><div class="col-md-6">';
											echo '<b>Course ID : </b>'.$subObj['course_id'].'<br>';
											echo '<b>Course Name : </b>'.$subObj['course_name'].'<br>';
											echo '<b>Definition : </b>'.$subObj['definition'].'<br><br>';
											/*echo '</div><div class="col-md-6">';
											echo '<div class="panel panel-default">
														<div class="panel-body" id="sub-chart-'.$subObj['subject_id'].'">
															<svg></svg>
														</div>
													</div>';*/
											echo '</div></div>';
											
											/*echo '<div class="row"><div class="col-md-12">
													<div class="panel panel-default">
														<div class="panel-heading">Constraint List</div>
														<div class="panel-body">';*/
											echo '<div class="row"><div class="col-md-12">
													<label>Constraint List</label>';
											
											// inner testforms accordion
											$constrSQL = "SELECT * FROM `constraint` con,`testform` tf WHERE con.subject_id=".$subObj['subject_id'].
														" AND con.constraint_id=tf.constraint_id AND con.user_create=".$userResult['user_id'];
											$constrQuery = mysqli_query($conn, $constrSQL);
											$j = 1;
											echo '<div class="row">
														<div class="col-md-12">
															<div class="panel-group" id="accordion'.$c_sub.'">';
											while($constrObj=mysqli_fetch_array($constrQuery)){
												echo '<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title" style="display:inline;">
																<a data-toggle="collapse" data-parent="#accordion'.$c_sub.'" href="#collapse-'.$constrObj['constraint_id'].'-'.$j.'">'.$constrObj['name'].'</a>
															</h4>
															&nbsp;&nbsp;
														</div>
															<div id="collapse-'.$constrObj['constraint_id'].'-'.$j++.'" class="panel-collapse collapse in">
																<div class="panel-body">';
												
												echo '<div class="row"><div class="col-md-6">';
												echo '<b>Constraint ID : </b>'.$constrObj['constraint_id'].'<br>';
												echo '<b>Name : </b>'.$constrObj['name'].'<br>';
												echo '<b>Note : </b>'.$constrObj['note'].'<br>';
												echo '<b>Created Time : </b>'.$constrObj['time'].'<br><br>';
												echo '</div></div>';
												
												// inner table
												echo '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
												echo '<label for="testform-sub'.$j.'">Test List</label>';
												echo '<table id="testform-sub'.$j.'" class="table table-striped table-bordered table-hover" role="grid">
														<thead>
															<tr>
																<th class="col-md-1 text-center">#</th>
																<th class="text-center">Test Name</th>
																<th class="col-md-1 text-center">Discrimination<br>Power</th>
																<th class="col-md-1 text-center">Difficulty<br>Level</th>
																<th class="col-md-1 text-center">Time<br>(Minutes)</th>
																<th class="col-md-1 text-center">Export<br>DOCX</th>
																<th class="col-md-1 text-center">Export<br>PDF</th>
															</tr>
														</thead>
														<tbody>';
												// forms query
												$tfSQL = "SELECT * FROM testform tf WHERE constraint_id=".$constrObj['constraint_id'];
												$tfQuery = mysqli_query($conn, $tfSQL);
												while($tfResult = mysqli_fetch_array($tfQuery)){
													echo "<tr><th class='text-center'>".$tfResult['testform_id']."</th>";
													echo "<td><a href='atest.php?tf_id=".$tfResult['testform_id']."'>".$tfResult['name']."</a></td>";
													echo "<td class='text-center'> - </td>";
													echo "<td class='text-center'> - </td>";
													echo "<td class='text-center'> - </td>";
													echo "<td class='text-center'><a href='export_docx.php?tf_id=".$tfResult['testform_id']."'><i class='fa fa-file-word-o' aria-hidden='true'></i></a></td>";
													echo "<td class='text-center'><a href='exportPDF_test.php?tf_id=".$tfResult['testform_id']."'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td></tr>";
												}
												echo '</tbody></table></div></div>';
												// end inner table
												
												echo '</div></div></div>';
											}
											echo '</div></div></div>';
											// end inner testforms accordion
											echo '</div></div>';
											//echo '</div></div></div></div>';
											
											echo '</div></div>';
											echo '</div><br>';
											$c_sub++;
										}
										// end outter subjects accordion
										$conn->close();
									?>
								</div>
							</div>
						</div>
						
						<!-- /. BODY -->
					</div>
					<!-- /. PAGE INNER  -->
				</div>
				<!-- /. PAGE WRAPPER  -->
			</div>
			
		</body>
	</html>		