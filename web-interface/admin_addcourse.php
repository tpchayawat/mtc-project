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
	
	$conn->close();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Create Course - MTC System</title>
		<meta http-equiv="description" content="MTC for Administrator" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#course-submit").click(function(){
					$.post('admin_query.php',{ 
						addcourse : {
							cdata : $('#course-form').serialize(),
							cuser : <?php echo $_SESSION['user_id'];?>,	// temp value
							isEdit : 0
						}},
						function(result){
							alert(result);
							window.location.reload();
					});
				});
			});
		</script>
	</head>
	
	<body>
		<!-- FOR DAD -->
		<img src="assets/img/black_ribbon_bottom_left.png" class="black-ribbon stick-bottom stick-left"/>
		<?php
			//$page_title = "Add User - MTC System";
			//$page_description = "Add User for Administrator";
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
							Create Course <small>Manage Course</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="#">Admin</a></li>
							<li class="active">Create Course</li>
						</ol>
					</div>
				</div>
				
				<!-- Main Page Content -->
				<div class="row">
					<div class="col-lg-9">
						<div class="panel panel-default">
							<div class="panel-heading">Course Information</div>
							<div class="panel-body">
								<form id="course-form" role="form" accept-charset="UTF-8" autocomplete="off">
									<div class="form-body">
										<div class="row">
											<div class="form-group col-lg-3">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></div>
													<input id="cid" name="cid" type="text" class="form-control" placeholder="Course ID">
												</div>                 
											</div>
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-font"></span></div>
													<input id="cname" name="cname" type="text" class="form-control" placeholder="Course Name">
												</div>                  
											</div>
											<div class="col-lg-3">
												<button id="sublist" class="btn btn-default" type="button" data-toggle="modal" data-target="#sublistModal"><span class="glyphicon glyphicon-list"></span> Course List</button>
												<div id="sublistModal" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Existing Course List</h4>
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
										<div class="row">
											<div class="form-group col-lg-9">
												<!--<label for="cdef">Definition</label>-->
												<textarea id="cdef" name="cdef" type="text" class="form-control" row="3" placeholder="Definition"></textarea>								            
											</div>
										</div>
									</div>
									<div class="form-footer">
										<div class="row">
											<div class="col-sm-6">
												<button id="course-submit" name="course-submit" class="btn btn-primary" type="button">
													<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Submit
												</button>&nbsp;&nbsp;&nbsp;
												<button class="btn btn-default" type="reset">Reset</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- END Main Page Content -->
			</div>
		</div>
	</body>
</html >