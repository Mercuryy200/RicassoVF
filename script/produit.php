<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');

// Récupération de l'ID du produit depuis l'URL
$id_produit = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Récupération des détails du produit sélectionné
$query = "SELECT * FROM produits WHERE id = :id_produit";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_produit', $id_produit);
$stmt->execute();
$produit = $stmt->fetch();

// Vérification si le produit existe
if (!$produit) {
    echo "Produit introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $produit['nom'] ?></title>
</head>
<?php
require "header.php";
?>
<div class="descripBox">
    <div class="galerie-images">
        <img src="../images/<?= $produit['image'] ?>" alt="<?= $produit['nom'] ?>">

    </div>

    <div class="description-produit">
        <div class="mainDesc">
            <h1><?= $produit['nom'] ?></h1>
            <p>$ <?= $produit['prix'] ?></p>
        </div>
        <p><?= $produit['description'] ?></p>
        <p><strong>Couleurs : <?= $produit['couleur'] ?></p>
        <?php if ($produit['type'] === 'chemise'): ?>
            <p>Taille : <?= $produit['taille'] ?></p>
        <?php else: ?>
            <p>Taille : <?= $produit['taille'] ?></p>
        <?php endif; ?>
    </div>
</div>


<?php
require "footer.php";
?>
