<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Add User - MTC System</title>
		<meta http-equiv="description" content="MTC for Administrator" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#addu-submit").click(function(){
					/* $.post('admin_query.php', {addu:$('#user-form').serialize()}, function(result){
						alert(result);
						window.location.reload();
					}); */
					$.post('admin_query.php',{ 
						addu : {
							udata : $('#user-form').serialize()
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
							Add User <small>Manage User</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="#">Admin</a></li>
							<li class="active">Add User</li>
						</ol>
					</div>
				</div>
				
				<!-- Content -->
				<div class="row">
					<div class="col-lg-9">
						<div class="panel panel-default">
							<div class="panel-heading">Personal Information</div>
							<div class="panel-body">
								<form id="user-form" role="form" autocomplete="off">
									<div class="form-body">
										<div class="row">
											<div class="form-group col-lg-4">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-edit"></span></div>
													<select id="role_id" name="role_id" class="selectpicker form-control" title="Role" style="width:auto;">
														
														<option value="0">Administrator</option>
														<option value="1">Instructor</option>
														<!-- <option value="0">Student</option> -->
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
													<input id="fname" name="fname" type="text" class="form-control" placeholder="First Name">
												</div>                 
											</div>
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
													<input id="lname" name="lname" type="text" class="form-control" placeholder="Last Name">
												</div>                  
											</div>
										</div>
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
													<input id="email" name="email" type="text" class="form-control" placeholder="Email">
												</div>                  
											</div>
										</div>
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-briefcase"></span></div>
													<input id="depart" name="depart" id="depart" type="text" class="form-control" placeholder="Department">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
													<input id="username" name="username" id="username" type="text" class="form-control" placeholder="Username">
												</div> 
											</div>
										</div>
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
													<input name="password" id="password" type="password" class="form-control" placeholder="Password">
												</div>  
												<!-- <span class="help-block" id="error"></span> -->                
											</div>
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
													<input id="cpassword" name="cpassword" type="password" class="form-control" placeholder="Retype Password">
												</div>  
												<!-- <span class="help-block" id="error"></span> -->               
											</div>
										</div>
									</div>
									<div class="form-footer">
										<div class="row">
											<div class="col-sm-6">
												<button id="addu-submit" name="addu-submit" class="btn btn-primary" type="button">
													<span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Submit
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
			</div>
		</div>
	</body>
</html >