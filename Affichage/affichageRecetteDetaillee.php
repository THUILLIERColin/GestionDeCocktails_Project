<?php 
    /* 
    * Fonction qui affiche la recette en détail
    * Il l'obtient grâce à l'indice de la recette dans $_GET['recette']
    */

function affichageRecettesDetaillee()
{ 
    global $recettes;
    // Vérifie si une recette est sélectionnée
    if(isset($_GET['recette']))
    {
        // Récupère la liste des ingrédients
        $tableIngredients = explode("|", $recettes[$_GET['recette']]['ingredients']);
        $img = searchImageRecette($recettes[$_GET['recette']])?>
        <div class="recette">
        <h1><?php echo $recettes[$_GET['recette']]['titre'] ?></h1><?php 
        // Affiche l'image de la recette si elle existe
        if($img != 'Photos/cocktail.png')
        {?>
            <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
            <br/><?php 
        }?>
        <ul><?php 
        // Affiche la liste des ingrédients
        foreach($tableIngredients as $ingredient)
        {
        ?>
            <li><?php echo $ingredient ?></li>
            <?php
        }
        ?></ul>
        <p><?php echo $recettes[$_GET['recette']]['preparation'] ?></p>  
        <input id="<?php echo $_GET['recette']?>" value="🖤"type="button" onclick="fav(this.id)"></input>
        <?php
        // Affiche le bouton "Favoris" en coeur rempli si l'utilisateur est connecté et a ajouté la recette aux favoris
        if(isset($_SESSION["user"]["login"]))
        {
            if(isset($utilisateur))
            {
                foreach($utilisateur as $nomEtRecette)
                {
                    if($_SESSION["user"]["login"]==$nomEtRecette[0])
                    {
                        if(in_array($_GET['recette'],$nomEtRecette[1]))
                        { ?>
                            <script>document.getElementById(<?php echo $_GET['recette']?>).value ="❤️";</script><?php
                        }
                    }
                }
            } 
        }
        else
        {
            // Affiche le bouton "Favoris" en coeur rempli si l'utilisateur n'est pas connecté et a ajouté la recette aux favoris temporaires
            if(in_array($_GET['recette'],$_SESSION["favTemp"]))
            { ?>
                <script>document.getElementById(<?php echo $_GET['recette']?>).value ="❤️";</script><?php
            }                
        }
    ?> 
    </div>
    <?php
    }
    // Affiche un message d'erreur si aucune recette n'est sélectionnée
    else 
    {
        echo 'Erreur : Aucune recette sélectionnée'; 
    }
}
 // Appelle la fonction pour afficher la recette en détail
affichageRecettesDetaillee();
?> 