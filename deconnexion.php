<?php
    //deconnexion de l utilisateur
    session_start(); // On démarre la session AVANT toute chose
    session_destroy(); // On détruit la session
    unset($_SESSION['user']); // On détruit la variable de session
    header('Location: index.php'); // On redirige le visiteur vers la page d'accueil
?>