<?php
	function check_data($name, $email, $task) {
		if ($name == '' || $email == '' || $task == '') 
			return (false);
		if (!preg_match("/@/", $email))
			return (false);
		return (true);
	}

	require('config.php');

	$name = $_POST['name'];
	$email = $_POST['email'];
	$task = $_POST['task'];
	$check = "";
	if (!check_data($name, $email, $task))
		echo $error;
	else
	{
		$sql = 'INSERT INTO tasks(name, email, task) VALUES(:name,:email,:task)';
		$query = $pdo->prepare($sql);
		$query->execute(['name' => $name, 'email' => $email, 'task' => $task]);
		header('Location: /');
	}
?>