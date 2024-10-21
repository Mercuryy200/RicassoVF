<?php
$host = 'localhost';
$dbname = 'catalogue_produits';
$username = 'root'; // Changez cela selon votre configuration
$password = '1234'; // Changez cela selon votre configuration

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

