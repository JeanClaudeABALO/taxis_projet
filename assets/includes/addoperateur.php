<?php
session_start();
include_once("functionsObject.php");
$url1 = "/chauffeur/";
$url2 = "/operateur/";
$url3 = "/";
$url4 = "/admin/operateurs/";

$id = $_SESSION['info']['id'];

if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
    if ($_SESSION['type'] == "admin") {

        $donnee = array(
            'nom' => $_POST['nom'],
            'prenoms' => $_POST['prenoms'],
            'telephone' => $_POST['telephone'],
            'email' => $_POST["email"],
            'sexe' => $_POST['sexe'],
            'mot_de_passe' => md5(defaultMdp($_POST['nom'], $_POST['telephone']))
        );

        $base = new Base();

        $Operateur = new Operateur($donnee['telephone'], $donnee['mot_de_passe'], $base);

        if ($Operateur->addOperateur($donnee, $id) == 0) {
            $_SESSION['message'] = " Opérateur ajouté avec succès ! ";
            phpRedirect($url4);
        } else {
            $_SESSION['message'] = " Echec lors de l'ajout de l'opérateur ! ";
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