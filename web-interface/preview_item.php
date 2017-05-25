<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	$conn = connectDB();
	
	$strSQL = "SELECT * FROM user_account WHERE user_id='".$_SESSION['user_id']."'";
	$objQuery = mysqli_query($conn, $strSQL);
	$userResult = mysqli_fetch_array($objQuery);
	
	$isPre = false;
	if(isset($_POST['pre_item'])){
		$pre_item = $_POST['pre_item'];
		$isPre = true;
	}
?>

<html>
	<head>
		<title>Item Preview</title>
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
		
		<script type="text/x-mathjax-config">
			MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
		</script>
		<script type="text/javascript" src="assets/MathJax-master/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
		</script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				if(window.opener && !window.opener.closed) {
					document.write(window.opener.newpage);
				}
				
				$("#abc").click(function(){
					alert("<?php echo "Hello jQuery!"; ?>");
				});
				
				$("#exit").click(function(){
					window.close();
				});
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div align="left">Item Preview</div>
				</div>
				<div class="panel-body">
					<!-- Item Contents -->
					
					<?php
						if($isPre){
							if($pre_item['pic_link'] != NULL)
								echo '<div id="pic_link_item><img src="'.$pre_item['pic_link'].'"></div>';
							echo '<div id="ques_item">'.$pre_item['ques_text'].'</div>';
							
							$n_choice = sizeof($pre_item['n_choice']);
							for($j=0 ; $j<$n_choice ; $j++){
								echo '<input type="radio" name="choice_item'.$i.'" id="ans_item'.$i.'_'.$j.'">&emsp;'.$pre_item['choices'][j].'</input><br>';
							}
						}
						else{
							echo "Invalid Content";
						}
					?>
					
					<!-- /Item Contents -->
				</div>
				<!-- Paginate -->
				<div class="panel-footer" align="center">
					<button type="button" id="abc">test</button>
					<button id="exit" type="button" class="btn btn-primary">Close</button>
				</div>
				<!-- /Paginate -->
			</div>
		</div>
		<footer></footer>
	</body>
</html>	