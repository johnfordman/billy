<?php
include('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="../css/styles.css" rel="stylesheet" title="Style" />
		<link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
        <title>Profil d'un utilisateur</title>
    </head>
    <body>
	<div class="container">
    	<div class="header">
			<h1><img src="../img/logo.png" alt="enigmhetix"></h1>
	    </div>


        <div class="contentProfil">
<?php
//On verifie que lidentifiant de lutilisateur est defini
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	//On verifie que lutilisateur existe
	$dn = $db->query('select username,  avatar, signup_date from users where id="'.$id.'"');
	if(count($dn)>0)
	{
		$dnn = $dn->fetch_array();
		//On affiche les donnees de lutilisateur
?>
Voici le profil de <i>"<?php echo htmlentities($dnn['username']); ?>"</i> :
<table style="width:500px;">
	<tr>
    	<td><?php
if($dnn['avatar']!='')
{
	echo '<img src="'.htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8').'" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
}
else
{
	echo 'Cet utilisateur n\'a pas d\'image perso.';
}
?></td><tr>

	</tr>
    	<td><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
        Cet utilisateur s'est inscrit le <?php echo $dnn['signup_date']; ?></td>
    </tr>
</table>
<?php
	}
	else
	{
		echo 'Cet utilisateur n\'existe pas.';
	}
}
else
{
	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
}
?>
		</div>
		<div class="editionProfil">
			<a href="updateProfil.php?id=<?php echo $id;?>">Editer</a>
			<a href="deleteUsers.php?id=<?php echo $id;?>">Supprimer</a>


		</div>
		<div class="foot"><a href="users.php">la liste des utilisateurs</a> </div>
	  </div>
	</body>
</html>