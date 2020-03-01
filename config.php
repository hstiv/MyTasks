<?php
	$desc = 'mysql:host=mysql.zzz.com.ua;dbname=satmak335';
	$pdo = new PDO($desc, 'hstiv', 'Satmak335');
	$error = '
<html>
	<head>
		<title>MyTasks</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-vidth, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="front/css/custom.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">	
	</head>
	<body>
		<li class="desk"><b>Введите верное значение!</b></li>
		<a href="/"><button class="button_pagination">Назад</button></a>
	</body>
</html>';
?>