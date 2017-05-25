<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	// get subject and topic info
	$tSql = "SELECT t.*,s.course_name,s.course_id FROM topic t,subject s WHERE t.subject_id=s.subject_id AND t.topic_id=".$_GET['t_id'];
	$tQuery = mysqli_query($conn,$tSql);
	$tResult = mysqli_fetch_array($tQuery);
	
	// get topic and item info
	//$topicSQL = "SELECT i.*,ch.content FROM topic t,item i,choice ch WHERE t.topic_id=i.topic_id AND i.item_id=ch.item_id AND t.topic_id=".$_GET['t_id'];
	//$topicQuery = mysqli_query($conn, $topicSQL);
	//$topicResult = mysqli_fetch_array($topicQuery);
	
	$topicSQL = "SELECT * FROM item i, item_param param, item_category cat WHERE i.item_id=param.item_id AND i.cat_id=cat.cat_id AND i.topic_id=".$_GET['t_id'];
	$topicQuery = mysqli_query($conn, $topicSQL);
	
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
		
		<style>
			.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
				border: none;
			}
		</style>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
				/*$("#tbtn").click(function(){
					alert("test");
				});*/
			
				var item_set = [];
				$.post("constr_query.php",{topic_id: <?php echo $_GET['t_id'];?>},
					function(result){
						//alert(result);
						item_set = JSON.parse(result);
						
						// get b data to draw graph
						var data = [];
						for(var i=0 ; i<item_set.length ; i++){
							data.push(parseFloat(item_set[i][0].b));
						}
						//alert(data);
						drawGraph(data,"#topic-chart svg","<?php echo $tResult['topic_name'];?>");
						
						// create item list
						/*var itemTable = '<table class="table table-bordered">'
							+'<thead><tr><th>#</th><th>Category</th><th>Question</th><th>a</th><th>b</th><th>time</th><th></th></tr></thead>'
							+'<tbody>';
						
						for(var i=0 ; i<item_set.length ; i++){
							var id = parseInt(item_set[i][0].item_id);
							itemTable += '<tr><th>'+id+'</th>'
								+'<td>'+parseInt(item_set[i][0].cat_id)+'</td>'
								+'<td>'+item_set[i][0].question+'</td>'
								+'<td>'+item_set[i][0].a+'</td>'
								+'<td>'+item_set[i][0].b+'</td>'
								+'<td>'+item_set[i][0].time+'</td>'
								+'<td><div class="btn btn-default itemview" id="itemview-'+id+'" value="'+id+'">View</div></td>'
						}
						itemTable += '</tr></tbody></table>';
						$("#item-list").empty().html(itemTable);*/
					}
				);
				
				//$("#tbtn").click(function(){
				$('[id^=itemview]').click(function(){
				//$('.itemview').click(function(){
					//alert("IN");
					$('#choice-modal').empty();

					var id = $(this).attr('value');
					//var id = 1;
					//alert("id: "+id);
					
					for(var i=0 ; i<item_set.length ; i++){
						if(id == parseInt(item_set[i][0].item_id)){
							//alert(id);
							$('#question-modal').html(item_set[i][0].question);
							for(var j=0 ; j<item_set[i][1].length ; j++){
								$('#choice-modal').append((j+1)+'. '+item_set[i][1][j].content+'<br>');
							}
							// draw item graph
							var item_graph = [];
							item_graph.push(parseFloat(item_set[i][0].b));
							drawGraph(item_graph,'#item-graph svg','Item-'+id);
							
							$('#item-param').html("<div style='font-weight: bold'>a : "+parseFloat(item_set[i][0].a)+"</div>"
								+"<div style='font-weight: bold'>b : "+parseFloat(item_set[i][0].b)+"</div>"
								+"<div style='font-weight: bold'>time(min) : "+parseInt(item_set[i][0].time)+"</div>");
						}
					}
					
					$('#showItemModal').modal('toggle');
					$('#showItemModal').modal('show');
				
				});

				// calculate information function and draw graph
				function drawGraph(data,svg,label) {
					//data = selected_item_param;
					//alert(data);
					var infoData = [];
					var points = [];
					
					for (var scale = -3; scale < 4; scale++) {
						// solution
						var info = 0;
						for(var i=0 ; i<data.length ; i++){
							//var b = (data[i].b*6.0)-3.0;	// bias scale to (-3 - 3)
							var prob = (1.0)/(1.0+(Math.exp(-1.0*(scale-data[i]))));
							info += prob*(1.0-prob);
						}
						info /= data.length;
						points.push({x: scale, y: info});
					}
					//alert(points[0]+" "+points[1].y+" "+points[2].y+" "+points[3].y+" "+points[4].y+" "+points[5].y+" "+points[6].y);
					infoData.push(
					{
						values: points,
						key: label,
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
									<?php echo $tResult['topic_name'];?> <small><?php echo $tResult['course_name'];?></small>
								</h1>
								<ol class="breadcrumb">
									<li><a href="admin_home.php">Home</a></li>
									<li><a href="itembank.php">Item Bank</a></li>
									<li><a href="#"><?php echo $tResult['course_name'];?></a></li>
									<li class="active"><?php echo $tResult['topic_name'];?></li>
								</ol>
							</div>
						</div>
						
						<!-- BODY -->
						<div class="row">
							<div class="col-md-5">
								<div class="panel panel-default">
									<div class="panel-heading">Topic Detail</div>
									<div class="panel-body" > <!-- style="height: 250px;" -->
										<div class="table-responsive">          
											<table class="table table-borderless">
												<tbody>
													<tr>
														<td style="width: 120px;"><label>Course ID :</label></td>
														<td><?php echo $tResult['course_id'];?></td>
													</tr>
													<tr>
														<td style="width: 120px;"><label>Course Name :</label></td>
														<td><?php echo $tResult['course_name'];?></td>
													</tr>
													<tr>
														<td style="width: 120px;"><label>Topic Name :</label></td>
														<td><?php echo $tResult['topic_name'];?></td>
													</tr>
													<tr>
														<td style="width: 120px;"><label>Definition :</label></td>
														<td><?php echo nl2br($tResult['definition']);?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

							</div>
							<div class="col-md-7 col-sm-12 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading">Topic Information</div>
									<div class="panel-body" id="topic-chart" style="height: 250px;">
										<svg></svg>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Item List</div>
									<div class="panel-body">
										<div id="item-list">
											<?php
												echo '<table class="table table-bordered"><thead><tr>
													<th class="col-md-1 text-center">#</th>
													<th class="col-md-1 text-center">Category</th>
													<th class="col-md-6 text-center">Question</th>
													<th class="col-md-1 text-center">Discrimination<br>Power</th>
													<th class="col-md-1 text-center">Difficulty<br>Level</th>
													<th class="col-md-1 text-center">Time<br>(Minutes)</th>
													<th class="col-md-1 text-center"></th></tr>
													</thead><tbody>';
												while($topicResult = mysqli_fetch_array($topicQuery)){
													echo '<tr><th class="text-center">'.$topicResult['item_id'].'</th>';
													echo '<td class="text-center">'.$topicResult['cat_name'].'</td>';
													echo '<td class="text-left">'.$topicResult['question'].'</td>';
													echo '<td class="text-center">'.$topicResult['a'].'</td>';
													echo '<td class="text-center">'.$topicResult['b'].'</td>';
													echo '<td class="text-center">'.$topicResult['time'].'</td>';
													echo '<td class="text-center"><div class="btn btn-default" id="itemview-'.$topicResult['item_id'].'" value="'.$topicResult['item_id'].'">View</div></td>';
												}
												echo '</tr></tbody></table>';
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- if use class="modal fade", svg graph error -->
						<div id="showItemModal" class="modal" role="dialog">
							<div class="modal-dialog modal-md">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Item detail</h4>
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
											<div class="col-md-9">
												<div class="panel panel-default">
												<div class="panel-heading" align="center">Content</div>
													<div class="panel-body">
														<div id="question-modal" style="font-weight: bold"></div><br>
														<div id="choice-modal"></div>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="panel panel-default">
													<div class="panel-heading" align="center">Parameter</div>
													<div class="panel-body" id="item-param"></div>
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
						<!-- /. BODY -->
					</div>
					<!-- /. PAGE INNER  -->
				</div>
				<!-- /. PAGE WRAPPER  -->
			</div>
		</body>
	</html>		