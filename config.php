<?php
	$hostname="localhost"; // Имя хоста
	$login=""; // Логин для подкл. к серверу баз даных 
	$pwd=""; // Пароль для подкл. к серверу баз даных
	$db_name="a0626401_killer";  // Название базы даных
	//подключение к базе
	$con = @mysql_connect($hostname, $login, $pwd) or die("Error! connect-database");
	mysql_select_db($db_name, $con) or die ("Error! select-database");
	mysql_query("set character_set_client='utf8'");
	mysql_query("set character_set_results='utf8'");
	mysql_query("set collation_connection='utf8_general_ci'");
?>