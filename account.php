<?php
session_start();
require_once "config/connect.php";
require_once "functions.php"; 

$id=$_SESSION["id"];
$msg="";

$stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id=:id");
$stmt->execute(array(
    'id' => $id
));
$user = $stmt->fetch();

if(!empty($_POST["update"])){
    $username=$_POST["username"];
    $email=$_POST["email"];
    $isUpdated=modifyAccount($pdo, $username, $email, $id);
    if($isUpdated){
        $msg='<span style="color:green; font-weight:bold; font-size:120%;">Your information has been updated.</span>';
    }else{
        $msg='<span style="color:red; font-weight:bold; font-size:120%;">Update failed</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User account</title>
</head>
<body>
    <h1>User account</h1>

<form action="?mode=edition&id=<?=$id?>" method="post">
   <label for="username">Username :</label>
   <input type="text" name="username" id="username" value="<?=$user['username'] ?>">

   <label for="email">Email : </label>
   <input type="email" name="email" id="email" value="<?=$user['email'] ?>">

   <input type="submit" name="update" value="Update info">

</form>
   <?= $msg ?>

   <br>

    <a href="connexion.php">Log out</a>
    
</body>
</html>