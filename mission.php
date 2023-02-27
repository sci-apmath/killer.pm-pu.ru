<?php 
if (!isset($_SESSION['user_id']))
		require "authorization.php";
$user_id =  $_SESSION['user_id'];

// header('Location: /game_pause.php');
include("config.php");
$res = mysql_query("select * from `killer` where `id` = '$user_id'", $con) or die ("Error! query – поиск строки пользователя");
$arr = mysql_fetch_assoc($res);

$id_victim = $arr['victim'];
$count_kill = $arr['count_kill'];
$status =  $arr['status'];
switch($status){
	case 0: header('Location: /killed.php'); break;
	case 2: header('Location: /winner.php'); break;
}
	
$res = mysql_query("select * from `killer` where `victim` = '$user_id'", $con) or die ("Error! query – поиск строки пользователя");
$arr = mysql_fetch_assoc($res);
	$your_killer_id = $arr['id'];

?>
<!DOCTYPE html>
<html>

<head>
	<title>Заказ</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="Cache-Control" content="no-cache">
	<link rel="stylesheet" href="/css/style_ac.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" >
	var id_user=<?php echo $user_id; ?>; 
	var id_killer=<?php echo $your_killer_id; ?>;
	var id_victim=<?php echo $id_victim; ?>;

$(document).ready(function(){

 //   var msg = new Messanger();
	timer();
});

//setTimeout("window.location.reload()",15000)


</script>
<style>
.chat_text_msg::-webkit-input-placeholder{
	color: #444;
	margin: 10px;
	font-size: 1.2em;
}
</style>
<script language="JavaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script>
function check(inp, btn) {

    if ($('#'+inp).val() != '')
        $('#'+btn).removeAttr('disabled');
    else
        $('#'+btn).attr('disabled','disable');
}
</script>


</head>

<body>
<div  id="content">
	<div class="navigation"><div class="timer">
	
<?php	
	$res = mysql_query("select `date` from `killer` where `id` = '$user_id'", $con) or die ("Error! query – даты убийства");	
	$arr = mysql_fetch_assoc($res);
	$date_in_base = $arr['date'];
	
	$today = date("Y-m-d H:i:s");

	$day = strtotime($date_in_base);
	$today = strtotime($today);
	$interval = $day-$today;

	$h = floor($interval/(60*60));
	$m = floor(($interval - $h*3600)/60);
	$s = ($interval - $h*3600 -$m*60);
		
	echo "<span id=\"hours\">".$h."</span> : <span id=\"minutes\">".$m."</span> : <span id=\"seconds\">".$s."</span>";
?>

	<script type="text/javascript">
var sec =0;
function timer(){
  var h=document.getElementById('hours').innerHTML;
  var m=document.getElementById('minutes').innerHTML;
  var s=document.getElementById('seconds').innerHTML;

  sec = h*3600+m*60+s*1;
  sec--;
  
  document.getElementById('hours').innerHTML = Math.floor(sec/(60*60));
  if ( Math.floor((sec - h*3600)/60) == - 1) 
	document.getElementById('minutes').innerHTML = 59;
  else
	document.getElementById('minutes').innerHTML =  ('0' + Math.floor((sec - h*3600)/60)).slice(-2);


  if(sec - h*3600 - m*60 == -1) 
	document.getElementById('seconds').innerHTML =59; 
  else
	document.getElementById('seconds').innerHTML = ('0' + (sec-h*3600- m*60)).slice(-2); 
 
 if(sec==0){document.location.href='http://killer.pm-pu.ru/killed.php';setTimeout(function(){},1000);}
   else{setTimeout(timer,1000);}
}

</script></div> 
	<div class="victim_count"> Ваши жертвы: <?php echo $count_kill; ?></div></div>
<div class="panel">
<?php
include("config.php");
//получаем жертву текущего юзера
//$res = mysql_query("select * from `killer` where `id` = '$user_id'", $con) or die ("Error! query – фото нет");	
//$arr = mysql_fetch_array($res, MYSQL_NUM);

