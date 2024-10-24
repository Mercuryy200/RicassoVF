<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
return $pdo;

