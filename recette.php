<?php include("donnees.inc.php");?>
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