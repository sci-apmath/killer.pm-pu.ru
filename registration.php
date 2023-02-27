<?
include "event_settings.php"
?>
<!DOCTYPE html>
<html>
<head>
<title>Регистрация</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


<script type="text/javascript">
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

function prepareInputsForHints() {

	var inputs = document.getElementsByTagName("input");
	var select = document.getElementsByTagName("select");
	var subscribes = document.getElementsByClassName("subscribe");
	if (document.documentElement.clientWidth > 800) {
		inputs[0].onmouseover = function () { subscribes[0].style.display = "block"; }
		inputs[0].onmouseout = function () { subscribes[0].style.display = "none"; }
		inputs[1].onmouseover = function () { subscribes[1].style.display = "block"; }
		inputs[1].onmouseout = function () { subscribes[1].style.display = "none"; }
		inputs[2].onmouseover = function () { subscribes[3].style.display = "block"; }
		inputs[2].onmouseout = function () { subscribes[3].style.display = "none"; }
		inputs[3].onmouseover = function () { subscribes[4].style.display = "block"; }
		inputs[3].onmouseout = function () { subscribes[4].style.display = "none"; }
		inputs[4].onmouseover = function () { subscribes[5].style.display = "block"; }
		inputs[4].onmouseout = function () { subscribes[5].style.display = "none"; }
		inputs[5].onmouseover = function () { subscribes[6].style.display = "block"; }
		inputs[5].onmouseout = function () { subscribes[6].style.display = "none"; }
		select[0].onmouseover = function () { subscribes[2].style.display = "block"; }
		select[0].onmouseout = function () { subscribes[2].style.display = "none"; }
	} else {
		inputs[0].onfocus = function () { subscribes[0].style.display = "block"; }
		inputs[0].onblur = function () { subscribes[0].style.display = "none"; }
		inputs[1].onfocus = function () { subscribes[1].style.display = "block"; }
		inputs[1].onblur = function () { subscribes[1].style.display = "none"; }
		inputs[2].onfocus = function () { subscribes[3].style.display = "block"; }
		inputs[2].onblur = function () { subscribes[3].style.display = "none"; }
		inputs[3].onfocus = function () { subscribes[4].style.display = "block"; }
		inputs[3].onblur = function () { subscribes[4].style.display = "none"; }
		inputs[4].onfocus = function () { subscribes[5].style.display = "block"; }
		inputs[4].onblur = function () { subscribes[5].style.display = "none"; }
		inputs[5].onfocus = function () { subscribes[6].style.display = "block"; }
		inputs[5].onblur = function () { subscribes[6].style.display = "none"; }
		select[0].onfocus = function () { subscribes[2].style.display = "block"; }
		select[0].onblur = function () { subscribes[2].style.display = "none"; }
		
	}
}
addLoadEvent(prepareInputsForHints);
</script>


</head>

<body>
  <div  id="content">
<?
if ($station_game==2) { ?>
<h1> Регистрация завершена! Игра в процессе!<br><a href="index.php">Вернуться!</a></h1>

<?

}



else { 
?>
  
  <h1>Добро пожаловать</h1>

  <form class="reg_form" action="reg_action.php" method="POST" enctype="multipart/form-data">
    <div class="container-flex">
			<div class="flex"><input class="field_reg" type = "text" name="first_name" required placeholder="имя" maxlength="20" pattern="^[А-Яа-яЁё]+$"></div>
			<div class="flex"><span class="subscribe">реальное полное имя (кириллицей)</span></div>
			<div class="flex"><input class="field_reg" type = "text" name="last_name" required placeholder="фамилия"  maxlength="25" pattern="^[А-Яа-яЁё]+$"></div>
			<div class="flex"><span class="subscribe">реальная фамилия (кириллицей)</span></div>
			<div class="flex"><select name="year" required placeholder="курс">
			<option selected value="1">1 курс
			<option value="2">2 курс
			<option value="3">3 курс
			<option value="4">4 курс
			<option value="5">1 курс маг.
			<option value="6">2 курс маг.
			<option value="7">аспирант
			<option value="8">преподаватель
			</select></div>
			<div class="flex"><span class="subscribe">выберите курс</span></div>
			<div class="flex"><input class="field_reg" type="email" name="email" required placeholder="e-mail"  maxlength="100"></div>
			<div class="flex"><span class="subscribe">на почту придет пароль</span></div>
			<div class="flex const1"><input  class="field_reg" maxlength="4" type="password" pattern="[0-9]{4}" name="password" required placeholder="пароль"></div>
			<div class="flex"><span class="subscribe">4 цифры, он же будет Вашим ID в игре, поэтому не делайте его простым</span></div>
			<!-- <input class="field_reg" type="text" name="captha" required placeholder="введите значение" maxlength="25"><span class="subscribe"></span>
     -->
			<div class="flex const2"><input id="file_reg" type="file" name="up_file" accept="image/*" ></div>
			<div class="flex"><span class="subscribe">фото: четкое, хорошо освещенное, лицо не менее чем на 0,5 фотографии, анфас, изображены только Вы,<br /> разрешение > 600х600
			</span></div>
        <div class="but1">
          <input class="button_reg" type="submit" value="зарегистрироваться">
        </div>
    </div>
  </form>
	<div class="vk">
		<a class="link_vk" target = '_blank' href="<? echo $VK_GROUP ?>"> <i class="fa fa-vk fa-2x"></i></a>
	</div> 
<?}
?>
</div> 

<?php include("templates/metrica.php"); ?>
</body>
</html>
