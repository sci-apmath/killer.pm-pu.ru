<?
	if (!isset($_SESSION['user_id']))
		require "authorization.php";

	$user_id = $_SESSION['user_id'];

	include("config.php");
	$res = mysql_query("select * from `killer` where `id` = '$user_id' ", $con) or die ("Error! query – запрос последней записи в таблице игроков");
	$arr = mysql_fetch_assoc($res);
		
// статус игрока
// 0 - игрок убит, 1 - игрок жив, 2 - игрок победитель
	$status = $arr['status'];
  switch($status){
	case 0: header('Location: /killed.php'); break;
	case 1: header('Location: /mission.php'); break;
	case 2: header('Location: /winner.php'); break;
  }
?>