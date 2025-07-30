<?php
session_start(); // On utilise les sessions ici pour que le navigateur enregistre certaines informations sur le navigateur
require_once "config/connect.php";
require_once "functions.php"; 

$msg = "";
// Je commence par une nouvelle vérification de ce nouveau formulaire, si les 2 champs sont remplis on récupère les données envoyées dont le mdp
if (!empty($_POST["submit"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST['email'];
        $password = $_POST["password"];

        $user = getUser($pdo, $email); // on appelle la fonction qui permettra de récupérer l'id et le mdp haché

        if ($user && password_verify($password, $user["password_hash"])) { //Ici on verifie que l'utilisateur existe et on utilise une fonction (native) qui vérifie si les mots de passe correspondent, si c'est le cas on enregistre l'ID dans les sessions et on est envoyé sur la page du compte (sinon on a un msg d'erreur)
            $_SESSION['id'] = $user['id'];
            header("Location: account.php");
            exit();   // pour arrêter le script après redirection
        } else {
            $msg = '<span style="color:red; font-weight:bold; font-size:120%;">Username and password are not correct</span>';
        }
    } else {
        $msg = '<span style="color:red; font-weight:bold; font-size:120%;">Please enter your username and password</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    
    <form method="post">       
        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" name="submit" value="Submit">
    </form>
    <?= $msg ?>
</body>
</html>