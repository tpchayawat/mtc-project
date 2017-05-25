<?php
	mysql_connect("localhost", "root", "toptop") or die("Connection fail!");
	mysql_select_db("mtc_project") or die("can't choose DB");
	//echo "Connection success!</br>";
	mysql_query("SET NAMES utf8");
?>