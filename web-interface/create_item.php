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
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Create Item - MTC E-Testing</title>
		
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
		
		<script type="text/x-mathjax-config">
			MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
		</script>
		<script type="text/javascript" src="assets/MathJax-master/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
		<script src="assets/js/custom-scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){

				$("#abc").click(function(){
					alert("Hello jQuery!");
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

				$("#ans_btn").click(function(){
					if($("#ans_type").val() == ""){
						alert("Please Select Answer Type");
					}
					else{
						var anstype = $(this).val();
						var nchoice = $("#n_choice").val();
						var choices_content = "";
						//multiple choice
						if(anstype == 0){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							choices_content += "<label>Answer "+(i+1)+": </label>"
								//+"&nbsp;<button id='tbutton-"+(i+1)+"' type='button'>test-"+(i+1)+"</button>"
								+"&nbsp;<span id='count-ans-"+(i+1)+"' style='color:green;'>Word count: 0</span>"
								+"<input id=\"ans-choice-"+(i+1)+"\" class=\"form-control\" type=\"text\"></input>"
								+"<input type=\"radio\" name=\"correctAns\" id=\"ca_"+(i+1)+"\" value=\""+(i+1)+"\">&nbsp;Correct Answer</input>"
								+"<br><br>";
							}
						}
						//multiple correct choice
						else if(anstype == 1){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							$("#ans_form").append("<label>Answer "+(i+1)+": </label><input id=\"ans-choice-"+(i+1)+"\" class=\"form-control\" type=\"text\" style=\"width:auto\" size=\"50\"></input>"
								+"&nbspCorrect<input type=\"checkbox\" id=\"ca_"+(i+1)+"\" value=\""+(i+1)+"\">"
								+"<br>");
							}
						}
						//sorting choice
						else if(anstype == 2){
							$("#ans_form").empty();
							for(var i=0;i<nchoice;i++){
							$("#ans_form").append("<label>Position "+(i+1)+": </label><input id=\"ans-choice-"+(i+1)+"\" class=\"form-control\" type=\"text\" style=\"width:auto\" size=\"50\"></input>"
								+"<br>");
							}
						}
						
						$("#ans_form").html(choices_content);
						//$("#ans_form").append("<p>Note: Choice will be auto shuffle order</p>");
					}
				});
				
				/* $(document).delegate("[id^=tbutton]", "click", function(){
					alert("yeah");
				}); */
				
				$(document).delegate("[id^=ans-choice]", "change keydown paste input", function(){
					var alphabet_num = 0;
					alphabet_num = $(this).val().length;
					$(this).prev().html('Word count: '+alphabet_num);
				});
				
				/* $('[id^=ans-choice]').delegate('change keydown paste input', 'input',function(){
					var alphabet_num = 0;
					alphabet_num = $(this).text().length;
					alert(alphabet_num);
					//$(this).next().html('count: '+alphabet_num);
				}); */
				
				// preview pic
				function showPic(input) {
					//$('#pre_pic').attr('src', input.value);
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#pre_pic').attr('src', e.target.result);
						};
						reader.readAsDataURL(input.files[0]);
					}
				}
				$("#upload_pic").change(function(){
					showPic(this);
				});
				
				$("#preview_btn").click(function(){
					/*var choices = [];
					var n =  $('#n_choice').val();
					for(var i=1 ; i<=n ; i++){
						choices.push($('#ans'+i).val());
					}
					
					var dataset = {
						ques_text : $("#question_text").val(),
						choices : choices
					};*/
					
					// reset
					$('#pre_pic').empty();
					$('#pre_question').empty();
					$('#pre_choices').empty();
					$('#pre_refer').empty();
					$('#pre_a').empty();
					$('#pre_b').empty();
					$('#pre_time').empty();
					// pic
					
					/*var input = $('#upload_pic').val();
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function (e) {
							$('#pre_pic').attr('src', e.target.result);
						};
						reader.readAsDataURL(input.files[0]);
					}*/
					
					// question
					//$('#pre_question').html("<div><math xmlns='http://www.w3.org/1998/Math/MathML'>"+$("#question_text").val()+"</math></div>");
					$('#pre_question').html($("#question_text").val());
					
					// choices
					var n =  $('#n_choice').val();
					for(var i=1 ; i<=n ; i++){
						if($('#ca_'+i).is(':checked') === false)
							$('#pre_choices').append("<input type='radio' name='ch' disabled='disabled'> "+$('#ans-choice-'+i).val()+"</input><br>");
						else
							$('#pre_choices').append("<input type='radio' name='ch' checked='checked' disabled='disabled'> <b>"+$('#ans-choice-'+i).val()+"</b></input><br>");
					}
					// param and reference
					$('#pre_refer').html($("#ref_text").val());
					$('#pre_a').html($("#param_a").val());
					$('#pre_b').html($("#param_b").val());
					$('#pre_time').html($("#param_t").val());
					
					// show
					$('#previewModal').modal('toggle');
					$('#previewModal').modal('show');
					
				});
				
				$("#uploadImg").click(function(){
					if($('#upload_pic').prop('files')[0] != null)
						alert($('#upload_pic').val());
				});
				
				$("#uploadImg").hide();
				function uploadImg(item_id){
				//$("#uploadImg").click(function(){
					//alert("clicked");
					// get image data
					var file_data = $('#upload_pic').prop('files')[0];   
					var form_data = new FormData();                  
					form_data.append('file', file_data);
					form_data.append('pic_id', item_id);
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
						}
					});
				//});
				}
				
				$("#submit").click(function(){
					var choices = [];
					var n =  $('#n_choice').val();
					for(var i=1 ; i<=n ; i++){
						choices.push($('#ans-choice-'+i).val());
					}
					// answer choice
					var ca = $('#ans_form input[type="radio"]:checked').val();
					
					var dataset = {
						sub_id : $('#sub_id').val(),
						topic_id : $('#topic_id').val(),
						pic : pic_link,
						cat_id : $('#cat_id').val(),
						ans_type : $('#ans_type').val(),
						ques_text : $("#question_text").val(),
						refer : $('#ref_text').val(),
						choices : choices,
						correctans : ca,
						param_a : $('#param_a').val(),
						param_b : $('#param_b').val(),
						param_t : $('#param_t').val(),
						user : <?php echo $userResult['user_id']; ?>
					};
					
					var id = 0;
					$.post('itembank_query.php', {add_item:dataset}, function(result){
						alert("result: "+result);
						//var id = JSON.parseInt(result);
						//alert("id: "+id);
						id = result;
						if($('#upload_pic').prop('files')[0] != null){
							alert("UPLOADING");
							uploadImg(id);
						}
						alert("FINISHED");
						window.location.reload();
					});
				});
				
				// textbox editor
				$('#bold_text').click(function(){
					//alert(window.getSelection().toString());
					var btext = prompt("Please enter text to bold", "");
					if (btext != null) {
						btext = "<b>"+btext+"</b>";
						var cursorPosStart = $('#question_text').prop('selectionStart');
						var cursorPosEnd = $('#question_text').prop('selectionEnd');
						var v = $('#question_text').val();
						var textBefore = v.substring(0, cursorPosStart);
						var textAfter  = v.substring(cursorPosEnd, v.length);
						$('#question_text').val(textBefore + btext + textAfter);
					}
				});
				
				$('#italic_text').click(function(){
					var itext = prompt("Please enter text to italic", "");
					if (itext != null) {
						itext = "<i>"+itext+"</i>";
						var cursorPosStart = $('#question_text').prop('selectionStart');
						var cursorPosEnd = $('#question_text').prop('selectionEnd');
						var v = $('#question_text').val();
						var textBefore = v.substring(0, cursorPosStart);
						var textAfter  = v.substring(cursorPosEnd, v.length);
						$('#question_text').val(textBefore + itext + textAfter);
					}
				});
				
				$('#u_text').click(function(){
					var utext = prompt("Please enter text to underline", "");
					if (utext != null) {
						utext = "<u>"+utext+"</u>";
						var cursorPosStart = $('#question_text').prop('selectionStart');
						var cursorPosEnd = $('#question_text').prop('selectionEnd');
						var v = $('#question_text').val();
						var textBefore = v.substring(0, cursorPosStart);
						var textAfter  = v.substring(cursorPosEnd, v.length);
						$('#question_text').val(textBefore + utext + textAfter);
					}
				});
				
				var pic_link = null;
				$("#insert_pic").click(function(){
					var picLink = prompt("Please enter URL of picture", "");
					if (picLink != null) {
						pic_link = picLink;
					}
				});
				
				$("#insert_equal").click(function(){
					var equation = prompt("Please enter equation (latex format)", "");
					if (equation != null) {
						equation = "$$"+equation+"$$ ";
						var cursorPosStart = $('#question_text').prop('selectionStart');
						var cursorPosEnd = $('#question_text').prop('selectionEnd');
						var v = $('#question_text').val();
						var textBefore = v.substring(0, cursorPosStart);
						var textAfter  = v.substring(cursorPosEnd, v.length);
						$('#question_text').val(textBefore + equation + textAfter);
					}
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
							<a href="itembank.php"><i class="fa fa-files-o"></i> Item Bank<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse in">
								<li class="active">
									<a href="itembank.php">Overview</a>
								</li>
								<li>
									<a href="create_sub.php">Add Course</a>
								</li>
								<li>
									<a href="create_topic.php">Add Topic</a>
								</li>
								<li class="active">
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
								Create Item <small></small>
							</h1>
							<ol class="breadcrumb">
								<li><a href="admin_home.php">Home</a></li>
								<li><a href="#">Item Bank</a></li>
								<li class="active">Create Item</li>
							</ol>
						</div>
					</div>
					
					<!-- BODY -->
					<div class="row">
						<div class="col-md-9">
							<div class="panel panel-default">
								<div class="panel-heading">
									Create Item
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#question" data-toggle="tab">Question</a>
										</li>
										<li class=""><a href="#answer" data-toggle="tab">Answer</a>
										</li>
										<li class=""><a href="#param" data-toggle="tab">Parameter</a>
										</li>
										<li class=""><a href="#refer" data-toggle="tab">Reference</a>
										</li>
										<!-- <li class=""><a href="#settings" data-toggle="tab">Settings</a>
										</li> -->
									</ul>
									
									<div class="tab-content">
										<div class="tab-pane fade active in" id="question">
											<div class="panel-body">
												<!--<div class="row">-->
													<h4>Create Question</h4><br>
													<form class="form-group" accept-charset="UTF-8">
														<div class="row">
															<div class="col-md-4">
																<label for="sub_id">Subject</label>
																<select id="sub_id" class="form-control" style="width:auto">
																	<option>-- Select Subject --</option>
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
															<div class="col-md-4">
																<label for="topic_id">Topic</label>
																<select id="topic_id" class="form-control" style="width:auto">
																	<option>-- Select Topic --</option>
																</select>
															</div>
														</div><br>
														
														<div class="row">
															<div class="col-md-4">
																<label for="cat_id">Category</label>
																<select id="cat_id" class="form-control" style="width:auto">
																	<option>-- Select Category --</option>
																	<?php
																		$mysqli = connectDB();
																		
																		$objQuery = mysqli_query($mysqli, "SELECT * FROM item_category");
																		while($objResult = mysqli_fetch_array($objQuery)){
																	?>
																			<option value="<?php echo $objResult["cat_id"];?>"><?php echo $objResult["cat_name"];?></option>
																	<?php
																		}
																	?>
																</select>
															</div>
														</div><br>
														
														
														
														<label>Content</label>
														<div class="row">
															<div class="col-md-10">
																<button id="bold_text" type="button" class="btn btn-default btn-sm"><i class="fa fa-bold" aria-hidden="true"></i></button>&nbsp;
																<button id="italic_text" type="button" class="btn btn-default btn-sm"><i class="fa fa-italic" aria-hidden="true"></i></button>&nbsp;
																<button id="u_text" type="button" class="btn btn-default btn-sm"><i class="fa fa-underline" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;
																<button id="insert_equal" type="button" class="btn btn-default btn-sm">Add Equation</button>&nbsp;&nbsp;&nbsp;
																<button id="insert_pic" type="button" class="btn btn-default btn-sm">URL Picture</button>&nbsp;&nbsp;&nbsp;
																<br><br>
																<textarea id="question_text" class="form-control" rows="3"></textarea><br>
																<label>Upload Picture</label>
																<input id="upload_pic" type="file"></input>
																<button type="button" id="uploadImg" class="btn btn-default btn-sm">Upload Image</button>
															</div>
														</div><br>
														
														<div class="row">
															<div class="col-md-6">
																<label>Author Name : </label>
																<?php echo $userResult['fname']." ".$userResult['lname']; ?>
															</div>
														</div>
													</form>
												<!-- </div> -->
											</div>
										</div>
										
										<div class="tab-pane fade" id="answer">
											<div class="panel-body">
												<!-- <div class="row"> -->
													<h4>Create Answer</h4><br>
													<div class="row">
														<div class="col-md-6">
															<div class="well">
																<div>
																	<label for="ans_type">Answer Type</label>
																	<select id="ans_type" class="form-control" style="width:auto">
																		<option value="">-- Select Type --</option>
																		<option value="0">Multiple Choice</option>
																		<option value="1">Multiple Correct Choice</option>
																		<option value="2">Sorting</option>
																	</select>
																</div>
																<div>
																	<label for="n_choice">Choice Number</label>
																	<!-- <input id="n_choice" type="text" class="form-control" style="width:auto" size="2" value="0"></input> -->
																	<select id="n_choice" class="form-control" style="width:auto">
																		<option value="2">2</option>
																		<option value="3">3</option>
																		<option value="4">4</option>
																		<option value="5">5</option>
																	</select>
																</div><br>
																<div>
																	<button id="ans_btn" class="btn btn-default btn-sm" type="button">Create Form</button>
																</div>
															</div>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-12">
															<h5>Answers Form</h5>
															<div class="well">
																<form id="ans_form" accept-charset="UTF-8">The answers form will show when click "Create Form"</form>
															</div>
														</div>
													</div>
												<!--/div> -->
											</div>
										</div>
										
										<div class="tab-pane fade" id="param">
											<div class="panel-body">
												<h4>Parameter</h4><br>
												<div class="row">
													
													<!--<div class="row">-->
														<div class="col-md-9">
															<form accept-charset="UTF-8">
																<div class="row">
																	<div class="col-md-8">
																		<label>Discrimination Power (Decimal Number)</label>
																		<div>
																			<input id="param_a" type="text" class="form-control" style="width:auto" placeholder="Enter a value" size="15">
																		</div>
																	</div>
																</div><br>
																<div class="row">
																	<div class="col-md-6">
																		<label>Difficulty (Decimal Number)</label>
																		<div>
																			<input id="param_b" type="text" class="form-control" style="width:auto" placeholder="Enter b value" size="15">
																		</div>
																	</div>
																</div><br>
																<div class="row">
																	<div class="col-md-6">
																		<label>Time (Minute)</label>
																		<div>
																			<input id="param_t" type="text" class="form-control" style="width:auto" placeholder="Enter time" size="10">
																		</div>
																	</div>
																</div><br>
															</form>
														</div>
													<!--</div>-->
												</div>
											</div>
										</div>
										
										<div class="tab-pane fade" id="refer">
											<div class="panel-body">
												<h4>Reference</h4><br>
												<div class="row">
													<div class="col-md-10">
														<form accept-charset="UTF-8">
															<label>Input : </label>
															<textarea id="ref_text" class="form-control"></textarea><br>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<button id="submit" class="btn btn-primary" name="create" value="Create" type="submit">Create</button>
											&nbsp;&nbsp;&nbsp;
											<button id="preview_btn" class="btn btn-default" >Preview</button>
											&nbsp;&nbsp;&nbsp;
											<button class="btn btn-default" name="reset" value="reset" onclick="">Reset</button>
										</div>
										
										<div id="previewModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Item Preview</h4>
													</div>
													<div id="preContModal" class="modal-body">
														<div class="row">
															<div class="col-md-12">
																<center>
																	<!--<label>Image</label>-->
																	<div><img id="pre_pic" src="uploads/No-Images.png" style="width:300px;height:200px;"/></div>
																</center>
															</div>
														</div><br>
														
														<div class="row">
															<div class="col-md-12">
																<div class="panel panel-default">
																	<div class="panel-heading">Contents</div>
																	<div class="panel-body">
																		<div class="row">
																			<div class="col-md-12">
																				<div id="pre_question"></div><br>
																				<div id="pre_choices"></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														
														<div class="row">
															<div class="col-md-3">
																<div class="panel panel-default">
																	<div class="panel-heading">Parameters</div>
																	<div class="panel-body">
																		<b>Discrimination Power: </b>
																		<span id="pre_a"></span><br>
																		<b>Difficulty: </b>
																		<span id="pre_b"></span><br>
																		<b>Time: </b>
																		<span id="pre_time"></span>
																	</div>
																</div>
															</div>
															<div class="col-md-9">
																<div class="panel panel-default">
																	<div class="panel-heading">Reference</div>
																	<div class="panel-body">
																		<div id="pre_refer"></div>
																	</div>
																</div>
															</div>
														</div>
														
													</div>
													<div class="modal-footer">
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
					<!-- <button id="abc" type="button">test</button> -->
					<!-- /. BODY -->

				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
		
	</body>
</html>