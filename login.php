<?php

	require 'config.php';
	
	if ($_POST['login'] == "admin" && $_POST['passwd'] == "123")
	{
		$admin = "1";
		$sql = 'INSERT INTO admin(admin) VALUE(:admin)';
		$query = $pdo->prepare($sql);
		$query->execute(['admin' => $admin]);
	}
	else
	{
		echo $error;
		exit();
	}
	header('Location:/');
?>