<!DOCTYPE html>
<html>
<head>
<title>Тасовка</title>
<meta charset="utf-8">
</head>

<body  bgcolor="#000000" text="#f00">
<?php
include("../config.php");
$count = mysql_query("select count(*) from `killer`", $con) or die ("Error! query – не подсчитано кол-во строк в БД"); 
$count_ar = mysql_fetch_array($count, MYSQL_NUM);
$old_id = mysql_query("select `id` from `killer`"  , $con) or die ("Error! query – список id с удаленными участниками");

/*здесь назначаем id по порядку, чтобы не было пробелов, где участники были удалены*/
$count_gamers=0;
while ($old_id_ar= mysql_fetch_row($old_id, MYSQL_NUM)) {
	$count_gamers=$count_gamers+1;
	mysql_query("UPDATE `killer` SET `id` = '$count_gamers' WHERE `id` = '$old_id_ar[0]'", $con) or die ("Error! query – ошибка при назначении упорядоченных id!");
	//echo "$i $old_id_ar[0] <br>";
}


$victims_list = mysql_query("select `victim` from `killer`", $con) or die ("Error! query – ошибка в $victims_list");
$vic_list_ar= mysql_fetch_row($victims_list, MYSQL_NUM);

for ($i=1; $i <= $count_gamers; $i++) {        //по порядку для каждого i-го участника из таблицы 
	if ($i!=$count_gamers)                     // кроме последнего
		{
		$j=$i+1;
		$r = rand($j, $count_gamers); //берем рандомную жертву в таблице ниже i-го участника
			while (array_search('$r', $vic_list_ar) == TRUE) {
				$r = rand($j, $count_gamers); //если такая жертва уже есть, делаем рандом снова
			};

		}
	else {$j=1;$r=1;} 
	//mysql_query("update `killer` set `victim` = '$r' where `id` = '$i'", $con) or die ("Error! query – ошибка при назначении жертвы");
	//упорядочивание киллер над жертвов
		mysql_query("UPDATE `killer` SET `id` = 'bufer' WHERE `id` = '$j'", $con) or die ("Error! query – ошибка при упорядочивании киллер-жертва 1");
		mysql_query("UPDATE `killer` SET `id` = '$j' WHERE `id` = '$r'", $con) or die ("Error! query – ошибка при упорядочивании киллер-жертва 2");
		mysql_query("UPDATE `killer` SET `id` = '$r' WHERE `id` = 'bufer'", $con) or die ("Error! query – ошибка при упорядочивании киллер-жертва 3");
		mysql_query("update `killer` set `victim` = '$j' where `id` = '$i'", $con) or die ("Error! query – ошибка при назначении жертвы");
	$victims_list = mysql_query("select `victim` from `killer`", $con) or die ("Error! query – ошибка в $victims_list");
	$vic_list_ar= mysql_fetch_row($victims_list, MYSQL_NUM);
}



?>
</body>
</html>