<?php
session_start();
require_once "config/connect.php";
require_once "functions.php";

$msg="";
$isError=false;

//Verification du formulaire d'inscription:
if(!empty($_POST["register_submit"])){
    if(empty($_POST["username"])){
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Username is required</span>';
        $isError=true;
    }
    if(empty($_POST["email"])){
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Email is required</span>';
        $isError=true;
    }
    if(empty($_POST["password"])){
        $msg= '<span style="color:red; font-weight:bold; font-size:120%;">Password is required</span>';
        $isError=true;
    }
    if(!$isError){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $isAlreadxExists = checkIfEmailExists($pdo, $email);
        if($isAlreadxExists){
            $msg='<span style="color:red; font-weight:bold; font-size:120%;">Email already exists</span>';
            $isError=true;
        }else{
            $request=addNewUser($pdo, $username, $email, $password);
            if($request){
                $msg='<span style="color:green; font-weight:bold; font-size:120%;">Your account is create <a href="account.php">Account</a></span>';
                $isError=false;
            }else{
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
    <br>
    <a href="connexion.php">Back</a>   
</body>
</html>