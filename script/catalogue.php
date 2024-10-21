<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');

// Récupération des filtres
$type = isset($_GET['type']) ? $_GET['type'] : '';
$taille = isset($_GET['taille']) ? $_GET['taille'] : '';
$couleur = isset($_GET['couleur']) ? $_GET['couleur'] : '';
$prix_min = isset($_GET['prix_min']) ? $_GET['prix_min'] : 0;
$prix_max = isset($_GET['prix_max']) ? $_GET['prix_max'] : 9999;

// Construction de la requête avec les filtres
$query = "SELECT * FROM produits WHERE 1=1";
if ($type) {
    $query .= " AND type = :type";
}
if ($taille) {
    $taille = "%$taille%";
    $query .= " AND taille LIKE :taille";
}
if ($couleur) {
    $couleur = "%$couleur%";
    $query .= " AND couleur LIKE :couleur";
}
$query .= " AND prix BETWEEN :prix_min AND :prix_max";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':prix_min', $prix_min);
$stmt->bindParam(':prix_max', $prix_max);
if ($type) {
    $stmt->bindParam(':type', $type);
}
if ($taille) {
    $stmt->bindParam(':taille', $taille);
}
if ($couleur) {
    $stmt->bindParam(':couleur', $couleur);
}
$stmt->execute();
$produits = $stmt->fetchAll();
?>

<?php
require "header.php";
?>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <form class='filterForm' method="GET" action="catalogue.php">
        <h3>FILTER</h3>
        <label for="type">TYPE :</label>
        <select name="type" id="type">
            <option value="">TOUS</option>
            <option value="cravate">CRAVATES</option>
            <option value="chemise">CHEMISES</option>
        </select>
        <label for="taille">TAILLE :</label>
        <select name="taille" id="taille">
            <option value="">TOUTES</option>
            <option value="O/S">O/S</option>
            <?php for ($i = 44; $i <= 56; $i += 2): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <label for="couleur">COULEUR :</label>
        <input type="text" name="couleur" id="couleur">
        <label for="prix_min">PRIX MIN :</label>
        <input type="number" name="prix_min" id="prix_min" value="0">
        <label for="prix_max">PRIX MAX :</label>
        <input type="number" name="prix_max" id="prix_max" value="9999">
        <button type="submit" class="filterBtn">FILTRER</button>
    </form>
</div>
<div class="overlay" id="myOverlay" onclick="closeSidebar()"></div>
<hr>
<div class="sort">
    <h3>PRODUIT</h3>
    <a href="">Afficher Tous</a>
    <a href="">Chemises</a>
    <a href="">Cravates</a>
</div>
<hr>
<div class="filterSort">
    <span class='filter' style="cursor:pointer" onclick="openNav()"><i class="fa-solid fa-filter"></i> Filters</span>
</div>
<hr>
<div class="products">
    <?php foreach ($produits as $produit):
        echo "
    <a href='produit.php?id={$produit['id']}' class='product' id='{$produit['id']}'>
    <div class='productBox' id='{$produit['id']}'>
        <img src='../images/${produit['image']}' alt='produit{$produit['nom']}'>
        <h3>{$produit['nom']}</h3>
        <div class='prix'>$ {$produit['prix']}</div>
        </div>
        </a>";
    endforeach;
    ?>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("myOverlay").classList.add("active");
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("myOverlay").classList.remove("active");
    }
</script>

<?php
require "footer.php";
?>