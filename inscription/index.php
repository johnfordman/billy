<?php

require('config.php')
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="css/styles.css" rel="stylesheet" title="Style" />

    </head>
    <body>
    <div class="container">

<?php
//On affiche un message de bienvenue, si lutilisateur est connecte, on affiche son pseudo
?>
        <p>
Bonjour <?php if(isset($_SESSION['username'])){echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');} ?>,<br />
 Bienvenue à toi jeune Sauveur !<br /></p>
<!--Vous pouvez <a href="users.php">voir la liste des utilisateurs</a>.<br /><br />-->
<?php
//Si lutilisateur est connecte, on lui donne un lien pour modifier ses informations, pour voir ses messages et un pour se deconnecter
if(isset($_SESSION['username']))
{
?>
    <div class="connexion">

<a href="edit_infos.php">Modifier mes donnees</a>
<a href="connexion.php">Se d&eacute;connecter</a>
        </div>
<?php
}
else
{
//Sinon, on lui donne un lien pour sinscrire et un autre pour se connecter
?>
    <div class="accueil">
<a href="sign_up.php">Inscription</a>
<a href="connexion.php">Se connecter</a>
    </div>
<?php
}
?>

    </div>
</body>
</html>