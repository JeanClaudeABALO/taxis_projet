<?php
session_start();
include_once("functionsObject.php");

$id_course = $_POST['course_id'];
$id_chauffeur = $_POST['chauf'];

$base = new Base();
$pdo = $base->connecteBase();

//insertion de l'id du chauffeur dans la table course

$sql = 'UPDATE courses SET chauffeur_id=? WHERE course_id=?';
$req = $pdo->prepare($sql);

$req->execute([$id_chauffeur, $id_course]); 

//Modification du statut de la course
$sql = 'UPDATE courses SET statut=? WHERE course_id=?';
$req = $pdo->prepare($sql);
$req->execute([1, $id_course]);

//Modification de la disponibilité du chauffeur
$sql = 'UPDATE chauffeurs SET disponible=? WHERE chauffeur_id=?';
$req = $pdo->prepare($sql);
$req->execute([1, $id_chauffeur]);

phpRedirect("/admin/");