<?php

$host = 'localhost';
$username = 'ahmed';
$password = 'toor';
$database = 'food';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Connection Failed: '.$e->getMessage();
}

?>