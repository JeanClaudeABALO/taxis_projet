<?php

//fonction de redirection avec php
function phpRedirect($url, $statusCode = 302)
{
    header('Location: ' . $url, true, $statusCode);
    exit();
}
//créaction de la classe de Base
class Base
{
    protected $server = "localhost";
    protected $user = "root";
    protected $mdp = "";
    protected $bdd = "rapido";
    protected $connexion;

    public function __construct($serveur = null, $utilisateur = null, $mdp = null, $bdd = null)
    {
        if ($serveur !== null) {
            $this->server = $serveur;
        }
        if ($utilisateur !== null) {
            $this->user = $utilisateur;
        }
        if ($mdp !== null) {
            $this->mdp = $mdp;
        }
        if ($bdd !== null) {
            $this->bdd = $bdd;
        }
    }

    public function connecteBase($i = null)
    {
        try {
            $this->connexion = new PDO("mysql:host=$this->server;dbname=$this->bdd", $this->user, $this->mdp);

            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            if ($i == null) {
                echo "Erreur de connexion : " . $e->getMessage();
            }
        }

        return $this->connexion;
    }

    public function closeBase()
    {
        $this->connexion = null;
    }
}
//classe utilisateurs
class Users
{
    protected $tel;
    protected $mdp;

    public function __construct($tel = null, $mdp = null)
    {
        if ($tel != null) {
            $this->tel = $tel;
        }
        if ($mdp != null) {
            $this->mdp = $mdp;
        }
    }

    public function nbreChauffeurs($base = new Base())
    {
        $pdo = $base->connecteBase();
        $sql = 'SELECT * FROM chauffeurs';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }

    public function nbreOperateurs($base = new Base())
    {
        $pdo = $base->connecteBase();
        $sql = 'SELECT * FROM operateurs';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }
}
//classe chauffeurs
class Chauffeur extends Users
{
    protected $base;

    public function __construct($tel = null, $mdp = null, $base = null)
    {
        parent::__construct($tel, $mdp);
        if ($base != null) {
            $this->base = $base;
        }
    }

    public function connexion()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM chauffeurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $this->base->closeBase();
                return 0;
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return 2;
            }
        }

        $this->base->closeBase();
        return 1;
    }

    public function pasTelephone()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM chauffeurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel) {
                $this->base->closeBase();
                return 0;
            }
        }

        $this->base->closeBase();
        return 1;
    }

    public function originalNumber($num, $id)
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM chauffeurs WHERE chauffeur_id=' . $id . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['chauffeur_id'] == $id) {
                $this->base->closeBase();
                if ($requet['telephone'] == $num) {
                    return 1;
                } else {
                    return 2;
                }
            }
        }

        return 0;
    }

    public function updateChauffeur($donnee, $id)
    {
        if ($this->pasTelephone() == 1) {
            $pdo = $this->base->connecteBase();
            $sql = 'UPDATE chauffeurs SET nom=?, prenoms=?, telephone=?, email=?, sexe=?, mot_de_passe=? WHERE chauffeur_id=' . $id . '';
            $req = $pdo->prepare($sql);
            try {
                $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe'], $donnee['mot_de_passe']]);
                $this->base->closeBase();
                return 0;
            } catch (PDOException $e) {
                $this->base->closeBase();
                return 1;
            }
        } else {
            if ($this->originalNumber($donnee['telephone'], $id) == 1) {
                $pdo = $this->base->connecteBase();
                $sql = 'UPDATE chauffeurs SET nom=?, prenoms=?, telephone=?, email=?, sexe=?, mot_de_passe=? WHERE chauffeur_id=' . $id . '';
                $req = $pdo->prepare($sql);
                try {
                    $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe'], $donnee['mot_de_passe']]);
                    $this->base->closeBase();
                    return 0;
                } catch (PDOException $e) {
                    $this->base->closeBase();
                    return 1;
                }
            }
        }
        return 2;
    }

    public function addChauffeur($donnee, $creator_id)
    {
        if ($this->pasTelephone() == 1) {
            $pdo = $this->base->connecteBase();
            $sql = 'INSERT INTO chauffeurs (nom, prenoms, telephone, email, sexe, mot_de_passe, disponible, admin_created_id) VALUES (?,?,?,?,?,?,?,?)';
            $req = $pdo->prepare($sql);
            try {
                $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe'], $donnee['mot_de_passe'], $donnee['disponible'], $creator_id]);
                $this->base->closeBase();
                return 0;
            } catch (PDOException $e) {
                $this->base->closeBase();
                return 1;
            }
        }
        return 1;
    }

    public function allChauffeurDispo()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM chauffeurs WHERE disponible=0';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }

    public function allChauffeurOccup()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM chauffeurs WHERE disponible=1';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }

    public function allChauffeur()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM chauffeurs';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }

    public function info()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM chauffeurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $donnees = array(
                    "id" => $requet['chauffeur_id'],
                    "nom" => $requet['nom'],
                    "prenoms" => $requet['prenoms'],
                    "email" => $requet['email'],
                    "telephone" => $requet['telephone'],
                    "mdp" => $requet['mot_de_passe'],
                    "sexe" => $requet['sexe'],
                    "disponible" => $requet['disponible'],
                    "createdAt" => $requet['createdAt'],
                    "updatedAt" => $requet['updatedAt']
                );
                $this->base->closeBase();
                return [0, $donnees];
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return [2];
            }
        }
        $this->base->closeBase();
        return [1];
    }
}
//classe opérateur
class Operateur extends Users
{
    protected $base;

