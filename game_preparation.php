<!DOCTYPE html>
<html>
<head>
<title>Ожидание регистрации</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/css/style.css">

</head>
<?
include 'event_settings.php';
?>
<body>
	<div class="cap_reg">
		<img id="cap" src="/img/reg.png"/>
	</div>
	<div class="vk">
    		<a class="link_vk" href="<? echo $VK_GROUP ?>"> <i class="fa fa-vk fa-2x"></i></a>
    </div>
</body>
</html>
<?php include("templates/metrica.php"); ?>