<?php
// Файл и угол поворота
$filename = $_POST['file'];
$degrees = 90;
// echo $filename;
// Загрузка изображения
$source = imagecreatefromjpeg($filename);

// Поворот
$rotate = imagerotate($source, $degrees, 0);

// Вывод
imagejpeg($rotate, $filename);

// Высвобождение памяти
imagedestroy($source); 
imagedestroy($rotate);

header("Location: http://killer.pm-pu.ru/adminka/photo_moderation.php");
?>