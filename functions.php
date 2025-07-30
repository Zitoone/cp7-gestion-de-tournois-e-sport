<?php

function checkIfEmailExists($pdo, $email){
    $stmt=$pdo->prepare("SELECT COUNT(id) as nb FROM users WHERE email=:email");
    $stmt->execute(array(
    "email"=>$email
));
$datas=$stmt->fetch();
return($datas["nb"] >= 1) ? true : false;
} // Pour cette fonction qui vérifie si l'email existe deja dans le bdd, on prepare donc une requete avec la fonction d'agreggation COUNT qui comptera le nombre de ligne de la colonne id ou l'email est présent. Si la reponse est: 0 mail present (faux), on peut ajouter le nouvel user mais si la réponse est 1 c'est vrai alors l'email existe deja

function addNewUser($pdo, $username, $email, $password){
    $stmt=$pdo->prepare("INSERT INTO users(username, email, password_hash) VALUES (:username, :email, :password)");
    $stmt->execute(array(
        "username"=>$username,
        "email"=>$email,
        "password"=>$password
    ));
    return $stmt->rowCount();
} // Cette fonction permet d'ajouter un nouvel utilisateur à la bdd avec la requête préparée INSERT INTO users. la metholde rowCount retournera le nombre de ligne affectée par la derniere requete

/* function getPassword($pdo, $email){
    $stmt=$pdo->prepare("SELECT id, password_hash FROM users WHERE email=:email");
    $stmt->execute(array(
        "email"=>$email
    ));
    $user=$stmt->fetch();
    return($user["password_hash"]);
}  */

function getUser($pdo, $email){
    $stmt = $pdo->prepare("SELECT id, username, email, password_hash FROM users WHERE email = :email");
    $stmt->execute([
        "email" => $email
    ]);
    $user = $stmt->fetch();
    return($user); 
} // Cette fonction permet de retourner l'id et le mdp haché stocké dans la base de données.

function modifyAccount($pdo, $username, $email, $id){
    $stmt = $pdo->prepare("UPDATE users SET username=:username, email=:email WHERE id=:id");
    $stmt->execute(array(
        "username"=>$username,
        "email"=>$email,
        "id"=>$id
    ));
    return $stmt->rowCount();
}
