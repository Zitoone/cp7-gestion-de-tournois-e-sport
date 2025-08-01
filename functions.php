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

function teamExists($pdo, $team_name) {
    $stmt = $pdo->prepare("SELECT * FROM teams WHERE name = :name");
    $stmt->execute(array(
        "name" => $team_name
    ));
    return $stmt->rowCount();
}

//Fonction avec 2 requêtes pour ajouter une team a la liste et en même temps ajouté l'utilisateur qui l'a crée en captain
function addTeam($pdo, $team_name, $user_id, $role="captain"){
    $stmt=$pdo->prepare("INSERT INTO teams(name) VALUES (:name)");
    $stmt->execute(array(
        "name"=>$team_name
    ));
// Ensuite on verifie si l'insert a fonctionné (1)
    if($stmt->rowCount()>0){
        $team_id = $pdo->lastInsertId();

        $stmt2=$pdo->prepare("INSERT INTO team_members(user_id, team_id, role_in_team) VALUES (:user_id, :team_id, :role)");
        $stmt2->execute(array(
        "user_id"=>$user_id,
        "team_id"=>$team_id,
        "role"=>$role
        ));
        return $team_id;
    }
    return false;
}

function getTeamsFromConnectedUser($pdo,$user_id){
    $stmt=$pdo->prepare("SELECT t.id, t.name FROM teams t INNER JOIN team_members tm ON t.id=tm.team_id INNER JOIN users u ON u.id=tm.user_id WHERE u.id=:id AND tm.role_in_team='captain'");
    $stmt->execute(array(
        "id"=>$user_id
    ));
    $teams = $stmt->fetchAll();
    return($teams);
}

function getUsers($pdo){
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE role='player'");
    $stmt->execute();
    $users = $stmt->fetchAll();
    return($users); 
}

function addPlayerInTeam($pdo, $user_id, $team_id){
    $stmt=$pdo->prepare("INSERT INTO team_members(user_id, team_id) VALUES (:user_id, :team_id)");
    $stmt->execute(array(
        "user_id"=>$user_id,
        "team_id"=>$team_id
    ));
    return $stmt->rowCount();
}

function getAllTeamsExceptUser($pdo, $user_id){
    $stmt=$pdo->prepare("SELECT DISTINCT t.id, t.name FROM teams t INNER JOIN team_members tm ON t.id=tm.team_id INNER JOIN users u ON u.id=tm.user_id WHERE tm.user_id!=:id");
    $stmt->execute(array(
        "id"=>$user_id
    ));
    $teams = $stmt->fetchAll();
    return($teams);
}

function getTournaments($pdo){
    $stmt=$pdo->prepare("SELECT t.id, t.name, t.game, t.description, t.start_date, t.end_date FROM tournaments t");
    $stmt->execute();
    $tournaments=$stmt->fetchAll();
    return($tournaments);
}

function addTeamInTournament($pdo, $team_id, $tournament_id){
    $stmt=$pdo->prepare("INSERT INTO registrations(team_id, tournament_id) VALUES (:team_id, :tournament_id)");
    $stmt->execute(array(
        "team_id"=>$team_id,
        "tournament_id"=>$tournament_id
    ));
    return $stmt->rowCount();
}

function addNewTournament($pdo, $name, $game, $description, $start, $end,$user_id){
    $stmt=$pdo->prepare("INSERT INTO tournaments(name, game, description, start_date, end_date, organizer_id) VALUES (:name, :game, :description, :start, :end, :organiser_id)");
    $stmt->execute(array(
        "name"=>$name,
        "game"=>$game,
        "description"=>$description,
        "start"=>$start,
        "end"=>$end,
        "organiser_id"=>$user_id
    ));
    return $stmt->rowCount();
}

function modifyTournament($pdo, $name, $game, $description, $start, $end,$user_id){
    $stmt=$pdo->prepare("UPDATE tournaments SET name=:name, game=:game, description=:description, start_date=:start, end_date=:end, organizer_id=:id");
    $stmt->execute(array(
        "name"=>$name,
        "game"=>$game,
        "description"=>$description,
        "start"=>$start,
        "end"=>$end
    ));
    return $stmt->rowCount();
}

function getTournamentById($pdo, $tournament_id){
    $stmt=$pdo->prepare("SELECT * FROM tournaments WHERE id=:id");
$stmt->execute(array(
    'id'=>$tournament_id
));
$tournament=$stmt->fetchAll();
}