<?php
    require('config.php');

    $id = $_GET['id'];
    $check = $_GET['check'];
    if ($check == 'checked')
        $check = '';
    else
        $check = 'checked';
	$sql = 'UPDATE `tasks` SET `check`='.$check. ' WHERE `id`='. $id;
	$query = $pdo->prepare($sql);
	$query->execute([]);

	header('Location: /');
?>