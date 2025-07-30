<?php
// Configuration de la base de données avec 4 arguments
$host = 'localhost';
$dbname = 'esports';
$username = 'masterofesport';
$password = 'sport1234';

try {
   // Création de la connexion PDO
   $pdo = new PDO(
      "mysql:host=$host;dbname=$dbname;charset=utf8",
      $username,
      $password,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
   );
} catch (PDOException $e) {
   die("Erreur de connexion : ".$e->getMessage()); // Die permet de terminer le script 
}