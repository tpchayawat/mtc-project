<!DOCTYPE html>
<html>
	<head>
		<title>Test Exam Sheet</title>
		<meta charset="utf-8"></meta>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/css/font-awesome.css" rel="stylesheet" />
		<!-- Custom Styles-->
		<link href="assets/css/custom-styles.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});
				
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
					
					$sub_id = 5;
					$topic_id = 1;
					
					$itembank = [];
					$questionQuery = mysqli_query($mysqli, "SELECT * FROM item WHERE subject_id='".$sub_id."' AND topic_id='".$topic_id."'");
					while($questionResult = mysqli_fetch_array($questionQuery)){
						$item = [];
						$ans = [];
						array_push($item, $questionResult["question"]);
						$ansQuery = mysqli_query($mysqli, "SELECT answer FROM choice WHERE item_id='".$questionResult["item_id"]."'");
						while($ansResult = mysqli_fetch_array($ansQuery)){
							array_push($ans, $ansResult["answer"]);
						}
						array_push($item, $ans);
						array_push($itembank, $item);
					}
				?>
				
				$("#dataTables-example_paginate").click(function(){
					
				});
				
				$("#ques_item").html("<?php echo $itembank[0][0]; ?>");
				$("#ans_item").html("<?php echo $itembank[0][1][0]; ?>");
				
				$("#ques_item2").html("<?php echo $itembank[1][0]; ?>");
				$("#ans_ite2").html("<?php echo $itembank[1][1][0]; ?>");
				
				<?php
					$mysqli->close();
				?>
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					Test Exam Sheet
				</div>
				<div class="panel-body">
					<!-- Item Contents -->
					<div class="tab-content">
						<div id="item1" class="tab-pane fade in active">
							<!-- Question -->
							<div id="ques_item">
							</div>
							<!-- /Question -->
							
							<!-- Pic -->
							<div id="pic_link_item">
							</div>
							<!-- /Pic -->
							
							<!-- Answers -->
							<div id="ans_item">
							</div>
							<!-- /Answers -->
						</div>
						
						<div id="item2" class="tab-pane fade">
							<!-- Question -->
							<div id="ques_item2">
							</div>
							<!-- /Question -->
							
							<!-- Pic -->
							<div id="pic_link_item2">
							</div>
							<!-- /Pic -->
							
							<!-- Answers -->
							<div id="ans_item2">
							</div>
							<!-- /Answers -->
						</div>
					</div>
					
					<!-- /Item Contents -->
				</div>
				<!-- Paginate -->
				<div class="panel-footer">
					<button type="button" id="abc">test</button>
					<ul class="pager">
					  <li class="previous"><a data-toggle="tab" href="#item1">Previous</a></li>
					  <li class="next"><a data-toggle="tab" href="#item2">Next</a></li>
					</ul>
				</div>
					<!-- /Paginate -->
			</div>
		</div>
		<footer></footer>
	</body>
</html>	