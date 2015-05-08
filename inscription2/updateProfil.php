<?php
/**
 * Created by PhpStorm.
 * User: PHRENEL
 * Date: 12/01/2015
 * Time: 13:02
 */

require('config.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/styles.css"/>
    <link href='http://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
    <title>admin-Page Edit users</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><img src="../img/logo.png" alt="enigmhetix"></h1>
    </div>
    <div class="contentProfil">

<?php
$id= $_GET['id'];

$sql="SELECT
          *
           FROM
            `users`
            WHERE
            `id`='".$id."'
    ";
$result=$db->query($sql);
$row=$result->fetch_array();
?>

<form action="editUsers.php" method="POST">
    <table>
        <tr>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/><br/>
            <td><label for="username">username :</label></td><td><input type="text" name="username" value="<?php echo $row['username']?>" placeholder="Username" class="input"/></td><br/>
        </tr>
        <tr>
            <td><label for="password">password :</label></td><td><input type="password" name="password" value="<?php echo $row['password']?>" placeholder="Password" class="input"/></td><br/>
        </tr>
            <tr>
            <td><label for="avatar">avatar :</label></td><td><input type="text" name="avatar" value="<?php echo $row['avatar']?>"placeholder="Avatar" class="input"/></td><br/>
            </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Save" class="save"/></td>
        </tr>
    </table>
</form>
        <div class="foot"><a href="users.php">Retour</a></div>
</body>
</html>