<?php
session_start();
session_unset(); // Fonction qui vide les variables de session
session_destroy(); // Détruit la session
header("Location: connexion.php");
