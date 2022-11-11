<?php
    if(!isset($_GET['chemin'])){
        $_GET['chemin']='Aliment';
        $_SESSION['historique'] = array( 0 => 'Aliment');
    }
        else {
            if(in_array($_GET['chemin'], $_SESSION['historique'])){
                // indiceHistorique est la variable int de l'indice de la cheminActuelle dans historique
                $indiceHistorique = array_search($_GET['chemin'], $_SESSION['historique']);
                if($_GET['chemin']='Aliment') array_splice($_SESSION['historique'], $indiceHistorique+1);
                else array_splice($_SESSION['historique'], $indiceHistorique);
            }
            else {
                if($_GET['chemin']!='Aliment') array_push($_SESSION['historique'],$_GET['chemin']);
            }
        }
        ?>

        <h1>Aliment courant</h1>
        <?php 
        foreach($_SESSION['historique'] as $precedent){
            ?>
            <a href="?chemin=<?php echo $precedent ?>"> <?php echo $precedent ?> </a> /
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
                <li><a href="?chemin=<?php echo $ingredient ?>"> <?php echo $ingredient ?> </a></li>
                <?php
            }
        }
    ?></ul>