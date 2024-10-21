<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=catalogue_produits', 'root', '1234');

// Traitement du formulaire d'inscription
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Vérifier si l'email est déjà inscrit
        $query = "SELECT * FROM infolettre WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $message = "Vous êtes déjà inscrit à l'infolettre.";
        } else {
            // Inscription à l'infolettre
            $query = "INSERT INTO infolettre (email, prenom) VALUES (:email, :prenom)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':prenom', $prenom);
            if ($stmt->execute()) {
                $message = "Inscription réussie ! Vous recevrez bientôt nos nouveautés.";
            } else {
                $message = "Une erreur s'est produite. Veuillez réessayer.";
            }
        }
    } else {
        $message = "Adresse e-mail invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription à l'infolettre</title>
</head>

<?php
require "header.php";
?>


<div class="infoForm">
    <h2>INFOLETTRE</h2>
    <p>Recevez en exclusivité nos dernières nouveautés, promotions et collections en avant-première!</p>
    <form method="POST" action="">
        <label for="email">Votre adresse e-mail :</label>
        <input type="text" name="prenom" id="prenom" placeholder="Prénom">
        <input type="email" name="email" id="email" placeholder="Adresse e-mail*" required>
        <div class="checkbx">
            <input type="checkbox">
            <span> Je consens à recevoir des offres et des propositions basées sur mes préférences conformément à la Politique de confidentialité de Ricasso &copy;</span>
        </div>
         <button type="submit" class="signupBtn">S'INSCRIRE</button>
    </form>
</div>


<p><?= $message ?></p>

<?php
require "footer.php";
?>