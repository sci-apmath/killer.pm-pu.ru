<!DOCTYPE html>
<html>

<head>
<title>Администратор</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="../css/style1.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


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

<?php
include "../event_settings.php";

include("../config.php");
	
	mysql_query("update `killer` set  `status`=1", $con) or die ("Error! query – ставлю себе новую дату 1");
	echo "<br><a href=\"index.php\">в админку!</a>";
?>

</body>

</html>