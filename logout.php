<?php
session_start();
session_unset(); // Vide les variables de session
session_destroy(); // Détruit la session
header("Location: connexion.php");
