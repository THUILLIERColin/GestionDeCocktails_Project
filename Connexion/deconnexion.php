<?php
    //deconnexion de l utilisateur
    session_start();
    session_destroy();
    unset($_SESSION['user']);
    header('Location: ../index.php');
?>