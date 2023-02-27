<!DOCTYPE html>
<html>

<head>
<title>Администратор</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/style1.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/jquery.jcrop.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.jcrop.min.js"></script>
<script src="../js/crop.js"></script>

<style>
.photo_flex {
	display: flex;
	flex-flow: row wrap;
	align-items: center;
}

</style>
</head>

<body>
<div  id="content">
<div class="container-photo_flex">
<?php
include("../config.php");
$res = mysql_query("select * from `killer` where `status_photo` = '1'", $con) or die ("Error! query – фото нет");
$res1 = mysql_query("select count(*) from `killer` where `status_photo` = '1'", $con) or die ("Error! query – фото нет");
$arr1 = mysql_fetch_array($res1, MYSQL_NUM);
$count_string = $arr1[0];


//for ($i=0; $i < $count_string; $i++){
	$arr = mysql_fetch_assoc($res);
	$uname = $arr['name'];
	$file_photo = $arr['name_photo'];
	$uid = $arr['id'];
	if (isset($file_photo)) {
			echo "
		<div class=\"photo_flex\">
			<div class=\"photo_doposle\">
				<p>$uname</p>
				<div id=\"img-target\">
					<img id=\"target\" src=\"../img/users/$file_photo\">
				</div>
				<div id=\"cropresult\"></div>
			</div>
			<div class=\"control_panel_photo\">
				<div id=\"$uid\">
					<button id=\"release\">убрать выделение</button> 
					<button id=\"crop\">обрезать</button>
				</div>
				<form class=\"admin\" action=\"admin_action.php\" method=\"POST\">
					<input type=\"hidden\" name=\"id\" value=\"$uid\"> 
					<div><input name=\"switch\" type=\"radio\" value=\"3\">одобрить</div>
					<div><input name=\"switch\" type=\"radio\" value=\"2\">отклонить</div>
					<div><input name=\"message\" type=\"text\">месседж</div>
					<div class=\"but1\">
						  <input class=\"button_reg\" type=\"submit\" value=\"отправить\">
					</div>
				</form>
				<form class=\"admin\" action=\"img_rotate.php\" method=\"POST\">
					<input type=\"hidden\" name=\"file\" value=\"../img/users/$file_photo\"> 
					<input class=\"button_reg\" type=\"submit\" value=\"повернуть\">
				</form>
			</div>
		</div>
		";
	} else {
		echo "Новых фотографий больше нет!";
		echo "<br><a href=\"index.php\">в админку!</a>";
	}

?>

</body>

</html>