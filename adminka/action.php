<?php

include('resize_crop.php');

function prov($per){
	if (isset($per)) {
		$per = stripslashes($per);
		$per = htmlspecialchars($per);
		$per = addslashes($per);		 
	}
	return $per;
}



if(isset($_POST)){
	$file = "test.txt";
	$user_id = $_POST['id'];
	
	include("../config.php");
	$res = mysql_query("select * from `killer` where `id` = '$user_id' ", $con) or die ("Error! query – запрос последней записи в таблице игроков");
	$arr = mysql_fetch_assoc($res);
	$filenew = $user_id.$arr['name_photo'];
	
	$x1 = prov($_POST['x1']);
	$x2 = prov($_POST['x2']);
	$y1 = prov($_POST['y1']);
	$y2 = prov($_POST['y2']);
	$img = prov($_POST['img']);
	$crop = prov($_POST['crop']);
	
	
/*	if (($x1==$x2) or ($y1==$y2)){
		echo "не выбрана область для обрезания"
		exit;
	} else {
*/	
	
	crop($img,  "../".$crop.$filenew, array($x1, $y1, $x2, $y2));	
		unlink($img);
//		file_put_contents($file, $crop.$filenew, FILE_APPEND | LOCK_EX);
		echo $filenew;
		$res = mysql_query("update `killer` set `name_photo`='$filenew' where `id` = '$user_id' ", $con) or die ("Error! query – запрос последней записи в таблице игроков");

	}


?>