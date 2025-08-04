<?php
session_start();
require_once "config/connect.php";
require_once "functions.php"; 

$msg = "";
if (!empty($_POST["submit"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST['email'];
        $password = $_POST["password"];

        $user = getUser($pdo, $email);

        if ($user && password_verify($password, $user["password_hash"])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: account.php");
            exit();
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
    <br>
    <?= $msg ?>
    <br>
    <a href="register.php">Create an account</a>
</body>
</html>