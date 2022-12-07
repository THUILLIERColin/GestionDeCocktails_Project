<?php
	// Vérifier si le formulaire est soumis 
	if (!empty($_POST['recherche'])) {
		$recherche = $_POST['recherche'];  // ."." ajout du point

		$nbErreurs= 0;
		$nbQuotes = 0;
		$indiceQuotes = array(); 

		// test si le nombre de doubles-quotes est impair
		for($i = 0 ; $i<strlen($recherche) ; $i++){
			if ($recherche[$i] == '"'){
				$nbQuotes++;
				$indiceQuotes[] = $i;
			}
		}

		echo 'nbQuotes = '.$nbQuotes.'<br/>';

		if ( $nbQuotes%2 ){ echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes \n </br>"; ++$nbErreurs; }

        $alimentsNonReconnu = array();
		$alimentsNonSouhaites = array();
		$alimentsSouhaites = array();

        preg_match('/[\"\s"]/', $recherche, $match);

        echo 'recherche = '.$recherche.'<br/><br/>';
        echo 'match = '; print_r($match); echo '<br/>';
    }
?>