    public function __construct($tel = null, $mdp = null, $base = null)
    {
        parent::__construct($tel, $mdp);

        if ($base != null) {
            $this->base = $base;
        }
    }

    public function connexion()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM operateurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $this->base->closeBase();
                return 0;
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return 2;
            }
        }

        $this->base->closeBase();
        return 1;
    }

    public function pasTelephone()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM operateurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel) {
                $this->base->closeBase();
                return 0;
            }
        }

        $this->base->closeBase();
        return 1;
    }

    public function originalNumber($num, $id)
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM operateurs WHERE operateur_id=' . $id . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['operateur_id'] == $id) {
                $this->base->closeBase();
                if ($requet['telephone'] == $num) {
                    return 1;
                } else {
                    return 2;
                }
            }
        }

        return 0;
    }

    public function addOperateur($donnee, $creator_id)
    {
        if ($this->pasTelephone() == 1) {
            $pdo = $this->base->connecteBase();
            $sql = 'INSERT INTO operateurs (nom, prenoms, telephone, email, sexe, mot_de_passe, creator_id) VALUES (?,?,?,?,?,?,?)';
            $req = $pdo->prepare($sql);
            try {
                $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe'], $donnee['mot_de_passe'], $creator_id]);
                $this->base->closeBase();
                return 0;
            } catch (PDOException $e) {
                $this->base->closeBase();
                return 1;
            }
        }

        return 1;
    }

    public function updateOperateur($donnee, $id)
    {
        if ($this->pasTelephone() == 1) {
            $pdo = $this->base->connecteBase();
            $sql = 'UPDATE operateurs SET nom=?, prenoms=?, telephone=?, email=?, sexe=? WHERE operateur_id=' . $id . '';
            $req = $pdo->prepare($sql);
            try {
                $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe']]);
                $this->base->closeBase();
                return 0;
            } catch (PDOException $e) {
                $this->base->closeBase();
                return 1;
            }
        } else {
            if ($this->originalNumber($donnee['telephone'], $id) == 1) {
                $pdo = $this->base->connecteBase();
                $sql = 'UPDATE operateurs SET nom=?, prenoms=?, telephone=?, email=?, sexe=? WHERE operateur_id=' . $id . '';
                $req = $pdo->prepare($sql);
                try {
                    $req->execute([$donnee['nom'], $donnee['prenoms'], $donnee['telephone'], $donnee['email'], $donnee['sexe']]);
                    $this->base->closeBase();
                    return 0;
                } catch (PDOException $e) {
                    $this->base->closeBase();
                    return 1;
                }
            }
        }
        return 2;
    }

    public function allOperateur($a = 0)
    {
        $pdo = $this->base->connecteBase(1);
        if ($a == 0) {
            $sql = 'SELECT * FROM operateurs';
        } else {
            $sql = 'SELECT * FROM operateurs ORDER BY operateur_id DESC';
        }

        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }

    public function info()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM operateurs WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $donnees = array(
                    "id" => $requet['operateur_id'],
                    "nom" => $requet['nom'],
                    "prenoms" => $requet['prenoms'],
                    "email" => $requet['email'],
                    "telephone" => $requet['telephone'],
                    "mdp" => $requet['mot_de_passe'],
                    "sexe" => $requet['sexe'],
                    "createdAt" => $requet['createdAt'],
                    "updatedAt" => $requet['updatedAt']
                );
                $this->base->closeBase();
                return [0, $donnees];
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return [2];
            }
        }
        $this->base->closeBase();
        return [1];
    }
}
//classe administrateur
class  Admin extends Users
{
    protected $base;

