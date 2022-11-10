<?php session_start();
    include("donnees.inc.php"); 
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
   <button onclick="window.location.href = '?page='">Navigation</button>
   <button onclick="window.location.href = '?page=rubrique&nom=fav'">Recette coeur</button>
   <button onclick="window.location.href = 'inscription.php'">Profil</button>


</header>

    <nav>
        <?php include("navigation.php"); ?>
    </nav>
    <main>
     <?php if(isset($_GET['nom'])){
         include("recetteFav.php");
          }
        else{
         include("recette.php");
        }
           ?>
    </main>
</body>
</html>