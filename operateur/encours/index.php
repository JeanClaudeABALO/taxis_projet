<?php
session_start();
include_once("../../assets/includes/functionsObject.php");
$id = $_SESSION['info']['id'];
$url1 = "/chauffeur/";
$url2 = "/operateur/";
$url3 = "/";

if (isset($_SESSION['connect']) && $_SESSION['connect'] == "oui") {
    if ($_SESSION['type'] == "operateur") {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Espace Personel | Opérateur Rapido | Courses en cours </title>
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        @media screen and (max-width:768px) {
            .point_depart {
                display: none;
            }
        }
    </style>
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
                            <a class="nav-link text-white" href="/operateur/">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link actif" href="/operateur/encours/">Courses en cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="/operateur/history">Historique</a>
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

            <div class="card mb-5 mt-4">
                <div class="card-header fw-bold ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg> &nbsp;
                    Liste complète de toutes vos courses en cours
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
                            
                                        <th class=" p-2 statut">Statut</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $base = new Base();
                                $opts = new Course($base);
                                $result = $opts->allCoursesOperateur($id, 1);

                                foreach ($result as $a) {
                                    $date_heure = explode(" ", $a['date_heure']);
                                    $date = (new DateTime($date_heure[0]))->format("d-m-Y");
                                    $heure = $date_heure[1];

                                    if (debutTbody($i) == 1) { ?>
                                        <tbody class="tbody">
                                        <?php } ?>
                                        <tr class="text-center border uneLigne">
                                            <td class="border py-3 numero" id="">
                                                RC<?php echo $a['course_id']; ?>
                                            </td>
                                            <td class="border py-3 point_depart"><?php echo $a['point_depart']; ?></td>
                                            <td class="border py-3 point_arrivee"><?php echo $a['point_arrivee']; ?></td>
                                            <td class="border py-3 date"><?php echo $date; ?></td>
                                            <td class="border py-3 heure"><?php echo $heure; ?></td>
                                                                                        <td class="border py-3 statut">
                                                <?php
                                                if ($a['statut'] == 0) { ?>
                                                    <span class="btn bg-warning m-0 py-1 px-2 enattente"> En attente ... </span>
                                                <?php } else if ($a['statut'] == 1) { ?>
                                                    <span class="btn bg-info m-0 py-1 px-2 encours"> En cours ... </span>
                                                <?php } else { ?>
                                                    <span class="btn bg-success text-white m-0 py-1 px-2 terminer"> Terminé </span>
                                                <?php }
                                                ?>
                                            </td>
                                            <td class="border py-3 d-none"><?php echo $a['createdAt']; ?></td>
                                            <td class="border py-3 d-none"><?php echo $a['updatedAt']; ?></td>
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

    <footer class=" bg5  text-white p-2 ">
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
    <script src="/assets/js/stop.js"></script>
    <script src="/assets/js/scriptCourseOperateur.js"></script>
</body>

</html>

<?php
    } else if ($_SESSION['type'] == "chauffeur") {
        $_SESSION['message'] = "Vous n'est pas Opérateur !";
        phpRedirect($url1);
    } else {
        $_SESSION['message'] = "Vous n'est pas Opérateur !";
        phpRedirect($url3);
    }
} else {
    $_SESSION['message'] = "Veuillez vous connecter !";
    phpRedirect($url3);
}
?>