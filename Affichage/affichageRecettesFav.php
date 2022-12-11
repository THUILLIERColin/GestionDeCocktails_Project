<?php
//si le fichier existe on peut l'inclure
if(file_exists("Donnees/donneeFav.php")){ 
  include("Donnees/donneeFav.php");
}
include("Donnees/Donnees.inc.php");

//Erreur de dernieres minutes,notre fichier ne correspondait pas avec le votre
$recettes=$Recettes;
?>
     <script>
      //fonction qui effectue l'action des favoris 
      function fav(numeroDeRecette){      
            $.ajax({
            url:"actionFav.php",    
            type: "post",    
            data:{"num" : numeroDeRecette}
        });
        location.reload();     //on recharge la page après chaque favoris ajouté envoyé
      }
      </script>
<?php 
//si l'utilisateur est connecté
if(isset($_SESSION["user"]["login"])){  
  //si on a pas un dossier vide on affiche les recettes contenues dedant
  if(isset($utilisateur)&&(!empty($utilisateur))){ 
    //on parcourt chaque utilisateur
  foreach($utilisateur as $nomEtRecette){
    //si c'est le même login que celui la personne connectée
    if($_SESSION["user"]["login"]==$nomEtRecette[0]){
      //si il n'y a pas de recettes favorite on affiche qu'il n'y en a pas
      if(empty($nomEtRecette[1])){
      ?> <p>Aucune recette favorite!</p><?php
      }else{ //sinon si il y en a,pour chaque recette on va les disposer 3 par 3 dans un div?>
    
      <?php $compteurDeTuile = 0;?><div id='recette'>
           <div class="outer"><?php
      foreach($nomEtRecette[1] as $indice => $numRecetteFav){
        
        $img = searchImageRecette($recettes[$numRecetteFav]) // On cherche l'image correspondante à la recette ?> 
          <div class="inner"> 
            <h2><a href="?page=RecetteDetaillee&chemin=<?php echo $_GET['chemin']; ?>&recette=<?php echo $numRecetteFav ?>" > <?php echo $recettes[$numRecetteFav]['titre']."  " ?></a></h2>
            <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
              <div class="ingredientsRecetteSynthetique">
                  <?php
                  foreach($recettes[$numRecetteFav]['index'] as $ingredient){
                      echo $ingredient."<br/>";
                  }?>
              </div>
            <input id="<?php echo $numRecetteFav?>" value="❤️"type="button" onclick="fav(this.id)"></input> 
          </div>
        <?php
      $compteurDeTuile++;
      //Si on est à la 3e tuile et qu'il reste des recettes, on refait une ligne en refermant notre div
      if($compteurDeTuile == 3){
        if(isset($nomEtRecette[1][$indice+1])){
          echo ("</div><div class='outer'>");
        }else{//sinon si c'était la derniere tuiles, on va juste fermer notre ligne 
          echo("</div>");
       
        }
         $compteurDeTuile = 0;
      }else{//sinon si il n'y a plus de recette on ferme notre div peu importe le nombre de recette dans la ligne
        if(!isset($nomEtRecette[1][$indice+1])){
          echo ("</div>");
        }
      }
      }?>
      <?php
      }
    }
  }
}
}
else{//sinon on regarde dans la session si nous avons des données concernant les favoris
  if(empty($_SESSION["favTemp"])){
    ?><p>Aucune recette favorite !</p><?php
  }
  $compteurDeTuile = 0; //sinon si il y en a,pour chaque recette on va les disposer 3 par 3 dans un div
  ?><div id='recette'>
           <div class="outer"><?php
    foreach($_SESSION["favTemp"] as $indice=>$numRecetteFav){
    $img = searchImageRecette($recettes[$numRecetteFav]) // On cherche l'image correspondante à la recette ?> 



      <div class="inner"> 
        <h2><a href="?page=RecetteDetaillee&chemin=<?php echo $_GET['chemin']; ?>&recette=<?php echo $numRecetteFav ?>" > <?php echo $recettes[$numRecetteFav]['titre']."  " ?></a></h2>
        <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
        <div class="ingredientsRecetteSynthetique">
                        <?php //on affiche le contenu de nos recettes
                        foreach($recettes[$numRecetteFav]['index'] as $ingredient){
                            echo $ingredient."<br/>";
                        }?>
                    </div>
        
        <input id="<?php echo $numRecetteFav?>" value="❤️"type="button" onclick="fav(this.id)"></input> 
      </div>
      


  <?php
  $compteurDeTuile++;      //Si on est à la 3e tuile et qu'il reste des recettes, on refait une ligne en refermant le div

  if($compteurDeTuile == 3){
    if(isset($_SESSION["favTemp"][$indice+1])){
      echo ("</div><div class='outer'>");
    }else{//sinon si c'était la derniere tuiles, on va juste fermer notre ligne 
      echo("</div>"); 
   
    }
     $compteurDeTuile = 0;
   
    }else{//sinon si il n'y a plus de recette on ferme notre div peu importe le nombre de recette dans la ligne
      if(!isset($_SESSION["favTemp"][$indice+1])){
        echo ("</div>");
      }
    }
 
  }?>
  </div>
  <?php
}

?>
