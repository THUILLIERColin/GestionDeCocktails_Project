<?php 
$profilvalide=0;
$nomvalide=0;
$loginvalide=0;
$mdpvalide=0;
$prenomvalide=0;
$datevalide=0;


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

        //le prénom est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([ ]*[áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Z]*[a-z]*(\-)*(([a-z]+(\-)[a-z]+)||([A-Z]+(\-)[A-Z]+)||([a-z]+(\-)[A-Z]+)||([A-Z]+(\-)[a-z]+))*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+)||([a-z]+(\')[A-Z]+)||([A-Z]+(\')[a-z]+))*)*$/",$_POST["prenom"]))
        {
            $prenomvalide=1;
        }

        //le login est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^([áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]*[A-Za-z0-9]+)+$/",$_POST["login"])){
            $loginvalide=1;     
        }

        //le mot de passe est correctement ecrit si il est conforme a l'expression reguliere
        if(preg_match("/^[(\S||\s)]+$/",$_POST["mdp"])){
            $mdpvalide=1 ;
        }

        //la date doit être anteriere  a la date du jour de 18 ans et doit etre au format jj/mm/aaaa 
        //if(preg_match("/^(((0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))\((0[1-9])|(1[0-2]))\((1[8-9][0-9][0-9])|2[0-9][0-9][0-9])*)$/",$_POST["date"]) && ($_POST["date"]<date('d\m\Y', strtotime("- 18 years")))){
         $datevalide=1;
        //}

        echo 'nomvalide : '.$nomvalide.'<br>prenomvalide : '.$prenomvalide.'<br>loginvalide : '.$loginvalide.'<br>mdpvalide : '.$mdpvalide.'<br>datevalide : '.$datevalide.'<br>';
        if($nomvalide==1 && $prenomvalide==1 && $loginvalide==1 && $mdpvalide==1 )
        { 
            $_SESSION['user']['login']	=$_POST["login"];
            $_SESSION['user']['mdp']	=$_POST["mdp"];
            $_SESSION['user']['nom']    =$_POST["nom"];
            $_SESSION['user']['prenom'] =$_POST["prenom"];
            $_SESSION['user']['sexe']	=$_POST["sexe"];
            $_SESSION['user']['date']	=$_POST["date"];
            
            //on creer un fichier dans le dossier user avec le login comme nom
            $donnees="login=".$_SESSION['user']['login']."&mdp=".$_SESSION['user']['mdp']."&nom=".$_SESSION['user']['nom']."&prenom=".$_SESSION['user']['prenom']."&sexe=".$_SESSION['user']['sexe']."&date=".$_SESSION['user']['date'];
            
            $fichier=fopen("DonneesUtilisateur/".$_POST["login"].".txt","w+");
            fwrite($fichier,$donnees);
            fclose($fichier);
            //je mets les informations dans un fichier et le nom du fichier et le login

            //file_put_contents("DonneesUtilisateur/".$_POST["login"].".txt",$donnees, true);
        }
    }
    ?>

    <h1>Votre Profil</h1><br/>


    <form method="post" action="#">
    <?php//mettre sous condition de modification+ double verification mot de passe ?>
    <h2>Zone d'inscription (nécéssaire) : </h2>

    login :
    <input type="text" name="login" required="required"
        value="<?php echo (isset($_POST['login'])?$_POST['login']:''); ?>"><br />

    mot de passe :
    <input  type="password" name="mdp" required="required"
        value="<?php echo (isset($_POST['mdp'])?$_POST['mdp']:''); ?>"><br />

     <h2>Vos données personelles (facultatif) :</h2>

    Nom :
    <input type="text" name="nom" 
        value="<?php echo (isset($_POST['nom'])?$_POST['nom']:''); ?>"><br />

    Prénom :
    <input type="text" name="prenom"
        value="<?php echo (isset($_POST['prenom'])?$_POST['prenom']:''); ?>"><br />
        
    Sexe (homme ou femme ou autre) :
    <input type="radio" name="sexe" value="homme" 
        <?php if($_POST['sexe']=="yes") echo "checked";?> />homme 
    <input type="radio" name="sexe" value="femmme"
        <?php if($_POST['sexe']=="yes") echo "checked";?> /> femme 
    <input type="radio" name="sexe" value="autre"
        <?php if($_POST['sexe']=="yes") echo "checked";?>/>  autre<br />

    Date de naissance(+18 ans):
    <input type="date" name="date"
        value="<?php echo (isset($_POST['date'])?$_POST['date']:''); ?>"><br />
    <input type="submit" name="submit" value="Valider">	

    ok 20
    </form>

   

<?php
 /* Hash un mot de passe
 * @param string $password Mot de passe non hashé
 * @return stirng Mot de passe hashé
 */
//function hashPassword( $password ) {
 //   return sha1( $password );
//}
//if( $_SESSION['user']['mdp'] !== hashPassword($password) ) {
?>

