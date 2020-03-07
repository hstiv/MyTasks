<?php
    session_start();

    if (isset($_POST['orderbutton']))
    {
		$name = $_POST['Имя'];
		$email = $_POST['Почта'];
		$check = $_POST['Статус'];
		if ($name != '' || $email != '' || $check != '')
		{
			$content.= ' ORDER BY ';
			if ($name != '')
				$content.= ' `name` '. $name;
			if ($email != '') {
				if ($name != '')
					$content.= ', ';
				$content.= ' `email` '. $email;
			}
			if ($check != '') {
				if ($name != '' || $email != '')
					$content.= ', ';
				$content.= '  `check` '. $check;
			}
			unset($_SESSION['order_addition']);
			$_SESSION['order_addition'] = $content;
		}
		else
			$_SESSION['order_addition'] = '';
		header('Location: /?success=');
		exit();
    }
    else
        header('Location: /?error=Danger!');