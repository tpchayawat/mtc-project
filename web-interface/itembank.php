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
		<meta charset="utf-8" />
		<title>Item Bank - MTC E-Testing</title>
		
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
		
		<script src='assets/js/d3/d3.min.js'></script>
		<script src='assets/js/nvd3/build/nv.d3.min.js'></script>
		<link href="assets/js/nvd3/build/nv.d3.min.css" rel="stylesheet" type="text/css"/>
		
		<script src="assets/js/custom-scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
				$('#expand-acc').hide();
				
				$('.closeall').click(function(){
					$('.panel-collapse.in').collapse('hide');
					$('#expand-acc').show();
					$('#collapse-acc').hide();
				});
				$('.openall').click(function(){
					$('.panel-collapse:not(".in")').collapse('show');
					$('#expand-acc').hide();
					$('#collapse-acc').show();
				});
				
				getChart();

				function getChart(){
					var color_pool = ['#ff7f0e','#2ca02c','#1f77b4','#98df8a','#2ca02c','#d62728','#aec7e8'];
					var items_param = [];
					var sub_b = [], si=-1;
					var sub_data = [];
					var s_id = 0;
					var n_item = 0, n_sub = 0;
					$.post("itembank_query.php",{
						get_item_data: "<?php echo $userResult['user_id']; ?>"},
						function(result){
							//alert(result);
							var objResult = JSON.parse(result);
							for(var i=0 ; i < objResult.length ; i++){
								var item = {"s_id":objResult[i]['s_id'],"c_name":objResult[i]['c_name'],"c_id":objResult[i]['c_id'],
											"t_id":objResult[i]['t_id'],"t_name":objResult[i]['t_name'],
											"a":parseFloat(objResult[i]['a']),
											"b":parseFloat(objResult[i]['b']),
											"time":parseInt(objResult[i]['time'])
											};
								items_param.push(item);
								
								var isDupSub = false;
								var cur_sid_index = 0;
								for(var ch=0 ; ch<sub_data.length ; ch++){
									if(objResult[i]['s_id'] == sub_data[ch][0]){
										isDupSub = true;
										cur_sid_index = ch;
										//alert(objResult[i]['s_id'] +" - "+ s_id +" - "+ isDupSub);
										break;
									}
								}
								
								if(!isDupSub){
									s_id = objResult[i]["s_id"];
									n_sub++;
									si++;
									sub_data[si] = [];
									sub_data[si][0] = objResult[i]['s_id'];
									sub_data[si][1] = objResult[i]['c_id'];
									sub_data[si][2] = objResult[i]['c_name'];
									sub_data[si][3] = [];
									cur_sid_index = si;
								}
								sub_data[cur_sid_index][3].push(parseFloat(objResult[i]['b']));
								//alert("sub_b["+si+"] : "+sub_b[si]);
							}
							n_item = items_param.length;
							$('#n_sub').html(n_sub);
							$('#n_item').html(n_item);
							//alert("n_sub:"+n_sub+" n_item:"+n_item);
							
							function getInfoData(data) {		// unfinish
								//alert(data);
								var infoData = [];
								for(var i=0 ; i<data.length ; i++){
									var course = [];
									for (var scale = -3; scale < 4; scale++) {
										// solution
										var info = 0;
										for(var c=0 ; c<data[i][3].length ; c++){
											var prob = (1.0)/(1.0+(Math.exp(-1.0*(scale-data[i][3][c]))));
											info += prob*(1.0-prob);
										}
										info /= data[i][3].length;
										course.push({x: scale, y: info});
									}
									infoData.push(
									{
										values: course,
										key: data[i][2],
										color: color_pool[i]
									});
								}
								return infoData;
							}
							
							//alert(sub_data[0]);
							
							//var sub = [];
							//sub.push(sub_data[0]);
							//drawGraph(getInfoData(sub),0);
							
							for(var s=0; s<= n_sub ; s++){
								// each data graph
								if(s != n_sub){
									var sub = [];
									sub[0] = sub_data[s];
									//alert(sub_data[i]);
									//lert(sub[0]);
									//var data = getInfoData(sub);
									drawGraph(getInfoData(sub),s);
									
								}
								// total data graph
								else{
									//var total_sub_data = getInfoData(sub_data);
									drawGraph(getInfoData(sub_data),s);
								}
									
							}
							
							function drawGraph(data,n){
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
									
									if(data.length > 1){
										d3.select('#total-sub-chart svg')
										.datum(data)
										.transition().duration(500)
										.call(chart)
										;
									}
									else{
										data[0]['color'] = color_pool[n];
										d3.select('#sub-chart-'+sub_data[n][0]+' svg')
										.datum(data)
										.transition().duration(500)
										.call(chart)
										;
										
									}
									
									nv.utils.windowResize(chart.update);
									
									return chart;
								});
							}
							
							/*nv.addGraph(function() {
								var chart = nv.models.lineChart()
								.interpolate("basis")
								.useInteractiveGuideline(true)
								;
								
								chart.xAxis
								.axisLabel('b (difficulty level)')
								.tickFormat(d3.format(',r'))
								//.tickValues([-3,-2,-1,0,1,2,3])
								;
								
								chart.yAxis
								.axisLabel('Information')
								.tickFormat(d3.format('.02f'))
								;
								
								var total_sub_data = getInfoData(sub_data);
								d3.select('#total-sub-chart svg')
								.datum(total_sub_data)
								.transition().duration(500)
								.call(chart)
								;
								
								for(var i=0 ; i<n_sub ; i++){
									//alert(items_param[i]['s_id']);
									var sub = [];
									sub[0] = sub_data[i];
									//alert(sub[0]);
									var data = getInfoData(sub);
									data[0]['color'] = color_pool[i];
									d3.select('#sub-chart-'+sub_data[i][0]+' svg')
									.datum(data)
									.transition().duration(500)
									.call(chart)
									;
								}
								
								nv.utils.windowResize(chart.update);
								
								return chart;
							});*/
						}
					);
					return items_param;
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
									Item Bank <small>Overview</small>
								</h1>
								<ol class="breadcrumb">
									<li><a href="admin_home.php">Home</a></li>
									<li><a href="itembank.php">Item Bank</a></li>
									<li class="active">Overview</li>
								</ol>
							</div>
						</div>
						
						<!-- BODY -->
						<!-- BEDGE AND GRAPH -->
						<div class="row">
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="panel panel-primary text-center no-boder bg-color-green">
									<div class="panel-left pull-left green">
										<i class="fa fa-bar-chart-o fa-5x"></i>
										
									</div>
									<div class="panel-right pull-right">
										<h3 id="n_sub"></h3>
									   <strong> No. of Courses</strong>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="panel panel-primary text-center no-boder bg-color-brown">
									<div class="panel-left pull-left brown">
										<i class="fa fa-users fa-5x"></i>
										
									</div>
									<div class="panel-right pull-right">
									<h3 id="n_item"></h3>
									 <strong>No. of Items</strong>

									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading">Course Information</div>
									<div class="panel-body" id="total-sub-chart" style="height: 400px;">
										<svg></svg>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										Course Details
										<a id="expand-acc" href="#" class="openall" style="float:right;font-weight:normal;">Expand All</a>
										<a id="collapse-acc" href="#" class="closeall" style="float:right;font-weight:normal;">Collapse All</a>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="panel-group" id="accordion">
												
													<?php
														$conn = connectDB();
														// subject query
														//$subSQL = "SELECT sub.* FROM subject sub,user_account user WHERE sub.user_create=user.user_id AND user.user_id=".$userResult['user_id'];
														$subSQL = "SELECT sub.* FROM subject sub,course_owner owner WHERE sub.subject_id=owner.subject_id AND owner.user_id=".$_SESSION['user_id'];
														$subQuery = mysqli_query($conn, $subSQL);
														$i = 1;
														while($subObj=mysqli_fetch_array($subQuery)){
															echo '<div class="panel panel-default">
																	<div class="panel-heading">
																		<h4 class="panel-title" style="display:inline;">
																			<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">'.$subObj['course_id'].' - '.$subObj['course_name'].'</a>
																		</h4>
																		&nbsp;&nbsp;
																		<a href="sub_edit.php?sid='.$subObj['subject_id'].'" style="font-weight:normal;">Edit</a>
																	</div>
																	<div id="collapse'.$i++.'" class="panel-collapse collapse in">
																		<div class="panel-body">';
															
															echo '<div class="row"><div class="col-md-6">';
															echo '<b>Course ID : </b>'.$subObj['course_id'].'<br>';
															echo '<b>Course Name : </b>'.$subObj['course_name'].'<br>';
															echo '<b>Definition : </b>'.$subObj['definition'].'<br><br>';
															echo '</div><div class="col-md-6">';
															echo '<div class="panel panel-default">
																		<div class="panel-body" id="sub-chart-'.$subObj['subject_id'].'">
																			<svg></svg>
																		</div>
																	</div>';
															echo '</div></div>';
															
															echo '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
															echo '<label for="topic-sub'.$i.'">Topic List</label>';
															echo '<table id="topic-sub'.$i.'" class="table table-striped table-bordered table-hover" role="grid">
																	<thead>
																		<tr>
																			<th>Topic Name</th>
																			<th>Objective</th>
																			<th>Instructor</th>
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>';
															// topic query
															$topicSQL = "SELECT t.*,u.fname,u.lname FROM topic t,user_account u WHERE t.subject_id='".$subObj['subject_id']."' AND t.user_create=u.user_id AND u.user_id=".$userResult['user_id'];
															//$topicSQL = "SELECT * FROM topic t WHERE t.subject_id=".$subObj['subject_id'];
															$topicQuery = mysqli_query($conn, $topicSQL);
															while($topicResult = mysqli_fetch_array($topicQuery)){
																echo "<tr><td><a href='subject.php?t_id=".$topicResult['topic_id']."'>".$topicResult['topic_name']."</a></td>";
																echo "<td>".nl2br($topicResult['definition'])."</td>";
																echo "<td>".$topicResult['fname']." ".$topicResult['lname']."</td>";
																echo '<td class="text-center"><a href="edit_topic.php?tid='.$topicResult['topic_id'].'">Edit</a></td></tr>';
															}
															echo '</tbody></table>
																</div></div></div></div></div>';
														}
														$conn->close();
													?>
												</div>
											</div>
										</div>
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