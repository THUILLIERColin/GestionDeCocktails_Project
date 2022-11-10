<?php 

function precedentCategorie($categorieActuelle){
    $filDAriane = array();
    if(isset($categorieActuelle['super-categorie'])){
        $filDAriane = $categorieActuelle['super-categorie'];
        $filDAriane = precedentCategorie($categorieActuelle['super-categorie']);
    }
    return $filDAriane;
}

// detruire au , 

if(!isset($_GET['categorie'])){
    $_GET['categorie']='Aliment';
}

print_r(precedentCategorie($hierarchie[$_GET['categorie']]));
?>

<?php
// Il faut créer un fichier de données avec les fruits en entrée puis chaque 
// fruit est un tableau contenant les recettes qui match avec les fruits

?>