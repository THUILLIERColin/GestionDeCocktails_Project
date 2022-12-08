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

		if ( $nbQuotes%2 ){ echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes \n </br>"; ++$nbErreurs; }
		else {

			$alimentsNonReconnu = array();
			$alimentsNonSouhaites = array();
			$alimentsSouhaites = array();

			$alimentsQuotes = array();
			$alimentsPlus = array();
			$alimentsMoins = array();

			$affichage = false;

			// Remplissage des tableaux de contraintes

			while(preg_match('/[+]?[-]?["][a-zA-Z\s]+["]/', $recherche)){
				preg_match('/[+]?[-]?["][a-zA-Z\s]+["]/', $recherche, $match);
				$alimentsQuotes[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}
			// match avec les +, - et rien devant les quotes

			while(preg_match('/[-][a-zA-ZéÉ]+/', $recherche)){
				preg_match('/[-][a-zA-ZéÉ]+/', $recherche, $match);
				$alimentsMoins[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			while(preg_match('/[+][a-zA-ZéÉ]+/', $recherche)){
				preg_match('/[+][a-zA-ZéÉ]+/', $recherche, $match);
				$alimentsPlus[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			while(preg_match('/[a-zA-ZéÉ]+/', $recherche)){
				preg_match('/[a-zA-ZéÉ]+/', $recherche, $match);
				$alimentsPlus[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			// Traitement des contraintes et remplissage des tableaux d'aliments souhaités, non-souhaités et non reconnus

			foreach ($alimentsQuotes as $aliment) {
				if (preg_match('/[+]/', $aliment)){
					$aliment = str_replace('+', "", $aliment);
					$aliment = str_replace('"', "", $aliment);
					if(estReconnue($aliment)) $alimentsSouhaites[] = $aliment;
					else $alimentsNonReconnu[] = $aliment;
				}
				elseif (preg_match('/[-]/', $aliment)){
					$aliment = str_replace('-', "", $aliment);
					$aliment = str_replace('"', "", $aliment);
					if(estReconnue($aliment)) $alimentsNonSouhaites[] = $aliment;
					else $alimentsNonReconnu[] = $aliment;
				}
				else {
					$aliment = str_replace('"', "", $aliment);
					if(estReconnue($aliment)) $alimentsSouhaites[] = $aliment;
					else $alimentsNonReconnu[] = $aliment;
				}
			}

			foreach ($alimentsPlus as $aliment) {
				$aliment = str_replace('+', "", $aliment);
				if(estReconnue($aliment)) $alimentsSouhaites[] = $aliment;
				else $alimentsNonReconnu[] = $aliment;
			}

			foreach ($alimentsMoins as $aliment) {
				$aliment = str_replace('-', "", $aliment);
				if(estReconnue($aliment)) $alimentsNonSouhaites[] = $aliment;
				else $alimentsNonReconnu[] = $aliment;
			}

			// Affichage des tableaux d'aliments souhaités, non-souhaités et non reconnus

			if(!empty($alimentsSouhaites)){
				echo 'Liste des aliments souhaités :';
				foreach($alimentsSouhaites as $aliment){
					if($aliment != end($alimentsSouhaites))
						echo $aliment.', ';
					else
						echo $aliment;
				}
				echo '</br>';
			}

			if(!empty($alimentsNonSouhaites)){
				echo 'Liste des aliments non souhaités :';
				foreach($alimentsNonSouhaites as $aliment){
					if($aliment != end($alimentsNonSouhaites))
						echo $aliment.', ';
					else
						echo $aliment;
				}
				echo '</br>';
			}

			if(!empty($alimentsNonReconnu)){
				echo 'Éléments non reconnus dans la requête :';
				foreach($alimentsNonReconnu as $aliment){
					if($aliment != end($alimentsNonReconnu))
						echo $aliment.', ';
					else
						echo $aliment;
				}
				echo '</br>';
			}

			// On redirige vers la page d'affichage des recettes correspondantes
			$_GET["page"]='RecettesRecherchee'; 
		}
	}
?>