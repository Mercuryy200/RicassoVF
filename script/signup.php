<?php
include 'header.php';
try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $courriel = $_POST['courriel'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO utilisateurs (nom, courriel, mot_de_passe, prenom) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nom, $courriel, $mot_de_passe, $prenom])) {
            echo "Inscription réussie !";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
} catch (PDOException $e) {
    // Display the error if the connection or query fails
    echo "Erreur de connexion ou d'exécution : " . $e->getMessage();
}
?>
<div class="signup-section">
    <form method="POST" action="" class="signupForm">
        <h2>S'INSCRIRE</h2>
        <span>Inscrivez-vous sur Ricasso.ca pour profiter de nombreux avantages:</span>
        <span class="required">Obligatoire*</span>
        <input type="text" name="prenom" id="prenom" placeholder="Prénom*" required>
        <input type="text" id="nom" name="nom" placeholder="Nom*" required>
        <input type="email" id="courriel" name="courriel" placeholder="Adresse e-mail*" required>
        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de Passe*" required>
        <div class="checkbx">
            <input type="checkbox">
            <label>Je consens à recevoir des offres et des propositions basées sur mes préférences conformément à la Politique de confidentialité de Versace.</label>
        </div>
        <button type="submit" class="signupBtn">S'INSCRIRE</button>
    </form>
</div>


<?php include 'footer.php'; ?>
