<?php
	require 'config.php';

	$check = $_POST['check'];
	$id = $_POST['id'];
	$status_1 = intval($_POST['status_1']);
	$status_2 = $_POST['status_2'];

	if (isset($_POST["delete"]))
	{
		$sql = 'DELETE FROM `tasks` WHERE `id`=?';
		$query = $pdo->prepare($sql);
		$query->execute([$id]);
		header('Location: /?success');
	}
	else if (isset($_POST['modify']))
	{
		if (isset($_POST['task']))
		{
			if ($_POST['task'] == '') {
				header('Location: /?error=Невозможно создать пустую задачу!');
				exit();
			}
			$task = $_POST['task'];
			$sql = 'UPDATE `tasks` SET `task`=? WHERE `tasks`.`id`='. $id;
			$query = $pdo->prepare($sql);
			$t1 = $query->execute([$task]);
			header('Location: /?success=');
		}
		if ($check != $status_1)
		{
			$sql = 'UPDATE `tasks` SET `check`='. $status_1.' WHERE `tasks`.`id`=?';
			$query = $pdo->prepare($sql);
			$query->execute([$id]);
			header('Location: /?success=Checkbox!');
		}
		if ($status_2 != $modified)
		{
			$sql = 'UPDATE `tasks` SET `modified`='. $status_2. ' WHERE `tasks`.`id`='. $id;
			$query = $pdo->prepare($sql);
			$query->execute([]);
		}
	}
	header('Location: /');
