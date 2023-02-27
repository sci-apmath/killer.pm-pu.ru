<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title> Регистрация.</title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>

<div id="content">
<?php
	include("config.php");
	$err = array();
	$reg_action = 0;	
	$img_up = 0; //флаг загрузки фото
		if (empty($_POST['first_name']) OR empty($_POST['last_name']) OR 
			empty($_POST['email']) OR empty($_POST['year']) OR
			empty($_POST['password']) OR !($_FILES['up_file']['size']>0)) {
			$err[] = "заполнены не все поля";
			}

		
		if (!preg_match("/^[А-Яа-яЁё]+$/u",$_POST['first_name'])){
			$err[] = "имя должно быть написано кириллицей";
		}
		if (strlen($_POST['first_name'])<1 OR strlen($_POST['first_name'])>40){
			$err[] = "имя от 1 до 20 символов";
		}
		if (!preg_match("/^[А-Яа-яЁё]+$/u",$_POST['last_name'])){
			$err[] = "фамилия должна быть написана кириллицей";
		}
		
		if (strlen($_POST['last_name'])<1 OR strlen($_POST['last_name'])>50){
			$err[] = "фамилия от 1 до 25 символов";
		}
		if (!preg_match("/^[1-8]{1}/",$_POST['year']) ){
			$err[] = "некорректный курс";
		}
		if (strlen($_POST['password'])!=4 ){
			$err[] = "пароль должен состоять из 4 цифр";
		}
		if(!is_numeric($_POST['password'])){
			$err[] = "пароль должен состоять из цифр";
		}
		if(!preg_match("/^[\._a-zA-Z0-9-]+@[\.a-zA-Z0-9-]+\.[a-z]{2,6}$/i", $_POST['email'])){
			$err[] = "некорректный e-mail";
		} 

		
		$res = mysql_query("select * from `killer` order by `id` desc limit 1 ", $con) or die ("Error! query – запрос последней записи в таблице игроков");
		$arr = mysql_fetch_array($res, MYSQL_NUM);
		$last_id = $arr[0]+1;	//id нового игрока
//		$err[] = "ид - $last_id";
		
		include("resize_crop.php");
		$name_photo="";
		$path = "img/users/";
		$types = array('image/gif', 'image/png', 'image/jpeg');

		$uploadfile ="";
		if(($_FILES['up_file']['size']>0) and ($_FILES['up_file']['size']< 2.5*1024*1024) ){
			if (!in_array($_FILES['up_file']['type'], $types)){
				$err[] = "запрещённый тип файла";
			} else {
				$info = new SplFileInfo($_FILES['up_file']['name']);
				$randLength = 10;
				$randomString = substr(str_shuffle(md5(time())),0,$randLength);
				$apend="photo_".$randomString.".".$info->getExtension();
				$name_photo = $apend;
				$uploadfile = "$path$apend";
				if (move_uploaded_file($_FILES['up_file']['tmp_name'], $uploadfile)) {
					$size = GetImageSize($uploadfile);
					$width = $size[0];
					$height = $size[1];
					if ($width > $height){
						if ($width > 600 ) {
							//	$err[] = "ширина изображения больше 800px!";
							//unlink($uploadfile);
							$koef = 600/$width;
							resize($uploadfile, $uploadfile, 600, $size[1]*$koef);
							$img_up = 1;
						}
					} else {
						if ($height > 600 ) {
							//	$err[] = "ширина изображения больше 800px!";
							//unlink($uploadfile);
							$koef = 600/$height;
							resize($uploadfile, $uploadfile, $size[0]*$koef, 600);
							$img_up = 1;
						}
					}						
					if (($size[0] < 600) or ($size[1]<600)){
						$err[] = "фотография меньше, чем 600х600 px";
					}
					$img_up = 1;
				} else { 
					$err[] = "не удалось загрузить фотографию";
				}
			}
		} else {
			$err[] = "размер фото больше 2.5 Мб или фото отсутствует";
		}


		
		$mail = mysql_real_escape_string(htmlspecialchars($_POST['email'])); 
		$query = mysql_query("SELECT `email` FROM `killer` WHERE  `email` ='".$mail."'");
		if(mysql_num_rows($query)> 0){
				$err[] = "пользователь с таким e-mail уже зарегистрирован";
		}		

		if(count($err) == 0){
			$f_name =  mysql_real_escape_string(htmlspecialchars($_POST['first_name']));
			$l_name =  mysql_real_escape_string(htmlspecialchars($_POST['last_name']));
			$year =  mysql_real_escape_string(htmlspecialchars($_POST['year']));
			$email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
			$pass = mysql_real_escape_string(htmlspecialchars($_POST['password']));

			$name=$l_name."  ".$f_name;
			
			mysql_query("INSERT INTO `killer` (`name`, `year`, `email`, `uid`, `status`, `status_photo`, `victim`, `name_photo`) VALUES ( '$name','$year','$email','$pass','1','1','0','$name_photo')") or die ("Error! query – write DB");
			$reg_action = 1;
			
			//отправляем на почту пароль.
			
			$from = 'site@killer.pm-pu.ru';
			$subject = "Киллер";
			$message = "Вы зарегистрировались на игру Киллер<br> Ваш логин: ".$email."<br>Ваш пароль (он же ID): ".$pass;
			$headers = "Content-type: text/html; charset=UTF-8 \r\n";
			$headers .= "From: <site@killer.pm-pu.ru>\r\n";
			$result = mail($email, $subject, $message, $headers);
		}
		else{
			$reg_action = 0;
			if ($img_up) unlink($uploadfile);
		}
?>  
	<h1><?php 
	if($reg_action) echo"Вы сделали это!"; 
	else  echo "ПРИ РЕГИСТРАЦИИ ПРОИЗОШЛИ ОШИБКИ:";
	?></h1>
<div class="errors">
<ul><?php
	if($reg_action) echo "<script> var reg=1; </script>";
	else {
		echo "<script> var reg=0; </script>";
		foreach($err AS $error) {
			echo "<li>  $error </li>";
		}
	?>
</div>
		<div align="right"><?php
		echo "<br><a href=\"registration.php\"> заполнить форму еще раз!</a>";
	}
?></ul>
	
	<script>
		
		var delay = 2000;
		if (reg){
			setTimeout("document.location.href='./game_registration.php'", delay);
		}
	</script>
</div>
</div>

</body>
</html>