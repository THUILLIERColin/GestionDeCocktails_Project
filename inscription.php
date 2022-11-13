<?php session_start();
?>

    
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
    <meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
</head>

<body>

<header>
    <h1>Votre profil</h1>
    
</header>
<?php 


if(isset($_GET["submit"])) // le formulaire vient d'etre valide
    {
        // le formulaire est entièrement valide : sauvegarde des données
            $_SESSION['user']['login']		=$_GET["login"Ò];
            $_SESSION['user']['mdp']		=$_GET["mdp"];
            $_SESSION['user']['nom']		=$_GET["nom"];
            $_SESSION['user']['prenom']	=$_GET["prenom"];
            $_SESSION['user']['sexe']		=$_GET["sexe"];
            $_SESSION['user']['date']	=$_GET["date"];     
        
        
     }
     ?>

<form method="get" action="?page=inscription">
    login :
    <input type="text" name="login" 
        value="<?php echo (isset($_GET['login'])?$_GET['login']:''); ?>"><br />
    mot de passe :
    <input type="text" name="mdp" 
        value="<?php echo (isset($_GET['mdp'])?$_GET['mdp']:''); ?>"><br /> 
    Nom :
    <input type="text" name="nom" 
        value="<?php echo (isset($_GET['nom'])?$_GET['nom']:''); ?>"><br />
    Prénom :
    <input type="text" name="prenom"
        value="<?php echo (isset($_GET['prenom'])?$_GET['prenom']:''); ?>"><br />
    Sexe (homme ou femme ou autre) :
    <input type="text" name="prenom"
        value="<?php echo (isset($_GET['prenom'])?$_GET['prenom']:''); ?>"><br />
    Date de naissance(+18 ans):
    <input type="text" name="date"
        value="<?php echo (isset($_GET['date'])?$_GET['date']:''); ?>"><br />
    <input type="submit" name="submit" value="Valider">	   
    </form>

    <?php
    if($profilvalide)
    {
        include('index.php');
    }

    ?>
    </main>
</body>
</html>