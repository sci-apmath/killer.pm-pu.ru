<?
include "event_settings.php";
$file="logs.txt";
$today = date("Y-m-d H:i:s");
session_set_cookie_params(10800); // время жизни сессии 3 часа

if(isset($_POST['email'])) {
  include("config.php");
  $name=mysql_real_escape_string($_POST['email']);
  $pass=mysql_real_escape_string($_POST['password']);
  
  $ip = $_SERVER['REMOTE_ADDR'];
  
  $query = "SELECT * FROM `killer` WHERE `email`='$name' AND `uid`='$pass'";
  $res = mysql_query($query) or die("Error! Don't read.");
  if ($row = mysql_fetch_assoc($res)){
    session_start();
    $_SESSION['user_id'] = $row['id'];
		$user_id = $row['id'];
		file_put_contents($file, "$today  Киллер с ID = $user_id зашёл на сайт. IP = $ip\n", FILE_APPEND | LOCK_EX);
		mysql_query("update `killer` set `visits` = `killer`.`visits`+1 where `id` = '$user_id'", $con) or die ("Error! query – auth conuter!");
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}

if (isset($_GET['action']) AND $_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: http://".$_SERVER['HTTP_HOST']."/");
  exit;
}

//if (isset($_REQUEST[session_name()])) session_start();

if (! session_id()) session_start();

if (isset($_SESSION['user_id'])) { 
  //echo "user_id = ".$_SESSION['user_id'];
  return;
} else {
?>
<!DOCTYPE html>
<html>
<head>
<title>Авторизация</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>
<div  id="content_auth">
  <form class="auth_form" method="POST">
       <div class="flex_auth"><input class="field_auth" type="email" name="email" required placeholder="e-mail"  maxlength="100"></div>
       <div class="flex_auth"><input class="field_auth" type="password" pattern="[0-9]{4}" name="password" required placeholder="пароль"></div>
       <div class="flex_auth"><input class="button_auth" type="submit" value="войти"></div>
	   <a class="link_auth" href="registration.php">зарегистрироваться</a> 
  </form>
  

<div class="vk">
    <a class="link_vk" target = '_blank' href="<? echo $VK_GROUP ?>"><i class="fa fa-vk fa-3x"></i></a>    
</div>

</div>
<?php include("templates/metrica.php"); ?>
</body>
</html>
<? 
}
exit;
?>