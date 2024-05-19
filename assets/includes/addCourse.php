<?php
session_start();
include_once("functionsObject.php");
$url1 = "/chauffeur/";
$url2 = "/operateur/";
$url3 = "/";
$url4 = "/admin/";

$date = $_POST['date'] . ' ' . $_POST['heuredepart'];
$date = new DateTime($date);
$date = $date->format('Y-m-d H:i:s');

$id = $_SESSION['info']['id'];

if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
    if ($_SESSION['type'] == "admin") {

        $donnee = array(
            'point_depart' => $_POST['point_depart'],
            'point_arrivee' => $_POST['point_arrivee'],
            'date_heure' => $date,
            'admin_created_id' => $id,
            'statut' => 0
        );

        $base = new Base();

        $course = new Course($base, $donnee);
        if ($course->addCourseAsAdmin($id) == 0) {
            $_SESSION['message'] = " Course ajoutée avec succès !";
            phpRedirect($url4);
        } else {
            $_SESSION['message'] = "Erreur, course non ajoutée !";
            phpRedirect($url4);
        }
    } else if ($_SESSION['type'] == "chauffeur") {
        $_SESSION['message'] = "Vous n'est pas Administrateur !";
        phpRedirect($url1);
    } else {
        $_SESSION['message'] = "Vous n'est pas Administrateur !";
        phpRedirect($url2);
    }
} else {
    $_SESSION['message'] = "Veuillez vous connecter !";
    phpRedirect($url3);
}
