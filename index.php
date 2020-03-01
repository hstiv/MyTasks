<?php

$content.=
'<html lang="ru">
	<head>
		<title>MyTasks</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-vidth, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="front/css/custom.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">	
	</head>
	<body>
		<div class="header">';

require 'config.php';

$query = $pdo->query('SELECT COUNT(*) as count FROM `admin`');
$row = $query->fetch(PDO::FETCH_OBJ);
$is_logged = $row->count;

if ($is_logged == 0)
	$content.= '<form action="/login.php" class="header_form" method="post">
				<input type="text" name="login" id="header_task" placeholder="Логин" class="form-control">
				<input type="text" name="passwd" id="header_task" placeholder="Пароль" class="form-control">
				<button type="submit" name="sendData" class="btn login_btn">Войти</button>';
else
	$content.= '<form action="/logout.php" class="header_form" method="post">
				<button type="submit" name="sendData" class="btn logout_btn">Выйти</button>';

$content.='	</form>
		</div>
		<div class="container">
			<form class="task_form" action="/add_task.php" method="post">
				<input type="text" name="name" id="task" placeholder="Ведите имя ползователя..." class="form-control">
				<input type="text" name="email" id="task" placeholder="Введите эл-адрес почты..." class="form-control">
				<input type="text" name="task" id="task" placeholder="Задача..." class="form-control">
				<button type="submit" name="sendData" class="btn custom_btn-success">Отправить</button>
			</form>
				<ul class=pagination>';
$query = $pdo->query('SELECT COUNT(*) as count FROM `tasks`');
$res = $query->fetch(PDO::FETCH_OBJ);
$page_count = $res->count;
$page_num = 1;
$notesOnPage = 3;

if (isset($_GET['page']))
	$active_page = $_GET['page'];
else
	$active_page = 1;

while ($page_count > 0)
{
	$content .= '<li class="page-item';
	if ($page_num == $active_page)
		$content.= ' active';
	$content.= '"><a class="page-link" href="?page='. $page_num. '">'. $page_num. '</a></li>';
	$page_num++;
	$page_count -= $notesOnPage;
}
$content.=		'</ul>';

$sql = 'ALTER TABLE tasks ORDER BY `name` ASC';
$query = $pdo->prepare($sql);
$query->execute([]);

$page = ($active_page - 1) * $notesOnPage;
if ($page >= 0)
{
	$sql = 'SELECT * FROM `tasks` WHERE `id` > 0 LIMIT '. $page.', '. $notesOnPage;
	$query = $pdo->query($sql);
	while ($row = $query->fetch(PDO::FETCH_OBJ))
	{
		$content.= '<ul class="ul_pagination">';
		$content.= '<li class="desk"><b>Имя: '. "$row->name".'</b></li>';
		$content.= '<li class="desk"><b>Email: '. "$row->email".'</b></li>';
		$content.= '<li class="li_pagination"><b>'. "$row->task".'</b></li>';
		$content.= '<input type="checkbox" ';
		$content.= ($is_logged == 0) ? ('onclick="return false;"') : ('');
		$content.= '/>';
		if ($is_logged == 1)
			$content.= '<a href="/delete_task.php/?id='. $row->id. '"><button class="button_pagination">Удалить</button></a>';
		$content.= '</ul>';
	}
}
$content.='</body>
</html>';

if (isset($content))
	echo $content;
?>