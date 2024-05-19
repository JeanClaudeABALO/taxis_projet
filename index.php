<?php
session_start();
include_once("assets/includes/functionsObject.php");
$url1 = "/chauffeur/";
$url2 = "/admin/";
$url3 = "/operateur/";
if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
    if ($_SESSION['type'] == "chauffeur") {
        phpRedirect($url1);
    } else if ($_SESSION['type'] == "operateur") {
        phpRedirect($url3);
    } else {
        phpRedirect($url2);
    }
} else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAPIDO | Connexion </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
</head>

<body>
    <div class="container-sm pt-5 pb-5">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 pt-2 mon-bg-3 rounded-4">
                <div class="login-form monbg-color-2 pt-4 pb-4 rounded-4 shadow">
                    <img src="assets/images/logo.png" alt="logo Rapido" width="100px
                " class="d-block mx-auto logo-rapido">
                    <h2 class="text-center mx-5 mb-3 text-light p-2 pb-3 border-bottom ">Page de Connexion</h2>
                    <form action="assets/includes/loginControl.php" method="post">
                        <div class="row align-items-center form-group pb-3 pt-3 mx-5">
                            <div class="col-4 p-0">
                                <label for="type" class="form-label text-light h6">Type :</label>
                            </div>
                            <div class="col-8 p-0">
                                <?php
                                if (isset($_SESSION['type']) && $_SESSION['type'] != "") {
                                    if ($_SESSION['type'] == "operateur") {
                                        echo '<select class="form-control text-center" name="type" id="type" value="admin"> <option value="operateur" selected>Opérateur</option> <option value="chauffeur">Chauffeur</option> <option value="admin">Administrateur</option> </select>';
                                    } else if ($_SESSION['type'] == "admin") {
                                        echo '<select class="form-control text-center" name="type" id="type" value="admin"> <option value="operateur">Opérateur</option> <option value="chauffeur">Chauffeur</option> <option value="admin" selected>Administrateur</option> </select>';
                                    } else {
                                        echo '<select class="form-control text-center" name="type" id="type" value="admin"> <option value="operateur">Opérateur</option> <option value="chauffeur" selected>Chauffeur</option> <option value="admin">Administrateur</option> </select>';
                                    }
                                } else {
                                    echo '<select class="form-control text-center" name="type" id="type" value="admin"> <option value="operateur">Opérateur</option> <option value="chauffeur" selected>Chauffeur</option> <option value="admin">Administrateur</option> </select>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row align-items-center form-group pb-3 pt-3 mx-5">
                            <div class="col-4 p-0">
                                <label for="telephone" class="text-light h6">Téléphone :</label>
                            </div>
                            <div class="col-8 p-0">
                                <?php
                                if (isset($_SESSION['tel']) && $_SESSION['tel'] != "") {
                                    echo '<input type="tel" id="telephone" name="telephone" class="form-control text-center" placeholder="EX : 90 00 00 00" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" title="Veuillez saisir un numéro de téléphone valide (ex: 90 00 00 00)" value="' . $_SESSION['tel'] . '" required>';
                                } else {
                                    echo '<input type="tel" id="telephone" name="telephone" class="form-control text-center" placeholder="EX : 90 00 00 00" pattern="[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}" title="Veuillez saisir un numéro de téléphone valide (ex: 90 00 00 00)" required>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row align-items-center form-group pb-4 pt-3 mx-5 border-bottom">
                            <div class="col-4 p-0">
                                <label for="password" class="text-light h6">Mot de passe :</label>
                            </div>
                            <div class="col-8 p-0">
                                <input type="password" name="mdp" id="password" class="form-control text-center " placeholder="Mot de passe" required>
                            </div>
                        </div>
                        <div class="row form-group px-4 pb-2 m-1 mb-0">
                            <div class="col-4"></div>
                            <div class="col-8 d-flex align-items-end justify-content-end px-4">
                                <button type="submit" class="btn btn-primary btn-block mt-3 d-block mb-lg-auto" id="r">Se connecter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
<?php } ?>