<?php
    //deconnexion de l utilisateur
<<<<<<< Updated upstream
    session_start(); // On démarre la session AVANT toute chose
    session_destroy(); // On détruit la session
    unset($_SESSION['user']); // On détruit la variable de session
    header('Location: index.php'); // On redirige le visiteur vers la page d'accueil
=======
    session_start();
    session_destroy();
    unset($_SESSION['user']);
    header('Location: index.php');
>>>>>>> Stashed changes
?>