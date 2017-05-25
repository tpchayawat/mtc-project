<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<link href="assets/css/mtc-newstyle.css" rel="stylesheet" />
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
										<li><a href="itembank_new.php">Overview</a></li>
										
										<!-- Topic Dropdown level 2 -->
										<li class="panel panel-default" id="dropdown">
											<a data-toggle="collapse" href="#topic-dropdown">
												<span class="glyphicon glyphicon-th-list"></span> Topic <span class="caret"></span>
											</a>
											<div id="topic-dropdown" class="panel-collapse collapse">
												<div class="panel-body">
													<ul class="nav navbar-nav">
														<li><a href="create_topic_new.php">Create</a></li>
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
														<li><a href="create_item_new.php">Create</a></li>
														<li><a href="import_item.php">Import</a></li>
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
										<li><a href="testform_new.php">Overview</a></li>
										
										<!-- Create Test Form Dropdown level 2 -->
										<li class="panel panel-default" id="dropdown">
											<a data-toggle="collapse" href="#create-form-dropdown">
												<span class="glyphicon glyphicon-edit"></span> Create Form <span class="caret"></span>
											</a>
											<div id="create-form-dropdown" class="panel-collapse collapse">
												<div class="panel-body">
													<ul class="nav navbar-nav">
														<li><a href="constr_man_new.php">Manual</a></li>
														<li><a href="constr_auto.php">Automatic</a></li>
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
										<li><a href="#">Student Exam Result</a></li>
										<!--<li><a href="admin_sublist.php">Student Exam Result</a></li>-->
									</ul>
								</div>
							</div>
						</li>
						
						<?php 
							if($_SESSION['type'] == 0){
								echo '
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
																<li><a href="admin_edituser.php">Edit User</a></li>
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
																<li><a href="admin_addcourse.php">Create Course</a></li>
																<li><a href="admin_assign-course.php">Assign Course</a></li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>
								<!-- END Admin -->
								';
							}
						?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>
	</div>
</body>
</html>				