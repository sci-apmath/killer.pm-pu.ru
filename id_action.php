<?php
if (!isset($_SESSION['user_id']))
	require "authorization.php";

include("config.php");
include("event_settings.php");
$user_id =  $_SESSION['user_id'];
$file = "logs.txt";
$victim_pass_q = mysql_real_escape_string(htmlspecialchars($_POST['id']));
$today = date("Y-m-d H:i:s");	

//echo "input <br> user_id = $user_id  input_id = $victim_pass ";

//дата окончания игры



$res = mysql_query("select * from `killer` where `id`='$user_id'", $con) or die ("Error! query – получаем ID жертвы и количество попыток");
$arr = mysql_fetch_assoc($res);
	$victim_id = $arr['victim'];
	$my_count = $arr['count_attempts'];
	
//	echo "base  <br> 	victim_id = $victim_id";
	
if ($my_count < 3){
	$res1 = mysql_query("select * from `killer` where `id`='$victim_id'", $con) or die ("Error! query – получаем информацию о жертве");
	$arr1 =  mysql_fetch_assoc($res1);
	$victim_pass_db = $arr1['uid'];
	$victim_victim = $arr1['victim'];
//	echo "$victim_victim";
	if ($victim_pass_q==$victim_pass_db){
		//убил
		mysql_query("update `killer` set `status` = '0', `victim` = '0' where `id` = '$victim_id'", $con) or die ("Error! query – ставлю статус = 0 и жертва = 0");
		file_put_contents($file, "$today  Киллера с ID = $user_id убил киллера с ID = $victim_id!  Он ввёл $victim_pass_q.\n", FILE_APPEND | LOCK_EX);
		
		$end_game_sec = strtotime($END_GAME_DAY);
		$date_next_kill = strtotime(date("Y-m-d H:i:s")) + $DAY_FOR_KILL*86400;
		
		if($date_next_kill < $end_game_sec){
			//сегодня+дней на убийство меньше чем конец игры
			$str_interval = "interval ".$DAY_FOR_KILL." day";
			mysql_query("update `killer` set `count_kill` = `killer`.`count_kill`+1, `date`=date_add('$today',$str_interval)  where `id` = '$user_id'", $con) or die ("Error! query – ставлю себе новую дату 1");
		} else {
			mysql_query("update `killer` set `count_kill` = `killer`.`count_kill`+1, `date`='$END_GAME_DAY'  where `id` = '$user_id'", $con) or die ("Error! query – ставлю датой конец игры");
		}
		
		file_put_contents($file, "$today  Киллер с ID = $user_id получил заказ на киллера с ID = $victim_victim!\n", FILE_APPEND | LOCK_EX);
		if ($victim_victim == $user_id) {
			mysql_query("update `killer` set `status` = '2' where `id` = '$user_id'", $con) or die ("Error! query – статус победителя");
			file_put_contents($file, "$today  Киллера с ID = $user_id ПОБЕДИЛ!\n", FILE_APPEND | LOCK_EX);
		} else {
			mysql_query("update `killer` set `victim` = '$victim_victim', `count_attempts`='0' where `id` = '$user_id'", $con) or die ("Error! query – обнуляю попытки и ставлю себе жертву новую");
		}
	} else {
		//не убил
		$k = $my_count+1;
		mysql_query("update `killer` set `count_attempts` = '$k' where `id` = '$user_id'", $con) or die ("Error! query – статус не обновился");
		file_put_contents($file, "$today  Долбоёб с ID = $user_id попытался подобрать ID! Он ввёл $victim_pass_q. Это его $k попытка!\n", FILE_APPEND | LOCK_EX);
	}	
} else {
	//слишком много попыток
	mysql_query("update `killer` set `status` = '0', `victim` = '0' where `id` = '$user_id'", $con) or die ("Error! query – меня убиваем, мне ставим жертвой ноль");
	$resc = mysql_query("select `id` from `killer` where `victim` = '$user_id'", $con) or die ("Error! query – получаю строку юзера");	
	$my_killer_str = mysql_fetch_assoc($resc);
	$id_my_killer = $my_killer_str['id'];
	
	file_put_contents($file, "$today  Долбоёб с ID = $user_id попытался подобрать ID больше трёх раз! За это был послан нахуй!  Он ввёл $victim_pass_q.\n", FILE_APPEND | LOCK_EX);
	mysql_query("update `killer` set `victim` = '$victim_id' where `id` = '$id_my_killer'", $con) or die ("Error! query – моему киллеру ставим мою жертву");
	
	$end_game_sec = strtotime($END_GAME_DAY);
	$date_next_kill = strtotime(date("Y-m-d H:i:s")) + $DAY_FOR_KILL*86400;
		
	if($date_next_kill < $end_game_sec){
		//сегодня+дней на убийство меньше чем конец игры
		$str_interval = "interval ".$DAY_FOR_KILL." day";
		mysql_query("update `killer` set `count_kill` = `killer`.`count_kill`+1, `date`=date_add('$today',$str_interval)  where `id` = '$id_my_killer'", $con) or die ("Error! query – ставлю себе новую дату");
	} else {
		mysql_query("update `killer` set `count_kill` = `killer`.`count_kill`+1, `date`='$END_GAME_DAY'  where `id` = '$id_my_killer'", $con) or die ("Error! query – ставлю датой конец игры");
	}
	
	file_put_contents($file, "$today  Киллера с ID = $id_my_killer  получил заказ на киллера с ID = $victim_id!\n", FILE_APPEND | LOCK_EX);
}

header("Location: http://".$_SERVER['HTTP_HOST']."/mission.php");
?>