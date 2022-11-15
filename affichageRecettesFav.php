<?php
include("donneeFav.php");
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
if(isset($utilisateur)&&(!empty($utilisateur))){ //si on a pas un dossier vide on affiche les recettes contenues dedant
  foreach($utilisateur as $nomEtRecette){
    if($_SESSION["user"]["login"]==$nomEtRecette[0]){
      if(empty($nomEtRecette[1])){

      }else{
      foreach($nomEtRecette[1] as $numRecetteFav){
         ?>
          <div class="inner"> 
            <h2><?php echo $recettes[$numRecetteFav]['titre']?></h2>  
            <p><?php echo  $recettes[$numRecetteFav]['ingredients']?></p>
            <p><?php echo $recettes[$numRecetteFav]['preparation'] ?></p>
            <input id="<?php echo $numRecetteFav?>" value="❤️"type="button" onclick="fav(this.id)"></input>
          </div>
      <?php
      }
      }
      
    }
  }
}?>
