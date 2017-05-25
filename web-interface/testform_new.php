<!DOCTYPE html>
<?php
	require('include/authen_session.php');
	include('include/connect_db.php');
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Testforms - MTC E-Testing</title>
		
		<script src="assets/js/jquery-2.1.4.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-select.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
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
							Test Forms <small>Overview</small>
						</h1>
						<ol class="breadcrumb">
							<li><a href="admin_home_new.php">Home</a></li>
							<li><a href="testform_new.php">Test Forms</a></li>
							<li class="active">Overview</li>
						</ol>
					</div>
				</div>
				
				<!-- Main Contents -->
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion">
							<?php
								$conn = connectDB();
								
								// outter subjects accordion
								$subSQL = "SELECT sub.* FROM subject sub,user_account user WHERE sub.user_create=user.user_id AND user.user_id=".$_SESSION['user_id'];
								$subQuery = mysqli_query($conn, $subSQL);
								$c_sub = 1;
								$i = 1;
								while($subObj=mysqli_fetch_array($subQuery)){
									echo '<div class="panel panel-default">
									<div class="panel-heading">
									<h4 class="panel-title" style="display:inline;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">'.$subObj['course_id'].' - '.$subObj['course_name'].'</a>
									</h4>
									&nbsp;&nbsp;
									<a href="sub_edit.php?sid='.$subObj['subject_id'].'" style="font-weight:normal;">Edit</a>
									</div>
									<div id="collapse'.$i++.'" class="panel-collapse collapse in">
									<div class="panel-body">';
									
									echo '<div class="row"><div class="col-md-6">';
									echo '<b>Course ID : </b>'.$subObj['course_id'].'<br>';
									echo '<b>Course Name : </b>'.$subObj['course_name'].'<br>';
									echo '<b>Definition : </b>'.$subObj['definition'].'<br><br>';
									/*echo '</div><div class="col-md-6">';
										echo '<div class="panel panel-default">
										<div class="panel-body" id="sub-chart-'.$subObj['subject_id'].'">
										<svg></svg>
										</div>
									</div>';*/
									echo '</div></div>';
									
									/*echo '<div class="row"><div class="col-md-12">
										<div class="panel panel-default">
										<div class="panel-heading">Constraint List</div>
									<div class="panel-body">';*/
									echo '<div class="row"><div class="col-md-12">
									<label>Constraint List</label>';
									
									// inner testforms accordion
									$constrSQL = "SELECT * FROM `constraint` con,`testform` tf WHERE con.subject_id=".$subObj['subject_id'].
									" AND con.constraint_id=tf.constraint_id AND con.user_create=".$_SESSION['user_id'];
									$constrQuery = mysqli_query($conn, $constrSQL);
									$j = 1;
									echo '<div class="row">
									<div class="col-md-12">
									<div class="panel-group" id="accordion'.$c_sub.'">';
									while($constrObj=mysqli_fetch_array($constrQuery)){
										echo '<div class="panel panel-default">
										<div class="panel-heading">
										<h4 class="panel-title" style="display:inline;">
										<a data-toggle="collapse" data-parent="#accordion'.$c_sub.'" href="#collapse-'.$constrObj['constraint_id'].'-'.$j.'">'.$constrObj['name'].'</a>
										</h4>
										&nbsp;&nbsp;
										</div>
										<div id="collapse-'.$constrObj['constraint_id'].'-'.$j++.'" class="panel-collapse collapse">
										<div class="panel-body">';
										
										echo '<div class="row"><div class="col-md-6">';
										echo '<b>Constraint ID : </b>'.$constrObj['constraint_id'].'<br>';
										echo '<b>Name : </b>'.$constrObj['name'].'<br>';
										echo '<b>Note : </b>'.$constrObj['note'].'<br>';
										echo '<b>Created Time : </b>'.$constrObj['time'].'<br><br>';
										echo '</div></div>';
										
										// inner table
										echo '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">';
										echo '<label for="testform-sub'.$j.'">Test List</label>';
										echo '<table id="testform-sub'.$j.'" class="table table-striped table-bordered table-hover" role="grid">
										<thead>
										<tr>
										<th class="col-md-1 text-center">#</th>
										<th class="text-center">Test Name</th>
										<th class="col-md-1 text-center">Discrimination<br>Power</th>
										<th class="col-md-1 text-center">Difficulty<br>Level</th>
										<th class="col-md-1 text-center">Time<br>(Minutes)</th>
										<th class="col-md-1 text-center">Export<br>DOCX</th>
										<th class="col-md-1 text-center">Export<br>PDF</th>
										</tr>
										</thead>
										<tbody>';
										// forms query
										$tfSQL = "SELECT * FROM testform tf WHERE constraint_id=".$constrObj['constraint_id'];
										$tfQuery = mysqli_query($conn, $tfSQL);
										while($tfResult = mysqli_fetch_array($tfQuery)){
											echo "<tr><th class='text-center'>".$tfResult['testform_id']."</th>";
											echo "<td><a href='atest_new.php?tf_id=".$tfResult['testform_id']."'>".$tfResult['name']."</a></td>";
											echo "<td class='text-center'> - </td>";
											echo "<td class='text-center'> - </td>";
											echo "<td class='text-center'> - </td>";
											echo "<td class='text-center'><a href='export_docx.php?tf_id=".$tfResult['testform_id']."'><i class='fa fa-file-word-o' aria-hidden='true'></i></a></td>";
											echo "<td class='text-center'><a href='exportPDF_test.php?tf_id=".$tfResult['testform_id']."'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></td></tr>";
										}
										echo '</tbody></table></div></div>';
										// end inner table
										
										echo '</div></div></div>';
									}
									echo '</div></div></div>';
									// end inner testforms accordion
									echo '</div></div>';
									//echo '</div></div></div></div>';
									
									echo '</div></div>';
									echo '</div><br>';
									$c_sub++;
								}
								// end outter subjects accordion
								$conn->close();
							?>
						</div>
					</div>
				</div>
				<!-- End Main Contents-->
			</div>
		</div>
	</body>
</html>		