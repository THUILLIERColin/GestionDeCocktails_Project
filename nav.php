<?php 

function precedentCategorie($categorieActuelle){
    echo 'categorieAcutelle'; print_r($categorieActuelle); echo '<br/>';echo '<br/>';
    $filDAriane = array();
    if(isset($categorieActuelle['sous-categorie'])){
        array_push($filDAriane,$categorieActuelle['sous-categorie']);
        array_push($filDAriane,precedentCategorie($categorieActuelle['sous-categorie']));
    }
    echo 'filDAriane'; print_r($filDAriane); echo '<br/>'; echo '<br/>';
    return $filDAriane;
}

// detruire au , 

if(!isset($_GET['categorie'])){
    $_GET['categorie']='Aliment';
}

//print_r(precedentCategorie($hierarchie[$_GET['categorie']]));
?>

<?php
// Il faut créer un fichier de données avec les fruits en entrée puis chaque 
// fruit est un tableau contenant les recettes qui match avec les fruits

?>