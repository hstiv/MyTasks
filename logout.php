<?php
    require 'config.php';
    $sql = "DELETE FROM `admin`";
    $query = $pdo->prepare($sql);
    $query->execute([]);

    header('Location: /');
?>