<?php include("donnees.inc.php");?>
<nav>
    <?php
        $categorieActuelle = $_GET['categorie'];

        if(!isset($_GET['categorie'])){
            $_GET['categorie']='Aliment';
            $_SESSION['historique'] = array( 0 => 'Aliment');
        }
        else {
            if(in_array($categorieActuelle, $_SESSION['historique'])){
                // indiceHistorique est la variable int de l'indice de la categorieActuelle dans historique
                $indiceHistorique = array_search($_GET['categorie'], $_SESSION['historique']);
                if($categorieActuelle='Aliment') array_splice($_SESSION['historique'], $indiceHistorique+1);
                else array_splice($_SESSION['historique'], $indiceHistorique);
            }
            else {
                if($categorieActuelle!='Aliment') array_push($_SESSION['historique'],$categorieActuelle);
            }
        }
        ?>

        <h1>Aliment courant</h1>
        <?php 
        foreach($_SESSION['historique'] as $precedent){
            ?>
            <a href="?categorie=<?php echo $precedent ?>"> <?php echo $precedent ?> </a> /
            <?php
        }
        ?>
        <ul>
        <?php 
        if(isset($hierarchie[end($_SESSION['historique'])]['sous-categorie'])){
            ?>
            <p>Sous - catégorie :</p>
            <?php 
            foreach($hierarchie[end($_SESSION['historique'])]['sous-categorie'] as $ingredient){
                ?>
                <li><a href="?categorie=<?php echo $ingredient ?>"> <?php echo $ingredient ?> </a></li>
                <?php
            }
        }
    ?></ul>
</nav>
<main>
    <?php 
    // Il faut parcourir toutes les sous catégories (même des sous catégories)

    if(isset($hierarchie[end($_SESSION['historique'])]['sous-categorie'])){
        foreach($hierarchie[end($_SESSION['historique'])]['sous-categorie'] as $ingredient){
            echo $ingredient. '<br/>';
            if(isset($hierarchie[$ingredient]['sous-categorie'])){
                foreach($hierarchie[$ingredient]['sous-categorie'] as $sousIngredient){
                    ?>
                    <li> <?php echo $sousIngredient ?> </li>
                    <?php
                }
            }
        }
    }
    
    ?>


    <div id='recette'>

    <?php 
    // Parcours des recettes : 
    foreach($recettes as $numeroRecette => $recette)
    {?>

    <table class="infobox" style="width:22em;border-spacing: 2px 5px; float: right;">
        <tbody>
            <tr>
                <th colspan="2">
                    <?php echo $recette['titre']."\n"; ?>
                </th>
            </tr>
        </tbody>
    </table>
                
    <?php  
    } ?>

    </div>
</main>