
    <h1>Votre profil</h1>

<?php 
global $profilvalide=false;//variable globale
global $nomvalide=false;
global $loginvalide=false;
global $mdpvalide=false;
global $prenomvalide=false;
global $datevalide=false;
global $sexevalide=false;
// le login peut être composé de lettres non accentuées, minuscules ou MAJUSCULES, et/ou de chiffres ;
if (preg_match("^([A-Z]*[a-z]*(\-)*(([a-z]+(\')[a-z]+)||([A-Z]+(\')[A-Z]+))*)*$",$_GET["nom"])){
    $nomvalide;
}
else{
    echo 'le nom est pas bien écrit' 
}

// le mot de passe peut contenir n’importe quel caractère. Aucune autre contrainte (i.e longueur, caractères de tel type, etc) ne doit être testé. Le mot de passe doit être hashé


// les nom et prénom sont composés de lettres minuscules et/ou de lettres MAJUSCULES, ainsi que les caractères « - », « » (espace) et « ’ ». Les lettres peuvent être accentuées. Tiret et apostrophe sont forcément encadré par deux lettres, par contre plusieurs espaces sont possibles entre deux parties de prénom/nom

 //la date de naissance doit être antérieure de 18 ans à la date du jour
if (preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["prenom"])){
    $prenomvalide;
}
else{
    echo 'le prenom est pas bien écrit' 
}
if (preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["login"])){
    $loginvalide;
}
else{
    echo 'le nom est pas bien écrit' 
}
if (preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["mdp"])){
    $mdpvalide ;
}
else{
    echo 'le nom est pas bien écrit' 
}
if  (preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["sexe"])){
    $sexevalide;
}
else{
    echo 'le sexe est pas bien écrit' 
}
if (preg_match("^([A-Z]*[a-z]*(\-)*)*$",$_GET["date"])){
    $datevalide;
}
else{
    echo 'la date est pas bien écrit' 
}
if ($nomvalide && $prenomvalide && $loginvalide && $mdpvalide && $sexevalide && $datevalide){
    $profilvalide=true;
}
else{
    echo 'le profil n est pas valide';
}

if(isset($_GET["submit"])) // le formulaire vient d'etre valide
    {
        if (
         $nomvalide
        && $loginvalide
        && $mdpvalide
        && $prenomvalide
        && $datevalide
        && $sexevalide)
        { // le formulaire est entièrement valide : sauvegarde des données
            $_SESSION['user']['login']		=$_GET["login"]; //POST
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
    <input type="radio" name="sexe" value="h"/> homme
    <input type="radio" name="sexe" value="f"/> femme
    <input type="radio" name="sexe" value="a"/> autre<br />


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