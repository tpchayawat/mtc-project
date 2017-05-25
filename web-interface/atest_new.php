<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	// get testforms info
	$tfSQL = "SELECT * FROM `testform` tf,`constraint` c WHERE tf.constraint_id=c.constraint_id AND tf.testform_id=".$_GET['tf_id'];
	$tfQuery = mysqli_query($conn, $tfSQL);
	$tfResult = mysqli_fetch_array($tfQuery);
	
	// get subject and topic info
	$subSql = "SELECT s.course_name,s.course_id FROM subject s WHERE s.subject_id=".$tfResult['subject_id'];
	$subQuery = mysqli_query($conn,$subSql);
	$subResult = mysqli_fetch_array($subQuery);
	
	$conn->close();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Test Forms - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script src='assets/js/d3/d3.min.js'></script>
		<script src='assets/js/nvd3/build/nv.d3.min.js'></script>
		<link href="assets/js/nvd3/build/nv.d3.min.css" rel="stylesheet" type="text/css"/>
		
		<style>
			.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
			border: none;
			}
		</style>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var item_set = [];
				$.post("testform_query.php",{
					get_testform_data2: {
						tf_id: '<?php echo $_GET['tf_id'];?>',
						u_id: '<?php echo $_SESSION['user_id'];?>'
					}},
					function(result){
						//alert(result);
						item_set = JSON.parse(result);
						
						// get b data to draw graph
						var data = [];
						var sum = 0.0;
						var alltime = 0;
						for(var i=0 ; i<item_set.length ; i++){
							var bval = {b:parseFloat(item_set[i][0].b)};
							data.push(bval);	// b
							sum += data[i];
							alltime += parseInt(item_set[i][0].time);		// time
						}
						//alert(sum/item_set[1].length);
						$('#tf-b').html(sum/item_set.length);
						$('#tf-time').html("~ "+alltime+" minutes");
						
						//alert(data);
						drawGraph(data,"#info-chart svg","<?php echo $tfResult['name'];?>");
						
						// create item list
						var itemTable = '<table class="table table-bordered">'
							+'<thead><tr>'
							//+'<th class="col-md-1 text-center">#</th><th class="col-md-1 text-center">Category</th>'
							+'<th class="col-md-1 text-center">Category</th>'
							+'<th class="text-center">Question</th><th class="col-md-1 text-center">Discrimination<br>Power</th>'
							+'<th class="col-md-1 text-center">Difficulty<br>Level</th><th class="col-md-1 text-center">Time<br>(Minutes)</th><th class="col-md-1"></th></tr></thead>'
							+'<tbody>';
						
						for(var i=0 ; i<item_set.length ; i++){
							var id = parseInt(item_set[i][0].item_id);			// item_id
							//itemTable += '<tr><th class="text-center">'+id+'</th>'
							itemTable += '<tr><td class="text-center">'+item_set[i][0].cat_name+'</td>'	// cat_id -> cat_name
								+'<td>'+item_set[i][0].question+'</td>'			// question
								+'<td class="text-center">'+item_set[i][0].a+'</td>'	// a
								+'<td class="text-center">'+item_set[i][0].b+'</td>'	// b
								+'<td class="text-center">'+item_set[i][0].time+'</td>'	// time
								+'<td class="text-center"><button class="btn btn-default" id="itemview-'+id+'" value="'+id+'">View</button>'
								+'</div></td>';
						}
						itemTable += '</tbody></table>';
						$("#item-list").html(itemTable);
					}
				);
				
				$(document).delegate("[id^=itemview]", "click", function(){	
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
									$('#choice-modal').append('<span style="color:green;font-weight: bold;">'+String.fromCharCode(alpha_char++)+'. '+item_set[i][1][j].content+' <i class="fa fa-check-circle-o" aria-hidden="true"></i><span><br>');
							}
							$('#ref-modal').html(item_set[i][0].refer);
							
							// draw item graph
							var item_graph = [];
							item_graph.push({item_id:id,b:parseFloat(item_set[i][0].b)});
							drawGraph(item_graph,'#item-graph svg',"item-"+id);
							
							$('#item-param').html("<div><b>Category :</b> "+item_set[i][0].cat_name+"</div>"
								+"<div><b>Discrimination Power :</b> "+parseFloat(item_set[i][0].a)+"</div>"
								+"<div><b>Difficulty Level :</b> "+parseFloat(item_set[i][0].b)+"</div>"
								+"<div><b>Time(Minutes) :</b> "+parseInt(item_set[i][0].time)+"</div>");
						}
					}
				
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
							<?php echo $tfResult['name'];?> <small><?php echo $tfResult['name'];?></small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="testform_new.php">Test Forms</a></li>
							<li><a href="#" onclick="history.go(-1);"><?php echo $subResult['course_id'];?></a></li>
							<li class="active"><?php echo $tfResult['name'];?></li>
						</ol>
					</div>
				</div>
				
				<!-- Main Contents -->
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Test Information</div>
							<div class="panel-body">
								<div id="info-chart" style="height:250px;">
									<svg></svg>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">Test Rasch Model</div>
							<div class="panel-body">
								<div id="info-chart" style="height:250px;">
									<svg></svg>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">Constraint Detail</div>
							<div class="panel-body">
								<div class="table-responsive">          
									<table class="table table-sm table-borderless">
										<tbody>
											<tr>
												<th class="col-md-4"><label>Consraint ID :</label></th>
												<td><?php echo $tfResult['constraint_id'];?></td>
											</tr>
											<tr>
												<th><label>Constraint Name :</label></th>
												<td><?php echo $tfResult['name'];?></td>
											</tr>
											<tr>
												<th><label>Course :</label></th>
												<td><?php echo $subResult['course_id']." ".$subResult['course_name'];?></td>
											</tr>
											<tr>
												<th><label>Total Form :</label></th>
												<td><?php echo $tfResult['total_form'];?></td>
											</tr>
											<tr>
												<th><label>Total Item :</label></th>
												<td><?php echo $tfResult['total_item'];?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">Test Detail</div>
							<div class="panel-body">
								<div class="table-responsive">          
									<table class="table table-sm table-borderless">
										<tbody>
											<tr>
												<th class="col-md-4"><label>Test ID :</label></th>
												<td><?php echo $tfResult['testform_id'];?></td>
											</tr>
											<tr>
												<th><label>Test Name :</label></th>
												<td><?php echo $tfResult['name'];?></td>
											</tr>
											<tr>
												<th><label>Discrimination Power :</label></th>
												<td id="tf-a">-</td>
											</tr>
											<tr>
												<th><label>Average Difficulty Level :</label></th>
												<td id="tf-b"></td>
											</tr>
											<tr>
												<th><label>time :</label></th>
												<td id="tf-time"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Item List</div>
							<div class="panel-body" style="height: 500px;">
								<div id="item-list"></div>
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
											<div class="panel-heading" align="center">Reference</div>
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
				<!-- End Main Contents -->
			</div>
		</div>
	</body>
</html>		