<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		echo "Please Login!";
		echo "<p>You will be redirected in <span id='counter'>5</span> second(s).</p>
				<script type='text/javascript'>
					function countdown() {
						var i = document.getElementById('counter');
						if (parseInt(i.innerHTML)<=0) {
							location.href = 'login.php';
						}
						i.innerHTML = parseInt(i.innerHTML)-1;
					}
					setInterval(function(){ countdown(); },500);
				</script>";
		exit();
	}
	if($_SESSION['type'] > 1){
		echo "<p>This page for Admin only!<p>";
		echo "<p>You will be redirected in <span id='counter'>5</span> second(s).</p>
				<script type='text/javascript'>
					function countdown() {
						var i = document.getElementById('counter');
						if (parseInt(i.innerHTML)<=0) {
							window.history.back();
						}
						i.innerHTML = parseInt(i.innerHTML)-1;
					}
					setInterval(function(){ countdown(); },500);
				</script>";
		exit();
	}
?>