<?php
<<<<<<< Updated upstream
foreach(){

?>
<div class="inner"> 
    <h2><?php echo $recette['titre']?></h2>
    <p><?php echo $recette['ingredients'] ?></p>
    <p><?php echo $recette['preparation'] ?></p>
  </div>
<?php
}?>
=======
include("donneeFav.php");
include("Donnees.inc.php");
?>
<?php 
if(file_exists("donneeFav.php")&&(filesize("donneeFav.php")!=0)){ //si on a pas un dossier vide on affiche les recettes contenues dedant
  
  foreach($recettesFavoris as $IDrecetteFav){ //pour chaque idRecetteFav (numero des recettes dans donnée fav)
  foreach($recettes as $IDrecette=>$recettes){
    if($IDrecette == $IDrecetteFav){?>
  <div class="inner"> 
  <?php echo $IDrecette."==".$IDrecette?>
    <h2><?php echo $recettes['titre']?></h2>  
    <p><?php echo $recettes['ingredients'] ?></p>
    <p><?php echo $recettes['preparation'] ?></p>
  </div>
<?php break;}
 }
}
}?>
>>>>>>> Stashed changes
