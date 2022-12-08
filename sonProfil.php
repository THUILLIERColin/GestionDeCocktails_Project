<h1>Votre Profil</h1><br/>

<?php //on recupere les donnees de l'utilisateur ?>
Votre login : <?php echo $_SESSION['user']['login']; ?><br/>
Votre prenom : <?php echo $_SESSION['user']['prenom']; ?><br/>
Votre nom : <?php echo $_SESSION['user']['nom']; ?><br/>
Votre sexe : <?php echo $_SESSION['user']['sexe']; ?><br/>
Votre date de naissance : <?php echo $_SESSION['user']['date']; ?><br/>

<button onclick="window.location.href = '?page=Modification'">modifier le profil</button>