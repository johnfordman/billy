<?php
include('config.php');
//On verifie si lutilisateur est connecte
if(isset($_SESSION['username']))
{
    //On verifie si le formulaire a ete envoye
    if(isset($_POST['username'], $_POST['password'], $_POST['passverif'], $_POST['avatar']))
    {
        //On enleve lechappement si get_magic_quotes_gpc est active
        if(get_magic_quotes_gpc())
        {
            $_POST['username'] = stripslashes($_POST['username']);
            $_POST['password'] = stripslashes($_POST['password']);
            $_POST['passverif'] = stripslashes($_POST['passverif']);
            $_POST['avatar'] = stripslashes($_POST['avatar']);
        }
        //On verifie si le mot de passe et celui de la verification sont identiques
        if($_POST['password'] == $_POST['passverif'])
        {
            //On verifie si le mot de passe a 6 caracteres ou plus
            if(strlen($_POST['password'])>=6)
            {
                //On verifie si lemail est valide
                /*if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['avatar']))
                {*/
                //On echape les variables pour pouvoir les mettre dans une requette SQL

                $username = $db->real_escape_string($_POST['username']);
                $password = $db->real_escape_string($_POST['password']);
                $avatar = $db->real_escape_string($_POST['avatar']);

                //On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis
                $req = $db->query('select count(*) as nb from users where username="'.$username.'"');
                $dn = $req->fetch_array();


                //On verifie si le pseudo a ete modifie pour un autre et que celui-ci n'est pas deja utilise
                if($dn['nb'] == 0 or $_POST['username'] == $_SESSION['username'])
                {
                    //On modifie les informations de lutilisateur avec les nouvelles

                    if($db->query('update users set username="'.$username.'", password="'.$password.'", avatar="'.$avatar.'" where id="'.$db->real_escape_string($_SESSION['userid']).'"'))
                    {
                        //Si ca a fonctionne, on naffiche pas le formulaire
                        $form = false;
                        //On supprime les sessions username et userid au cas ou il aurait modifie son pseudo
                        unset($_SESSION['username'], $_SESSION['userid']);
                        ?>
                        <div class="message">Vos informations ont bien &eacute;t&eacute; modifif&eacute;e. Vous devez vous reconnecter.<br />
                            <a href="connexion.php">Se connecter</a></div>
                    <?php
                    }
                    else
                    {
                        //Sinon on dit quil y a eu une erreur
                        $form = true;
                        $message = 'Une erreur est survenue lors des modifications.';
                    }
                }
                else
                {
                    //Sinon, on dit que le pseudo voulu est deja pris
                    $form = true;
                    $message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
                }
                /*}
                else
                {
                    //Sinon, on dit que l'email nest pas valide
                    $form = true;
                    $message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
                }*/
            }
            else
            {
                //Sinon, on dit que le mot de passe n'est pas assez long
                $form = true;
                $message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
            }
        }
        else
        {
            //Sinon, on dit que les mots de passes ne sont pas identiques
            $form = true;
            $message = 'Les mot de passe que vous avez entr&eacute; ne sont pas identiques.';
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
            echo '<strong>'.$message.'</strong>';
        }
        //Si le formulaire a deja ete envoye on recupere les donnes que l'utilisateur avait deja insere
        if(isset($_POST['username'],$_POST['password']))
        {
            $username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
            if($_POST['password']==$_POST['passverif'])
            {
                $password = htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
            }
            else
            {
                $password = '';
            }
            $avatar = htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');
        }
        else
        {
            //Sinon, on affiche les donnes a partir de la base de donnee
            $req = $db->query("select username,password,avatar from users where username='".$_SESSION['username']."'");
            $dnn = $req->fetch_assoc();

            $username = htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8');
            $password = htmlentities($dnn['password'], ENT_QUOTES, 'UTF-8');
            $avatar = htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8');
        }
        //On affiche le formulaire
        ?>
        <div class="content">
            <form action="edit_infos.php" method="post">
                Vous pouvez modifier vos informations:<br />
                <div class="center">
                    <table>
                        <tr>
                            <td><label for="username">Nom d'utilisateur</label></td><td><input type="text" name="username" id="username" class="input" value="<?php echo $username; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="password">Mot de passe<span class="small">(6 caract&egrave;res min.)</span></label></td><td><input type="password" class="input" name="password" id="password" value="<?php echo $password; ?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="passverif">Mot de passe<span class="small">(v&eacute;rification)</span></label></td><td><input type="password" class="input" name="passverif" id="passverif" value="<?php echo $password; ?>" required/></td>
                        </tr>
                        <tr>
                            <td><label for="avatar">Image perso<span class="small">(facultatif)</span></label></td><td><input type="file" name="avatar" class="input" id="avatar" value="<?php echo $avatar; ?>" /></td>
                            <img src="<?php echo $avatar; ?>" alt=""/>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Save" class="save"/></td>
                    </table>
                </div>
            </form>
        </div>
    <?php
    }
}
else
{
    ?>
    <div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.<br />
        <a href="connexion.php">Se connecter</a></div>
<?php
}
?>
<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a> </div>
</div>
