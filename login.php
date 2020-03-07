<?php
	session_start();
	
	require 'config.php';

	if (isset($_POST['signin']))
	{
		if ($_POST['login'] == "admin" && $_POST['passwd'] == "123")
		{
			$_SESSION["admin"] = 1;
			header("Location: /?success=Успешно");
		}
		else
		{
			header("Location: /?error=Не верный логин или пароль");
			exit();
		}
	}
	else if (isset($_POST['signout']))
	{
		if ($_SESSION['admin'] == 0) {
			header('Location: /');
			exit();
		}
		$_SESSION["admin"] = 0;
		session_destroy();
		header('Location: /?success=Успешно');
	}
	else
		header('Location: /?error=Danger!');
