<?
// number of second the script allowed to run.
$limit = 360;
$time = time();

// getting last loaded value
$last_id = (int)$_GET['id'];
$last_id1 = (int)$_GET['id1'];
$user_id = (int)$_GET['id_user'];
$id_victim = (int)$_GET['id_victim'];
$id_killer = (int)$_GET['id_killer'];

// just to be sure that script will be killed
set_time_limit($limit+100);

include("config.php");
 
// цикл, проверяющий новые сообщения каждые 100 секунд
while (time()-$time<$limit) {
    // checking if something new was added to my test table
    $res = mysql_query("select * from `killer_chat` where `id_killer` = '$user_id' and `id_victim`  = '$id_victim' and `id`>'$last_id' order by `date`");
	$res1 = mysql_query("select * from `killer_chat` where `id_killer` = '$id_killer' and `id_victim`  = '$user_id' and `id`>'$last_id1' order by `date`");
	
    if ((mysql_num_rows($res))  or (mysql_num_rows($res1))){
        while ($item=mysql_fetch_array($res)) {
            // пишем js-скрипт, который выполнится у клиента
			if ($item['direction'] == 1 ) 
				echo 'self.putMessage("'.$item['id'].'","you","'.$item['message'].'");';
			else echo 'self.putMessage("'.$item['id'].'","victim","'.$item['message'].'");';
        }
        while ($item=mysql_fetch_array($res1)) {
            // пишем js-скрипт, который выполнится у клиента
			if ($item['direction'] == 2 ) 
				echo 'self.putMessage1("'.$item['id'].'","you","'.$item['message'].'");';
			else echo 'self.putMessage1("'.$item['id'].'","killer","'.$item['message'].'");';
        }	
        // выбрасываем все данные и выходим, чтобы клиент смог их обработать
        flush();
        exit;
    }
	
    // если данных нет - ждём 100 секунд
    sleep(100);
}

mysql_close();

?>	
