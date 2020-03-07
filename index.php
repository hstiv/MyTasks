<?php
session_start();
require 'config.php';

if (!isset($_SESSION["admin"]))
	$_SESSION["admin"] = 0;

//============================ header =====================================
$content.=
'<!DOCTYPE>
<html lang="ru">
	<head>
		<title>MyTasks</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="front/css/custom.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	<body>
		<header class="header">
			<form action="/login.php" class="header_form" method="post">';
if ($_SESSION["admin"] == 0)
	$content.= '<input type="text" name="login" id="header_task" placeholder="Логин" class="form-control">
				<input type="text" name="passwd" id="header_task" placeholder="Пароль" class="form-control">
				<button type="submit" name="signin" class="btn login_btn">Войти</button>';
else
	$content.= '<button type="submit" name="signout" class="btn logout_btn">Выйти</button>';

$content.= '</form>
		</header>
		<main>';
if (isset($_GET['error']))
	$content.=
			'<div class="alert alert-danger" style="text-align: center">
					<strong>'. $_GET['error'] .'<strong>
			</div>';
$content.='<div class="container" style="width: 100%!important; max-width: 400px!important; margin-top: 5px">
			<form class="task_form" action="/add_task.php" method="post">
				<input type="text" name="name" id="task" placeholder="Ведите имя ползователя..." class="form-control">
				<input type="text" name="email" id="task" placeholder="Введите эл-адрес почты..." class="form-control">
				<input type="text" name="task" id="task" placeholder="Задача..." class="form-control">
				<button type="submit" name="sendtask" class="btn custom_btn-success">Отправить</button>
			</form>
			<ul class=pagination>';
//====================== Counting how many pages should be and making pagination ===========================
$query = $pdo->query('SELECT COUNT(*) as count FROM `tasks`');
$res = $query->fetch(PDO::FETCH_OBJ);
$page_count = $res->count;
$page_num = 1;
$notesOnPage = 3;
$active_page = isset($_GET['page']) ? $_GET['page'] : 1;

while ($page_count > 0) {
	$content .= '<li class="page-item';
	if ($page_num == $active_page)
		$content.= ' active';
	$content.= '"><a class="page-link" href="?page='. $page_num. '">'. $page_num. '</a></li>';
	$page_num++;
	$page_count -= $notesOnPage;
}
$content.=		'</ul>';
//=========================================================================================================
$order = '';
if ($_SESSION['order_addition'] != '')
	$order = $_SESSION['order_addition'];

//====================== Tasks ==========================
$page = ($active_page - 1) * $notesOnPage;
if ($page >= 0) {
	$sql = 'SELECT * FROM `tasks`'. $order.' LIMIT '. $page.', '. $notesOnPage;
	$query = $pdo->query($sql);
	while ($row = $query->fetch(PDO::FETCH_OBJ)) {
		$checked = ($row->check == 1 ? ' checked ' : '');
		$on_click = ($_SESSION["admin"] == 0 ? ' onclick="return false"' : '');
		$readonly = ($_SESSION["admin"] == 0 ? ' readonly' : '');
		$content.= 
				'<form class="ul_pagination" action="/modify_task.php" method="post">
					<li class="desk"><b>Имя: '. "$row->name".'</b></li>
					<li class="desk"><b>Email: '. "$row->email".'</b></li>
					<input type="text" name="task" id="task" class="li_pagination" value="'. $row->task.'"'. $readonly.'>
					<input type="hidden" name="status_1" value="0">
					<input type="checkbox" id="status_1" name="status_1" value="1"'. $checked. $on_click. '/>';
		if ($_SESSION['admin'] == 1) { //shows when admin is logged
			$content.= '<input type="radio" name="status_2" value="0"'. ($row->modified == 0 ? ' checked ' : ''). 'style="margin-left:5px" class="red_input"/>
					<input type="radio" id="status_2" name="status_2" value="1" '. ($row->modified == 1 ? ' checked ' : '') . 'class="green_input"/>
					<button type="submit" class="button_pagination" style="background: green" name="modify">Изменить</button>
					<button type="submit" class="button_pagination" name="delete">Удалить</button>
					<input type="hidden" name="id" value="'. $row->id. '">
					<input type="hidden" name="modified" value="'. $row->modified .'">
					<input type="hidden" name="check" value="'. $row->check. '">';
		}
		$content.= (($row->modified == 1) ? '<label class="desk">Отредактировано администратором</label>' : '').
				'</form>';
	}
}

//============================ Soting ==========================
$order_types = array('Нет' => '',
					'По возрастанию' => 'ASC',
					'По убыванию' => 'DESC');

$order_values = array('Имя' => 'name',
					'Почта' => 'email',
					'Статус' => 'check');

$content.='	</div>
			<div class="container">
				<form action="/set_order.php" class="order_form" method="post">';
foreach($order_values as $rus => $eng) {
	$content.= '<ul class="container" style="display: flex; flex-direction: column; text-align: center; margin-left: 5px!important; font-size: 0.8rem; padding: 5px; max-width: 110px; border: 1px solid gray; border-radius: 5px; background-color: rgb(225, 225, 225); margin-top: 5px; margin-bottom: 5px">	
					<select class="select_container" name="'. $rus.'" value="'. $rus.'">';
	foreach($order_types as $type => $value) {
		$content.=		'<option name='. $type.' value="'. $value.'">'. $type.'</option>';
	}
	$content.=		'</select>
					<label>'. $rus.'</label>
				</ul>';
}
$content.=	'<button type="submit" name="orderbutton" class="sort_btn">Сортировать</button>
			</form>
			</div>
		</main>
	</body>
</html>';

//=========================== just printing everything ================
if (isset($content))
	echo $content;

unset($_GET);
unset($_SESSION);