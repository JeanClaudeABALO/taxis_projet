<?php
session_start();
include_once("functionsObject.php");

$chauffeur = '/chauffeur/';
$operateur = '/operateur/';
$admin = '/admin/';
$top = '/#r';

$type = $_POST['type'];
$tel = $_POST['telephone'];
$mdp = $_POST['mdp'];
$base = new Base();

if ($type == "operateur") {
    $Operateur = new Operateur($tel, $mdp, $base);
    if ($Operateur->connexion() == 0) {
        $_SESSION['message'] = " Bienvenue sur Rapido ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        $_SESSION['operateur'] = $Operateur;
        $_SESSION['connect'] = "oui";
        $_SESSION['info'] = ($Operateur->info()[0] == 0 ? $Operateur->info()[1] : 4);

        phpRedirect($operateur);
    } else if ($Operateur->connexion() == 1) {
        $_SESSION['message'] = " Operateur Inconnu ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    } else if ($Operateur->connexion() == 2) {
        $_SESSION['message'] = " Mot de passe Incorrecte ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    }
} else if ($type == "chauffeur") {
    $Chauffeur = new Chauffeur($tel, $mdp, $base);
    if ($Chauffeur->connexion() == 0) {
        $_SESSION['message'] = " Bienvenue sur Rapido ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        $_SESSION['chauffeur'] = $Chauffeur;
        $_SESSION['connect'] = "oui";
        $_SESSION['info'] = ($Chauffeur->info()[0] == 0 ? $Chauffeur->info()[1] : 4);

        phpRedirect($chauffeur);
    } else if ($Chauffeur->connexion() == 1) {
        $_SESSION['message'] = " Chauffeur Inconnu ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    } else if ($Chauffeur->connexion() == 2) {
        $_SESSION['message'] = " Mot de passe Incorrecte ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    }
} else {
    $Admin = new Admin($tel, $mdp, $base);
    if ($Admin->connexion() == 0) {
        session_destroy();
        session_start();
        $_SESSION['message'] = " Bienvenue sur Rapido ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        $_SESSION['connect'] = "oui";
        $_SESSION['info'] = ($Admin->info()[0] == 0 ? $Admin->info()[1] : 4);

        phpRedirect($admin);
    } else if ($Admin->connexion() == 1) {
        $_SESSION['message'] = " Administrateur Inconnu ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    } else if ($Admin->connexion() == 2) {
        $_SESSION['message'] = " Mot de passe Incorrecte ! ";
        $_SESSION['type'] = $type;
        $_SESSION['tel'] = $tel;
        phpRedirect($top);
    }
}
