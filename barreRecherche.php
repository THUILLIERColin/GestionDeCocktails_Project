<?php
	// Vérifier si le formulaire est soumis 
	if (!empty($_POST['recherche'])) {
		$recherche = $_POST['recherche'];  // ."." ajout du point

		$nbErreurs= 0; // compteur d'erreurs
		$nbQuotes = 0; // compteur de double-quotes
		$indiceQuotes = array(); // tableau des indices des double-quotes

		// test si le nombre de doubles-quotes est impair
		for($i = 0 ; $i<strlen($recherche) ; $i++){
			if ($recherche[$i] == '"'){
				$nbQuotes++;
				$indiceQuotes[] = $i;
			}
		}
		// test si le nombre de doubles-quotes est impair
		if ( $nbQuotes%2 ){ 
			echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes \n </br>"; 
			++$nbErreurs; // si impair, on incrémente le compteur d'erreurs
		}
		else {

			$alimentsNonReconnu = array(); // tableau des aliments non reconnus
			$alimentsNonSouhaites = array(); // tableau des aliments non souhaités
			$alimentsSouhaites = array(); // tableau des aliments souhaités

			$alimentsQuotes = array(); // tableau des aliments entre quotes
			$alimentsPlus = array(); // tableau des aliments précédés d'un +
			$alimentsMoins = array(); // tableau des aliments précédés d'un -

			// Remplissage des tableaux de contraintes

			// match avec les +, - et rien devant les quotes
			while(preg_match('/[+]?[-]?["][a-zA-Zç\s]+["]/', $recherche)){
				preg_match('/[+]?[-]?["][a-zA-Zç\s]+["]/', $recherche, $match);
				$alimentsQuotes[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			// match avec les - devant les mots
			while(preg_match('/[-][a-zA-ZéÉç]+/', $recherche)){
				preg_match('/[-][a-zA-ZéÉç]+/', $recherche, $match);
				$alimentsMoins[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			// match avec les + devant les mots
			while(preg_match('/[+][a-zA-ZéÉç]+/', $recherche)){
				preg_match('/[+][a-zA-ZéÉç]+/', $recherche, $match);
				$alimentsPlus[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			// match avec les mots restants
			while(preg_match('/[a-zA-ZéÉç]+/', $recherche)){
				preg_match('/[a-zA-ZéÉç]+/', $recherche, $match);
				$alimentsPlus[] = $match[0];
				$recherche = str_replace($match[0], "", $recherche);
			}

			// Traitement des contraintes et remplissage des tableaux d'aliments souhaités, non-souhaités et non reconnus

			// traitement des aliments entre quotes
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

			// traitement des aliments précédés d'un +
			foreach ($alimentsPlus as $aliment) {
				$aliment = str_replace('+', "", $aliment);
				if(estReconnue($aliment)) $alimentsSouhaites[] = $aliment;
				else $alimentsNonReconnu[] = $aliment;
			}

			// traitement des aliments précédés d'un -
			foreach ($alimentsMoins as $aliment) {
				$aliment = str_replace('-', "", $aliment);
				if(estReconnue($aliment)) $alimentsNonSouhaites[] = $aliment;
				else $alimentsNonReconnu[] = $aliment;
			}

			// Affichage des tableaux d'aliments souhaités, non-souhaités et non reconnus

			if(!empty($alimentsSouhaites)){
				echo 'Liste des aliments souhaités :'; 
				foreach($alimentsSouhaites as $aliment){ // affichage des aliments souhaités
					if($aliment != end($alimentsSouhaites))
						echo $aliment.', ';
					else
						echo $aliment;
				}
				echo '</br>';
			}

			if(!empty($alimentsNonSouhaites)){
				echo 'Liste des aliments non souhaités :';
				foreach($alimentsNonSouhaites as $aliment){ // affichage des aliments non souhaités
					if($aliment != end($alimentsNonSouhaites))
						echo $aliment.', ';
					else
						echo $aliment;
				}
				echo '</br>';
			}

			if(!empty($alimentsNonReconnu)){
				echo 'Éléments non reconnus dans la requête :';
				foreach($alimentsNonReconnu as $aliment){ // affichage des aliments non reconnus
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