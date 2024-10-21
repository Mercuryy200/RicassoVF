<?php
$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');
session_start();
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courriel = $_POST['courriel'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs WHERE courriel = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$courriel]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $message= "Connexion réussie !";
        header("Location: profile.php");
        exit();
    } else {
        $message = "Identifiants invalides.";
    }
}
?>
<div class="login-main-section">
    <div class="loginCont">
        <form action="" method="POST" class="connexion">
            <h2>CONNEXION</h2>
            <span class="required">Obligatoire*</span>
            <input type="email" id="courriel" name="courriel" placeholder="Adresse e-mail*" required>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe*" required>
            <div class="afficherMDP">
                <input type="checkbox" name="chkbx" id="chkbx" onclick="passwordVisibility()">
                <span>Afficher Mot de passe</span>
            </div>
            <input type="submit" value="CONNEXION">
        </form>
    </div>
    <hr>
    <div class="signupCont">
        <h2>CRÉER UN COMPTE</h2>
        <p>Inscrivez-vous sur Ricasso.ca pour profiter de nombreux avantages:</p>
        <div class="avantages">
            <ul class="benefits">
                <li><i class="fa-regular fa-envelope"></i> Découvrir les dernières actualités et offres exclusive</li>
                <li><i class="fa-solid fa-bag-shopping"></i> Consulter l'historique de vos commandes et les adresses enregistrées</li>
                <li><i class="fa-regular fa-heart"></i> Enregistrer des articles dans votre WishList</li>
                <li><i class="fa-regular fa-credit-card"></i> Paiement plus rapide</li>
            </ul>
        </div>
        <a href="signup.php">
            <button class="signupBtn">S'INSCRIRE</button>
        </a>
    </div>

</div>
<script>
    function passwordVisibility() {
        var x = document.getElementById("mot_de_passe");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php include 'footer.php'; ?>
