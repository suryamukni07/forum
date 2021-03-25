<?php
$mysql_host = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_db = "db_forum";
$con=mysql_connect($mysql_host, $mysql_user, $mysql_password)or die("Error Connecting to MYSql Server:".mysql_error());  
mysql_select_db($mysql_db)or die("Error Selecting MYSql Database:".mysql_error());  

?>