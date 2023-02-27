<?php
include("config.php");

$id_killer=mysql_real_escape_string(htmlspecialchars($_POST['id_killer']));
$id_victim=mysql_real_escape_string(htmlspecialchars($_POST['id_victim']));
$direction=mysql_real_escape_string(htmlspecialchars($_POST['direction']));
$mess=$_POST['message'];

$order   = array(chr(13), chr(10), chr(59), chr(34), chr(39));
$mess = str_replace($order, ' ',$mess);

$mess = mysql_real_escape_string($mess);

if (strlen($mess) < 2) {
	$res = mysql_query("insert into `killer_chat`(`id_killer`, `id_victim`, `direction`, `date`, `message`) values ('$id_killer','$id_victim','$direction',now(),'чё-то я ни о чём')",$con) or die ("Error! query – произошла ошибка при добавлении сообщения!");
} else {
	$res = mysql_query("insert into `killer_chat`(`id_killer`, `id_victim`, `direction`, `date`, `message`) values ('$id_killer','$id_victim','$direction',now(),'$mess')",$con) or die ("Error! query – произошла ошибка при добавлении сообщения!");	
}


header("Location: http://".$_SERVER['HTTP_HOST']."/mission.php");
?>