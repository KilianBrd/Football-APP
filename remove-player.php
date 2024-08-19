<?php
include 'db_connexion.php';

$conn->beginTransaction();

$sqlnotes = 'DELETE FROM notes WHERE joueur_id = :id';
$req = $conn->prepare($sqlnotes);
$req->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$req->execute();

$sql = 'DELETE FROM joueur WHERE id = :id';
$req = $conn->prepare($sql);
$req->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$req->execute();

$conn->commit();

header('Location: all-players.php');
exit();