    public function __construct($tel, $mdp, $base)
    {
        parent::__construct($tel, $mdp);
        $this->base = $base;
    }

    public function connexion()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM admin_table WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $this->base->closeBase();
                return 0;
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return 2;
            }
        }

        $this->base->closeBase();
        return 1;
    }

    public function info()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'SELECT * FROM admin_table WHERE telephone=' . $this->tel . '';
        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        foreach ($reqs as $requet) {
            if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] == md5($this->mdp)) {
                $donnees = array(
                    "id" => $requet['admin_id'],
                    "nom" => $requet['nom'],
                    "prenoms" => $requet['prenoms'],
                    "email" => $requet['email'],
                    "telephone" => $requet['telephone'],
                    "mdp" => $requet['mot_de_passe'],
                    "createdAt" => $requet['createdAt'],
                    "updatedAt" => $requet['updatedAt']
                );
                $this->base->closeBase();
                return [0, $donnees];
            } else if ($requet['telephone'] == $this->tel && $requet["mot_de_passe"] != md5($this->mdp)) {
                $this->base->closeBase();
                return [2];
            }
        }
        $this->base->closeBase();
        return [1];
    }
}

//classe course
class Course
{
    protected $donnee = array();
    protected $base;

    public function __construct($base = null, $donnee = null)
    {
        if ($base) {
            $this->base = $base;
        }
        if ($donnee) {
            $this->donnee = $donnee;
        }
    }

    public function addCourseAsAdmin($id)
    {
        $pdo = $this->base->connecteBase();
        $sql = 'INSERT INTO courses (point_depart, point_arrivee, date_heure, admin_created_id, statut) VALUES (?,?,?,?,?)';
        $req = $pdo->prepare($sql);

        try {
            $req->execute([$this->donnee['point_depart'], $this->donnee['point_arrivee'], $this->donnee['date_heure'], $id, $this->donnee['statut']]);

            echo "Course correctement ajoutée !";

            return 0;
        } catch (PDOException $e) {

            echo "erreur " . $e->getMessage();

            return 1;
        }
    }

    public function addCourseAsOperateur()
    {
        $pdo = $this->base->connecteBase();
        $sql = 'INSERT INTO courses (point_depart, point_arrivee, date_heure, operateur_id, statut) VALUES (?,?,?,?,?)';
        $req = $pdo->prepare($sql);

        try {
            $req->execute([$this->donnee['point_depart'], $this->donnee['point_arrivee'], $this->donnee['date_heure'], $this->donnee['operateur_id'], $this->donnee['statut']]);
            return 0;
        } catch (PDOException $e) {
            echo "erreur " . $e->getMessage();
            return 1;
        }
    }

    public function attributChauffeur($id1, $id2, $d)
    {
        if ($id2 == -1) {

            $pdo = $this->base->connecteBase();

            $sql = 'SELECT * FROM courses WHERE course_id=' . $id1;
            $req = $pdo->prepare($sql);
            $req->execute();
            $reqs = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($reqs as $a) {
                if ($a['statut'] != 2) {
                    $sql = 'UPDATE courses SET chauffeur_id=? WHERE course_id=' . $id1 . '';
                    $req = $pdo->prepare($sql);

                    try {
                        $req->execute([null]);
                    } catch (PDOException $e) {
                        echo "erreur " . $e->getMessage();
                        return 1;
                    }

                    $sql = 'UPDATE courses SET statut=? WHERE course_id=' . $id1 . '';
                    $req = $pdo->prepare($sql);

                    try {
                        $req->execute([0]);
                    } catch (PDOException $e) {
                        echo "erreur " . $e->getMessage();
                        return 2;
                    }

                    $i = 0;
                    $sql = 'SELECT * FROM courses';
                    $req = $pdo->prepare($sql);
                    $req->execute();
                    $reqs = $req->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($reqs as $a) {
                        if ($a['chauffeur_id'] == $d) {
                            $i = $i + 1;
                        }
                    }

                    if ($i == 0) {
                        $sql = 'UPDATE chauffeurs SET disponible=? WHERE chauffeur_id=' . $d . '';
                        $req = $pdo->prepare($sql);

                        try {
                            $req->execute([0]);
                        } catch (PDOException $e) {
                            echo "erreur " . $e->getMessage();
                            return 2;
                        }
                    }
                }
            }

            $sql = 'SELECT * FROM courses WHERE course_id=' . $id1 . '';
            $req = $pdo->prepare($sql);
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            $jsonData = json_encode($donnees);

            return $jsonData;
        } else {

            $pdo = $this->base->connecteBase();
            $sql = 'SELECT * FROM courses WHERE course_id=' . $id1;
            $req = $pdo->prepare($sql);
            $req->execute();
            $reqs = $req->fetchAll(PDO::FETCH_ASSOC);
            foreach ($reqs as $a) {
                if ($a['statut'] != 2) {

                    $sql = 'UPDATE courses SET chauffeur_id=? WHERE course_id=' . $id1 . '';
                    $req = $pdo->prepare($sql);

                    try {
                        $req->execute([$id2]);
                    } catch (PDOException $e) {
                        echo "erreur " . $e->getMessage();
                        return 1;
                    }

                    $sql = 'UPDATE courses SET statut=? WHERE course_id=' . $id1 . '';
                    $req = $pdo->prepare($sql);

                    try {
                        $req->execute([1]);
                    } catch (PDOException $e) {
                        echo "erreur " . $e->getMessage();
                        return 2;
                    }

                    $sql = 'UPDATE chauffeurs SET disponible=? WHERE chauffeur_id=' . $id2 . '';
                    $req = $pdo->prepare($sql);

                    try {
                        $req->execute([1]);
                    } catch (PDOException $e) {
                        echo "erreur " . $e->getMessage();
                        return 2;
                    }
                }
            }

            $sql = 'SELECT * FROM courses WHERE course_id=' . $id1 . '';
            $req = $pdo->prepare($sql);
            $req->execute();
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            $jsonData = json_encode($donnees);

            return $jsonData;
        }
    }

