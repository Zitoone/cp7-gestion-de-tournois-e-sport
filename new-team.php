<?php
session_start();
require_once "config/connect.php";
require_once "functions.php"; 

$id=$_SESSION["id"];
$msg="";
$IsError=false;
$lastTeamName = "";


if(!empty($_POST["submit"])){
    $name=$_POST["team-name"];

    if(empty($name)){
        $msg='<span style="color:red; font-weight:bold; font-size:120%;">Team name is required!</span>';
        $IsError=true;
    }else{
        $teamAlreadyExists=teamExists($pdo, $name);
        if($teamAlreadyExists){
            $msg='<span style="color:red; font-weight:bold; font-size:120%;">Team already exists</span>';
        $IsError=true;
        }
    }
    if(!$IsError){
        $lastId = addTeam($pdo, $name);
        $lastTeamName = getTeamNameById($pdo, $lastId);
        $msg='<span style="color:green; font-weight:bold; font-size:120%;">Your team has been created</span>';
// htmlspecialchars est une fonction de sécurité qui empêche un utilisateur d’injecter du code 
/* '. htmlspecialchars($lastTeamName) .'  */
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

    <h2>Add players in my team</h2>

    <h3> <?= $lastTeamName ?></h3>

    <p>Choose your player</p>

<?php
$users=getUsers($pdo);
foreach($users as $user): ?>
   <article>
        <p>Name <?= $user["username"] ?> <button>Add</button></p> 
   </article>
<?php
endforeach; ?>


    <h2>Join a team</h2>

    
</body>
</html>