<?php
session_start();
//On demarre les sessions


/******************************************************
----------------Configuration Obligatoire--------------
Veuillez modifier les variables ci-dessous pour que l'
espace membre puisse fonctionner correctement.
 ******************************************************/

//On se connecte a la base de donnee

try {
    $db = new mysqli( 'localhost', 'root', 'root', 'exo' );
} catch (mysqli_sql_exception $e) {
    die('Probleme de connexion');
}

$db->set_charset("utf8");

//Email du webmaster
$mail_webmaster = 'example@example.com';

//Adresse du dossier de la top site
$url_root = 'http://www.example.com/';

/******************************************************
----------------Configuration Optionelle---------------
 ******************************************************/

//Nom du fichier de laccueil
$url_home = 'index.php';

//Nom du design
$design = 'default1';
?>