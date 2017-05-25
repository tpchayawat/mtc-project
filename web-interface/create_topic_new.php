<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Create Topic - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#con_topic").click(function(){
					if($("#sub_id").val()=="" || $("#tname").val()=="" || $("#tdef").val()==""){
						alert("Please insert all field data");
					}
					else{
						var dataset = {
							tid : "",
							tname : $("#tname").val()
						};
						$.post("itembank_query.php", {checkDup_topic:dataset}, function(result){
							//alert(result);
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
								
								$("#preTopicModal").html("<div class='row'><div class='col-lg-3'><label>Course Name : </label></div><div class='col-lg-6'>"+$("#sub_id option[value='"+$("#sub_id").val()+"']").text()+"</div></div>"
								+"<div class='row'><div class='col-lg-3'><label>Topic Name : </label></div><div class='col-lg-6'>"+$("#tname").val()+"</div></div>"
								+"<div class='row'><div class='col-lg-3'><label>Definition : </label></div><div class='col-lg-6'>"+$("#tdef").val()+"</div></div>"
								+"<div class='row'><div class='col-lg-3'><label>Objective : </label></div><div class='col-lg-6'>"+$("#tobj").val()+"</div></div>");
								
								$('#confirmModal').modal('toggle');
								$('#confirmModal').modal('show');
							}
						});
					}
				});
				
				$("#add_t").click(function(){
					var dataset = {
						isEdit : 0,
						sub_id : $("#sub_id").val(),
						tname : $("#tname").val(),
						tdef : $("#tdef").val(),
						tobj : $("#tobj").val(),
						user : <?php echo $_SESSION['user_id']; ?>
					};
					$.post("itembank_query.php", {add_topic:dataset}, function(result){
						alert(result);
						window.location.reload();
					});
				});
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
							Create Topic <small>Item Bank</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="itembank_new.php">Item Bank</a></li>
							<li class="active">Create Topic</li>
						</ol>
					</div>
				</div>
				<!-- Main Page Content -->
				<div class="row">
					<div class="col-lg-9">
						<div class="panel panel-default">
							<div class="panel-heading">Course Information</div>
							<div class="panel-body">
								<form id="topic-form" role="form" accept-charset="UTF-8" autocomplete="off">
									<div class="form-body">
										
										<div class="row">
											<div class="form-group col-lg-3">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-book"></span></div>
													<select id="sub_id" name="sub_id" class="selectpicker form-control" title="Select Course" style="width:auto">
														<?php
															$mysqli = connectDB();
															$objQuery = mysqli_query($mysqli, "SELECT * FROM subject s,course_owner own WHERE s.subject_id=own.subject_id AND own.user_id=".$_SESSION['user_id']);
															while($objResult = mysqli_fetch_array($objQuery)){
																echo '<option value="'.$objResult["subject_id"].'">'.$objResult["course_name"].'</option>';
															}
															$mysqli->close();
														?>
													</select>
												</div>   
											</div>
										</div>
										
										<div class="row">
											<div class="form-group col-lg-6">
												<div class="input-group">
													<div class="input-group-addon"><span class="glyphicon glyphicon-font"></span></div>
													<input id="tname" name="tname" type="text" class="form-control" placeholder="Topic Name">
												</div>                  
											</div>
											<div class="col-lg-3">
												<button id="topiclist" class="btn btn-default" type="button" data-toggle="modal" data-target="#topicListModal"><span class="glyphicon glyphicon-list"></span> Topic List</button>
												<div id="topicListModal" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Existing Topic List</h4>
															</div>
															<div class="modal-body">
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
																			$conn = connectDB();
																			$topic_sql = "SELECT t.*,s.course_id,s.course_name,u.fname,u.lname FROM topic t,subject s,user_account u 
																			WHERE s.subject_id=t.subject_id AND s.user_create=u.user_id";
																			$topicQuery = mysqli_query($conn, $topic_sql);
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
											</div>
										</div>
										
										<div class="row">
											<div class="form-group col-lg-9">
												<!--<label for="tdef">Course Outline</label>-->
												<textarea id="tdef" name="tdef" type="text" class="form-control" row="3" placeholder="Course Outline"></textarea>								            
											</div>
										</div>
										
										<div class="row">
											<div class="form-group col-lg-9">
												<!--<label for="tobj">Definition</label>-->
												<textarea id="tobj" name="tobj" type="text" class="form-control" row="3" placeholder="Objective"></textarea>								            
											</div>
										</div>
										
									</div>
									<div class="form-footer">
										<div class="row">
											<div class="col-sm-6">
												<button id="con_topic" name="con_topic" class="btn btn-primary" type="button">
													<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Submit
												</button>&nbsp;&nbsp;&nbsp;
												<button class="btn btn-default" type="reset">Reset</button>
											</div>
										</div>
									</div>
									
									<div id="confirmModal" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Do you confirm?</h4>
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
				<!-- END Main Page Content -->
			</div>
		</div>
	</body>
</html >