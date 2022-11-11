<?php
    if(empty($_GET['chemin'])){
        // Si la variable n'est pas initialiser ou vide on la met sur Aliment
        $_GET['chemin']='Aliment';
        $chemin = array( 0 => 'Aliment');
    }
    else{
        // On explose la variable chemin pour pouvoir la parcourir 
        $chemin = preg_split("/,+/",$_GET['chemin']);
    } ?>

        <h1>Aliment courant</h1>
        <?php 
        foreach($chemin as $categorieFils){
            ?>
            <a href="?chemin=<?php  ?>"> <?php echo $categorieFils ?> </a> /
            <?php
        }
        ?>
        <ul>

        <?php 
        
        if(isset($hierarchie[end($chemin)]['sous-categorie'])){
            ?>
            <p>Sous - catégorie :</p>
            <?php 
            foreach($hierarchie[end($chemin)]['sous-categorie'] as $ingredient){
                ?>
                <li><a href="?chemin=<?php echo $_GET['chemin'].",".$ingredient ?>"> <?php echo $ingredient ?> </a></li>
                <?php
            }
        }
    ?></ul>