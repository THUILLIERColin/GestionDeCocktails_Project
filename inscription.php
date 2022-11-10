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
$profilvalide=false;
$nomvalide=false;
$loginvalide=false;
$mdpvalide=false;
$prenomvalide=false;
$datevalide=false;
$sexevalide=false;

if(preg_match("^([A-Z]*[a-z]*(\-)*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+))*)*$",$_GET["nom"])){
    $nomvalide;
}
else{
    echo 'le nom est pas bien écrit' 
}

if(preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["prenom"])){
    $prenomvalide;
}
else{
    echo 'le prenom est pas bien écrit' 
}

if(preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["login"])){
    $loginvalide;
}
else{
    echo 'le nom est pas bien écrit' 
}

if(preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["mdp"])){
    $mdpvalide ;
}
else{
    echo 'le nom est pas bien écrit' 
}



if(preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["sexe"])){
    $sexevalide;
}
else{
    echo 'le nom est pas bien écrit' 
}

if(preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["date"])){
    $datevalide;
}
else{
    echo 'le nom est pas bien écrit' 
}

if(isset($_GET["submit"])) // le formulaire vient d'etre valide
    {
        if ($profilvalide 
        && $profilvalide
        && $nomvalide
        && $loginvalide
        && $mdpvalide
        && $prenomvalide
        && $datevalide
        && $sexevalide)
        { // le formulaire est entièrement valide : sauvegarde des données
            $_SESSION['user']['login']		=$_GET["login"Ò];
            $_SESSION['user']['mdp']		=$_GET["mdp"];
            $_SESSION['user']['nom']		=$_GET["nom"];
            $_SESSION['user']['prenom']	=$_GET["prenom"];
            $_SESSION['user']['sexe']		=$_GET["sexe"];
            $_SESSION['user']['date']	=$_GET["date"];     
            $profilvalide=true;
        }
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
    <input type="radio" name="sexe" value="f"/> une femme 
    <input type="radio" name="sexe" value="h"/> un homme
    <input type="radio" name="sexe" value="h"/> autre
        value="<?php echo (isset($_GET['sexe'])?$_GET['sexe']:''); ?>"><br />
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