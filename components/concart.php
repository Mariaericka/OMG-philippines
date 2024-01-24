<?php

$db_name = 'mysql:host=localhost;dbname=omgph1';
$user_name = 'root';
$user_password = '';

try {
    $pdo = new PDO($db_name, $user_name, $user_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

?>
