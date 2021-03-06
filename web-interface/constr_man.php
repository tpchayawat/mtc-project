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
		
		<script src='assets/js/d3/d3.min.js'></script>
		<script src='assets/js/nvd3/build/nv.d3.min.js'></script>
		<link href="assets/js/nvd3/build/nv.d3.min.css" rel="stylesheet" type="text/css"/>

		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});
				
				$("#sub_id").change(function(){
					$("#topic_id").html("<option>-- Select Topic --</option>");
					//alert($("#sub_id").val());
					$.post("constr_query.php",{
						sub_id: $("#sub_id").val()
						},
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
				var selected_item = [];			//selected item set
				var selected_item_param = [];	//parameter of selected items 
				
				$("#topic_id").change(function(){
					item_set = [];
					$.post("constr_query.php",{
						topic_id: $("#topic_id").val()},
						function(result){
							//alert(result);
							item_set = JSON.parse(result);
							//alert(dataObj[0].topic_name);
							
							if($("#item_num").val() != ""){
								$("#aval-item").empty();
								n = $("#item_num").val();
								$("#item_counter").html(ci+"/"+n);
								
								for(var i=0 ; i<item_set.length ; i++){
									//var item_id = parseInt(item_set[i].item_id);
									var item_id = parseInt(item_set[i][0].item_id);
									var isDup = false;
									if(selected_item.length > 0){
										for(var j=0 ; j<selected_item.length ; j++){
											if(item_id == selected_item[j]){
												isDup = true;
												break;
											}
										}
										if(!isDup){
											/*$("#aval-item").append("<option value='"+item_id+"'>Item ID: "+item_id+"&emsp;a: "+parseFloat(item_set[i][0].a)
											+"&emsp;b: "+parseFloat(item_set[i][0].b)+"&emsp;time: "+parseInt(item_set[i][0].time)
											+"<a>view</a></option>");*/
											$("#aval-item").append("<option value='"+item_id+"'>"+item_set[i][0].question+"</option>");
										}
									}
									else{
										/*$("#aval-item").append("<option data-toggle='tooltip' title='double click to view the item' value='"+item_id+"'>Item ID: "+item_id+"&emsp;a: "+parseFloat(item_set[i][0].a)
										+"&emsp;b: "+parseFloat(item_set[i][0].b)+"&emsp;time: "+parseInt(item_set[i][0].time)
										+"&emsp;<a>view</a></option>");*/
										$("#aval-item").append("<option data-toggle='tooltip' title='double click to view the item' value='"+item_id+"'>"+item_set[i][0].question+"</option>");
									}
								}
							}
							else{
								alert("Please Enter Item Number!");
							}
						}
					);
				});
				
				$('#aval-item, #selected-item').dblclick(function(){
					//alert("item: "+$('#aval-item').val()+" ");
					$('#choice-modal').empty();
					$('#pic-modal').attr('src','uploads/No-Images.png');
					
					$('#showItemModal').modal('toggle');
					$('#showItemModal').modal('show');
					
					var id = $(this).val();
					//alert("id: "+id);
					
					for(var i=0 ; i<item_set.length ; i++){
						if(id == parseInt(item_set[i][0].item_id)){
							//alert(id);
							var qtext = item_set[i][0].question;
							if(item_set[i][0].pic_link.length > 0){
								$('#pic-modal').attr('src',item_set[i][0].pic_link);
								qtext += ' <span><i class="fa fa-picture-o" aria-hidden="true"></i></span>';
							}
							$('#question-modal').html(qtext);
							var alpha_char = 97;
							for(var j=0 ; j<item_set[i][1].length ; j++){
								// check correct answer
								if(item_set[i][1][j].choice_id != item_set[i][0].choice_id)
									$('#choice-modal').append('<b>'+String.fromCharCode(alpha_char++)+'.</b> '+item_set[i][1][j].content+'<br>');
								else
									$('#choice-modal').append('<span style="color:red;font-weight: bold;">'+String.fromCharCode(alpha_char++)+'. '+item_set[i][1][j].content+' <i class="fa fa-check-circle-o" aria-hidden="true"></i><span><br>');
							}
							$('#ref-modal').html(item_set[i][0].refer);
							
							// draw item graph
							var item_graph = [];
							item_graph.push({item_id:id,b:parseFloat(item_set[i][0].b)});
							drawGraph(item_graph,'#item-graph svg');
							
							$('#item-param').html("<div><b>Category :</b> "+item_set[i][0].cat_name+"</div>"
								+"<div><b>Discrimination Power :</b> "+parseFloat(item_set[i][0].a)+"</div>"
								+"<div><b>Difficulty Level :</b> "+parseFloat(item_set[i][0].b)+"</div>"
								+"<div><b>Time(Minutes) :</b> "+parseInt(item_set[i][0].time)+"</div>");
						}
					}
				});
				
				// tooltip
				$('[data-toggle="tooltip"]').tooltip(); 
				// hide submit item number button
				$('#submit_nitem').hide();
				
				$("#add_item").click(function(){
					var selected = $("#aval-item").val();
					
					if((ci+selected.length)<=n){
						
						//selected_item.push($('#aval-item option:selected').val());	// push selected item into array
						var sel_buffer = $('#aval-item option:selected');				// create buffer for multiple selection
						//alert(ar[1].value);
						for(var i=0 ; i<sel_buffer.length ; i++){
							var id = sel_buffer[i].value;
							// push selected item into array
							selected_item.push(id);
							// push parameter b of selected item into specific array
							for(var j=0 ; j<item_set.length ; j++){
								if(id == parseInt(item_set[j][0].item_id)){
									//alert("id: "+id+", b: "+parseFloat(item_set[j][0].b));
									selected_item_param.push({
										item_id: id,
										b: parseFloat(item_set[j][0].b)
									});
								}
							}
						}
						
						// recalulate info and redraw a graph
						//alert(selected_item_param);
						drawGraph(selected_item_param,'#form-graph svg');
						
						$('#aval-item option:selected').clone().appendTo($("#selected-item"));
						$('#aval-item option:selected').remove();
						ci += selected.length;
						$("#item_counter").html(ci+"/"+n);
					}
					else{alert("Cannot Add Item!\nselected item is more than limit form.");}
				});
				
				// sort item - unusable
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
						var rn = $("#selected-item").val();		// set of removing item
						//alert(rn);
						//var rem = $('#selected-item option:selected');
						
						$('#selected-item option:selected').clone().appendTo($("#aval-item"));
						$("#aval-item").sort_select_box();
						
						ci -= rn.length;
						$("#item_counter").html(ci+"/"+n);
						
						$('#selected-item option:selected').remove();
						
						// remove parameter b of selected item into specific array
						//for(var rid in rn){
						for(var rid=0 ; rid<rn.length ; rid++){
							for(var i=0 ; i<selected_item_param.length ; i++){
								if(rn[rid] == selected_item_param[i].item_id){
									selected_item_param.splice(i,1);
								}
							}
						}
						
						drawGraph(selected_item_param,"#form-graph svg");
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
					
					var isShuffle = 0;
					if($('#is-shuffle').is(':checked'))
						isShuffle = 1;
					
					var dataset = {
						s_id : $("#sub_id").val(),
						total_item : n,
						total_form : 1,
						note : $("#note").val(),
						testform_name : $("#name").val(),
						selected_item : sel_item,
						shuffle : isShuffle,
						user : <?php echo $userResult['user_id']; ?>
					};
					//alert(dataset.submit_man.testform_name);
					$.post("constr_query.php", {submit_man:dataset}, function(result){
						alert(result);
						window.location.replace($(location).attr("href"));
					});
				});
				
				// calculate information function and draw graph
				function drawGraph(data,svg) {
					//data = selected_item_param;
					//alert(data);
					var infoData = [];
					var points = [];
					
					for (var scale = -3; scale < 4; scale++) {
						// solution
						var info = 0;
						for(var i=0 ; i<data.length ; i++){
							//var b = (data[i].b*6.0)-3.0;	// bias scale to (-3 - 3)
							var prob = (1.0)/(1.0+(Math.exp(-1.0*(scale-data[i].b))));
							info += prob*(1.0-prob);
						}
						info /= data.length;
						points.push({x: scale, y: info});
					}
					//alert(points[0]+" "+points[1].y+" "+points[2].y+" "+points[3].y+" "+points[4].y+" "+points[5].y+" "+points[6].y);
					infoData.push(
					{
						values: points,
						key: "current form",
						color: "#1f77b4"
					});
					//return infoData;
					
					nv.addGraph(function() {
						var chart = nv.models.lineChart()
						.interpolate("basis")
						.useInteractiveGuideline(true)
						;
						
						chart.xAxis
						.axisLabel('b (difficulty level)')
						.tickFormat(d3.format(',r'))
						;
						//.tickValues([-3,-2,-1,0,1,2,3])
						
						chart.yAxis
						.axisLabel('Information')
						.tickFormat(d3.format('.02f'))
						;
						
						d3.select(svg)
							.datum(infoData)
							.transition().duration(500)
							.call(chart)
							;
						
						nv.utils.windowResize(chart.update);
						
						return chart;
					});
				}

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
												<div class="col-md-4">
													<label for="name">Test Form Name</label>
													<input id="name" class="form-control" placeholder="Enter test name" style="width:auto" size="30"></input>
													<label for="item_num">Item Number</label>
													<input id="item_num" class="form-control" placeholder="Enter item number" style="width:auto" size="15"></input><br>
													
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
													<br>
													
													<button id="submit_nitem" class="btn btn-default btn-sm" type="button">Get Item</button>
												</div>
												<div class="col-md-8">
													<div class="panel panel-default">
														<!--<div class="panel-heading" align="center">Test Form Information Graph</div>-->
														<div class="panel-body" id="form-graph" style="height: 250px;">
															<svg></svg>
														</div>
													</div>
												</div>
											</div><br>
											
											<div class="row">
												<div class="col-md-6">
													<label>Option</label><br>
													<label class="checkbox-inline"><input id="is-shuffle" type="checkbox" value="">Shuffle item</label>
												</div>
											</div><br>
											
											<div class="row">
												<div class="col-md-5">
													<label for="aval-item">Avalible item (hold shift to select more than one):</label>
													<select multiple id="aval-item" class="form-control"  size="10" align="left">
													</select>
													*double-click to view the item
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
													<label for="selected-item">Selected item (hold shift to select more than one):</label>
													<select multiple class="form-control" id="selected-item" size="10" align="left">
													</select>
												</div>
											</div><br>
											
											<div class="row">
												<div class="col-md-6">
													<label for="note">Note</label>
													<textarea id="note" class="form-control" ></textarea>
												</div>
											</div><br>
											
											<div>
												<button id="submit" class="btn btn-primary" type="button">Create Form</button>&ensp;
												<button id="reset" class="btn btn-default" type="reset">Reset</button>
											</div>
										</form>
										
										<!-- /Form Contents -->
									</div>
									
									<!-- if use class="modal fade", svg graph error -->
									<div id="showItemModal" class="modal" role="dialog">
										<div class="modal-dialog modal-md">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Item Details</h4>
												</div>
												<div class="modal-body">
													<div class="row">
														<div class="col-md-12">
															<div class="panel panel-default">
																<div class="panel-heading" align="center">Item Information</div>
																<div class="panel-body" id="item-graph" style="height: 200px;">
																	<svg></svg>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="panel panel-default">
															<div class="panel-heading" align="center">Content</div>
																<div class="panel-body">
																	<div class="row">
																		<div class="col-md-8">
																			<div id="question-modal" style="font-weight: bold;"></div><br>
																			<div id="choice-modal"></div>
																		</div>
																		<div class="col-md-4">
																			<img id="pic-modal" src="uploads/No-Images.png" style="width:150px;height:100px"/>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-5">
															<div class="panel panel-default">
																<div class="panel-heading" align="center">Attributes</div>
																<div class="panel-body" id="item-param"></div>
															</div>
														</div>
														<div class="col-md-7">
															<div class="panel panel-default">
															<div class="panel-heading" align="center">Referrence</div>
																<div class="panel-body">
																	<div id="ref-modal"></div>
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