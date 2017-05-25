<!DOCTYPE html>

<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	$subSQL = "SELECT sub.*,fname,lname FROM subject sub,user_account user WHERE sub.user_create=user.user_id";
	$subQuery = mysqli_query($conn, $subSQL);
	
	if(isset($_GET['sid'])){
		$sid = $_GET['sid'];
	}
	$subEditQuery = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id=".$sid);
	$subEditResult = mysqli_fetch_array($subEditQuery);
	
	$conn->close();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Course Editor - MTC E-Testing</title>
		
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
		
		<script src="assets/js/custom-scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				getSubEdit();
				function getSubEdit(){
					$("#c_id").val('<?php echo $subEditResult['course_id'];?>');
					$("#c_name").val('<?php echo $subEditResult['course_name'];?>');
					$("#c_def").val('<?php echo $subEditResult['definition'];?>');
				}
				
				$("#con_sub").click(function(){
					if($("#c_id").val()=="" || $("#c_name").val()=="" || $("#c_def").val()==""){
						alert("Please insert all field data");
					}
					else{
						var dataset = {
							sid : '<?php echo $subEditResult['subject_id'];?>',
							cid : $("#c_id").val(),
							cname : $("#c_name").val()
						};
						$.post("itembank_query.php", {checkDup_sub:dataset}, function(result){
							//alert(result);
							var dataResult = JSON.parse(result);
							var isDupID = dataResult['id'];
							var isDupName = dataResult['name'];
							if(isDupID || isDupName){
								//alert("DUPLICATE Course Input");
								if(isDupID){
									$("#error_id").html("** Duplicate Course ID");
									$("#id_form").addClass(" has-error");
								}
								else{
									$("#id_form").removeClass("has-error").addClass(" has-success");
									$("#error_id").html("");
								}
								if(isDupName){
									$("#error_name").html("** Duplicate Course Name");
									$("#name_form").addClass(" has-error");
								}
								else{
									$("#name_form").removeClass("has-error").addClass(" has-success");
									$("#error_name").html("");
								}
							}
							else{
								//alert("NO DUP");
								$("#id_form").removeClass("has-error").addClass(" has-success");
								$("#error_id").html("");
								$("#name_form").removeClass("has-error").addClass(" has-success");
								$("#error_name").html("");
								
								$("#preSubModal").html("<div><p>Course ID : </p>"+$("#c_id").val()+"</div>"
												+"<div><p>Course Name : </p>"+$("#c_name").val()+"</div>"
												+"<div><p>Definition : </p>"+$("#c_def").val()+"</div>");
								
								$('#confirmModal').modal('toggle');
								$('#confirmModal').modal('show');
							}
						});
					}
				});
				
				$("#add_c").click(function(){
					if($("#c_id").val()=="" || $("#c_name").val()=="" || $("#c_def").val()==""){
						alert("Please insert all field data");
					}
					else{
						var dataset = {
							isEdit : 1,
							sid : '<?php echo $subEditResult['subject_id'];?>',
							cid : $("#c_id").val(),
							cname : $("#c_name").val(),
							cdef : $("#c_def").val(),
							user : <?php echo $userResult['user_id']; ?>
						};
						$.post("itembank_query.php", {add_sub:dataset}, function(result){
							alert(result);
							window.location.href = "itembank.php";
							//window.location.reload();
						});
					}
				});
				
				$('#reset').click(function(){
					getSubEdit();
				});
				
				$('#backButton').click(function(){
					window.history.back();
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
						
						<li class="active-menu">
							<a href="#"><i class="fa fa-files-o"></i> Item Bank<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li class="active">
									<a href="itembank.php">Overview</a>
								</li>
								<li class="active">
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
								Edit Course <small></small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="itembank.php">Item Bank</a></li>
								<li class="active">Edit Course</li>
							</ol>
						</div>
					</div>
					
					<!-- BODY -->
					<div class="row">
						<div class="col-md-9 col-sm-12 col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Edit Course
								</div>
								<div class="panel-body">
									<form method="post">
										<div id="id_form" class="form-group">
											<label class="control-label" for="c_id">Course ID</label>
											<div class="row">
												<div class="col-md-2">
													<input id="c_id" type="text" class="form-control" style="width:auto" placeholder="Enter ID" size="10">
												</div>
												<div class="col-md-2">
													&nbsp;&nbsp;&nbsp;
													<button id="sublist" class="btn btn-default" type="button" data-toggle="modal" data-target="#sublistModal"><i class="fa fa-list"></i> List</button>
												</div>
												<div class="col-md-4">
													<div id="error_id" class="control-label"></div>
												</div>
												<div id="sublistModal" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Existing Subject List</h4>
															</div>
															<div class="modal-body">
																<table id="exam_detail" class="table table-striped table-bordered table-hover" role="grid">
																	<thead>
																		<tr>
																			<th>Course ID</th>
																			<th>Course Name</th>
																			<th>Instructor</th>
																		</tr>
																	</thead>
																	<tbody>
																			<?php
																				while($subResult = mysqli_fetch_array($subQuery)){
																					echo "<tr><td>".$subResult['course_id']."</td>";
																					echo "<td>".$subResult['course_name']."</td>";
																					echo "<td>".$subResult['fname']." ".$subResult['lname']."</td></tr>";
																				}
																			?>
																	</tbody>
																</table>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id= "name_form" class="form-group">
											<label class="control-label" for="c_name">Course Name</label>
											<div class="row">
												<div class="col-md-6">
													<input id="c_name" name="c_name" type="text" class="form-control" placeholder="Enter course name">
												</div>
												<div class="col-md-4">
													<div id="error_name" class="control-label"></div>
												</div>
											</div>
										</div>
										<label>Definition</label>
										<div>
											<textarea id="c_def" name="c_def" class="form-control" rows="3"></textarea>
										</div><br>
										
										<!-- <button id="con_sub" class="btn btn-primary" type="button" data-toggle="modal" data-target="#confirmModal">Submit</button> -->
										<button id="con_sub" class="btn btn-primary" type="button">Submit</button>
										&nbsp;&nbsp;&nbsp;
										<button id="reset" class="btn btn-default" type="button">Reset</button>
										<a id="backButton" class="btn btn-default" style="float:right;">Back</a>
										
										<div id="confirmModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Do you confirm new edit?</h4>
													</div>
													<div id="preSubModal" class="modal-body">
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button id="add_c" type="button" class="btn btn-primary">Confirm</button>
													</div>
												</div>
											</div>
										</div>
										
									</form>
								</div>
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