<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>MTC System Login</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery.metisMenu.js"></script>
		<script src="assets/js/custom-scripts.js"></script>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	</head>
	
	<body>
		<div id="wrapper">
			<nav class="navbar navbar-inverse" style="margin-bottom:0px;border-radius:0px;">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="admin_home_new.php">MTC - System</a>
					</div>
				</div>
			</nav>
			
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<br><br><br><br><br>
					<div class="panel panel-default" align="center">
						<div class="panel-heading panel-inverse">
							Login
						</div>
						<div class="panel-body">
							<form method="post" action="include/authen_login.php">
								<div>
									<label>Username</label><br>
									<input name="username" type="text" placeholder="Username" size="30">
								</div>
								<div>
									<label>Password</label><br>
									<input name="password" type="password" placeholder="Enter Password" size="30">
								</div><br>
								<input class="btn btn-default" type="submit" name="Submit" value="Login">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>