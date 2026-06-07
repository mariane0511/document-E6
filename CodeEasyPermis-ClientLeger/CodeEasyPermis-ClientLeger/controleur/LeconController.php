<?php
require_once "modele/Lecon.php";
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";
require_once "modele/Vehicule.php";

class LeconController {
    private $pdo;
    private $leconModel;
    private $candidatModel;
    private $moniteurModel;
    private $vehiculeModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->leconModel = new Lecon($pdo);
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
        $this->vehiculeModel = new Vehicule($pdo);
    }

    public function planning() {
        if (isset($_SESSION['moniteur'])) {
            $moniteurActuel = $this->moniteurModel->getByEmail($_SESSION['moniteur']['email']);
            $idcandidat = isset($_GET['candidat']) ? intval($_GET['candidat']) : null;

            // Filtrer les leçons du moniteur connecté (+ candidat si précisé)
            $toutes = $this->leconModel->getByMoniteur($moniteurActuel['idmoniteur']);
            $lecons = $idcandidat
                ? array_values(array_filter($toutes, fn($l) => $l['idcandidat'] == $idcandidat))
                : $toutes;
        } else {
            $moniteurActuel = null;
            $lecons = $this->leconModel->getPlanning();
        }
        require "vue/planning/planning.php";
    }

    public function ajouterLecon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idlecon = $this->leconModel->getNewId();
            $data = [
                'idlecon'    => $idlecon,
                'datedebut'  => $_POST['datedebut'],
                'datefin'    => $_POST['datefin'],
                'idcandidat' => $_POST['idcandidat'],
                'idmoniteur' => $_POST['idmoniteur'],
                'idvehicule' => $_POST['idvehicule']
            ];
            if ($this->leconModel->add($data)) {
                header("Location: index.php?page=planning&success=1");
                exit;
            } else {
                $error = "Erreur lors de l'ajout de la leçon";
            }
        }
        $candidats = $this->candidatModel->all();
        $moniteurs = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();
        $vehicules  = $this->vehiculeModel->getAll();
        require "vue/planning/ajouter.php";
    }

    public function supprimerLecon() {
        if (isset($_GET['id'])) {
            $this->leconModel->delete($_GET['id']);
        }
        header("Location: index.php?page=planning");
        exit;
    }

    public function mesLecons() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }
        $candidatActuel = $this->candidatModel->getByEmail($_SESSION['candidat']['email']);
        $idcandidat = $candidatActuel['idcandidat'];
        $lecons = $this->leconModel->getByCandidat($idcandidat);

        // Récupérer la formule pour la sidebar
        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        require "vue/candidat/mes-lecons.php";
    }

    // Reporter une leçon (candidat)
    public function reporterLecon() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=mes-lecons");
            exit;
        }

        $idlecon = intval($_POST['idlecon']);
        $lecon = $this->leconModel->getById($idlecon);

        // Sécurité : vérifier que la leçon appartient au candidat connecté
        if (!$lecon || $lecon['idcandidat'] != $_SESSION['candidat']['idcandidat']) {
            die("Accès refusé");
        }

        // Vérifier que la leçon n'est pas déjà passée
        if (strtotime($lecon['datedebut']) < time()) {
            header("Location: index.php?page=mes-lecons&error=passe");
            exit;
        }

        // Vérifier délai minimum de 24h
        if ((strtotime($lecon['datedebut']) - time()) < 86400) {
            header("Location: index.php?page=mes-lecons&error=delai");
            exit;
        }

        // Vérifier que la nouvelle date est dans le futur
        $nouvelleDate = $_POST['nouvelle_date'];
        $nouvelleDateFin = $_POST['nouvelle_date_fin'];

        if (strtotime($nouvelleDate) < time()) {
            header("Location: index.php?page=mes-lecons&error=date_invalide");
            exit;
        }

        $this->leconModel->updateDates($idlecon, $nouvelleDate, $nouvelleDateFin);
        header("Location: index.php?page=mes-lecons&success=reporter");
        exit;
    }

    // Annuler une leçon (candidat)
    public function annulerLecon() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=mes-lecons");
            exit;
        }

        $idlecon = intval($_POST['idlecon']);
        $lecon = $this->leconModel->getById($idlecon);

        // Sécurité : vérifier que la leçon appartient au candidat connecté
        if (!$lecon || $lecon['idcandidat'] != $_SESSION['candidat']['idcandidat']) {
            die("Accès refusé");
        }

        // Vérifier que la leçon n'est pas déjà passée
        if (strtotime($lecon['datedebut']) < time()) {
            header("Location: index.php?page=mes-lecons&error=passe");
            exit;
        }

        // Vérifier délai minimum de 24h
        if ((strtotime($lecon['datedebut']) - time()) < 86400) {
            header("Location: index.php?page=mes-lecons&error=delai");
            exit;
        }

        $this->leconModel->updateStatut($idlecon, 'annulee');
        header("Location: index.php?page=mes-lecons&success=annuler");
        exit;
    }
    public function modifierLecon() {
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit; }

        if (!isset($_GET['id'])) {
            header("Location: index.php?page=planning");
            exit;
        }

        $lecon = $this->leconModel->getById($_GET['id']);
        if (!$lecon) { header("Location: index.php?page=planning"); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->leconModel->updateDates($_GET['id'], $_POST['datedebut'], $_POST['datefin']);
            // Optionnel: mettre à jour candidat/moniteur/vehicule si besoin
            if (!empty($_POST['idmoniteur']) && !empty($_POST['idvehicule']) && !empty($_POST['idcandidat'])) {
                $stmt = $this->pdo->prepare("UPDATE lecon SET idcandidat=?, idmoniteur=?, idvehicule=? WHERE idlecon=?");
                $stmt->execute([$_POST['idcandidat'], $_POST['idmoniteur'], $_POST['idvehicule'], $_GET['id']]);
            }
            header("Location: index.php?page=planning&success=modif");
            exit;
        }

        $candidats = $this->candidatModel->all();
        $moniteurs = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();
        $vehicules  = $this->vehiculeModel->getAll();
        require "vue/planning/modifier.php";
    }

}
?>