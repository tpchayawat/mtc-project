<!DOCTYPE html>

<?php
	session_start();
	if($_SESSION['user_id'] == ""){
		echo "Please Login!";
		header("Location: login.php");
		exit();
	}

	if($_SESSION['status'] != 1){
		echo "This page for user only!";
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
		<title>Test Exam Sheet - MTC E-Testing</title>
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
		
		<script type="text/x-mathjax-config">
			MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
		</script>
		<script type="text/javascript" src="assets/MathJax-master/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
		</script>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		
		<script src="assets/js/jquery.countdown.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				<?php
					$mysqli = connectDB();
					
					$sub_id = $_GET["sub_id"];
					$tf_id = $_GET["testform_id"];
					
					$itemset = [];
					//$questionQuery = mysqli_query($mysqli, "SELECT * FROM item WHERE subject_id='".$sub_id."' AND topic_id='".$topic_id."'");
					$questionQuery = mysqli_query($mysqli, "SELECT form.form_id, item.* FROM form JOIN item ON testform_id=".$tf_id." AND form.item_id=item.item_id ");
					while($questionResult = mysqli_fetch_array($questionQuery)){
						$items = [];
						$choices = [];
						array_push($items, $questionResult["question"]);	//item[0]
						//$item['question'] = $questionResult["question"];
						$chQuery = mysqli_query($mysqli, "SELECT * FROM choice WHERE item_id='".$questionResult["item_id"]."'");
						while($chResult = mysqli_fetch_array($chQuery)){
							$ch = [];
							array_push($ch, $chResult['choice_id']);
							array_push($ch, $chResult['content']);
							//$ch['cid'] = $chResult['choice_id'];
							//$ch['content'] = $chResult["content"];
							array_push($choices, $ch);
							//array_push($choices, $ansResult["content"]);
						}
						//$item['choices'] = $choices;
						array_push($items, $choices);	//item[1]
						array_push($items, $questionResult["item_id"]);	//item[2]
						array_push($itemset, $items);
					}
					
					$examQuery = mysqli_query($mysqli, "SELECT exam_no FROM log_answer WHERE user_id='".$userResult['user_id']."' AND testform_id='".$tf_id."' ORDER BY exam_no DESC LIMIT 1");
					$examResult = mysqli_fetch_array($examQuery);
					$exam_no = ($examResult!=NULL? ($examResult['exam_no']+1):1);
					
					$mysqli->close();
				?>
				
				var page = 0;
				var n = "<?php echo sizeof($itemset); ?>";
				$("#page").html((page+1)+"/"+n);

				var finalDate = new Date();
				finalDate.setMinutes(finalDate.getMinutes() + 5);	//set timer
				
				$('#exam-timer').countdown(finalDate)
				.on('update.countdown', function(event){
					$(this).html(event.strftime('%H:%M:%S'));
				})
				.on('finish.countdown', function(event){
					$(this).html("time out");
				});
				
				$("#nav").hide();
				$("#prevtab").hide();
				$("#check_score").hide();
				
				var start_time = new Date();
				//alert("start_time: "+start_time);
				
				$("#nexttab").click(function(){
					var item = ($('.nav-tabs > .active').find('a').attr('href')).substring(1);
					var ch_form = 'chform_'+item;
					var ans = $('input:radio[name="choice_'+item+'"]:checked', '#'+ch_form).val();
					
					var ansset = {
						user_id : <?php echo $userResult['user_id'];?>,
						tf_id : <?php echo $tf_id; ?>,
						exam_no : <?php echo $exam_no;?>,
						item_id : $('.tab-content > .active').val(),
						textans : ans,
						//s_time : start_time.getTime()/1000
						s_time : start_time
					};
					$.post("logans_query.php", {logans:ansset}, function(result){
						if(page<n-1){
							if(page == n-2){
								$('#next a').html('Submit Exam');
							}
							start_time = new Date(result*1000);
							page++;
							$('.nav-tabs > .active').next('li').find('a').trigger('click');
							$("#page").html((page+1)+"/"+n);
						}
						else{
							alert("Finish");
							$("#page").hide();
							$("#next").hide();
							$("#check_score").show();
						}
					});
				});
				
				$("#prevtab").click(function(){
					$('.nav-tabs > .active').prev('li').find('a').trigger('click');
				});
				
				$("#check_score").click(function(){
					checkset = {
						user_id : <?php echo $userResult['user_id'];?>,
						tf_id : <?php echo $tf_id;?>,
						exam_no : <?php echo $exam_no;?>
					};
					$.post("logans_query.php", {check_score:checkset}, function(result){
						alert("Your score is "+result+"/"+n);
						window.close();
					});
				});
				
				$("#abc").click(function(){
					checkset = {user_id : <?php echo $userResult['user_id'];?>};
					$.post("logans_query.php", {check_score:checkset}, function(result){
						alert("Your score is "+result+"/"+n);
						window.close();
					});
				});
				
				/*$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});*/
				
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div align="left">Test Exam Sheet</div>
				</div>
				<div class="panel-body">
					<!-- Item Contents -->
					<div align="right">Exam time left : <span id="exam-timer"></span></div>
					<div class="tabbable">
						<ul id="nav" class="nav nav-tabs">
							<?php
								$n_item = sizeof($itemset);
								
								for($i=0 ; $i<$n_item ; $i++){
									if($i==0){
										echo '<li class="active"><a href="#item'.$i.'" data-toggle="tab"></a></li>';
									}
									else{
										echo '<li><a href="#item'.$i.'" data-toggle="tab"></a></li>';
									}
								}
							?>
						</ul>
						<ul class="tab-content">
							<?php
								//echo sizeof($itembank);	//5
								//echo sizeof($itembank[0][1]);	//4
								
								for($i=0 ; $i<$n_item ; $i++){
									if($i==0){
										echo '<li id="item'.$i.'" class="tab-pane fade in active" value="'.$itemset[$i][2].'">';
									}
									else{
										echo '<li id="item'.$i.'" class="tab-pane fade" value="'.$itemset[$i][2].'">';
									}
									echo '<div id="pic_link_item'.$i.'"></div>';
									echo '<div id="ques_item'.$i.'">'.$itemset[$i][0].'</div>';
									
									$n_choice = sizeof($itemset[$i][1]);
									echo '<form id="chform_item'.$i.'">';
									for($j=0 ; $j<$n_choice ; $j++){
										echo '<input type="radio" name="choice_item'.$i.'" id="ans_item'.$i.'_'.$j.'" value="'.$itemset[$i][1][$j][0].'">&emsp;'.$itemset[$i][1][$j][1].'</input><br>';
									}
									echo '</form>';
									echo '</li>';
								}
							?>
						</ul>
					</div>
						<!-- /Item Contents -->
				</div>
				<!-- Paginate -->
				<div class="panel-footer">
					<!-- <button type="button" id="abc">test</button> -->
					<ul class="pager">
						<li class="previous"><a id="prevtab" href="#">Previous</a></li>
						<li id="check_score" class="btn btn-primary" align="center">Check Score</li>
						<li id="page" align="center"></li>
						<li id="next" class="next"><a id="nexttab" href="#">Next</a></li>
					</ul>
				</div>
				<!-- /Paginate -->
			</div>
		</div>
		<footer></footer>
	</body>
</html>	