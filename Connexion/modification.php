<?php 
$nomvalide=0; //variable qui permet de savoir si le nom est valide
$mdpvalide=0; //variable qui permet de savoir si le mot de passe est valide
$prenomvalide=0; //variable qui permet de savoir si le prenom est valide
$datevalide=0; //variable qui permet de savoir si la date est valide
$sexevalide=0; //variable qui permet de savoir si le sexe est valide

//fonction qui permet de savoir si une chaine est vide
function est_vide($chaine)
{
  return (trim($chaine)=='');
}


if(isset($_POST["submit"])) // le formulaire vient d'etre valide
    { 
        //le nom est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([ ]*[áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Z]*[a-z]*(\-)*(([a-z]+(\-)[a-z]+)||([A-Z]+(\-)[A-Z]+)||([a-z]+(\-)[A-Z]+)||([A-Z]+(\-)[a-z]+))*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+)||([a-z]+(\')[A-Z]+)||([A-Z]+(\')[a-z]+))*)*$/",$_POST["nom"]))
        {   
            $nomvalide=1;
        }
        else{
            echo 'Le nom n\'est pas valide';
        }

        //le prénom est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([ ]*[áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Z]*[a-z]*(\-)*(([a-z]+(\-)[a-z]+)||([A-Z]+(\-)[A-Z]+)||([a-z]+(\-)[A-Z]+)||([A-Z]+(\-)[a-z]+))*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+)||([a-z]+(\')[A-Z]+)||([A-Z]+(\')[a-z]+))*)*$/",$_POST["prenom"]))
        {
            $prenomvalide=1;
        }
        else{
            echo 'Le prénom n\'est pas valide';
        }

        //le sexe est valide si il est coché ou non
        $sexevalide=1;

        //le mot de passe est correct si les deux mots de passes sont identiques
        if($_POST["mdp"]==$_POST["mdp2"]){
            $mdpvalide=1;
        }
        else{
            echo 'Les mots de passe ne sont pas identiques';
        }

        //la date doit être anteriere a la date du jour de 18 ans et doit etre au format jj/mm/aaaa 
        $age = date_diff(date_create($_POST['date']), date_create('now'))->y;
        
        if (($age >=18)|| (empty($_POST["date"]))){
            $datevalide=1;
        }
        else{
            echo '<p class="erreur">La date n\'est pas valide</p>';
        }
        
        //si toutes les variables sont valides alors on modifie les données de l'utilisateur
        if($nomvalide==1 && $prenomvalide==1 && $mdpvalide==1 && $sexevalide==1 && $datevalide==1){
            if (isset($_POST["mdp"]))
                {
                    $_SESSION['user']['mdp']	=hashageMDP($_POST["mdp"]);
                }
                
                if (isset($_POST["nom"]))
                {
                    $_SESSION['user']['nom']	=$_POST["nom"];
                }
                else {
                    //on recupere les donnees de l'utilisateur
                    retrouverDonneeUserNom();
                }
            
                if (isset($_POST["prenom"]))
                {
                    $_SESSION['user']['prenom']	=$_POST["prenom"];
                }
                else {
                    //on recupere les donnees de l'utilisateur
                    retrouverDonneeUserPrenom();    
                }
                if (isset($_POST["sexe"]))
                {
                    $_SESSION['user']['sexe']	=$_POST["sexe"];
                }
                else{
                    //on recupere les donnees de l'utilisateur
                    retrouverDonneeUserSexe();
                }
                if (isset($_POST["date"]))
                {

                    $_SESSION['user']['date']	=$_POST["date"];
                }
                else {
                    //on recupere les donnees de l'utilisateur
                    retrouverDonneeUserDate();
                }
                
                //on met les donnees dans une variable
                $donnees="login=".$_SESSION['user']['login']."&mdp=".$_SESSION['user']['mdp']."&nom=".$_SESSION['user']['nom']."&prenom=".$_SESSION['user']['prenom']."&sexe=".$_SESSION['user']['sexe']."&date=".$_SESSION['user']['date'];
                //on creer un fichier dans le dossier user avec le login comme nom
                $fichier=fopen("Donnees/DonneesUtilisateur/".$_SESSION['user']['login'].".txt","w+");

                file_put_contents($fichier,""); //on vide le fichier
                fwrite($fichier,$donnees); //on ecrit les donnees dans le fichier
                fclose($fichier); //on ferme le fichier
                header("Location: index.php"); //on redirige vers la page d'accueil
        }
    }
    ?>

    <h1>Votre Profil</h1><br/>

    <?php
        echo "Login : ".$_SESSION['user']['login']."<br/>";
        ?>
        <form method="post" action="#">
        <h2>Vos données personelles (facultatif) :</h2>

        ancien ou nouveau mot de passe : 
        <input  type="password" name="mdp" required="required"
            value="<?php echo (isset($_POST['mdp'])?$_POST['mdp']:''); ?>"><br />

        confirmation du mot de passe : 
        <input  type="password" name="mdp2" required="required"
            value="<?php echo (isset($_POST['mdp2'])?$_POST['mdp2']:''); ?>"><br />

        Nom :
        <input type="text" name="nom" 
            value="<?php echo (isset($_POST['nom'])?$_POST['nom']:''); ?>"><br />

        Prénom :
        <input type="text" name="prenom"
            value="<?php echo (isset($_POST['prenom'])?$_POST['prenom']:''); ?>"><br />
            
        Sexe :
        <input type="radio" name="sexe" value="homme" 
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='homme') echo 'checked="checked"';?> />homme 
        <input type="radio" name="sexe" value="femme"
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='femme') echo 'checked="checked"';?> /> femme <br />


        Date de naissance(+18 ans):
        <input type="date" name="date"
            value="<?php echo (isset($_POST['date'])?$_POST['date']:''); ?>"><br />
        <input type="submit" name="submit" value="modifier le profil">
        </form>
        <?php
    
    