    public function allCourses($a = 0)
    {
        $pdo = $this->base->connecteBase(1);
        if ($a == 0) {
            $sql = 'SELECT * FROM courses';
        } else {
            $sql = 'SELECT * FROM courses ORDER BY course_id DESC';
        }

        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }

    public function allCoursesOfChauffeur($id, $b = 0, $a = 0)
    {
        if ($b != 0) {
            $pdo = $this->base->connecteBase(1);
            if ($a == 0) {
                $sql = 'SELECT * FROM courses WHERE chauffeur_id=' . $id . ' AND statut=2';
            } else {
                $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE chauffeur_id=' . $id . ' AND statut=2';
            }
            $req = $pdo->prepare($sql);
            $req->execute();

            $reqs = $req->fetchAll();

            $this->base->closeBase();
            return $reqs;
        } else {
            $pdo = $this->base->connecteBase(1);
            if ($a == 0) {
                $sql = 'SELECT * FROM courses WHERE chauffeur_id=' . $id . ' AND statut=1';
            } else {
                $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE chauffeur_id=' . $id . ' AND statut=1';
            }
            $req = $pdo->prepare($sql);
            $req->execute();

            $reqs = $req->fetchAll();

            $this->base->closeBase();
            return $reqs;
        }
    }

    public function allCoursesOperateur($id, $b = 0, $a = 0)
    {
        if ($b == 0) {
            $pdo = $this->base->connecteBase(1);
            if ($a == 0) {
                $sql = 'SELECT * FROM courses WHERE operateur_id=' . $id . '';
            } else {
                $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE operateur_id = ' . $id;
            }

            $req = $pdo->prepare($sql);
            $req->execute();
            $donnees = array();

            $reqs = $req->fetchAll();

            $dateActuelle = date("Y-m-d");

            foreach ($reqs as $a) {
                //$date_heure = explode(" ", $a['date_heure']);
                //$date = (new DateTime($date_heure[0]))->format("Y-m-d");
                if ($a['statut'] == 0) {
                    $donnees[] = $a;
                }
            }

            $this->base->closeBase();
            return $donnees;
        } else if ($b == 1) {
            $pdo = $this->base->connecteBase(1);
            if ($a == 0) {
                $sql = 'SELECT * FROM courses WHERE operateur_id=' . $id . '';
            } else {
                $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE operateur_id=' . $id . '';
            }

            $req = $pdo->prepare($sql);
            $req->execute();
            $donnees = array();

            $reqs = $req->fetchAll();

            $dateActuelle = date("Y-m-d");

            foreach ($reqs as $a) {
                //$date_heure = explode(" ", $a['date_heure']);
                //$date = (new DateTime($date_heure[0]))->format("Y-m-d");
                if ($a['statut'] == 1) {
                    $donnees[] = $a;
                }
            }

            $this->base->closeBase();
            return $donnees;
        } else if ($b == 2) {
            $pdo = $this->base->connecteBase(1);
            if ($a == 0) {
                $sql = 'SELECT * FROM courses WHERE operateur_id=' . $id . '';
            } else {
                $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE operateur_id=' . $id . '';
            }

            $req = $pdo->prepare($sql);
            $req->execute();
            $donnees = array();

            $reqs = $req->fetchAll();

            $dateActuelle = date("Y-m-d");

            foreach ($reqs as $a) {
                //$date_heure = explode(" ", $a['date_heure']);
                //$date = (new DateTime($date_heure[0]))->format("Y-m-d");
                if ($a['statut'] == 2) {
                    $donnees[] = $a;
                }
            }

            $this->base->closeBase();
            return $donnees;
        }

        $pdo = $this->base->connecteBase(1);
        if ($a == 0) {
            $sql = 'SELECT * FROM courses WHERE operateur_id=' . $id . '';
        } else {
            $sql = 'SELECT * FROM courses ORDER BY course_id DESC WHERE operateur_id=' . $id . '';
        }

        $req = $pdo->prepare($sql);
        $req->execute();

        $reqs = $req->fetchAll();

        $this->base->closeBase();
        return $reqs;
    }


