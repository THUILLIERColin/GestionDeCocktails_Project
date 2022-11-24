<form method="post" action="">
    <input type="text" name="recherche" placeholder="Rechercher un produit" />
    <input type="submit" value="Rechercher" />
</form>

<?php
	// Vérifier si le formulaire est soumis 
	if ( isset( $_POST['submit'] ) ) {
		$recherche = $_POST['recherche'];  // ."." ajout du point ?
		// $_SESSION['recherche'] = $recherche; // On stocke la recherche dans la session ?? 
	}

	$j = 0;
	for($i = 0 ; $i<strlen($recherche) ; $i++){// test si le nombre de doubles-quotes est impair
		if ($recherche[$i] == '"'){
			$j++;
		}
	}

	$alimentsNonReconnu = array();
	$alimentsNonSouhaites = array();
	$alimentsSouhaites = array();

	if ( $j%2 ) echo "Problème de syntaxe dans votre requête : nombre impair de double-quotes \n </br>";

	
?>