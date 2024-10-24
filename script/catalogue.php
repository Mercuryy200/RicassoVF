<?php
require "header.php";

// Récupération des filtres
$type = isset($_GET['type']) ? array_filter($_GET['type']) : [];
$taille = isset($_GET['taille']) ? array_filter($_GET['taille'] ): [];
$couleur = isset($_GET['couleur']) ? array_filter($_GET['couleur']) : [];
$prix_min = isset($_GET['prix_min']) ? $_GET['prix_min'] : 0;
$prix_max = isset($_GET['prix_max']) ? $_GET['prix_max'] : 9999;

// Construction de la requête avec les filtres
$query = "SELECT * FROM produits WHERE 1=1";
if (!empty($type)) {
    $placeholders = implode(',', array_fill(0, count($type), '?'));
    $query .= " AND type IN ($placeholders)";
}
if (!empty($taille)) {
    foreach ($taille as $key => $size) {
        $query .= " AND taille LIKE ?";
        $taille[$key] = "%$size %";
    }
}
if (!empty($couleur)) {
    foreach ($couleur as $key => $color) {
        $query .= " AND couleur LIKE ?";
        $couleur[$key] = "%$color %";
    }
}
$query .= " AND prix BETWEEN ? AND ?";

$stmt = $pdo->prepare($query);
$i = 1;
foreach ($type as $value) {
    $stmt->bindValue($i++, $value);
}

foreach ($taille as $value) {
    $stmt->bindValue($i++, $value);
}

foreach ($couleur as $value) {
    $stmt->bindValue($i++, $value);
}

$stmt->bindValue($i++, $prix_min, PDO::PARAM_INT);
$stmt->bindValue($i++, $prix_max, PDO::PARAM_INT);


$stmt->execute();
$produits = $stmt->fetchAll();
?>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <form class='filterForm' method="GET" action="catalogue.php">
        <h3>FILTER</h3>
        <label for="type">TYPE :</label>
        <div class="typeChkbx">
            <input type="checkbox" name="type[]" id="chemise" value="chemise">
            <label for="chemise">CHEMISE</label>
            <br>
            <input type="checkbox" name="type[]" id="cravate" value="cravate">
            <label for="cravate">CRAVATE</label>
        </div>
        <label for="taille">TAILLE :</label>
        <div class="tailleChkbx">
            <input type="checkbox" name="taille[]" id="O/S" value="O/S">
            <label for="O/S">O/S</label>
            <br>
            <?php for($i = 44; $i <= 56; $i += 2){
                echo "<input type='checkbox' name='taille[]' id='{$i}' value='{$i}'><label for='{$i}'>{$i}</label><br>";
            }
            ?>
        </div>
        <label for="couleur">COULEUR :</label>
        <div class="couleurChkbx">
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Rose" id="rose">
                <div class="filterColor" id="Rose"></div>
                <label for="rose">Rose</label>
            </div>
             <div class="clrBox">
                 <input type="checkbox" name="couleur[]" value="Bleu" id="Bleu">
                 <div class="filterColor" id="Bleu"></div>
                 <label for="bleu">Bleu</label>
            </div>
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Noir" id="Noir">
                <div class="filterColor" id="Noir"></div>
                <label for="noir">Noir</label>
            </div>
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Blanc" id="Blanc">
                <div class="filterColor"></div>
                <label for="Blanc">Blanc</label>
            </div>
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Mauve" id="Mauve">
                <div class="filterColor" id="Mauve"></div>
                <label for="Mauve">Mauve</label>
            </div>
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Vert" id="Vert">
                <div class="filterColor" id="Vert"></div>
                <label for="Vert">Vert</label>
            </div>
            <div class="clrBox">
                <input type="checkbox" name="couleur[]" value="Jaune" id="Jaune">
                <div class="filterColor" id="Jaune"></div>
                <label for="Jaune">Jaune</label>
            </div>
        </div>
        <label for="prix_min">PRIX MIN :</label>
        <input type="number" name="prix_min" id="prix_min" value="0">
        <label for="prix_max">PRIX MAX :</label>
        <input type="number" name="prix_max" id="prix_max" value="9999">
        <button type="submit" class="filterBtn">FILTRER</button>
    </form>
</div>
<div class="overlay" id="myOverlay" onclick="closeNav()"></div>
<hr>
<div class="sort">
    <h3>PRODUIT</h3>
    <a href="catalogue.php">Afficher Tous</a>
    <a href="catalogue.php?type%5B%5D=chemise">Chemises</a>
    <a href="catalogue.php?type%5B%5D=cravate">Cravates</a>
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
        <img src='../images/{$produit['image']}' alt='produit{$produit['nom']}'>
        <h3>{$produit['nom']}</h3>
        <div class='prix'>$ {$produit['prix']}</div>
        </div>
        </a>";
    endforeach;
    ?>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
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