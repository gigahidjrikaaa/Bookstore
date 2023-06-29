<?php
    $host = '20.121.18.251';
    $port = '5432';
    $dbname = 'bookstore';
    $username = 'admin';
    $password = 'pl,okmijn';

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
