<?php
session_start();
require_once "config/connect.php";
require_once "functions.php"; 

$user_id=$_SESSION["id"];
$user_role=$_SESSION["role"];
$msg="";
$IsError=false;
//Gestion du form d'ajout de team en tant que capitaine
if(!empty($_POST["submit"])){
    $team_name=$_POST["team-name"];
    if(empty($team_name)){
        $msg='<span style="color:red; font-weight:bold; font-size:120%;">Team name is required!</span>';
        $IsError=true;
    }else{
        $teamAlreadyExists=teamExists($pdo, $team_name);
        if($teamAlreadyExists){
            $msg='<span style="color:red; font-weight:bold; font-size:120%;">Team already exists</span>';
        $IsError=true;
        }
    }
    if(!$IsError){
        $lastId = addTeam($pdo, $team_name, $user_id, $role="captain");
        $msg='<span style="color:green; font-weight:bold; font-size:120%;">Your team has been created CAPTAIN ;)</span>';
    }
}
//Gestion du formulaire d'ajout de joueur dans une équipe
$msg2="";
$isError= false;
if(!empty($_POST["submit_add_player"])){
    if(empty($_POST["my-teams"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Choose a team</span>';
        $isError=true;
    }
    if(empty($_POST["players"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Choose a player</span>';
        $isError=true;
    }
    if(!$isError){
        $team_id=$_POST["my-teams"];
        $player_id=$_POST["players"];
        $request=addPlayerInTeam($pdo, $user_id, $team_id);
        if($request){
            $msg2 = '<span style="color:green; font-weight:bold; font-size:120%;">A new player is in the team!</span>';
            } else {
            $msg2 = '<span style="color:red; font-weight:bold; font-size:120%;">Something failed</span>';
        }
    }
}
// Gestion form d'ajout de l'utilisateur connecté dans une autre équipe que la sienne
$msg3="";
$isError=false;
if(!empty($_POST["submit_add"])){
    if(empty($_POST["teams"])){
    $msg3= '<span style="color:red; font-weight:bold; font-size:120%;">Choose a team</span>';
    $isError=true;
    }
    if(!$isError){
        $team_id=$_POST["teams"];
        $user_id=$_SESSION["id"];
        $request=addPlayerInTeam($pdo, $user_id, $team_id);
            if($request){
                $msg3 = '<span style="color:green; font-weight:bold; font-size:120%;">Welcome in the team!</span>';
            } else {
                $msg3 = '<span style="color:red; font-weight:bold; font-size:120%;">Something failed</span>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
</head>
<body>
    <h1>Teams</h1>
    <h2>Add a new team</h2>
    
    <form action="#" method="post">
        <label for="name">Name of your team</label>
        <input type="text" name="team-name" id="team-name">

        <input type="submit" name="submit" value="Add a team">
    </form>
    <?= $msg ?>

    <h2>Add or pull players from your team</h2>

<!--     <h3> <?= $lastTeamName ?></h3> -->
    <h3>Choose your team and player</h3>

    <form action="#" method="post">
        <label for="my-teams">Teams: </label>
        <select name="my-teams" id="my-teams">
         <option value="0">Please select your team</option>
            <?php
            $teams=getTeamsFromConnectedUser($pdo, $user_id);
            foreach($teams as $team):
// htmlspecialchars est une fonction de sécurité qui empêche un utilisateur d’injecter du code 
$team_id=htmlspecialchars($team['id']);                $teamname=htmlspecialchars($team['name']);
                echo "<option value='$team_id'>$teamname</option>";
            endforeach; ?>
        </select>
        <br>
        <br>
        <label for="players">Players: </label>
        <select name="players" id="players">
         <option value="0">Please select a player</option>
            <?php
            $users=getUsers($pdo);
            foreach($users as $user):
                $player_id=htmlspecialchars($user['id']);
                $username=htmlspecialchars($user['username']);
                echo "<option value='$user_id'>$username</option>";
            endforeach; ?>
        </select>
        <br>
        <br>
        <input type="submit" name="submit_add_player" value="Add">
        <input type="submit" name="submit_pull_player" value="Pull">
     </form>
     <?= $msg2 ?>

    <h2>Join a team</h2>
    <form action="#" method="post">
        <label for="teams">Teams: </label>
        <select name="teams" id="teams">
         <option value="0">Please select a team</option>
            <?php
            $all_teams=getAllTeamsExceptUser($pdo, $user_id);
            foreach($all_teams as $team):
                $all_team_id=htmlspecialchars($team['id']);
                $all_team_name=htmlspecialchars($team['name']);
                echo "<option value='$all_team_id'>$all_team_name</option>";
            endforeach; ?>
        </select>
            <br>
            <br>
            <input type="submit" name="submit_add" value="Join a team">
            <br>
            <?= $msg3 ?>
    </form>
    <br>
    <a href="tournaments.php">Tournaments</a>
    <br>
    <br>
    <a href="account.php">Back to your account</a>    
</body>
</html>