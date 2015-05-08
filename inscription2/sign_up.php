<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="../css/styles.css" rel="stylesheet" title="Style" />
		<link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
        <title>Inscription</title>
    </head>
    <body>
		<div class="container">
			<header>
				<h1><img src="../img/logo.png" alt="enigmhetix"></h1>
			</header>
<?php
//On verifie que le formulaire a ete envoye
if(isset($_POST['username'], $_POST['password'], $_POST['passverif']) and $_POST['username']!='')
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['password'] = stripslashes($_POST['password']);
		$_POST['passverif'] = stripslashes($_POST['passverif']);
	}
	//On verifie si le mot de passe et celui de la verification sont identiques
	if($_POST['password']==$_POST['passverif'])
	{
		//On verifie si le mot de passe a 6 caracteres ou plus
		if(strlen($_POST['password'])>=6)
		{

				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$username = $db->real_escape_string($_POST['username']);
				$password = $db->real_escape_string(hash("sha512", $_POST['password']));
				//On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis

				$req = $db->query('select id from users where username="'.$username.'"');
				$dn = $req->fetch_array();
				if($dn==0)
				{
					//On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
					$req = $db->query('select id from users');
					$dn2 = $req->fetch_array();

/*try {
    $db = new mysqli( 'localhost', 'root', '', 'phpwork' );
} catch (mysqli_sql_exception $e) {
    die('Probleme de connexion');
}*/


// Check if image file is a actual image or fake image
if(isset($_FILES["avatar"])) {

	$target_dir = "upload/";

	$target_file = $target_dir . basename($_FILES["avatar"]["name"]);

	$uploadOk = 1;

	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	$check = getimagesize($_FILES["avatar"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}


// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
// Check file size
if ($_FILES["avatar"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["avatar"]["name"]). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}


					//On enregistre les informations dans la base de donnee
					$req = $db->query("INSERT INTO `users`(
																`username`,
																`password`,
																`avatar`,
																`signup_date`
																) VALUES (
																		'".$username."',
																		'".$password."',
																		'".$target_file."',
																		now()
																		)");
					if($req)
					{
						//Si ca a fonctionne, on naffiche pas le formulaire
						$form = false;
						// envoi a la page de connexion
						header('Location: connexion.php');
						die()
/**/?><!--
<div class="message">Vous avez bien &eacute;t&eacute; inscrit. Vous pouvez dor&eacute;navant vous connecter.<br />
<a href="connexion.php">Se connecter</a></div>
--><?php
					}
					else
					{
						//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
					}
				}
				else
				{
					//Sinon, on dit que le pseudo voulu est deja pris
					$form = true;
					$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
				}


		}
		else
		{
			//Sinon, on dit que le mot de passe nest pas assez long
			$form = true;
			$message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
		}
	}
	else
	{
		//Sinon, on dit que les mots de passes ne sont pas identiques
		$form = true;
		$message = 'Les mots de passe que vous avez entr&eacute; ne sont pas identiques.';
	}
}
else
{
	$form = true;
}
if($form)
{
	//On affiche un message sil y a lieu
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
	//On affiche le formulaire
?>
<div class="content">
    <form action="sign_up.php" method="post" enctype="multipart/form-data">
		Veuillez remplir ce formulaire pour vous inscrire:
        <div class="center">
			<table>
				<tr>
				<td><label for="username">Nom d'utilisateur</label></td><td><input type="text" name="username" class="input" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');} ?>" /></td>
				</tr>
				<tr>
					<td><label for="password">Mot de passe<span class="small">(6 caract&egrave;res min.)</span></label></td><td><input type="password" class="input" name="password" required/></td>
				</tr>
				<tr>
					<td><label for="passverif">Mot de passe<span class="small">(v&eacute;rification)</span></label></td><td><input type="password" class="input" name="passverif" required/></td>
				</tr>
				<tr>
					<!--<td><label for="avatar">Avatar<span class="small">(facultatif)</span></label></td><td><input type="text" name="avatar" class="input" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /></td>-->

					<td><label for="avatar">Image perso<span class="small">(facultatif)</span></label></td><td><input type="file" name="avatar" class="input" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /></td>

				</tr>
				<tr>
					<td></td><td><input type="submit" value="Sign up" class="save"/></td>
				</tr>
		</div>
    </form>
</div>
<?php
}
?>
		<div class="foot"><a href="<?php echo $url_home; ?>">Retour </a></div>
	</div>
	</body>
</html>