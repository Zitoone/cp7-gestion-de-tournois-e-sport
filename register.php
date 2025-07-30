<?php
require_once "config/connect.php";
require_once "functions.php";  //On commence par inserer a ce fichier le fichier de connexion a la bdd et celui des fonctions

$msg=""; // j'initialise le msg informatif que j'introduis sous le formulaire dans le HTML
$isError=false; // Je crée une variable booléene initialisée a FAUX pour les éventuelles erreurs

//Verification du formulaire d'inscription:

if(!empty($_POST["register_submit"])){ // Si le formulaire nommé register_submit n'est pas vide
    if(empty($_POST["username"])){ // Si la case username est vide alors le msg informatif apparait et l'erreur est VRAIE
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Username is required</span>';
        $isError=true;
    }
    if(empty($_POST["email"])){ // Pareil avec la case email
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Email is required</span>';
        $isError=true;
    }
    if(empty($_POST["password"])){ // Pareil avec la case mot de passe
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Password is required</span>';
        $isError=true;
    }
    if(!$isError){ // Si l'erreur est finalement FAUSSE et que tous les champs sont OK alors on peut récupérer les infos avec la methode POST
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // On utilise ici la fonctions de hachage de mot de passe avec la constante DEFAULT qui utilise l'algorithme bcrypt, il faut donc bien s'assurer que le type de resultat qui sera stocké dans la bdd a bien une longueur de 255 caractères

        $isAlreadxExists = checkIfEmailExists($pdo, $email); // On crée une variable qui retournera la réponse de notre fonction qui permet de vérifier si l'email existe deja dans la bdd (voir fonction : 0 Faux ou 1 Vrai)
        if($isAlreadxExists){ // Si c'est vrai (1), un msg apparait et l'erreur est a VRAIE
            $msg='<span style="color:red; font-weight:bold; font-size:120%;">Email already exists</span>';
            $isError=true;
        }else{ //Si c'est faux, on peut ajouter le nouvel utilisateur a la bdd avec une nouvelle fonction
            $request=addNewUser($pdo, $username, $email, $password);
            if($request){ // si la requete de la fonction s'est bien passée on a un msg de confirmation
                $msg='<span style="color:green; font-weight:bold; font-size:120%;">Your account is create</span>';
                $isError=false;
            }else{ // sinon un msg d'erreur
                $msg='<span style="color:red; font-weight:bold; font-size:120%;">Registration failed</span>';
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
</head>
<body>
    <h1>New inscription</h1>

<form action="#" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <input type="submit" name="register_submit" value="Create new player account">
    </form>  

    <?= $msg ?>
    
</body>
</html>