<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $page_title; ?></title>
		<meta http-equiv="description" content="<?php echo $page_description; ?>" />
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

		<!-- Bootstrap-Select Styles -->
		<link href="assets/css/bootstrap-select.min.css" rel="stylesheet" />
		<!-- Black Ribbon for DAD -->
		<link href="assets/css/black-ribbon.css" rel="stylesheet" />
	</head>
	<body>
		<div id="nav-header">
			<nav class="navbar navbar-inverse" style="margin-bottom:0px;border-radius:0px;">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="admin_home_new.php">MTC - System</a>
					</div>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<p class = "navbar-text">Signed in as 
								<a href="#" class="navbar-link"><?php echo $_SESSION['fname'];?></a>
							</p>
						</li>
						<li class = "dropdown">
							<a href = "#" class = "dropdown-toggle" data-toggle = "dropdown"><span class="glyphicon glyphicon-user"></span> Account <b class = "caret"></b></a>
							<ul class = "dropdown-menu">
								<li><a href = "#">User Profile</a></li>
								<li><a href = "#">Setting</a></li>
								<li class = "divider"></li>
								<li><a href = "logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</body>
</html>				