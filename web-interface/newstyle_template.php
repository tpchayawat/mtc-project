<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<title>Admin Home - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<!-- Bootstrap Styles-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FontAwesome Styles-->
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<!-- Google Fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		<!-- Bootstrap-Select Styles -->
		<link href="assets/css/bootstrap-select.min.css" rel="stylesheet" />
		<!-- MTC New Styles -->
		<link href="assets/css/mtc-newstyle.css" rel="stylesheet" />
		<!-- Black Ribbon -->
		<link href="assets/css/black-ribbon.css" rel="stylesheet" />
		
		<script type="text/javascript">
			$(function () {
				$('.navbar-toggle').click(function () {
					$('.navbar-nav').toggleClass('slide-in');
					$('.side-body').toggleClass('body-slide-in');
					$('#search').removeClass('in').addClass('collapse').slideUp(200);
					
					/// uncomment code for absolute positioning tweek see top comment in css
					$('.absolute-wrapper').toggleClass('slide-in');
					
				});
				
				// Remove menu for searching
				$('#search-trigger').click(function () {
					$('.navbar-nav').removeClass('slide-in');
					$('.side-body').removeClass('body-slide-in');
					
					/// uncomment code for absolute positioning tweek see top comment in css
					$('.absolute-wrapper').removeClass('slide-in');
					
				});
			});
		</script>
	</head>
	
	<body>
		<img src="assets/img/black_ribbon_bottom_left.png" class="black-ribbon stick-bottom stick-left"/>
		<div id="navigation">
			<div id="nav-header">
				<nav class="navbar navbar-inverse" style="margin-bottom:0px;border-radius:0px;">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="admin_home_new.php">MTC - System</a>
						</div>
						<ul class="nav navbar-nav navbar-right">
							<li>
								<p class = "navbar-text">Signed in as 
									<a href="#" class="navbar-link">Admin</a>
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
			
			<!-- uncomment code for absolute positioning tweek see top comment in css -->
			<div class="absolute-wrapper"> </div>
			<!-- Menu -->
			<div class="side-menu">
				<nav class="navbar navbar-default" role="navigation">
					
					<!-- Main Menu -->
					<div class="side-menu-container">
						<ul class="nav navbar-nav">
							
							<li><a href="admin_home_new.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
							
							<!-- Item Bank Dropdown-->
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#itembank-dropdown">
									<span class="glyphicon glyphicon-duplicate"></span> Item Bank <span class="caret"></span>
								</a>
								
								<!-- Item Bank level 1 -->
								<div id="itembank-dropdown" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="itembank.php">Overview</a></li>
											
											<!-- Topic Dropdown level 2 -->
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#topic-dropdown">
													<span class="glyphicon glyphicon-th-list"></span> Topic <span class="caret"></span>
												</a>
												<div id="topic-dropdown" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="create_topic.php">Create</a></li>
															<li><a href="#">Edit</a></li>
														</ul>
													</div>
												</div>
											</li>
											
											<!-- Item Dropdown level 2 -->
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#item-dropdown">
													<span class="glyphicon glyphicon-list-alt"></span> Item <span class="caret"></span>
												</a>
												<div id="item-dropdown" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="create_item.php">Create</a></li>
															<li><a href="#">Edit</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</li>
							
							<!-- Test Forms Dropdown-->
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#testform-dropdown">
									<span class="glyphicon glyphicon-file"></span> Test Form <span class="caret"></span>
								</a>
								
								<!-- Test Forms level 1 -->
								<div id="testform-dropdown" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="testform.php">Overview</a></li>
											
											<!-- Create Test Form Dropdown level 2 -->
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#create-form-dropdown">
													<span class="glyphicon glyphicon-edit"></span> Create Form <span class="caret"></span>
												</a>
												<div id="create-form-dropdown" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="constr_man.php">Manual</a></li>
															<li><a href="#">Automatic</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</li>
							
							<!-- Test Forms Dropdown-->
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#exam-dropdown">
									<span class="glyphicon glyphicon-education"></span> Examination <span class="caret"></span>
								</a>
								
								<!-- Exam level 1 -->
								<div id="exam-dropdown" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="#">Overview</a></li>
											<li><a href="admin_sublist.php">Student Exam Result</a></li>
										</ul>
									</div>
								</div>
							</li>
							
							<!-- Admin Dropdown-->
							<li class="panel panel-default" id="dropdown">
								<a data-toggle="collapse" href="#admin-dropdown">
									<span class="glyphicon glyphicon-user"></span> Admin <span class="caret"></span>
								</a>
								
								<!-- Admin level 1 -->
								<div id="admin-dropdown" class="panel-collapse collapse">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="#">Overview</a></li>
											
											<!-- Manage User Dropdown level 2 -->
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#admin-user-dropdown">
													<span class="glyphicon glyphicon-user"></span> Manage User <span class="caret"></span>
												</a>
												<div id="admin-user-dropdown" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="admin_adduser.php">Add User</a></li>
															<li><a href="#">Edit User</a></li>
															<li><a href="#">Remove User</a></li>
														</ul>
													</div>
												</div>
											</li>
											
											<!-- Course Dropdown level 2 -->
											<li class="panel panel-default" id="dropdown">
												<a data-toggle="collapse" href="#admin-course-dropdown">
													<span class="glyphicon glyphicon-list"></span> Manage Course <span class="caret"></span>
												</a>
												<div id="admin-course-dropdown" class="panel-collapse collapse">
													<div class="panel-body">
														<ul class="nav navbar-nav">
															<li><a href="#">Create Course</a></li>
															<li><a href="#">Assign Course</a></li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</nav>
			</div>
		</div>
		<!-- Main Content -->
		<div class="container-fluid">
			<div class="side-body">
				<h1> Main Content here </h1>
				<pre> Resize the screen to view the left slide menu </pre>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
				<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
			</div>
		</div>
	</body>
</html >