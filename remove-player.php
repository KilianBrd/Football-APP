<?php
include 'db_connexion.php';

$sql = 'DELETE FROM joueur WHERE id = :id';
$req = $conn->prepare($sql);
$req->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$req->execute();

header('Location: all-players.php');
exit();