//получаем фото жертвы
$res = mysql_query("select * from `killer` where `id` = '$id_victim '", $con) or die ("Error! query – фото нет");	
$arr = mysql_fetch_assoc($res);
$photo_victim = $arr['name_photo'];
echo "
	<div class=\"panel_1\">
		<div class=\"victim\">
			<img class=\"victim_ph\" src=\"/img/users/$photo_victim\">
			<form class=\"inter_id\" action=\"id_action.php\" method=\"POST\">
				<input class=\"id_field\"    onkeyup=\"check('input','button');\" id=\"input\"  type = \"text\" name=\"id\" required placeholder=\"ID жертвы\" pattern=\"^[0-9]{4}\">
				<input class=\"send_button\" type=\"submit\" id=\"button\" disabled=\"disabled\" value=\"убить\">
			</form>
	    </div>
	</div>

";
?>

<div class="panel_2">

	<div class="tabs">
	<ul>
		<li>
			<input type="radio" name="tabs-0" checked="checked" id="tabs-0-0"/><label for="tabs-0-0">жертва</label>
			<div class="area">
			<?php
			echo "
		<div id=\"dialog1\" class=\"dialogue\">";
				
					$res = mysql_query("select * from `killer_chat` where `id_killer` = '$user_id' and `id_victim`  = '$id_victim' order by `date` asc ", $con) or die ("Error! query – запрос истории переписки");

				while($arr = mysql_fetch_array($res, MYSQL_NUM)) {
					if ($arr[3] == 1 ) echo "<p><span class=\"you\">you:</span> $arr[5]</p>";
					else echo "<p>victim: $arr[5]</p>";
				}
				
				
		echo "</div>	
			<form action=\"add_chat.php\" method=\"POST\">
				<input type=\"hidden\" name=\"id_killer\" value=\"$user_id\">
				<input type=\"hidden\" name=\"id_victim\" value=\"$id_victim\">
				<input type=\"hidden\" name=\"direction\" value=\"1\">
				<textarea id=\"input1\" class=\"chat_text_msg\" placeholder=\"напишите сообщение своей жертве\" name=\"message\" onkeyup=\"check('input1','button1');\"  placeholder=\"напишите сообщение своей жертве\"></textarea>
				<input class=\"button_chat\" type=\"submit\" value=\"отправить\" id=\"button1\" disabled=\"disabled\">
		    </form>";
			?>
			</div>
		</li>
		<li>
			<input type="radio" name="tabs-0" id="tabs-0-1"/><label for="tabs-0-1">киллер</label>
			<div class="area">
			<?php
			echo "
		<div id=\"dialog2\" class=\"dialogue\">";
			
			
			$res = mysql_query("select * from `killer_chat` where `id_killer` = '$your_killer_id' and `id_victim`  = '$user_id' order by `date` asc ", $con) or die ("Error! query – запрос истории переписки");
	while($arr = mysql_fetch_array($res, MYSQL_NUM)) {
		if ($arr[3] == 1 ) echo "<p>killer: $arr[5]</p>";
		else echo "<p><span class=\"you\">you:</span> $arr[5]</p>";
	}
			
			
			
			
			
		echo "</div>
			<form action=\"add_chat.php\" method=\"POST\">
				<input type=\"hidden\" name=\"id_killer\" value=\"$your_killer_id\">
				<input type=\"hidden\" name=\"id_victim\" value=\"$user_id\">
				<input type=\"hidden\" name=\"direction\" value=\"2\">
				<textarea class=\"chat_text_msg\" \" name=\"message\" placeholder=\"напишите сообщение своему киллеру\" onkeyup=\"check('input2','button2');\" id=\"input2\"></textarea>
				<input class=\"button_chat\" type=\"submit\" value=\"отправить\" id=\"button2\" disabled=\"disabled\">
		    </form>";		
			?>
			</div>
		</li>
	</ul>
	</div>
</div>

</div>
</div>
<?php include("metrics.php"); ?>
</body>

</html>