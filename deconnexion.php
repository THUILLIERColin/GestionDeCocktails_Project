<?php
    //deconnexion de l utilisateur
    session_start(); //on demarre la session
    session_destroy(); //on detruit la session
    unset($_SESSION['user']); //on detruit la variable de session
    header('Location: index.php'); //on redirige vers la page d'accueil
?>