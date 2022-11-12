<h1>Aliment courant</h1><?php 
// On parcours le tableau chemin pour afficher les liens vers les catégories précédentes 
foreach($chemin as $categorieFilsAriane){
// Il faudrait prendre $_GET['chemin'] et supprimer apres la catégorie $categorieFilsAriane
    ?>
    <a href="?page=Acceuil&chemin=<?php $categorieFilsAriane ?>"> <?php echo $categorieFilsAriane ?> </a> /
    <?php 
}?>
<ul><?php 
    if(isset($hierarchie[end($chemin)]['sous-categorie'])){?>
        <p>Sous - catégorie :</p><?php 
        foreach($hierarchie[end($chemin)]['sous-categorie'] as $ingredient){?>
            <li><a href="?page=Acceuil&chemin=<?php echo $_GET['chemin'].",".$ingredient ?>"> <?php echo $ingredient ?> </a></li> <?php
        }
    }?>
</ul>