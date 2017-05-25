<!DOCTYPE html>

<?php
	session_start();
	if($_SESSION['user_id'] == ""){
		echo "Please Login!";
		header("Location: login.php");
		exit();
	}

	if($_SESSION['status'] != 0){
		echo "This page for Admin only!";
		exit();
	}	
	
	include('connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	if(isset($_GET['tid'])){
		$tid = $_GET['tid'];
	}
	$topicEditQuery = mysqli_query($conn, "SELECT * FROM topic WHERE topic_id=".$tid);
	$topicEditResult = mysqli_fetch_array($topicEditQuery);
	
	$conn->close();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Course Creator - MTC E-Testing</title>
		
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
		
		<script>
			$(document).ready(function(){
			
				getTopicEdit();
				function getTopicEdit(){
					$('#sub_id option[value='+'<?php echo $topicEditResult['subject_id'];?>'+']').attr('selected','selected');
					$("#t_name").val('<?php echo $topicEditResult['topic_name'];?>');
					$("#t_def").val('<?php echo $topicEditResult['definition'];?>');
					$("#t_obj").val('<?php echo $topicEditResult['objective'];?>');
				}
				
				$("#test").click(function(){
					alert("test");
				});
				
				$("#con_topic").click(function(){
					if($("#sub_id").val()=="" || $("#t_name").val()=="" || $("#t_def").val()=="" || $("#t_obj").val()==""){
						alert("Please insert all field data");
					}
					else{
						var dataset = {
							tid : '<?php echo $topicEditResult['topic_id'];?>',
							tname : $("#t_name").val()
						};
						$.post("itembank_query.php", {checkDup_topic:dataset}, function(result){
							alert(result);
							var dataResult = JSON.parse(result);
							var isDupName = dataResult['name'];
							if(isDupName){
								//alert("DUPLICATE Topic Input");
								$("#error_name").html("** Duplicate Topic Name");
								$("#topic_name_form").addClass(" has-error");
							}
							else{
								//alert("NO DUP");
								$("#topic_name_form").removeClass("has-error").addClass(" has-success");
								$("#error_name").html("");
								
								$("#preTopicModal").html("<div class='row'><div class='col-md-12'><p>Course Name : </p>"+$("#sub_id option[value='"+$("#sub_id").val()+"']").text()+"</div></div>"
												+"<div class='row'><div class='col-md-12'><p>Topic Name : </p>"+$("#t_name").val()+"</div></div>"
												+"<div class='row'><div class='col-md-12'><p>Definition : </p>"+$("#t_def").val()+"</div></div>");
								
								$('#confirmModal').modal('toggle');
								$('#confirmModal').modal('show');
							}
						});
					}
				});
				
				$("#add_t").click(function(){
					var dataset = {
						isEdit : 1,
						tid : '<?php echo $topicEditResult['topic_id'];?>',
						sub_id : $("#sub_id").val(),
						tname : $("#t_name").val(),
						tdef : $("#t_def").val(),
						tobj : $("#t_obj").val(),
						user : <?php echo $userResult['user_id']; ?>
					};
					$.post("itembank_query.php", {add_topic:dataset}, function(result){
						alert(result);
						window.location.href = "itembank.php";
						//window.location.reload();
					});
				});
				
				$('#reset').click(function(){
					getTopicEdit();
				});
				
				$('#backButton').click(function(){
					window.history.back();
				});
			});
		</script>
		
	</head>
	
	<body>
		<div id="wrapper">
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
							<a href="itembank.php"><i class="fa fa-files-o"></i> Item Bank<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li class="active">
									<a href="itembank.php">Overview</a>
								</li>
								<li>
									<a href="create_sub.php">Add Course</a>
								</li>
								<li class="active">
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
								Edit Topic <small></small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="#">Item Bank</a></li>
								<li class="active">Edit Topic</li>
							</ol>
						</div>
					</div>
					
					<!-- BODY -->
					<div class="row">
						<div class="col-md-9 col-sm-12 col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									Edit Topic
								</div>
								<div class="panel-body">
									<form>
										<div id="subid_form" class="form-group">
											<label for="sub_id" lass="control-label">Subject</label><br>
											<div class="row">
												<div class="col-md-3">
													<fieldset disabled>
													<select id="sub_id" name="sub_id" class="form-control" style="width:auto">
														<option>-- Select Subject --</option>
														<?php
															$mysqli = connectDB();
															
															$objQuery = mysqli_query($mysqli, "SELECT * FROM subject");
															while($objResult = mysqli_fetch_array($objQuery)){
														?>
																<option value="<?php echo $objResult["subject_id"];?>"><?php echo $objResult["course_name"];?></option>
														<?php
															}
															$mysqli->close();
														?>
													</select>
													</fieldset>
												</div>
											</div>
										</div>
										
										<div id="topic_name_form" class="form-group">
											<label for="t_name" class="control-label">Topic Name</label>
											<div class="row">
												<div class="col-md-6">
													<input id="t_name" type="text" class="form-control" placeholder="Enter topic name">
												</div>
												<div class="col-md-2">
													<button id="topicList" class="btn btn-default" type="button" data-toggle="modal" data-target="#topicListModal"><i class="fa fa-list"></i> List</button>
												</div>
												<div class="col-md-4">
													<div id="error_name" class="control-label"></div>
												</div>
											</div>
										</div>
										
										<div id="topicListModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Existing Topics List</h4>
													</div>
													<div class="modal-body">
														<?php
															$conn = connectDB();
															$topicQuery = mysqli_query($conn, "SELECT t.*,s.course_id,s.course_name,u.fname,u.lname FROM topic t,subject s,user_account u WHERE s.subject_id=t.subject_id AND s.user_create=u.user_id");
															
														?>
														<table class="table table-striped table-bordered table-hover" role="grid">
															<thead>
																<tr>
																	<th>Topic Name</th>
																	<th>Course ID</th>
																	<th>Course Name</th>
																	<th>Instructor</th>
																</tr>
															</thead>
															<tbody>
																	<?php
																		while($topicResult = mysqli_fetch_array($topicQuery)){
																			echo "<tr><td>".$topicResult['topic_name']."</td>";
																			echo "<td>".$topicResult['course_id']."</td>";
																			echo "<td>".$topicResult['course_name']."</td>";
																			echo "<td>".$topicResult['fname']." ".$topicResult['lname']."</td></tr>";
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
										
										<label>Definition</label>
										<div>
											<textarea id="t_def" name="t_def" class="form-control" rows="3"></textarea>
										</div><br>
										
										<label>Objective</label>
										<div>
											<textarea id="t_obj" name="t_obj" class="form-control" rows="2"></textarea>
										</div><br>
										
										<button id="con_topic" class="btn btn-primary" type="button">Submit</button>
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
													<div id="preTopicModal" class="modal-body">
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button id="add_t" type="button" class="btn btn-primary">Confirm</button>
													</div>
												</div>
											</div>
										</div>
										
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- <div><button type="button" id="test">test</button></div> -->
					<!-- /. BODY -->
					
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
		
	</body>
</html>