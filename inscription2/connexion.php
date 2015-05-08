<?php
require_once('config.php');

//Si lutilisateur est connecte, on le deconnecte
if(isset($_SESSION['username']))
{
    //On le deconecte en supprimant simplement les sessions username et userid
    unset($_SESSION['username'], $_SESSION['userid']);
    // renvoi sur la page connexion
    header('Location: connexion.php');
    ?>
    <div class="message">Vous avez bien &eacute;t&eacute; d&eacute;connect&eacute;.<br />
        <a href="<?php echo $url_home; ?>">Accueil</a></div>
<?php
}
else
{
    $ousername = '';
    //On verifie si le formulaire a ete envoye
    if(isset($_POST['username'], $_POST['password']))
    {
        //On echappe les variables pour pouvoir les mettre dans des requetes SQL
        if(get_magic_quotes_gpc())
        {
            $ousername = $db->real_escape_string(stripslashes($_POST['username']));
            $username = $db->real_escape_string(stripslashes($_POST['username']));
            $password = $db->real_escape_string(hash("sha512", (stripslashes($_POST['password']))));
        }
        else
        {
            $username = $db->real_escape_string($_POST['username']);
            $password = $db->real_escape_string(hash("sha512", (stripslashes($_POST['password']))));
        }
        //On recupere le mot de passe de lutilisateur
        $req = $db->query('select password, id from users where username="'.$username.'"');
        $dn = $req->fetch_array();
        //On le compare a celui quil est entre et on verifie si le membre existe
        if($dn['password'] == $password and mysqli_num_rows($req)>0)
        {
            //Si le mot de passe est bon, on ne vas pas afficher le formulaire
            $form = false;
            //On enregistre son pseudo dans la session username et son identifiant dans la session userid
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['userid'] = $dn['id'];
            header('Location: index.php');
            ?>
            <div class="message">Vous avez bien ete connecte. Vous pouvez acc&eacute;der &agrave; votre espace membre.<br />
                Cliquez sur <a href="<?php echo $url_home; ?>">GO</a></div>
        <?php
        }
        else
        {
            //Sinon, on indique que la combinaison nest pas bonne
            $form = true;
            $message = 'La combinaison que vous avez entre n\'est pas bonne.';
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
            <form action="connexion.php" method="post">
                Veuillez entrer vos identifiants pour vous connecter:<br />
                <div class="center">
                    <table>
                        <tr>
                            <td><input type="text" name="username" id="username"  class="input" placeholder="Username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" /></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" id="password" class="input" placeholder="Password"/></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Connexion" class="save"/></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    <?php
    }
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour </a></div>
