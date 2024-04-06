<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'projetjava';
    $username = 'root';

    // Se connecter à la base de données
    $db = new mysqli($host, $username, '', $dbname);
    if ($db->connect_error) {
        die("Connection échouée");
    }

    if (isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {
        // Prendre les informations à partir du formulaire de connexion
        $username = $_REQUEST["username"];
        $password = $_REQUEST["password"];

        // Écrire la requête
        $enregistrement = "SELECT * FROM Clients WHERE username='$username' AND password='$password'";

        // Exécuter la requête
        $result = $db->query($enregistrement);

        // Vérifier si la requête est bien exécutée
        if ($result === false) {
            die("Erreur d'exécution de la requête : " . $db->error);
        }

        // Vérifier si l'utilisateur est dans la base de données
        if ($result->num_rows > 0) {
            // Si oui, rediriger vers la page Timeline
            header("Location: Timeline.html");
            exit(); // Arrêter l'exécution du script après la redirection
        } else {
            // Sinon, afficher un message d'erreur
            $message = "Nom d'utilisateur ou mot de passe érronés";
        }
    }
} else {
    $message = ""; // Effacer le message si la méthode de requête n'est pas POST
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Connexion.css">
    <title>Connexion</title>
</head>
<body> 
    <form action="Connection.php" method="post">
        <h1>Connexion</h1> 
        <?php 
            if (isset($message)) { 
                echo "<span style=\"color: red;\">$message</span>";
            } 
        ?>

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Se connecter">
        Pas de compte?
        <a href="inscription.php">Inscrivez vous</a><br>
    </form>
</body>
</html>
