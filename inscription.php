<?php 
$nomvalide=0;
$loginvalide=0;
$mdpvalide=0;
$prenomvalide=0;
$datevalide=0;
$sexevalide=0;


function est_vide($chaine)
{
  return (trim($chaine)=='');
}

retrouverDonneeUserNom();

$dossier="DonneesUtilisateur";
if (!file_exists($dossier)) {
    mkdir("DonneesUtilisateur/");
}

if(isset($_POST["submit"])) // le formulaire vient d'etre valide
    { 
        //le nom est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([ ]*[áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Z]*[a-z]*(\-)*(([a-z]+(\-)[a-z]+)||([A-Z]+(\-)[A-Z]+)||([a-z]+(\-)[A-Z]+)||([A-Z]+(\-)[a-z]+))*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+)||([a-z]+(\')[A-Z]+)||([A-Z]+(\')[a-z]+))*)*$/",$_POST["nom"]))
        {   
            $nomvalide=1;
        }

        //le prénom est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([ ]*[áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Z]*[a-z]*(\-)*(([a-z]+(\-)[a-z]+)||([A-Z]+(\-)[A-Z]+)||([a-z]+(\-)[A-Z]+)||([A-Z]+(\-)[a-z]+))*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+)||([a-z]+(\')[A-Z]+)||([A-Z]+(\')[a-z]+))*)*$/",$_POST["prenom"]))
        {
            $prenomvalide=1;
        }

        //le login est correctement ecrit si il est conforme a l'expression reguliere
        if((preg_match("/^([áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Za-z0-9]+)+$/",$_POST["login"])||(preg_match("/^([áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Za-z0-9]+)+$/",$_SESSION['user']['login'])))){
            $loginvalide=1;     
        }
        //le sexe est valide si il est coché ou non
        $sexevalide=1;

        //le mot de passe est correct si les deux mots de passes sont identiques
        if($_POST["mdp"]==$_POST["mdp2"]){
            $mdpvalide=1;
        }

        //la date doit être anteriere  a la date du jour de 18 ans et doit etre au format jj/mm/aaaa 
        //if(preg_match("/(^(((0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))/((0[1-9])|(1[0-2]))/((1[8-9][0-9][0-9])|2[0-9][0-9][0-9])*)$)/",$_POST["date"]) && ($_POST["date"]<date('d\m\Y', strtotime("- 18 years")))){
        if (($_POST["date"]<date('d\m\Y', strtotime("- 18 years"))|| (!empty($_POST["date"])))){
            $datevalide=1;
        }
        

        if($nomvalide==1 && $prenomvalide==1 && $loginvalide==1 && $mdpvalide==1 && $sexevalide==1 && $datevalide==1){
            if(!empty($_SESSION['user']['login']))
            {
                
                if (isset($_POST["mdp"]))
                {
                    $_SESSION['user']['mdp']	=password_hash($_POST["mdp"], PASSWORD_DEFAULT);
                }
                
                if (isset($_POST["nom"]))
                {
                    $_SESSION['user']['nom']	=$_POST["nom"];
                }
                else {
                    retrouverDonneeUserNom();
                }
            
                if (isset($_POST["prenom"]))
                {
                    $_SESSION['user']['prenom']	=$_POST["prenom"];
                }
                else {
                    retrouverDonneeUserPrenom();    
                }
                if (isset($_POST["sexe"]))
                {
                    $_SESSION['user']['sexe']	=$_POST["sexe"];
                }
                else{
                    retrouverDonneeUserSexe();
                }
                if (isset($_POST["date"]))
                {
                    $_SESSION['user']['date']	=$_POST["date"];
                }
                else {
                    retrouverDonneeUserDate();
                }
                
                $donnees="login=".$_SESSION['user']['login']."&mdp=".$_SESSION['user']['mdp']."&nom=".$_SESSION['user']['nom']."&prenom=".$_SESSION['user']['prenom']."&sexe=".$_SESSION['user']['sexe']."&date=".$_SESSION['user']['date'];
                //on creer un fichier dans le dossier user avec le login comme nom
                $fichier=fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt","w+");

                file_put_contents($fichier,"");
                fwrite($fichier,$donnees);
                fclose($fichier);
                header("Location: index.php");

            }
            else{
                $_SESSION['user']['login']	=$_POST["login"];
                $_SESSION['user']['mdp']	=password_hash($_POST["mdp"], PASSWORD_DEFAULT);
                $_SESSION['user']['nom']    =$_POST["nom"];
                $_SESSION['user']['prenom'] =$_POST["prenom"];
                $_SESSION['user']['sexe']	=$_POST["sexe"];
                $_SESSION['user']['date']	=$_POST["date"];

                $donnees="login=".$_SESSION['user']['login']."&mdp=".$_SESSION['user']['mdp']."&nom=".$_SESSION['user']['nom']."&prenom=".$_SESSION['user']['prenom']."&sexe=".$_SESSION['user']['sexe']."&date=".$_SESSION['user']['date'];
                //on creer un fichier dans le dossier user avec le login comme nom
                $fichier=fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt","w+");
                fwrite($fichier,$donnees);
                fclose($fichier);
                header("Location: index.php");
            }
        }
    }
    ?>

    <h1>Votre Profil</h1><br/>

    <?php//mettre sous condition de modification+ double verification mot de passe ?>
    <?php
    if(!empty($_SESSION['user']['login']))
    {
        echo "Login : ".$_SESSION['user']['login']."<br/>";
        ?>
        <form method="post" action="#">
        <h2>Vos données personelles (facultatif) :</h2>


        changement du mot de passe : 
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
            value="<?php echo (isset($_POST['prenom'])?$_POST['prenom']:''); ?>">
            
        Sexe (homme ou femme ou autre) :
        <input type="radio" name="sexe" value="homme" 
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='homme') echo 'checked="checked"';?> />homme 
        <input type="radio" name="sexe" value="femmme"
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='femme') echo 'checked="checked"';?> /> femme <br />


        Date de naissance(+18 ans):
        <input type="date" name="date"
            value="<?php echo (isset($_POST['date'])?$_POST['date']:''); ?>"><br />
        <input type="submit" name="submit" value="modifier le profil">
        </form>
        <?php
    }
    else
    {?>
         <form method="post" action="#">
        <h2>Zone d'inscription (nécéssaire) : </h2>

        login :
        <input type="text" name="login" required="required"
            value="<?php echo (isset($_POST['login'])?$_POST['login']:''); ?>"><br />

        mot de passe :
        <input  type="password" name="mdp" required="required"
            value="<?php echo (isset($_POST['mdp'])?$_POST['mdp']:''); ?>"><br />

        verification mot de passe:
        <input  type="password" name="mdp2" required="required"
            value="<?php echo (isset($_POST['mdp2'])?$_POST['mdp2']:''); ?>"><br />

        <h2>Vos données personelles (facultatif) :</h2>

        Nom :
        <input type="text" name="nom" 
            value="<?php echo (isset($_POST['nom'])?$_POST['nom']:''); ?>"><br />

        Prénom :
        <input type="text" name="prenom"
            value="<?php echo (isset($_POST['prenom'])?$_POST['prenom']:''); ?>"><br />
            
        Sexe :
        <input type="radio" name="sexe" value="homme" 
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='homme') echo 'checked="checked"'; ?> />homme 
        <input type="radio" name="sexe" value="femmme"
        <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='femme') echo 'checked="checked"'; ?> /> femme <br />

        Date de naissance(+18 ans):
        <input type="date" name="date"
            value="<?php echo (isset($_POST['date'])?$_POST['date']:''); ?>"><br />
        <input type="submit" name="submit" value="Valider">	
        </form>
        
    <?php
    }?>