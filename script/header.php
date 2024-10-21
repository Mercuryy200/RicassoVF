<?php
global $pdo;
session_start(); // Assurez-vous que la session est démarrée

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['loginBtn'])) {
        header('Location: login.php');
        exit();
    }
    
    if (isset($_POST['registerBtn'])) {
        header('Location: signup.php');
        exit();
    }
}

$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');

// Vérifiez si l'utilisateur est connecté
$utilisateurConnecte = false;
$nomUtilisateur = '';
if (isset($_SESSION['utilisateur_id'])) {
    $id = $_SESSION['utilisateur_id'];
    $sql = "SELECT nom FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur) {
        $nomUtilisateur = htmlspecialchars($utilisateur['nom']);
        $utilisateurConnecte = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/aai3wtd.css">
    <script src="https://kit.fontawesome.com/565b37de03.js" crossorigin="anonymous"></script>
    <title>Rich Ricasso</title>
</head>

<body>
<div class="navbar">
    <div class="leftNav">
        <a href="index.php" class="navh1"><h1>RICASSO</h1></a>
        <a href="index.php">ACCEUIL</a>
        <a href="catalogue.php">CATALOGUE</a>
    </div>
    <div class="rightNav">
    <?php if ($utilisateurConnecte): ?>
        <a href="profile.php" class="right"><i class="fa-regular fa-user"></i></a>
    <?php else: ?>
        <a href="login.php" class="right"><i class="fa-regular fa-user"></i></a>
    <?php endif; ?>
    <a href="infolettre.php" class="right"><i class="fa-regular fa-envelope"></i></a>
    </div>
</div>
<div class="main">
