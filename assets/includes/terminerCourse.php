<?php
session_start();
include_once("functionsObject.php");

$id_course = $_POST['course_id'];
$id_chauffeur = $_SESSION['info']['id'];

$base = new Base();
$pdo = $base->connecteBase();


//Modification du statut de la course
$sql = 'UPDATE courses SET statut=? WHERE course_id=?';
$req = $pdo->prepare($sql);
$req->execute([2, $id_course]);


//Compter le nombbre de courses de chauffeur
$sql = 'SELECT *FROM courses WHERE chauffeur_id=? AND statut=?';
$req = $pdo->prepare($sql);
$req->execute([$id_chauffeur, 1]);
$reqs = $req->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
foreach($reqs as $a){
    $i += 1;
}
if ($i == 0) {
    $sql = 'UPDATE chauffeurs SET disponible=? WHERE chauffeur_id=?';
    $req = $pdo->prepare($sql);
    $req->execute([1, $id_chauffeur]);
}

phpRedirect("/chauffeur/");