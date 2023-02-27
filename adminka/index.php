<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Админка</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<?
	include("../config.php");
	$res1 = mysql_query("select count(*) from `killer` where `status_photo` = '1'", $con) or die ("Error! query – фото нет");
	$arr1 = mysql_fetch_array($res1, MYSQL_NUM);
	$count_string = $arr1[0];
?>
<body>
	<ul style="display: block; margin: 0 auto; width: 300px; list-style: none;">
		<li><a href="#">Настройка игры</a>
		<li><a href="photo_moderation.php">Модерация фотографий участников (<? echo $count_string; ?>)</a>
		<li><a href="add_date.php">Назначить время первого убийства!</a>
	</ul>
</body>
</html>