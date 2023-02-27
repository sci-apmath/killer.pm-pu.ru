<!DOCTYPE html>
<html>
<head>
<title>Выгрузка участников</title>
<meta charset="utf-8">
</head>
<body>
<?php
	include("config.php");
	$file = "db.txt";
	$resc = mysql_query("select `name`, `year` from `killer` where `visits` <> 0 order by `name`", $con) or die ("Error! query – не выбрал участников");
	while ($my_killer_str = mysql_fetch_array($resc, MYSQL_NUM)) {
		file_put_contents($file, "$my_killer_str[0] $my_killer_str[1] курс \n", FILE_APPEND | LOCK_EX);
		echo "$my_killer_str[0] $my_killer_str[1] курс <br>";
	}
	$r = mysql_query("select count(*) from `killer` where `visits`<> 0", $con) or die ("Error! query – не нашел количество");
	$killers = mysql_fetch_array($r, MYSQL_NUM);
	echo "<br>Всего участников $killers[0]";	
?>
</body>
</html>