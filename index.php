<?php session_start();
if(!isset($_SESSION["favTemp"])){
    $_SESSION["favTemp"]= array();
}
    include("Donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include("functions.php");
    if(file_exists("donneeFav.php")){
            include("donneeFav.php");
    }
    
?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
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
    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie();
    }
    
        include_once('initialisation.inc.php');
    
 // On verifie si le dossier qui va contenir les données des utilisateurs existe sinon on le créé
 $dossier="DonneesUtilisateur";
 if (!file_exists($dossier)) {
     mkdir($dossier.'/');
 }
    ?>

<header>
    <h1>Bienvenue sur le site de cockails</h1>
</header>

<div id="entete">
        <button onclick="window.location.href = '?page=Accueil&chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=RecettesFavorites'">❤️</button>
        
        <?php if(!empty($_SESSION['user']['login'])):
            //on met le login de l'utilisateur
             echo $_SESSION['user']['login']; ?>
            <button onclick="window.location.href = '?page=Profil'">Profil</button>
            <?php //on met le bouton de deconnexion ?>
            <a href="deconnexion.php"><button>se déconnecter</button></a>
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
            <form method="post" action="#">
                    login :
                    <input type="text" name="loginConnexion" placeholder="login" required="required" 
                        value="<?php echo (isset($_POST['loginConnexion'])?$_POST['loginConnexion']:''); ?>" />
        
                    mot de passe :
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
        <?php endif; ?>
        <form method="post" action="">
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
    </div>

    <nav>
        <?php
        if(!empty($_POST['recherche'])) include("barreRecherche.php");
        else include('navigation.php');
        ?>
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
        switch($_GET['page']){
            case 'Accueil':
                include("affichageRecettesSynthetique.php");
                break;
            case 'Profil':
                include("sonProfil.php");
                break;
            case 'Inscription':
                include("inscription.php");
                break;
            case 'Modification':
                include("modification.php");
                break;
            case 'RecetteDetaillee':
                include("affichageRecetteDetaillee.php");
                break;
            case 'RecettesFavorites':
                include("affichageRecettesFav.php");
                break;
            case 'RecettesRecherchee':
                include("affichageRecettesRecherchee.php");
                break;
            default:
                include("affichageRecettesSynthetique.php");
                break;
        }
    }
    else{
        include("affichageRecettesSynthetique.php"); // En cas de page non définie on affiche la page d'accueil
    }
?>
    </main>
</body>
</html>