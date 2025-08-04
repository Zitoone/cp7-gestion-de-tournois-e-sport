<?php
session_start();
require_once "config/connect.php";
require_once "functions.php"; 

$user_id=$_SESSION["id"];
$user_role=$_SESSION["role"];
$msg="";
$isError= false;
if(!empty($_POST["submit_add_tournament"])){
    if(empty($_POST["my-teams"])){
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Choose a team</span>';
        $isError=true;
    }
    if(empty($_POST["tournaments"])){
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Choose a tournament</span>';
        $isError=true;
    }
    if(!$isError){
        $team_id=$_POST["my-teams"];
        $tournament_id=$_POST["tournaments"];
        $request=addTeamInTournament($pdo, $team_id, $tournament_id);
        if($request){
            $msg = '<span style="color:green; font-weight:bold; font-size:120%;">Your team is in the tournament</span>';
            } else {
            $msg = '<span style="color:red; font-weight:bold; font-size:120%;">Something failed</span>';
        }
    }
}
//Gestion du form d'ajout de nouveau tournois
$msg2="";
$isError=false;
if(!empty($_POST["submit_new_tournament"])){
    if(empty($_POST["name"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Please enter the name of the tournament</span>';
        $isError=true;
    }
        if(empty($_POST["game"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Please enter the game of the tournament</span>';
        $isError=true;
    }
        if(empty($_POST["description"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Please enter the description of the tournament</span>';
        $isError=true;
    }
        if(empty($_POST["start"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Please enter the start date of the tournament</span>';
        $isError=true;
    }
        if(empty($_POST["end"])){
        $msg2= '<span style="color:red; font-weight:bold; font-size:120%;">Please enter the end date of the tournament</span>';
        $isError=true;
    }
    if(!$isError){
        $name=$_POST["name"];
        $game=$_POST["game"];
        $description=$_POST["description"];
        $start=$_POST["start"];
        $end=$_POST["end"];
        $new_tourn=addNewTournament($pdo, $name, $game, $description, $start, $end, $user_id);
        if($new_tourn){
            $msg2 = '<span style="color:green; font-weight:bold; font-size:120%;">New tournament is added</span>';
        } else {
            $msg2 = '<span style="color:red; font-weight:bold; font-size:120%;">Something failed</span>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments</title>
</head>
<body>
    <h1>Tournaments</h1>
    <h2>List of next tournaments</h2>
    <ul>
        <?php
        $tournaments=getTournaments($pdo);
        foreach($tournaments as $tournament):?>
            <li>
                <?= $tournament['name'] ?> 
                <?php if($user_role=="organizer"):?>
            <form method="GET" action="modify_tournament.php">
                <input type="hidden" name="tournament_id" value="<?= $tournament['id'] ?>">
                <button type="submit" >Modify</button>
            </form>
            <?php endif; ?>

            <?php if($user_role=="admin"):?>
            <form method="POST" action="delete_tournament.php">
                <button type="submit" name="delete_tournament">Delete</button>
            </form>
            <?php endif; ?>
            
                <ul>
                    <li><?= $tournament['game'] ?></li>
                    <li><?= $tournament['description'] ?></li>
                    <li><?= $tournament['start_date'] ?></li>
                    <li><?= $tournament['end_date'] ?></li>
                </ul>
            </li>
        <?php endforeach; ?>   
    </ul>

    <h2>Add your team to a tournament</h2>
    <form action="#" method="post">
        <label for="my-teams">Teams: </label>
        <select name="my-teams" id="my-teams">
         <option value="0">Please select your team</option>
            <?php
            $teams=getTeamsFromConnectedUser($pdo, $user_id);
            foreach($teams as $team):
            $team_id=htmlspecialchars($team['id']);
            $teamname=htmlspecialchars($team['name']);
                echo "<option value='$team_id'>$teamname</option>";
            endforeach; ?>
        </select>
        <br>
        <br>
        <label for="tournaments">Players: </label>
        <select name="tournaments" id="tournaments">
         <option value="0">Please select a tournament</option>
            <?php
            $tournaments_select=getTournaments($pdo);
            foreach($tournaments as $tournament):
                $tournament_id=htmlspecialchars($tournament['id']);
                $tournament_name=htmlspecialchars($tournament['name']);
                echo "<option value='$tournament_id'>$tournament_name</option>";
            endforeach; ?>
        </select>
        <br>
        <br>
        <input type="submit" name="submit_add_tournament" value="Add">

     </form>
     <?= $msg ?>

<!--Sera visible si l'utilisateur a un statut d'oraganisateur -->
<?php
if($user_role=="organizer"):?>
    <h2>Add a tournament</h2>
        <form action="#" method="post">
            <label for="name">Name</label>
            <input type="name" name="name" id="name">

            <label for="game">Game</label>
            <input type="game" name="game" id="game">

            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>

            <label for="start">Start date</label>
            <input type="date" name="start" id="start">

            <label for="end">End date</label>
            <input type="date" name="end" id="end">

            <input type="submit" name="submit_new_tournament" value="Add a tournament">
    </form>
    <?= $msg2 ?>
<?php endif; ?>
    <br>
    <a href="teams.php">Teams</a>
    <br>
    <a href="account.php">Account</a>
    <br>
    <a href="logout.php">Log out</a>
</body>
</html>