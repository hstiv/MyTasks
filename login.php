<?php

	require 'config.php';
	if (isset($_POST['signin']))
	{
		if ($_POST['login'] == "admin" && $_POST['passwd'] == "123")
		{
			session_start();
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
		session_start();
		session_unset();
		session_destroy();
		header('Location: /?success=Успешно');
	}
	else
		header('Location: /?error=Danger!');
