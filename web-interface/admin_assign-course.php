<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	
	$conn = connectDB();
	$subSQL = "SELECT s.*,u.fname,u.lname FROM subject s,user_account u WHERE s.user_create=u.user_id";
	if(!$subResult = $conn->query($subSQL)){
		echo $conn->error;
	}
	$conn->close();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Assign Course - MTC System</title>
		<meta http-equiv="description" content="MTC for Administrator" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script><!-- Tether for Bootstrap -->
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				// initial global data set
				var instr_set = [];		// instructor user queried set
				var sel_instr = [];		// selected user
				var sel_course = 0;		// selected course to assignment
				
				// reset assignment form
				function resetForm(){
					sel_course = 0;
					//instr_set.splice(0,instr_set.length);
					sel_instr.splice(0,sel_instr.length);
					instr_set = [];
					$('#curr-list').empty();
					$('.selectpicker').val('').selectpicker('refresh');
				}
				
				// add button to query assignment form data
				$(".assign-bt").click(function(){
					// reset
					resetForm();
					sel_course = $(this).val();
					// post
					$.post('admin_query.php',{getInstr : $(this).val()},
						function(result){
							//alert(result);
							instr_set = JSON.parse(result);
							//alert(instr_set);
							for(var i=0 ; i<instr_set.length ; i++){
								//alert(instr_set[i]['fname']);
								var isAdmin = "";
								if(instr_set[i]['type'] == 0){
									isAdmin = " (Admin)";
									$('#curr-list').append('<option disabled value="instr_set[i]["user_id"]">'
										+instr_set[i]['fname']+' '+instr_set[i]['lname']+isAdmin+'</option>');
								}
								else{
									$('#curr-list').append('<option value="instr_set[i]["user_id"]">'
										+instr_set[i]['fname']+' '+instr_set[i]['lname']+'</option>');
								}
							}
						}
					);
				});
				
				// add button to add user to selected list
				$("#add-instr").click(function(){
					var sel_id = $('#sel-instr').val();
					//alert(sel_id);
					var isMember = false;
					for(var i=0 ; i<instr_set.length ; i++){	// check duplicate with query user set
						if(instr_set[i]['user_id'] == sel_id){
							isMember = true;
						}
					}
					for(var i=0 ; i<sel_instr.length ; i++){	// check duplicate with selected user set
						if(sel_instr[i] == sel_id){
							isMember = true;
						}
					}
					if(!isMember){								// append to select list
						sel_instr.push(sel_id);
						$('#curr-list').append('<option selected value="'+sel_id+'">'
							+$('#sel-instr option:selected').text()+'</option>');
					}
				});
				
				// submit button to query data to server
				$("#assign-submit").click(function(){			// submit assignment to server
					$.post('admin_query.php',{
						assigncourse : {
							sub_id : sel_course,
							u_id : sel_instr,
							adder : <?php echo $_SESSION['user_id'];?>
						}},
						function(result){
							alert(result);
							window.location.reload();
						}
					);
				});
				
				// reset button to reset assignment form
				$("#assign-reset").click(function(){
					var instr_set_tmp = instr_set;		// temp instr_set variable for rewrite exist user list
					resetForm();
					for(var i=0 ; i<instr_set_tmp.length ; i++){
						var isAdmin = "";
						if(instr_set_tmp[i]['type'] == 0){
							isAdmin = " (Admin)";
							$('#curr-list').append('<option disabled value="instr_set_tmp[i]["user_id"]">'
								+instr_set_tmp[i]['fname']+' '+instr_set_tmp[i]['lname']+isAdmin+'</option>');
						}
						else{
							$('#curr-list').append('<option value="instr_set_tmp[i]["user_id"]">'
								+instr_set_tmp[i]['fname']+' '+instr_set_tmp[i]['lname']+'</option>');
						}
					}
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
							Assign Course <small>Manage Course</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="#">Manage Course</a></li>
							<li class="active">Assign Course</li>
						</ol>
					</div>
				</div>
				
				<!-- Content -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Course Information</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<?php
											echo '<table class="table">
											<thead class="thead-default"><tr>
											<th>Course ID</th>
											<th>Course Name</th>
											<!--<th>Definition</th>-->
											<th>Creator</th>
											<th></th>
											</tr></thead><tbody>';
											while($sub = $subResult->fetch_array(MYSQLI_ASSOC)){
												echo '<tr>
												<th scope="row">'.$sub['course_id'].'</th>
												<td>'.$sub['course_name'].'</td>
												<!--<td>'.$sub['definition'].'</td>-->
												<td>'.$sub['fname'].' '.$sub['lname'].'</td>
												<td class="text-right">
												<button class="btn btn-primary btn-sm assign-bt" type="button" value="'.$sub['subject_id'].'" data-toggle="modal" data-target="#userListModal">
												<span class="glyphicon glyphicon-plus"></span> Assign User</button>
												<!-- <button class="btn btn-danger btn-sm rem-bt" type="button" value="'.$sub['subject_id'].'" data-toggle="modal" data-target="#userListModal">
												<span class="glyphicon glyphicon-minus"></span> Remove</button> -->
												</td></tr>';
											}
											echo '</tbody></table>';
										?>
										<div id="userListModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Assignment Users</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-lg-6">
															<?php
																$conn = connectDB();
																$instrSQL = "SELECT * FROM user_account WHERE type=1";
																if(!$instrResult = $conn->query($instrSQL)){
																	echo $conn->error;
																}else{
																	echo '<select id="sel-instr" class="selectpicker form-control" title="Instructors" style="width:auto;">';
																	while($instr = $instrResult->fetch_array(MYSQLI_ASSOC)){
																		echo "<option value='".$instr['user_id']."'>".$instr['fname']." ".$instr['lname']."</option>";
																	}
																	echo "</select>";
																}
																$conn->close();
															?>
															</div>
															<div class="col-lg-3">
																<button id="add-instr" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-plus"></span></button>
															</div>
														</div><br>
														<div class="row">
															<div class="col-lg-6">
																<label for="curr-list">Current Instructors</label>
																<select multiple id="curr-list" class="form-control" size="5">
																</select>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button id="assign-submit" type="button" class="btn btn-primary">Save</button>
														<button id="assign-reset" type="button" class="btn btn-default">Reset</button>
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</body>
</html >