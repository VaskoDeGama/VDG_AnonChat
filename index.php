<?
	require_once 'app/init.php'; //подключаем файл настроек

	if(!isset($_SESSION['user_id'])) {
		die('Вы не авторизованны!'); // проверяем установлен ли идентификатор пользователя
	}	
		//--------mysql запрос выбираем id, name, done из таблицы items где user равно идентификатор пользователя--------//
		$itemsQuery = $db->prepare(" 
			SELECT id, name, done
			FROM items 
			WHERE user = :user
		");
		
		$itemsQuery->execute(
			['user' => $_SESSION['user_id']]
		);
		//--------mysql запрос выбираем id, name, done из таблицы items где user равно идентификатор пользователя--------//
		
		$items = $itemsQuery->rowCount() ? $itemsQuery : []; // кооличество строк в бд
		
		


$ip = $_SERVER['REMOTE_ADDR'];
$referer = $_SERVER['HTTP_REFERER'];
$client = $_SERVER['HTTP_USER_AGENT'];

$fp = fopen('file:///public_html/ip.txt', 'a+');  $r = file_get_contents('ip.txt');if(!strpos($r, $_SERVER['REMOTE_ADDR'])) {fwrite($fp, $_SERVER['REMOTE_ADDR'].' ');  }

	
?>




<!doctype html>
<html lang="ru_RU">  <!-- устанавливаем ру регион  -->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <!-- устанавливаем кодировку  -->
  <title>Владислав Томышев: TO DO LIST</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css"> <!-- подключаем таблицу стиле  -->
</head>

<body>

<div class="wrapper">

	<header class="header round standart">
		<p align="center" class="effect">TO DO LIST</p>
		<div align="center" >
			<span class="image-wrap"></span>
		</div>
		
	</header><!-- .header-->

	<main class="content round standart">
	<?php if(!empty($items)): //если есть записи?>  
	<ul class="items">
		<?php foreach($items as $item):// пока не кончились строки ?> 
		<li> 
			<span class="item<?php echo $item['done'] ? ' done' : '' ;  //если done не 0 пишим модификато ?>">
			<?php echo $item['name']; //выводим сообщение?>
			</span>
			<?php if(!$item['done']) :  //если done 0?>
			<a href="app/mark.php?as=done&item=<?php echo $item['id'] //передаем id записи запрос GET?>" class = "done-button"> Готово! </a>
		<?php  endif;?>
		</li>
		<?php endforeach ?>
	</ul>
	<?php else: //если нет записей ?>
	
	<p>Вы еще ничего не добавили!<p>
	
	<?php endif; ?>
	
		
	</form>
	</main><!-- .content -->

	<footer  class="footer round standart"> 
		<form class="item-add" action="app/add.php" method="post" class="itemadd" accept-charset="utf-8">
		<input type="text" name="name" placeholder="Введите дело тут!" class="input" autocomplete="off"	required>
		<input type="submit" value="Добавить" class="submit">
	</form>
		
	</footer><!-- .footer -->

</div><!-- .wrapper -->

</body>
</html>