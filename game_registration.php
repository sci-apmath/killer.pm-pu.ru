<?
include "event_settings.php";
?>
<?php 
	if (!isset($_SESSION['user_id']))
		require "authorization.php";
	if ($station_game==2) {
		header('Location:http://killer.pm-pu.ru/index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Старт игры</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/css/style1.css">
<link rel="stylesheet" href="/css/jquery.jcrop.css" type="text/css" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.jcrop.min.js"></script>
<script src="/js/crop.js"></script>

<style>
.coordinats{
	width: 50px;
}
	
label{
	color: white;
}
</style> 

</head>

<body>
<div  id="content">
<?php
	
	if (($status_photo==1) or ($status_photo==3)) {
		include("waiting_start.php");
	}
	$user_id = $_SESSION['user_id'];
	//echo "$user_id";
	include("config.php");
	$res = mysql_query("select * from `killer` where `id` = '$user_id' ", $con) or die ("Error! query – запрос последней записи в таблице игроков");
	$arr = mysql_fetch_assoc($res);
	$status_photo = $arr['status_photo'];
	
	//  0 - фото нет 1 - фото загружено и ждёт подтверждения 2 - фото отклонено администратором 3 - фото загружено и одобрено
	
	$name_photo = $arr['name_photo'];
	$adm_message = $arr['message'];
	
	if (($status_photo==1) or ($status_photo==3)) {
		include("waiting_start.php");
	} else if(($status_photo==0) or ($status_photo == 2)) {
echo "
	<h1>ЗАГРУЗИТЕ ФОТО</h1>";
	if ($status_photo == 2) 
		echo "
<div class=\"admin_message\"> Прошлое фото не подходит.  </div>
<div class=\"admin_message\"> $adm_message </div>
		";
		
echo "	
		<form class=\"reg_form\" action=\"photo_action.php\" method=\"POST\" enctype=\"multipart/form-data\">
			<div class=\"container-flex\">
				<div class=\"flex\"><input id=\"file_reg\" type=\"file\" name=\"up_file\" accept=\"image/*\" >		
				</div>
				<div class=\"but1\">
					<input class=\"button_reg\" type=\"submit\" value=\"загрузить\">
				</div>
			</div>
		</form>";
		
		
		}
?>
</div>
<?php include("templates/metrica.php"); ?>
</body>
</html>