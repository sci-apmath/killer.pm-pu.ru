<?php
include("../event_settings.php");
$id=$_POST['id'];
$mes=$_POST['message'];
$swi=$_POST['switch'];
include("../config.php");
$res = mysql_query("update `killer` set `status_photo`='$swi', `message`='$mes'  where `id` = '$id'", $con) or die ("Error! query – фото нет");


if($swi == 2){
$from = 'site@killer.pm-pu.ru';
$res = mysql_query("select `email` from `killer` where `id` = '$id'", $con) or die ("Error! query –не смог получить емаил");
$arr =  mysql_fetch_array($res, MYSQL_NUM);
			$email = $arr[0];
			$subject = "Сообщение с сайта!";
			$message = "Фото не подходит: ".$mes;
			$headers = "Content-type: text/html; charset=UTF-8 \r\n";
			$headers .= "From: <site@killer.pm-pu.ru>\r\n";
			$result = mail($email, $subject, $message, $headers);
		}

if($swi == 3){
	$from = 'site@killer.pm-pu.ru';
	$res = mysql_query("select `email` from `killer` where `id` = '$id'", $con) or die ("Error! query –не смог получить емаил");
	$arr =  mysql_fetch_array($res, MYSQL_NUM);
	
	$email = $arr[0];
	$subject = "Сообщение с сайта!";
	$message = "Фото одобрено. ".$mes.$EMAIL_DATE;
	$headers = "Content-type: text/html; charset=UTF-8 \r\n";
	$headers .= "From: <site@killer.pm-pu.ru>\r\n";
	$result = mail($email, $subject, $message, $headers);
	
	
	
}
		
header("Location: http://".$_SERVER['HTTP_HOST']."/adminka/photo_moderation.php");
?>