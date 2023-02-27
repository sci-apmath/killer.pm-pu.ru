<?
// стадия на которой сейчас находится игра
// 0 - заглушка начало игры, 1 - регистрация, 2 - игра, 3 - игра завершена
include ("event_settings.php");
 
  switch($station_game){
	case 0: header('Location: /game_preparation.php'); break;
	case 1: header('Location: /game_registration.php'); break;
	case 2: header('Location: /game.php'); break;
	case 3: header('Location: /game_end.php'); break;
	case 4: header('Location: /game_pause.php'); break;
  }
?>