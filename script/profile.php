<?php
include 'header.php';
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}
$message1 = '';
$message2 = '';
$error = '';
$id = $_SESSION['utilisateur_id'];
$sql = "SELECT * FROM utilisateurs WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_info'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $courriel = $_POST['courriel'];

        $sql = "UPDATE utilisateurs SET nom = ?, courriel = ?, prenom = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $courriel, $prenom, $id]);
        $message1 = "Informations mises à jour !";
    }

    if (isset($_POST['update_password'])) {
        $mdpActuel = $_POST['passActuel'];
        $nouvMdp = $_POST['nouvPass'];

        if (password_verify($mdpActuel, $utilisateur['mot_de_passe'])) {
            if (!password_verify($nouvMdp, $utilisateur['mot_de_passe'])) {
                $hashedPassword = password_hash($nouvMdp, PASSWORD_DEFAULT);
                $sql = "UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$hashedPassword, $id]);
                $message2 = "Mot de passe mis à jour !";
            } else {
                $error = "Votre nouveau mot de passe est identique à l'ancien !";
            }
        } else {
            $error = "Le mot de passe actuel est incorrect !";
        }
    }
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
                <li><?php echo htmlspecialchars($utilisateur['prenom']) . " " . htmlspecialchars($utilisateur['nom']); ?></li>
                <li><?php echo htmlspecialchars($utilisateur['courriel']) ?></li>
            </ul>
            <button onclick="modifyForm1()" class="btnNoStyle">Modifier</button>
        </div>

        <h4>MODIFIER LE MOT DE PASSE</h4>
        <div class="infoMdp">
            <button onclick="modifyForm2()" class="btnNoStyle"><i class="fa-regular fa-pen-to-square"></i> Modifier le mot de passe</button>
        </div>
    </div>

    <div class="modifyUser" id="modifyUser">
        <?php if (empty($message1)): ?>
            <h4>MODIFIER LES INFORMATIONS PERSONNELLES</h4>
            <form method="POST" action="" class="userForm">
                <input type="hidden" name="update_info" value="1">
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>" required>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($utilisateur['nom']); ?>" required>
                <input type="email" id="courriel" name="courriel" value="<?php echo htmlspecialchars($utilisateur['courriel']); ?>" required>
                <button type="submit">ENREGISTRER LES MODIFICATION</button>
            </form>
            <button onclick="fermerForm1()" class="btnNoStyle">Annuler</button>
        <?php else: echo $message1; endif; ?>
    </div>

    <div class="modifyPass" id="modifyPass">
        <?php if (empty($message2)): ?>
        <h4>MODIFIER LE MOT DE PASSE</h4>
        <form method="POST" action="" class="userForm">
            <input type="hidden" name="update_password" value="1">
            <span class="required">Obligatoire*</span>
            <input type="password" id="passActuel" name="passActuel" placeholder="Mot de passe actuel*" required>
            <input type="password" id="nouveauPass" name="nouvPass" placeholder="Nouveau mot de passe*" required>
            <div class="afficherMDP">
                <input type="checkbox" name="chkbx" id="chkbx" onclick="passwordVisibility()">
                <span>Afficher Mot de passe</span>
            </div>
            <button type="submit">ENREGISTRER LES MODIFICATION</button>
            <?php  echo $error ?>
        </form>
        <button onclick="fermerForm2()" class="btnNoStyle">Annuler</button>
        <?php else: echo $message2; endif; ?>
    </div>
</div>

<script>
    function modifyForm1() {
        document.getElementById("modifyUser").style.display = "flex";
    }

    function modifyForm2() {
        document.getElementById("modifyPass").style.display = "flex";
    }

    function fermerForm1() {
        document.getElementById("modifyUser").style.display = "none";
    }

    function fermerForm2() {
        document.getElementById("modifyPass").style.display = "none";
    }
    function passwordVisibility() {
        var x = document.getElementById("passActuel");
        var y = document.getElementById("nouveauPass");
        if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
    }
</script>

<?php include 'footer.php'; ?>
