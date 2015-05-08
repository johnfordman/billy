<?php

require('config.php');
$sql = "UPDATE
            `users`
            SET
            `id`='" . $db->real_escape_string($_POST['id']) . "',
            `username`='" . $db->real_escape_string($_POST['username']) . "',
            `password`='" . $db->real_escape_string($_POST['password']) . "',
            `avatar`='" . $db->real_escape_string($_POST['avatar']) . "'

            WHERE
            `id`='".(int)$_POST['id']."'
";
if (!$db->query($sql)) {
    die($db->error);
}

header('location:users.php');
?>