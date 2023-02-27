
<!DOCTYPE html>
<html>
<head>
<title>Ожидание старта</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/css/style1.css"><!-- общий стилевой файл -->
<!-- <link rel="stylesheet" href="/css/jquery.jcrop.css" type="text/css" /> -->  <!-- стилевой файл для обрезалки фоток -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">  <!-- штучка отвечающая за красивые иконки офф. сайт  http://fontawesome.io/icons/ -->
<script src="/js/jquery.min.js"></script>  <!-- очень распространённая js-библиотека. Обычно подключается, чтобы работали какие-то дргугие скрипты написанные с использование функций этой библиотеки. Открывать файл бессмысленно, он обфусцирован (типа зашифрована)-->
<script src="/js/jquery.jcrop.min.js"></script> <!-- тоже для обрезания фоток -->
<script src="/js/crop.js"></script> <!-- файл со скриптами джава скрипт. обрезание фоток -->

<style>
.start-text {
    color:  red;
    font-size: 50px;
}

.start-text-data {
    margin-left: 3em;
}
<!--
.coordinats{
	width: 50px;
}
	
label{
	color: white;
}
-->
</style> 

</head>
<?php
include 'event_settings.php';
?>
<body>
<div  id="content">

            <div class="start-text">Старт Игры</div>
            <div class="start-text start-text-data"><? echo $WAITING_START_DATE ?></div>
            <!-- <img class="image" src="img/start.png"> -->
			<div class="vk">
						<a class="link_vk" href="<? echo $VK_GROUP ?>"><i class="fa fa-vk fa-2x"></i></a>
			</div>

</div>
<?php include("templates/metrica.php"); ?>
</body>
</html>
