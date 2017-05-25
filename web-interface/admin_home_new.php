<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
	
	if($_SESSION['type'] == 0){
		$newURL = "itembank_new.php";
		header('Location: '.$newURL);
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Admin Home - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				//alert(<?php echo $_SESSION['courses'];?>);
				alert("test");
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
							Welcome to MTC System <small>Home</small>
						</h1>
						<ol class="breadcrumb">
							<li class="active"><a href="admin_home_new.php">Home</a></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>