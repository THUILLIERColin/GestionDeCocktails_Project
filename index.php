<?php session_start();
    include_once("Donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include_once("functions.php");
    include_once("donneeFav.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
</head>

<body>
    <?php
    // Si la variable n'est pas initialiser ou vide on la met sur Aliment
    if(!isset($_GET['chemin']) || $_GET['chemin'] == null) {
        $_GET['chemin']='Aliment';
        $chemin = array( 0 => 'Aliment');
    }
    else{
        $chemin = explode(',', $_GET['chemin']); // On explose la variable chemin pour pouvoir la parcourir plus facilement
    }

    if(!isset($_GET["page"])) 
        $_GET["page"] = "Accueil";

    /* 
    * Verifie si le fichier existe si oui il l'inclu, si non il le crée 
    * Le fichier contiendra un tableau
    * Le tableau contiendra les recettes qui match avec la catégorie
    */
    if(!file_exists('initialisation.inc.php'))
        intialisationRecettePourCategorie();
    
    include_once('initialisation.inc.php');

    // On verifie si le dossier qui va contenir les données des utilisateurs existe
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
        <button onclick="window.location.href = '?page=RecettesFavorites&nom=fav'">Recette coeur</button>
        
        <?php if(!empty($_SESSION['user']['login'])):?>
            <?php echo $_SESSION['user']['login']; ?>
            <button onclick="window.location.href = '?page=Profil'">Profil</button>
            <a href="deconnexion.php"><button>se déconnecter</button></a>
            <?php
            if (empty($_SESSION['user']['nom']))
            {
                retrouverDonneeUserNom();
            }
            if (empty($_SESSION['user']['prenom']))
            {
                retrouverDonneeUserPrenom();
            }
            if (empty($_SESSION['user']['sexe']))
            {
                retrouverDonneeUserSexe();
            }
            if (empty($_SESSION['user']['date']))
            {
                retrouverDonneeUserDate();
            }
            ?>
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
        <body>
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
        </body>
    </main>
</body>
</html>