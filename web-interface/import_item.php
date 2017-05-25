<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Import Item - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
				var subject_id = '';
				var topic_id = '';
				
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
					});
				});
				
				$("#submit").click(function(){
					//alert("click");
					subject_id = $("#sub_id").val();
					topic_id = $("#topic_id").val();
					importFile();
				});
				
				function importFile(){
					//$("#uploadImg").click(function(){
					//alert("clicked");
					// get image data
					var file_data = $('#upload_file').prop('files')[0];   
					var form_data = new FormData();                  
					form_data.append('file', file_data);
					form_data.append('subject_id', subject_id);
					form_data.append('topic_id', topic_id);
					//alert(form_data);
					
					$.ajax({
						url: 'itembank_query.php', // point to server-side PHP script 
						dataType: 'text',  // what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: form_data,
						type: 'post',
						success: function(php_script_response){
							alert(php_script_response); // display response from the PHP script, if any
							window.location.reload();
						}
					});
					//});
				}
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
							Import Items <small>Item Bank</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="itembank_new.php">Item Bank</a></li>
							<li class="active">Import Items</li>
						</ol>
					</div>
				</div>
				
				<!-- Main Content Page-->
				<!-- Import csv item -->
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="panel panel-default">
							<div class="panel-heading">Import Items</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6">
										<label for="sub_id">Course</label>
										<select id="sub_id" class="form-control" style="width:auto">
											<option>-- Select Course --</option>
											<?php
												$mysqli = connectDB();
												
												$objQuery = mysqli_query($mysqli, "SELECT * FROM subject s,course_owner own WHERE s.subject_id=own.subject_id AND own.user_id=".$_SESSION['user_id']);
												while($objResult = mysqli_fetch_array($objQuery)){
												?>
												<option value="<?php echo $objResult["subject_id"];?>"><?php echo $objResult["course_name"];?></option>
												<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label for="topic_id">Topic</label>
										<select id="topic_id" class="form-control" style="width:auto">
											<option>-- Select Topic --</option>
										</select>
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										<label>Select import text file</label>
										<input id="upload_file" type="file"></input>
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-12" align="right">
										<button id="submit" class="btn btn-primary" type="button">Import</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="alert alert-info" role="alert">
							<h4><span class="glyphicon glyphicon-info-sign"></span> Information</h4>
							Please use text file with format below<br><br>
							"Number","[Recall=1,Interpretation=2,Problem Solving=3]","Question","choice1;choice2;choice3;...;choiceN","CorrectAnswer","DiscriminationPower;DificultyLevel;Time"
						</div>
					</div>
				</div>
								
				<div class="row">
					
				</div>
				<!-- END import csv item -->
				<!-- END Main Content Page-->
			</div>
		</div>
	</body>
</html >																											