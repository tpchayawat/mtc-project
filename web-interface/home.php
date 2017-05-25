<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>MTC Overview</title>
		<script src='chart.min.js'></script>
		<script src='legend.js'></script>
		<script src="assets/js/jquery-1.10.2.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		<script src="assets/js/custom-scripts.js"></script>
		
		<link rel="stylesheet" type="text/css" href="assets/css/demo.css">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/css/font-awesome.css" rel="stylesheet" />
		<!-- Custom Styles-->
		<link href="assets/css/custom-styles.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
					<a class="navbar-brand" href="index.html">MTC</a>
				</div>
				
				<ul class="nav navbar-top-links navbar-right">
					<!-- /.dropdown -->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
							<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
							</li>
							<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
							</li>
							<li class="divider"></li>
							<li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
							<a class="active-menu" href="home.php"><i class="fa fa-dashboard"></i> Home</a>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-sitemap"></i> Item Bank<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#">Summary</a>
								</li>
								<li>
									<a href="create_sub.php">Add Subject and Topic</a>
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
									<a href="#">Summary</a>
								</li>
								<li>
									<a href="#">Add Constraint</a>
								</li>
							</ul>
						</li>
						
						<li>
							<a href="#"><i class="fa fa-sitemap"></i> Result of Construction<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="#">Summary</a>
								</li>
								<li>
									<a href="#">Search</a>
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
								Dashboard <small>Summary of your App</small>
							</h1>
							<ol class="breadcrumb">
								<li class="active">Home</li>
							</ol>
						</div>
					</div>
					
					
					<!-- <footer><p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p></footer> -->
				</div>
				<!-- /. PAGE INNER  -->
			</div>
			<!-- /. PAGE WRAPPER  -->
		</div>
		
	</body>
</html>