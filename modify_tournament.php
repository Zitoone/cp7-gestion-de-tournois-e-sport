<?php
session_start();
require_once "config/connect.php";
require_once "functions.php";

$tournament=null;
$msg="";
//Si l'id du tournois existe dans l'URL grace a la methode GET envoyer dans le formulaire de la page tournois, alors on peut envoyer l'id du tournois dans la fonction qui recupère les infos du tournois
if (isset($_GET['tournament_id'])) {
    $tournament_id=$_GET['tournament_id'];
    $tournament = getTournamentById($pdo, $tournament_id);
//Gestion du form de modification du tournois, avec la fonction de modofication des infos du tournois
    if(!empty($_POST["submit_modify_tournament"])){
        $name=$_POST["name"];
        $game=$_POST["game"];
        $description=$_POST["description"];
        $start=$_POST["start"];
        $end=$_POST["end"];
        $user_id=$_SESSION["id"];
        $isUpdated=modifyTournament($pdo, $name, $game, $description, $start, $end,$user_id,$tournament_id);
        if($isUpdated){
            $msg='<span style="color:green; font-weight:bold; font-size:120%;">Tournament has been updated.</span>';
        }else{
            $msg='<span style="color:red; font-weight:bold; font-size:120%;">Update failed</span>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify tournament</title>
</head>
<body>
    <h1>Modify your tournament</h1>
    
    <?php if($tournament): ?>
        <form action="#" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name-modify" value="<?= $tournament['name'] ?>">

            <label for="game">Game</label>
            <input type="text" name="game" id="game-modify" value="<?= $tournament['game'] ?>">

            <label for="description">Description</label>
            <textarea name="description" id="description-modify"><?= $tournament['description'] ?></textarea>


            <label for="start">Start date</label>
            <input type="date" name="start" id="start-modify" value="<?= $tournament['start_date'] ?>">

            <label for="end">End date</label>
            <input type="date" name="end" id="end-modify" value="<?= $tournament['end_date'] ?>">

        <input type="submit" name="submit_modify_tournament" value="Modify your tournament">
    </form>
    <?= $msg ?>
    <?php endif; ?>
    
</body>
</html>