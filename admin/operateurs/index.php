
<?php 
    session_start();
    include_once("../../assets/includes/functionsObject.php");
    $url1 = "/chauffeur/";
    $url2 = "/operateur/";
    $url3 = "/";

    if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
        if ($_SESSION['type'] == "admin") {
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAPIDO | Admin | Opérateurs </title>
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/addoperator.css">
</head>

<body>

    <header class=" mon-bg-5">
        <!-- Céation du menu -->

        <nav class="navbar navbar-expand-lg monbg-color-2 p-0 ">
            <div class="container">
                <a class="navbar-brand" href="#"><img src="/assets/images/logo.png" width="40px" alt=""></a>
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/admin/">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/admin/chauffeurs/">Chaufeurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link actif" href="/admin/operateurs/">Operateurs</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search">
                        <button class="btn btn-outline-success bg-black text-white border-black" type="submit">Rechercher</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- fin du menu -->
    </header>

    <div class="container-fluid contenu">
        <div class="container">
            <div class="add-operator p-3 d-flex flex-column align-items-end ">
                <span class="ouvreModal btn bg-success text-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                    </svg>
                    Ajouter
                </span>
            </div>




            <div class="card mb-5 ">
                <div class="card-header fw-bold ">
                    Les Opérateurs chez RAPIDO
                </div>
                <div class="card-body">
                    
                <table class="table table-hover">
    <thead class="table-dark w-100">
        <tr class="text-center border border-black">
            <th class="numero">N°</th>
            <th class="nom">Nom</th>
            <th class="prenoms">Prénoms</th>
            <th class="telephone">Téléphone</th>
            <th class="email">E-mail</th>
            <th class="sexe">Sexe</th>
            <th colspan="1" class="operations">Opérations</th>
        </tr>
    </thead>
    <?php
    $i = 1;
    $base = new Base();
    $opts = new Operateur("", "", $base);
    $result = $opts->allOperateur(1);

    foreach ($result as $a) {

        if (debutTbody($i) == 1) { ?>
            <tbody class="tbody">
            <?php } ?>

            <tr class="text-center border nom<?php echo $a['telephone']; ?>">
                <td class=" border py-3 numero" id="/assets/includes/updateOperateur.php?id=<?php echo $a['operateur_id']; ?>"><?php echo $i; ?></td>
                <td class=" border py-3 nom"><?php echo $a['nom']; ?></td>
                <td class=" border py-3 prenoms"><?php echo $a['prenoms']; ?></td>
                <td class=" border py-3 telephone"><?php echo $a['telephone']; ?></td>
                <td class=" border py-3 email"><?php echo $a['email']; ?></td>
                <td class=" border py-3 sexe"><?php echo $a['sexe']; ?></td>
                <td class=" border py-3 d-none"><?php echo $a['createdAt']; ?></td>
                <td class=" border py-3 d-none"><?php echo $a['updatedAt']; ?></td>
                <td class="operations py-3">
                    <a href="#premier-index" class="btn fw-bold py-0 px-2 action1 modifier" id="nom<?php echo $a['telephone']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                        Modifier
                    </a>
                </td>
                <td class=" border py-3 d-none">/assets/includes/defaultOperateurPasse.php?id=<?php echo $a['operateur_id']; ?></td>
            </tr>
            <?php if (debutTbody($i) == 2) { ?>
            </tbody>
        <?php }
            $i = $i + 1;
        }
        if (debutTbody($i - 1) != 2) { ?>
        </tbody>
    <?php } ?>
</table>

                </div>

                <div class="p-3 d-flex flex-column align-items-end ">
                    <div class="row w-auto align-items-center mx-3 ">
                        <div class="col-3">
                            <span class="precedent btn bg-danger-subtle text-primary w-auto ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                </svg>
                            </span>
                        </div>
                        <div class="col-6 text-center">
                            <span class="spnote p-2 w-auto">
                                100/200
                            </span>
                        </div>
                        <div class="col-3">
                            <span class="suivant btn bg-danger-subtle text-primary w-auto ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer class=" bg5 p-2 text-white">
            <div class="container">
                <div class="row">

                    <div class="col">
                        <div class="" style="text-align: right">
                        <a href="/assets/includes/deconnect.php" class="logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="blue" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </footer>
        <div class="ajoutModal p-0 pt-5">
                <div class="ajoutModal-content">
                    <span class="close">&times;</span>
                    <div class="image-formulaire">
                        <div class="images">
                            <img src="/assets/images/io1.webp" width="100%">
                            <div class="flootage"></div>
                        </div>
                        <div class="formulaire container" id="premier-index">
                            <h3>Ajouter Un chauffeur</h3>
                            <form method="post" class="formemaj">
                                <label for="nom">Nom :</label><br>
                                <input type="text" name="nom" id="nom" placeholder="nom du chauffeur ...">
                                <label for="prenoms">Prénoms :</label><br>
                                <input type="text" name="prenoms" placeholder="prénoms du chauffeur" id="nom">
                                <label for="email">Email :</label><br>
                                <input type="email" name="email" id="email" placeholder="ex: exemple@gmail.com">
                                <label for="telephone">Téléphone :</label><br>
                                <input type="telephone" name="telephone" id="telephone" placeholder="ex: 63116556">
                                <label for="sexe">Sexe :</label><br>
                                <select name="sexe" id="sexe" required>
                                    <option value="M">M</option>
                                    <option value="F">F</option>
                                </select>
                                <input type="submit" value="Ajouter Chauffeur" class="bg-success text-light border-0 mt-4">
                                <hr>
                                <input type="reset" value="Nettoyer les champs" class="bg-warning border-0">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="/assets/js/operateuradmin.js"></script>

</body>

</html>
<?php
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
?>