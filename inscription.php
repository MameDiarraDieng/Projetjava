<?php
    $host = 'localhost';
    $dbname = 'projetjava';
    $username = 'root';
    $db = new mysqli($host,$username,'',$dbname);
    if($db->connect_error){
         die("Connection échouée");
    }

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $enregistrement = "SELECT * FROM Clients WHERE username='$username' AND password='$password'";
            $result = $db->query($enregistrement);
            
            if ($result === false) {
                die("Erreur d'exécution de la requête : " . $db->error);
            }

            if ($result->num_rows > 0) {
                $message = "Vous possédez déjà un compte.";
            } else {
                $insert_query = "INSERT INTO Clients (username, password) VALUES ('$username', '$password')";
                $insert_result = $db->query($insert_query);

                if ($insert_result === true) {
                    header("Location: Connection.php");
                } else {
                    $message = "Erreur lors de la création du compte : " . $db->error;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Connexion.css">
    <title>Inscription</title>
</head>
<body> 
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Inscription</h1> 
        <?php 
            if (isset($message) && $message != "") { 
                echo "<span style=\"color: red;\">$message</span>";
            } 
        ?>
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="S'inscrire">
        Vous avez deja un compte?
        <a href="Connection.php">Connectez vous</a><br>
    </form>
</body>
</html>
