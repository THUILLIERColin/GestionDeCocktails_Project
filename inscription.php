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
son nom, prénom, sexe (homme ou femme) et sa date de naissance
<form method="get" action="?page=inscription">
    Nom :
    <input type="text" name="nom" 
        value="<?php echo (isset($_GET['nom'])?$_GET['nom']:''); ?>"><br />
    Prénom :
    <input type="text" name="prenom"
        value="<?php echo (isset($_GET['prenom'])?$_GET['prenom']:''); ?>"><br />
    Sexe (homme ou femme) :
    <input type="text" name="sexe"
        value="<?php echo (isset($_GET['sexe'])?$_GET['sexe']:''); ?>"><br />
    Date de naissance:
    <input type="text" name="date"
        value="<?php echo (isset($_GET['date'])?$_GET['date']:''); ?>"><br />
    <input type="submit" name="submit" value="Valider">	   
    </form>
    </main>
</body>
</html>