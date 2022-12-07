<?php session_start();
    include_once("donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include_once("functions.php"); 
    include_once('donneeFav.php')?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
</head>

<body>
    <?php
    if(!isset($_GET['chemin']) || $_GET['chemin'] == null) {
        // Si la variable n'est pas initialiser ou vide on la met sur Aliment
        $_GET['chemin']='Aliment';
        $chemin = array( 0 => 'Aliment');
    }
    else{
        // On explose la variable chemin pour pouvoir la parcourir plus facilement
        $chemin = explode(',', $_GET['chemin']);
        // $chemin = preg_split("/,+/",$_GET['chemin']);
    }

    /* 
    * Verifie si le fichier existe si oui il l'inclu, si non il le crée 
    * Le fichier contiendra un tableau
    * Le tableau contiendra les recettes qui match avec la catégorie
    */
    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie();
    }
    else {
        include_once('initialisation.inc.php');
    }
    
    ?>

<header>
    <h1>Bienvenue sur le site de cockails ok 4</h1>
</header>

    <div id="entete">
        <button onclick="window.location.href = '?page=Accueil&chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=RecettesFavorites&nom=fav'">Recette coeur</button>
        <?php //a verifier ?>
        <?php if(!empty($_SESSION['user']['login'])):?>
            <?php echo $_SESSION['user']['login']; ?>
            <button onclick="window.location.href = '?page=Profil'">Profil</button>
            <a href="deconnexion.php"><button>se déconnecter</button></a>
        <?php else: ?>
                    <form method="post" action="#">
                    login :
                    <input type="text" name="login" placeholder="login" required="required" 
                        value="<?php echo (isset($_POST['login'])?$_POST['login']:''); ?>" />
        
                    mot de passe :
                    <input type="password" name="mdp" placeholder="mot de passe" required="required"
                        value="<?php echo (isset($_POST['mdp'])?$_POST['mdp']:''); ?>" /> 
                    <input type="submit" name="connexion" value="connexion" />
                    </form>
                    <?php 
                    if (isset($_POST['connexion'])){
                        //verification si le user existe grace au nom du fichier
                        $_SESSION['user']['login']	=$_POST["login"];
                        $_SESSION['user']['mdp']	=$_POST["mdp"];
                        if (file_exists("DonneesUtilisateur/".$_SESSION['user']['login'].".txt"))
                        {
                            //ouverture du fichier
                            $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
                            //lecture du fichier
                            $ligne = fgets($fichier);
                            //fermeture du fichier
                            fclose($fichier);
                            //decoupage de la ligne
                            $tab = explode("&", $ligne);
                            //verification du mot de passe
                            $tab1 = explode("=", $ligne);
                            if ($tab1[1] == $_POST["mdp"])
                            {
                                //si le mot de passe est bon on ouvre la session
                                $_SESSION['login'] = $_POST["login"];
                                //on redirige vers la page d'accueil
                                header("Location: index.php");
                            }
                            else
                            {
                                //si le mot de passe est mauvais on affiche un message d'erreur
                                echo "Mot de passe incorrect";
                            }
                        }
                        else
                        {
                            //si le nom d'utilisateur n'existe pas on affiche un message d'erreur
                            echo "Nom d'utilisateur incorrect";
                        }
                    }
                    ?>
                    
                    <button onclick="window.location.href = '?page=Inscription'">s'inscrire</button>
        <?php endif; ?>
        
        <form method="post" action="">
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
    </div>

    <nav>
        <?php include("navigation.php"); ?>
    </nav>
    <main>

      <script>
      function fav(numeroDeRecette){  
        if(document.getElementById(numeroDeRecette).value=="🖤"){           //on change les emoji si besoins
            document.getElementById(numeroDeRecette).value ="❤️";
        }else{
            document.getElementById(numeroDeRecette).value ="🖤";
        }
        $.ajax({
            url:"actionFav.php",    
            type: "post",    
            data:{"num" : numeroDeRecette}
        });
      }
      </script>
        
<?php
        if(isset($_GET['page'])){
            if($_GET['page']=='Accueil'){
                include("affichageRecettesSynthetique.php"); 
            }
            if($_GET['page']=='Profil'){
                include("sonProfil.php");
            }
            if($_GET['page']=='Inscription'){
                include("inscription.php");
            }
            if($_GET['page']==='RecetteDetaillee'){
                include("affichageRecetteDetaillee.php");
            }
            if($_GET['page']==='RecettesFavorites'){
                include("affichageRecettesFav.php");
            }
        }
        else{
            include("affichageRecettesSynthetique.php");
        }?>
    </main>
</body>
</html>