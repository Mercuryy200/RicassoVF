<?php
$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');
session_start();
include 'header.php';

if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['utilisateur_id'];
$sql = "SELECT * FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $courriel = $_POST['courriel'];
    $sql = "UPDATE utilisateurs SET nom = ?, courriel = ?, prenom = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $courriel, $prenom, $id]);
    echo "Informations mises à jour !";
}
?>
<div class="userHeader">
    <h2>Bienvenue <?php echo htmlspecialchars($utilisateur['prenom'])?>,</h2>
    <a href="logout.php">Déconnexion</a>
</div>
<div class="user">
    <div class="userLeft">
        <h3>Compte</h3>
        <h4>INFORMATIONS PERSONNELLES</h4>
        <div class="infoPerso">
            <ul class="infoPersoList">
                <li>
                    <?php echo htmlspecialchars($utilisateur['prenom']) . " " . htmlspecialchars($utilisateur['nom']); ?>
                </li>
                <li>
                    <?php echo htmlspecialchars($utilisateur['courriel']) ?>
                </li>
            </ul>
            <button onclick="modifyForm()" class="btnNoStyle">Modifier</button>
        </div>
        <h4>MODIFIER LE MOT DE PASSE</h4>
        <div class="infoMdp">
            <button onclick="modifyForm()" class="btnNoStyle"><i class="fa-regular fa-pen-to-square"></i> Modifier le mot de passe</button>
        </div>
    </div>
    <div class="modifyUser" id="modifyUser">
        <h4>MODIFIER LES INFORMATIONS PERSONNELLES</h4>
        <form method="POST" action="" class="userForm">
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>" required>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($utilisateur['nom']); ?>" required>
            <input type="email" id="courriel" name="courriel" value="<?php echo htmlspecialchars($utilisateur['courriel']); ?>" required>
            <button type="submit">ENREGISTRER LES MODIFICATION</button>
        </form>
        <button onclick="fermerForm()" class="btnNoStyle">Annuler</button>
    </div>
</div>
<script>
    function modifyForm(){
        document.getElementById("modifyUser").style = "display:flex;";
    }
    function fermerForm(){
        document.getElementById("modifyUser").style= "display: none;"
    }
</script>

<?php include 'footer.php'; ?>
