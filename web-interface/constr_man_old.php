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
	
	$conn->close();
?>

<html>
	<head>
		<title>Create Form - MTC E-Testing</title>
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
		<script src="assets/js/custom-scripts.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});
				
				$("#sub_id").change(function(){
					$("#topic_id").html("<option>-- Select Topic --</option>");
					//alert($("#sub_id").val());
					$.post("constr_query.php",{
						sub_id: $("#sub_id").val()},
						function(result){
							//alert(result);
							var dataObj = JSON.parse(result);
							//alert(dataObj[0].topic_name);
							
							for(var i=0 ; i<dataObj.length ; i++){
								$("#topic_id").append("<option value='"+parseInt(dataObj[i].topic_id)+"'>"+dataObj[i].topic_name+"</option>");
							}
						}
					);
				});
				
				var ci = 0;
				var n = 0;
				/*$("#item_num").change(function(){
					if($(this).val() != null){
						n = $(this).val();
						$("#item_counter").html(ci+"/"+n);
					}
				});*/
				
				var item_set = [];
				
				$("#topic_id").change(function(){
					$.post("constr_query.php",{
						topic_id: $(this).val()},
						function(result){
							//alert(result);
							item_set = JSON.parse(result);
							//alert(dataObj[0].topic_name);
							
							$("#aval-item").empty();
							/*for(var i=0 ; i<item_set.length ; i++){
								var item_id = parseInt(item_set[i].item_id);
								$("#aval-item").append("<option value='"+item_id+"'>Item ID: "+item_id+"&emsp;a: "+parseFloat(item_set[i].a)
								+"&emsp;b: "+parseFloat(item_set[i].b)+"&emsp;time: "+parseInt(item_set[i].time)+"</option>");
							}*/
						}
					);
				});
				
				$('#submit_nitem').click(function(){
					if($("#item_num").val() != ""){
						$("#aval-item").empty();
						n = $("#item_num").val();
						$("#item_counter").html(ci+"/"+n);
						
						for(var i=0 ; i<item_set.length ; i++){
							var item_id = parseInt(item_set[i].item_id);
							$("#aval-item").append("<option value='"+item_id+"'>Item ID: "+item_id+"&emsp;a: "+parseFloat(item_set[i].a)
							+"&emsp;b: "+parseFloat(item_set[i].b)+"&emsp;time: "+parseInt(item_set[i].time)+"</option>");
						}
					}
					else{
						alert("Please Enter Item Number!");
					}
				});
				
				$("#add_item").click(function(item_set){
					dataObj = item_set;
					var selected = $("#aval-item").val();
					
					//alert(selected+" "+selected.length);
					//alert(ci+"/"+n);
					
					if((ci+selected.length)<=n){
						/*for(var i=0 ; i<selected.length ; i++){
							$("#selected-item").append("<option value='"+selected[i]+"'>Item ID: "+selected[i]+"</option>");
							$("#aval-item").children('option[value="' + selected[i] + '"]').attr('disabled', true);
							ci++;
						}*/
						
						$('#aval-item option:selected').clone().appendTo($("#selected-item"));
						$('#aval-item option:selected').remove();
						ci += selected.length;
						$("#item_counter").html(ci+"/"+n);
					}
					else{alert("Cannot Add Item!\nselected item is more than form limit.");}
				});
				
				$.fn.sort_select_box = function(){
					var new_options = $("#" + this.attr('id') + ' option');
					new_options.sort(function(a,b) {
						if (a.val > b.val) return 1;
						else if (a.val < b.val) return -1;
						else return 0;
					});
				   return new_options;
				}
				
				$("#remove_item").click(function(){
					if($("#selected-item").val() != null){
						var rn = $("#selected-item").val();
						//var rem = $('#selected-item option:selected');
						
						$('#selected-item option:selected').clone().appendTo($("#aval-item"));
						$("#aval-item").sort_select_box();
						
						ci -= rn.length;
						$("#item_counter").html(ci+"/"+n);
						
						$('#selected-item option:selected').remove();
					}
					else{alert("No selected item.");}
				});
				
				$("#reset").click(function(){
					$("#aval-item").empty();
					$("#selected-item").empty();
					$("#item_counter").html("-/-");
					ci = 0;
					n = 0;
				});
				
				$("#submit").click(function(){
					var sel_item = [];
					$("#selected-item option").each(function(){
						sel_item.push($(this).val());
					});
					
					var dataset = {
						t_id : $("#topic_id").val(),
						total_item : n,
						total_form : 1,
						note : $("#note").val(),
						testform_name : $("#name").val(),
						selected_item : sel_item
					};
					//alert(dataset.submit_man.testform_name);
					$.post("constr_query.php", {submit_man:dataset}, function(result){
						alert(result);
						window.location.replace($(location).attr("href"));
					});
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
						
						<li>
							<a href="#"><i class="fa fa-files-o"></i> Item Bank<span class="fa arrow"></span></a>
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
								<li>
									<a href="testform.php">Overview</a>
								</li>
								<li class="active">
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
								Create Form <small>Manual method</small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="#">Test Form</a></li>
								<li class="active">Create Form</li>
							</ol>
						</div>
					</div>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										Manual Test Form Constructor
									</div>
									<div class="panel-body">
										<!-- Form Contents -->
										<form method="post">
											<div class="row">
												<div class="col-md-5">
													<label for="name">Test Form Name</label>
													<input id="name" class="form-control" placeholder="Enter test name" style="width:auto" size="30"></input><br>
													
													<label for="sub_id">Subject</label>
													<select id="sub_id" name="sub_id" class="form-control" style="width:auto">
														<option>-- Select Subject --</option>
														<?php
															$mysqli = new mysqli("localhost", "root", "toptop", "mtc_project");
															/* Check the connection. */
															if (mysqli_connect_errno()) {
																printf("Connect failed: %s\n", mysqli_connect_error());
																exit();
															}
															else{
																//echo "connection success";
															}
															
															$subQuery = mysqli_query($mysqli, "SELECT * FROM subject");
															while($subResult = mysqli_fetch_array($subQuery)){
														?>
																<option value="<?php echo $subResult["subject_id"];?>"><?php echo $subResult["course_name"];?></option>
														<?php
															}
															$mysqli->close();
														?>
													</select>
												
													<label for="topic_id">Topic</label>
													<select id="topic_id" name="topic_id" class="form-control" style="width:auto">
														<option>-- Select Topic --</option>
													</select>
													<label for="item_num">Item Number</label>
													<input id="item_num" class="form-control" placeholder="Enter item number" style="width:auto" size="15"></input><br>
													<button id="submit_nitem" class="btn btn-default btn-sm" type="button">Get Item</button>
												</div>
												<div class="col-md-7">
													<div class="panel panel-default">
														<div class="panel-body" id="form-graph"></div>
													</div>
												</div>
											</div><br>
											
											<div class="row">
												<div class="col-md-5">
													<label for="aval-item">Avalible item (hold shift to select more than one):</label>
													<select multiple id="aval-item" class="form-control"  size="10" align="left">
													</select>
												</div>
												
												<div class="col-sm-2">
													<div align="center">
														<br><br><br><br>
														<button id="add_item" class="btn btn-success" type="button">>>>></button>
														<br><br>
														<button id="remove_item" class="btn btn-danger" type="button"><<<<</button>
														<br><br>
														<p id="item_counter">-/-</p>
													</div>
												</div>
												
												<div class="col-md-5">
													<label for="selected-item">Selected item in form (hold shift to select more than one):</label>
													<select multiple class="form-control" id="selected-item" size="10" align="left">
													</select>
												</div>
											</div><br>
											
											<div>
												<label for="note">Note</label>
												<textarea id="note" class="form-control" style="width:auto" row="3"></textarea>
											</div><br><br>
											
											<div>
												<button id="submit" class="btn btn-primary" type="button">Create Form</button>&ensp;
												<button id="reset" class="btn btn-default" type="reset">Reset</button>
											</div>
										</form>
										
										<!-- /Form Contents -->
									</div>
									<!-- Paginate -->
									<!-- <div class="panel-footer">
										<button id="abc" type="button">test</button>
									</div> -->
									<!-- /Paginate -->
								</div>
							</div>
						</div>
					<footer></footer>
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
	</body>
</html>	