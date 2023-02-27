<?php
include "event_settings.php";
$file = "logs.txt";
include("config.php");
$today = date("Y-m-d H:i:s");
//$today = "2016-09-28 15:05:00";

$res = mysql_query("select * from `killer` where `date` < '$today' and `status`<>0", $con) or die ("Error! нет истекшего времени");
while($arr = mysql_fetch_array($res, MYSQL_NUM)) {
	$id = $arr[0];
	file_put_contents($file, "$today  Пидор с ID = $id выкинут из игры за бездействие!\n", FILE_APPEND | LOCK_EX);
//	echo "$today  Пидор с ID = $id выкинут из игры за бездействие!<br>";
	mysql_query("update `killer` set `status` = '0' where `id` = '$id'", $con) or die ("Error! query – статус не обновился");
	$q = mysql_query("select * from `killer` where `victim` = '$id'", $con) or die ("Error! query – получаю строку юзера");	
	$my_killer = mysql_fetch_array($q, MYSQL_NUM);
	mysql_query("update `killer` set `victim` = '0' where `id` = '$my_killer[0]'", $con) or die ("Error! query – статус не обновился");
}


$str_interval = "interval ".$DAY_FOR_KILL." day";

$id_killers = array();
$id_victims = array();

$res = mysql_query("select * from `killer` where `status`= '1' and  `victim`='0' order by `id` ", $con) or die ("Error! нет истекшего времени");
while($arr = mysql_fetch_array($res, MYSQL_NUM)) {
	$id = $arr[0];
	array_push($id_killers, $id);
}

$q = mysql_query("select `id`,`victim` from `killer` where `status`= '0' and  `victim` <> '0' order by `id`", $con) or die ("Error! query – статус не обновился");
	while($next_victim = mysql_fetch_array($q, MYSQL_NUM)) {
		array_push($id_victims, $next_victim[1]);
	}

//echo "киллеры<br>";
//print_r($id_killers);
//echo "<br><br>жертвы<br>";
//print_r($id_victims);

if (count($id_killers)>0){
	if ((count($id_killers)==count($id_victims)) && (count($id_killers)==1) && ($id_killers[0]> $id_victims[0])) { 
	} else 
	{	
	while( $id_killers[0]>= $id_victims[0]){
		array_push($id_victims, array_shift($id_victims));
	}
	}
//echo "я тут<br>";
for($i=0; $i < count($id_killers); $i++){
	$killer = $id_killers[$i];
	$vic = $id_victims[$i];
//	echo "$killer --> $vic <br>";
	
	$end_game_sec = strtotime($END_GAME_DAY);
	$date_next_kill = strtotime(date("Y-m-d H:i:s")) + $DAY_FOR_KILL*86400;
		
	if($date_next_kill < $end_game_sec){
		//сегодня+дней на убийство меньше чем конец игры
		$str_interval = "interval ".$DAY_FOR_KILL." day";
		mysql_query("update `killer` set  `victim` = '$vic',`date`=date_add('$today',$str_interval)  where `id` = '$killer'", $con) or die ("Error! query – ставлю себе новую дату 1");
	} else {
		mysql_query("update `killer` set `victim` = '$vic',`date`='$END_GAME_DAY'  where `id` = '$killer'", $con) or die ("Error! query – статус не обновился");
	}
	
	
//	mysql_query("update `killer` set `victim` = '$vic',`date`=date_add('$today',$str_interval)  where `id` = '$killer'", $con) or die ("Error! query – статус не обновился");
	file_put_contents($file, "$today  Киллеру с ID = $killer получил в заказ на ID = $vic!\n", FILE_APPEND | LOCK_EX);
	mysql_query("update `killer` set `victim` = '0' where  `victim`<>0 and status = 0", $con) or die ("Error! query – статус не обновился");
}

}
//print_r($id_victims); 

?>