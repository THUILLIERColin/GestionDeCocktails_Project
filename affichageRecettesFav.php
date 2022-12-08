<?php
if(file_exists("donneeFav.php")){
  include("donneeFav.php");
}
include("Donnees.inc.php");
?>
     <script>
      function fav(numeroDeRecette){      
            $.ajax({
            url:"actionFav.php",    
            type: "post",    
            data:{"num" : numeroDeRecette}
        });
        location.reload();
      }
      </script>
<?php 
if(isset($_SESSION["user"]["login"])){  //si l'utilisateur est connecté
  if(isset($utilisateur)&&(!empty($utilisateur))){ //si on a pas un dossier vide on affiche les recettes contenues dedant
  foreach($utilisateur as $nomEtRecette){
    if($_SESSION["user"]["login"]==$nomEtRecette[0]){
      if(empty($nomEtRecette[1])){

      }else{?>
      <div class="outer">
      <?php $compteurDeTuile = 1;
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
      if($compteurDeTuile == 3){
        if(isset($nomEtRecette[1][$indice+1])){
          echo ("</div><div class='outer'>");
        }else{
          echo("</div>");
        $compteurDeTuile = 1;
        }
        
      }
      else{
        $compteurDeTuile=$compteurDeTuile+1;
      }
      }?>
      </div>
      <?php
      }
    }
  }
}
}
else{//sinon on regarde dans la session 
  $compteurDeTuile = 1;
    foreach($_SESSION["favTemp"] as $numRecetteFav){
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
  if($compteurDeTuile == 3){
    
    echo ("</div><div class='outer'>");
    $compteurDeTuile = 1;
  }
  else{
    $compteurDeTuile=$compteurDeTuile+1;
  }
 
  }?>
  </div>
  <?php
}

?>
