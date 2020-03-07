<?php
	function check_data($name, $email, $task) {
		if (empty($name) || empty($email) || empty($task)) {
			header("Location: /?error=Заполните все поля!&name=". $name. "&email=". $email. "&task=". $task);
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $name)) {
			header("Location: /?error=Не верные имя и почта пользователя!&task=". $task);
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: /?error=Не верная почта пользователя!&name=". $name. "task=". $task);
			exit();
		}
		else if (!preg_match("/^[a-zA-Z0-9]*/", $name)) {
			header("Location: /?error=Не верное имя пользователя!&mail=". $mail. "task=". $task);
			exit();
		}
	}

	require('config.php');

	if (isset($_POST["sendtask"])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$task = $_POST['task'];

		check_data($name, $email, $task);
		$sql = 'INSERT INTO tasks(name, email, task) VALUES(:name,:email,:task)';
		$query = $pdo->prepare($sql);
		$query->execute(['name' => $name, 'email' => $email, 'task' => $task]);
		header('Location: /?add_task_success=Успешно!');
	}
	else
		header('Location: /?error=Danger!');