    public function marqueCourseTermine($id1, $id2)
    {
        $pdo = $this->base->connecteBase(1);

        $sql = 'UPDATE courses SET statut=? WHERE course_id=' . $id1 . '';
        $req = $pdo->prepare($sql);

        try {
            $req->execute([2]);
        } catch (PDOException $e) {
            echo "erreur " . $e->getMessage();
            return 2;
        }

        $i = 0;
        $sql = 'SELECT * FROM courses WHERE statut=1';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll(PDO::FETCH_ASSOC);
        foreach ($reqs as $a) {
            if ($a['chauffeur_id'] == $id2) {
                $i = $i + 1;
            }
        }

        if ($i == 0) {
            $sql = 'UPDATE chauffeurs SET disponible=? WHERE chauffeur_id=' . $id2 . '';
            $req = $pdo->prepare($sql);

            try {
                $req->execute([0]);
            } catch (PDOException $e) {
                echo "erreur " . $e->getMessage();
                return 2;
            }
        }

        $sql = 'SELECT * FROM courses WHERE course_id=' . $id1 . '';
        $req = $pdo->prepare($sql);
        $req->execute();
        $donnees = $req->fetchAll(PDO::FETCH_ASSOC);

        return $donnees;
    }

    public function nbreCourses()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM courses';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll();

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }

    public function nbreCoursesEnAttente()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM courses WHERE statut=0';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll();

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }

    public function nbreCoursesEnCours()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM courses WHERE statut=1';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll();

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }

    public function nbreCoursesTerminer()
    {
        $pdo = $this->base->connecteBase(1);
        $sql = 'SELECT * FROM courses WHERE statut=2';
        $req = $pdo->prepare($sql);
        $req->execute();
        $reqs = $req->fetchAll();

        $i = 0;
        foreach ($reqs as $a) {
            $i = $i + 1;
        }

        return $i;
    }
}
//fonction pour récuperer le nom du chauffeur
function getChauffeurName($id)
{
    $base = new Base();
    $pdo = $base->connecteBase();
    $sql = 'SELECT * FROM chauffeurs WHERE chauffeur_id=' . $id;
    $req = $pdo->prepare($sql);
    $req->execute();
    $reqs = $req->fetchAll();

    foreach ($reqs as $a) {
        $name = $a['prenoms'];
    }

    $pdo = $base->closeBase();
    return $name;
}
//fonction qui inverse une phrase
function inverseStr($a)
{
    $b = "";
    for ($i = 0; $i < strlen($a); $i++) {
        $b = $a[$i] . $b;
    }

    return $b;
}

//function qui retourne les quatre premier caractère d'un mot
function quatrePCharaters($a)
{
    if (gettype($a) == "string") {
        $b = "";
        $i = 0;
        while ($i < 4) {
            $b = $b . $a[$i];
            $i = $i + 1;
        }

        while (strlen($b) < 6) {
            $b = "0" . $b;
        }

        return $b;
    }

    return "";
}

//fonction qui crée le mot de passe par défaut.
function defaultMdp($nom, $num)
{
    $premier = strtoupper($nom[0]);
    $num4 = inverseStr(quatrePCharaters(inverseStr($num)));
    $mdpd = $premier . "-" . $num4;
    return $mdpd;
}


//fonction qui retourn 1 si on doit créer un tbody et 0 sinon.

function debutTbody($i)
{
    $rest = ($i % 10);
    if ($rest == 1) {
        return 1;
    } else if ($rest == 0) {
        return 2;
    }

    return 0;
}
