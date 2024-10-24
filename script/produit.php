<?php
require "header.php";
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


<div class="descripBox">
    <div class="galerie-images">
        <img src="../images/<?= $produit['image'] ?>" alt="<?= $produit['nom'] ?>">
        <img src="../images/unicorn.jpg" alt="unicorn">
    </div>

    <div class="description-produit">
        <div class="desc">
            <div class="mainDesc">
                <h1><?= $produit['nom'] ?></h1>
                <p>$ <?= $produit['prix'] ?></p>
            </div>
            <hr>
            <p><?= $produit['description'] ?></p>
            <hr>
            <p>COULEURS:</p>
            <div class="colors">
                <?php
                $couleurs = explode(' ', $produit['couleur']);
                foreach ($couleurs as $couleur) {
                    echo "<div class='color' id='$couleur'></div>";
                }
                ?>
            </div>
            <hr>
            <p>TAILLES:</p>
            <div class="sizes">
                <?php
                $tailles = explode(' ', $produit['taille']);
                foreach ($tailles as $taille) {
                    echo "<div class='taille'>$taille</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php
require "footer.php";
?>
