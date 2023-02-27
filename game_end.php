<!DOCTYPE html>
<html>
<head>
  <title>Игра завершена!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/css/style1.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<?
include 'event_settings.php';
?>
<body>
<div  id="content">
<!--	/* тут нужна картинка для окончания игры */ -->
	<h2>Игра завершена.</h2>
	<h1>Нечего тут лазить. Идите читать конспекты!</h1>
    <div class="vk">
    		<a class="link_vk" href="<? echo $VK_GROUP ?>"> <i class="fa fa-vk fa-2x"></i></a>
    </div>
</div>
<?php include("metrics.php"); ?>
</body>
</html>