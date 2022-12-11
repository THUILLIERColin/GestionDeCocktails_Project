<h2>Aliment courant</h2>

<?php 

// On parcours le tableau chemin pour afficher les liens vers les catégories précédentes 
foreach($chemin as $categorieFilAriane){
    $cheminString = $_GET['chemin'];
    if($categorieFilAriane != 'Aliment') { 
        // On enlève ceux qui suit la dernière catégorie du chemin
        $cheminString = substr($cheminString, 0, stripos($cheminString, $categorieFilAriane)+strlen($categorieFilAriane)); 
    }
    else {
        $cheminString = 'Aliment'; // On remet la valeur de la catégorie racine
    } 
    if ($categorieFilAriane != end($chemin)) { ?>
        <a href="?page=Accueil&chemin=<?php echo $cheminString ?>"><?php echo $categorieFilAriane ?></a> / <?php 
        // On affiche le lien vers la catégorie précédente
    }
    else {?>
        <a href="?page=Accueil&chemin=<?php echo $cheminString ?>"> <?php echo $categorieFilAriane ?> </a><?php 
        // On affiche le lien vers la catégorie courante
    }
}
// On affiche les sous catégories de la catégorie courante ?>
        <p>Sous-catégorie :</p>
<ul><?php 
    if(isset($hierarchie[end($chemin)]['sous-categorie'])){
        foreach($hierarchie[end($chemin)]['sous-categorie'] as $ingredient){?>
            <li><a href="?page=Accueil&chemin=<?php echo $_GET['chemin'].",".$ingredient ?>"> <?php echo $ingredient ?> </a></li> <?php
        }
    }?>
</ul>
