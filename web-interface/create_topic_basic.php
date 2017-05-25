<!DOCTYPE html>
<html>
	<head>
		<script src="assets/js/jquery-2.1.4.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$("#test").click(function(){
					alert("test");
				});
				
				$("#add_t").click(function(){
					var dataset = {
						sub_id : $("#sub_id").val(),
						tname : $("#tname").val(),
						tdef : $("#tdef").val(),
						user : 1 //manual
					};
					$.post("constr_query.php", {add_topic:dataset}, function(result){
						alert(result);
					});
					alert("Success! Topic has been added");
				});
			});
		</script>
		
	</head>
	<body>
		<div>
			<form>
				<label>Subject</label>
				<div>
					<select id="sub_id" name="sub_id">
						<option>-- Select Subject --</option>
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
							
							$objQuery = mysqli_query($mysqli, "SELECT * FROM subject");
							while($objResult = mysqli_fetch_array($objQuery)){
						?>
								<option value="<?php echo $objResult["subject_id"];?>"><?php echo $objResult["course_name"];?></option>
						<?php
							}
							$mysqli->close();
						?>
					</select>
				</div>
				<label>Topic Name</label>
				<div>
					<input id="tname" name="t_name" type="text">
				</div>
				<label>Definition</label>
				<div>
					<textarea id="tdef" name="t_def" rows="3"></textarea>
				</div><br>
				<input id="add_t" type="button" name="submit" value="Add Topic">
				&nbsp;&nbsp;&nbsp;
				<input type="reset" name="reset" value="Reset"></button>
			</form>
		</div>
		<div>
			<button type="button" id="test">test</button>
		</div>
	</body>
</html>