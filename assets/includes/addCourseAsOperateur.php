<?php
session_start();
include_once("functionsObject.php");

$url1 = "/chauffeur/";
$url2 = "/admin/";
$url3 = "/";
$url4 = "/operateur/";

$date = $_POST['date'] . ' ' . $_POST['heuredepart'];
$date = new DateTime($date);
$date = $date->format('Y-m-d H:i:s');

$id1 = $_SESSION['info']['id'];

if (isset($_SESSION['IDparticule'])) {
    $id2 = $_SESSION['IDparticule'];
}

if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
    if ($_SESSION['type'] == "operateur") {

        $donnee = array(
            'point_depart' => $_POST['point_depart'],
            'point_arrivee' => $_POST['point_arrivee'],
            'date_heure' => $date,
            'operateur_id' => $id1,
            'statut' => 0
        );

        $base = new Base();

        $course = new Course($base, $donnee);
        if ($course->addCourseAsOperateur() == 0) {
            $_SESSION['message'] = " Course ajoutée avec succès !";
            phpRedirect($url4);
        } else {
            $_SESSION['message'] = "Erreur, course non ajoutée !";
            phpRedirect($url4);
        }
    } else if ($_SESSION['type'] == "chauffeur") {
        $_SESSION['message'] = "Vous n'est pas Opérateur !";
        phpRedirect($url1);
    } } else {
    $_SESSION['message'] = "Veuillez vous connecter !";
    phpRedirect($url3);
}