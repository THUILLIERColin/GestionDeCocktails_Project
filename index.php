<?php session_start();
if(!isset($_SESSION["favTemp"])){
    $_SESSION["favTemp"]= array();
}
    include("Donnees/Donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include("functions.php");
    if(file_exists("Donnees/donneeFav.php")){
            include("Donnees/donneeFav.php");
    }
    $recettes=$Recettes;
    $hierarchie=$Hierarchie;
    
?>
<!DOCTYPE html>
<html>

<head>
    <title> Cocktails !</title>
	<meta charset="utf-8" />
    <link rel="icon" type="image/png" sizes="16x16" href="Photos/cocktail.png">
    <link rel="stylesheet"  href="style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
    if(!file_exists('Donnees/initialisation.inc.php')){
        intialisationRecettePourCategorie();
    }
    
        include_once('Donnees/initialisation.inc.php');
    
 // On verifie si le dossier qui va contenir les données des utilisateurs existe sinon on le créé
 $dossier="Donnees/DonneesUtilisateur";
 if (!file_exists($dossier)) {
     mkdir($dossier.'/');
 }
    ?>

<header>
    <h1>🍹🍹 Bienvenue sur le site de cockails 🍹🍹</h1>
</header>

<div id="entete">
    <div class="navigation">
        <button onclick="window.location.href = '?page=Accueil&chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=RecettesFavorites'">❤️</button>
    </div>
        <?php if(!empty($_SESSION['user']['login'])):?>
           <div class="cont"> 
            <?php echo $_SESSION['user']['login']; ?>
            <button onclick="window.location.href = '?page=Profil'">Profil</button>
            <?php //on met le bouton de deconnexion ?>
            <a href="Connexion/deconnexion.php"><button>se déconnecter</button></a>
        </div>
            <?php
            if (empty($_SESSION['user']['nom']))
            {
                //on recupere les donnees de l'utilisateur
                retrouverDonneeUserNom();
            }
            if (empty($_SESSION['user']['prenom']))
            {
                //on recupere les donnees de l'utilisateur
                retrouverDonneeUserPrenom();
            }
            if (empty($_SESSION['user']['sexe']))
            {
                //on recupere les donnees de l'utilisateur
                retrouverDonneeUserSexe();
            }
            if (empty($_SESSION['user']['date']))
            {
                //on recupere les donnees de l'utilisateur
                retrouverDonneeUserDate();
            }
            ?>
           <?php else: ?>
            <div class="cont"> 
                <?php //Formulaire pour nous connecter?>
            <form method="post" action="#">
                    Login :
                    <input type="text" name="loginConnexion" placeholder="login" required="required" 
                        value="<?php echo (isset($_POST['loginConnexion'])?$_POST['loginConnexion']:''); ?>" />
        
                    Mot de passe :
                    <input type="password" name="mdpConnexion" placeholder="mot de passe" required="required"
                        value="<?php echo (isset($_POST['mdpConnexion'])?$_POST['mdpConnexion']:''); ?>" /> 
                    <input type="submit" name="connexion" value="connexion" />
                    </form>
                    
                    <?php 
                    if (isset($_POST['connexion'])){
                        //verification si le user existe grace au nom du fichier
                        verifierMdp();
                    }
                    ?>
                    
                    <button onclick="window.location.href = '?page=Inscription'">s'inscrire</button>
                </div>
                <div class="cont">
        <?php endif; ?>
        <form method="post" action="">
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
                </div>
    </div>
<div class="cont2">
    <nav>
        <?php
        if(!empty($_POST['recherche'])) include("barreRecherche.php");
        else include('navigation.php');
        ?>
    </nav>
    <main>

      <script>
      function fav(numeroDeRecette){  //fonction qui gère l'action d'aimer une recette
        if(document.getElementById(numeroDeRecette).value=="🖤"){           //on met à jours les emoji si besoins
            document.getElementById(numeroDeRecette).value ="❤️";
        }else{
            document.getElementById(numeroDeRecette).value ="🖤";
        }
        $.ajax({  //on execute actionFav.php
            url:"actionFav.php",    
            type: "post",    
            data:{"num" : numeroDeRecette}
        });
      }
      </script>
        
<?php  //selon l'URL on charge la page souhaitée
       if(isset($_GET['page'])){
        switch($_GET['page']){
            case 'Accueil':
                include("Affichage/affichageRecettesSynthetique.php");
                break;
            case 'Profil':
                include("Connexion/sonProfil.php");
                break;
            case 'Inscription':
                include("Connexion/inscription.php");
                break;
            case 'Modification':
                include("Connexion/modification.php");
                break;
            case 'RecetteDetaillee':
                include("Affichage/affichageRecetteDetaillee.php");
                break;
            case 'RecettesFavorites':
                include("Affichage/affichageRecettesFav.php");
                break;
            case 'RecettesRecherchee':
                include("Affichage/affichageRecettesRecherchee.php");
                break;
            default:
                include("Affichage/affichageRecettesSynthetique.php");
                break;
        }
    }
    else{
        include("Affichage/affichageRecettesSynthetique.php"); // En cas de page non définie on affiche la page d'accueil
    }
?>
    </main>
</body>
</div>
</html>