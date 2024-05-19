<?php
session_start();
include_once("../assets/includes/functionsObject.php");
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
    <title>Courses RAPIDO | Page Entreprise</title>
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <header class=" bg5 ">
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
                            <a class="nav-link actif" href="/admin/">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/admin/chauffeurs/">Chaufeurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/admin/operateurs/">Operateurs</a>
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
            <span class="ouvreModal btn bg5 text-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                </svg> &nbsp;
                Créer une course
            </span>
        </div>

        <div class="card mb-5 ">
            <div class="card-header fw-bold ">
                Les courses chez RAPIDO
            </div>
            <div class="card-body">
            <table class="table table-hover">
            <thead class="table-dark w-100">
                <tr class="text-center border border-black">
                    <th class=" p-2 numero">N°</th>
                    <th class=" p-2 point_depart">Point de départ</th>
                    <th class=" p-2 point_arrivee">Point d'arrivée</th>
                    <th class=" p-2 date">Date</th>
                    <th class=" p-2 heure">Heure</th>
                    <th class=" p-2 chauffeur">Chauffeur</th>
                    <th class=" p-2 statut">Attribuer</th>
                    <th class=" p-2 statut">Statut</th>
                </tr>
            </thead>
            <?php
            $i = 1;
            $base = new Base();
            $opts = new Course($base);
            $result = $opts->allCourses(1);

            foreach ($result as $a) {
                $date_heure = explode(" ", $a['date_heure']);
                $date = (new DateTime($date_heure[0]))->format("d-m-Y");
                $heure = $date_heure[1];

                if (debutTbody($i) == 1) { ?>
                    <tbody class="tbody">
                    <?php } ?>
                    <form action="<?php if($a['statut'] == 0){
                        echo "/assets/includes/attribuerChauffeur.php";
                    } else if($a['statut'] == 1){
                        echo "/assets/includes/retirerChauffeur.php";
                    } ?>" method="post"> <tr class="text-center border uneLigne" id="tr<?php echo $a['statut']; ?>">
                        <input type="text" value="<?php echo $a['course_id']; ?>" name="course_id" class="d-none">
                        <td class="border py-3 numero" id="">
                            RC<?php echo $a['course_id']; ?>
                        </td>
                        <td class="border py-3 point_depart"><?php echo $a['point_depart']; ?></td>
                        <td class="border py-3 point_arrivee"><?php echo $a['point_arrivee']; ?></td>
                        <td class="border py-3 date"><?php echo $date; ?></td>
                        <td class="border py-3 heure"><?php echo $heure; ?></td>
                        <td class="border py-3 chauffeur">
                            <?php
                            if ($a['statut'] == 1) { ?>
                                <select name="chauf" id="../../assets/includes/attributChauffeur.php?id1=<?php echo $a['course_id']; ?>&id2=" class=" p-1 border selection" disabled>
                                    <?php } else {
                                    if ($a['chauffeur_id'] != null) { ?>
                                        <select name="chauf" id="../../assets/includes/attributChauffeur.php?id1=<?php echo $a['course_id']; ?>&id2=" class=" p-1 border selection deja">
                                        <?php } else { ?>
                                            <select name="chauf" id="../../assets/includes/attributChauffeur.php?id1=<?php echo $a['course_id']; ?>&id2=" class=" p-1 border selection">
                                        <?php }
                                            } ?>
                                        <option value="-1" class=" px-1 py-2 ">Choisir un chauffeur</option>
                                        <option value="" disabled class="bg-success text-white fw-bold">Chauffeurs Disponibles</option>
                                        <?php
                                        $opt2 = new Chauffeur("", "", $base);
                                        $result2 = $opt2->allChauffeurDispo();

                                        foreach ($result2 as $b) {

                                            if ($a['chauffeur_id'] == $b['chauffeur_id']) { ?>
                                                <option class="option" value="<?php echo $b['chauffeur_id']; ?>" selected>
                                                    <?php echo $b['nom'] . ' ' . $b['prenoms'] . ' (' . $b['telephone'] . ')'; ?>
                                                </option>
                                            <?php } else { ?>
                                                <option class="option" value="<?php echo $b['chauffeur_id']; ?>">
                                                    <?php echo $b['nom'] . ' ' . $b['prenoms'] . ' (' . $b['telephone'] . ')'; ?>
                                                </option>
                                        <?php }
                                        }
                                        ?>
                                        <option value="" disabled class=" bg-danger text-white fw-bold">Chauffeurs non disponibles</option>

                                        <?php
                                        $result2 = $opt2->allChauffeurOccup();

                                        foreach ($result2 as $b) {

                                            if ($a['chauffeur_id'] == $b['chauffeur_id']) { ?>
                                                <option class="option" value="<?php echo $b['chauffeur_id']; ?>" selected>
                                                    <?php echo $b['nom'] . ' ' . $b['prenoms'] . ' (' . $b['telephone'] . ')'; ?>
                                                </option>
                                            <?php } else { ?>
                                                <option class="option" value="<?php echo $b['chauffeur_id']; ?>">
                                                    <?php echo $b['nom'] . ' ' . $b['prenoms'] . ' (' . $b['telephone'] . ')'; ?>
                                                </option>
                                        <?php }
                                        }
                                        ?>
                                            </select>
                        </td>
                        <td class="border py-3">

                            <?php if ($a['statut'] == 0) { ?>
                                <input class="btn bg-warning text-dark m-0 py-1 px-2 enattente" type="submit" value="Attribuer">
                            <?php } else if($a['statut'] == 1) { ?>                                                 
                                <input class="btn bg-warning text-dark m-0 py-1 px-2 enattente" type="submit" value="Retirer">
                                <?php } else { ?>                                                 
                                    <input class="btn bg-warning text-dark m-0 py-1 px-2 enattente" type="submit" value="Fin" disabled>
                                <?php } ?>
                        </td>
                        <td class="border py-3 statut">
                            <?php
                            if ($a['statut'] == 0) { ?>
                                <span class="btn bg-danger text-white m-0 py-1 px-2 enattente"> En attente ... </span>
                            <?php } else if ($a['statut'] == 1) { ?>
                                <span class="btn bg-info m-0 py-1 px-2 encours"> En cours ... </span>
                            <?php } else { ?>
                                <span class="btn bg-success text-white m-0 py-1 px-2 terminer"> Terminée </span>
                            <?php }
                            ?>
                        </td>
                        <td class="border py-3 d-none"><?php echo $a['createdAt']; ?></td>
                        <td class="border py-3 d-none"><?php echo $a['updatedAt']; ?></td>
                    </tr>
                </form>
                    <?php if (debutTbody($i) == 2) { ?>
                    </tbody>
                <?php }
                    $i = $i + 1;
                }
                if (debutTbody($i - 1) != 2) { ?>
                </tbody>
            <?php } ?>
        </table>

                <div class="p-3 d-flex flex-column align-items-end ">
                    <div class="row w-auto align-items-center mx-3 ">
                        <div class="col-3">
                            <span class="precedent btn bg4 text-primary w-auto ">
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
                            <span class="suivant btn bg4 text-primary w-auto ">
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
                        <a href="/assets/includes/deconnect.php" class="btn logout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="white" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </footer>
    
    <div class="courseModal p-0 pt-5 ">
        <div class="courseModal-content mx-auto p-1">
            <span class="close">&times;</span>
            <div class="container py-3 ">
                <h3 class="modalTitle">Renseigner une course !</h3>
                <form action="" method="post" class=" p-3 laforme">
                    <div class="row mb-1 p-3 ">
                        <div class="form-floating border border-2 border-dark-subtle rounded-2 p-0 ">
                            <input type="text" class="form-control" id="floatingInput" placeholder="ex: Dangbo " name="point_depart" required>
                            <label for="floatingInput">Point de départ :</label>
                        </div>
                    </div>
                    <div class="row mb-1 p-3 ">
                        <div class="form-floating border border-2 border-dark-subtle rounded-2 p-0 ">
                            <input type="text" class="form-control" id="floatingInput" placeholder="ex: Dangbo " name="point_arrivee" required>
                            <label for="floatingInput">Point d'arrivée :</label>
                        </div>
                    </div>
                    <div class="row mb-3 p-0 ">
                        <div class="col-12 col-sm-6 p-3">
                            <div class="form-floating border border-2 border-dark-subtle rounded-2 p-0">
                                <input type="date" class="form-control" id="floatingInput" placeholder="ex: Dangbo " name="date" required>
                                <label for="floatingInput">Date :</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 p-3">
                            <div class="form-floating border border-2 border-dark-subtle rounded-2 p-0 ">
                                <input type="time" class="form-control" id="floatingInput" placeholder="ex: 15 : 00" name="heuredepart" required>
                                <label for="floatingInput">Heure :</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 p-0 ">
                        <div class="col-12 col-sm-6 p-3">
                            <input type="reset" value="Annuler" class=" w-100 border-0 py-3 bg-danger text-white rounded-2 ">
                        </div>
                        <div class="col-12 col-sm-6 p-3">
                            <input type="submit" value="Enrégistrer" class=" w-100 border-0 py-3 bg-success text-light rounded-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <script src="/assets/js/stop.js"></script>
    <script src="/assets/js/scriptCourse.js"></script>
    
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