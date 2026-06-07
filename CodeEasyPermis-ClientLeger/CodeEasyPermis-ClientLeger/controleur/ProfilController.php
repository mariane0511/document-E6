<?php
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";
require_once "modele/User.php";
require_once "modele/Lecon.php";
require_once "modele/Formule.php";

class ProfilController {
    private $pdo;
    private $candidatModel;
    private $moniteurModel;
    private $userModel;
    private $leconModel;
    private $formuleModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
        $this->userModel = new User($pdo);
        $this->leconModel = new Lecon($pdo);
        $this->formuleModel = new Formule($pdo);
    }

    public function dashboardCandidat() {
        if (!isset($_SESSION['candidat'])) { header("Location: index.php?page=login"); exit; }
        $candidat = $_SESSION['candidat'];
        $candidatActuel = $this->candidatModel->getByEmail($candidat['email']);

        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        $heuresConduite = $this->leconModel->getHeuresCandidat($candidatActuel['idcandidat']);
        $prochaines = $this->leconModel->getByCandidat($candidatActuel['idcandidat']);
        $prochainesLecons = array_filter($prochaines, function($lecon) {
            return strtotime($lecon['datedebut']) >= time()
                && (!isset($lecon['statut']) || $lecon['statut'] !== 'annulee');
        });
        $nbProchainesLecons = count($prochainesLecons);

        require "vue/candidat/dashboard.php";
    }

    public function profilCandidat() {
        if (!isset($_SESSION['candidat'])) { header("Location: index.php?page=login"); exit; }
        $candidat = $_SESSION['candidat'];
        $candidatActuel = $this->candidatModel->getByEmail($candidat['email']);

        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        require "vue/candidat/Profil.php";
    }

    public function updateCandidat() {
        if (!isset($_SESSION['candidat'])) { header("Location: index.php?page=login"); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['candidat']['idcandidat'];
            $candidatActuel = $this->candidatModel->getByEmail($_SESSION['candidat']['email']);

            $data = [
                'nom'           => $_POST['nom'],
                'prenom'        => $_POST['prenom'],
                'email'         => $_POST['email'],
                'datenaissance' => $_POST['datenaissance'] ?? null,
                'idformule'     => $candidatActuel['idformule']
            ];

            if (!empty($_POST['mdp'])) {
                $mdp = $_POST['mdp'];
                $mdpValide = strlen($mdp) >= 12
                    && preg_match('/[A-Z]/', $mdp)
                    && preg_match('/[a-z]/', $mdp)
                    && preg_match('/[0-9]/', $mdp)
                    && preg_match('/[^A-Za-z0-9]/', $mdp);

                if (!$mdpValide) {
                    $erreur = "Le mot de passe ne respecte pas les exigences CNIL.";
                    $formule = $this->formuleModel->getById($candidatActuel['idformule']);
                    require "vue/candidat/Profil.php";
                    return;
                }
                $data['mdp'] = $mdp;
            }

            $this->candidatModel->update($id, $data);
            $_SESSION['candidat'] = $this->candidatModel->getByEmail($data['email']);
            header("Location: index.php?page=profil-candidat&success=1");
            exit;
        }
    }

    public function facture() {
        if (!isset($_SESSION['candidat'])) { header("Location: index.php?page=login"); exit; }
        $candidatActuel = $this->candidatModel->getByEmail($_SESSION['candidat']['email']);

        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        require "vue/candidat/facture.php";
    }

    // ========== MONITEUR ==========

    public function dashboardMoniteur() {
        if (!isset($_SESSION['moniteur'])) { header("Location: index.php?page=login"); exit; }
        $moniteur = $_SESSION['moniteur'];
        $moniteurActuel = $this->moniteurModel->getByEmail($moniteur['email']);

        $heuresMois = $this->leconModel->getHeuresMoniteurMois($moniteurActuel['idmoniteur']);
        $leconsAujourdhui = $this->leconModel->getAujourdhui();
        $mesLeconsAujourdhui = array_filter($leconsAujourdhui, function($lecon) use ($moniteurActuel) {
            return $lecon['idmoniteur'] == $moniteurActuel['idmoniteur'];
        });
        $nbLeconsAujourdhui = count($mesLeconsAujourdhui);

        $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT idcandidat) as nb_eleves FROM lecon WHERE idmoniteur = ?");
        $stmt->execute([$moniteurActuel['idmoniteur']]);
        $nbEleves = $stmt->fetch()['nb_eleves'] ?? 0;

        require "vue/moniteur/dashboard.php";
    }

    public function mesEleves() {
        if (!isset($_SESSION['moniteur'])) { header("Location: index.php?page=login"); exit; }
        $moniteurActuel = $this->moniteurModel->getByEmail($_SESSION['moniteur']['email']);

        // Récupérer les élèves avec stats
        $stmt = $this->pdo->prepare("
            SELECT c.idcandidat, c.nom, c.prenom, c.email, c.etudiant,
                   f.libelle as formule_libelle,
                   COUNT(DISTINCT l.idlecon) as nb_lecons,
                   COALESCE(SUM(TIMESTAMPDIFF(HOUR, l.datedebut, l.datefin)), 0) as heures_conduites,
                   COALESCE((SELECT COUNT(*) FROM resultat_quiz rq WHERE rq.idcandidat = c.idcandidat), 0) as nb_quiz,
                   COALESCE((SELECT AVG(rq2.score) FROM resultat_quiz rq2 WHERE rq2.idcandidat = c.idcandidat), 0) as score_moyen
            FROM candidat c
            JOIN lecon l ON c.idcandidat = l.idcandidat
            JOIN formule f ON c.idformule = f.idformule
            WHERE l.idmoniteur = ?
            GROUP BY c.idcandidat, c.nom, c.prenom, c.email, c.etudiant, f.libelle
            ORDER BY c.nom, c.prenom
        ");
        $stmt->execute([$moniteurActuel['idmoniteur']]);
        $mesEleves = $stmt->fetchAll();

        require "vue/moniteur/mes-eleves.php";
    }

    public function evaluations() {
        if (!isset($_SESSION['moniteur'])) { header("Location: index.php?page=login"); exit; }
        $moniteurActuel = $this->moniteurModel->getByEmail($_SESSION['moniteur']['email']);

        // Élèves du moniteur
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT c.idcandidat, c.nom, c.prenom
            FROM candidat c
            JOIN lecon l ON c.idcandidat = l.idcandidat
            WHERE l.idmoniteur = ?
            ORDER BY c.nom
        ");
        $stmt->execute([$moniteurActuel['idmoniteur']]);
        $mesEleves = $stmt->fetchAll();

        $eleveIds = array_column($mesEleves, 'idcandidat');

        // Résultats quiz de tous ces élèves
        $resultatsQuiz = [];
        if (!empty($eleveIds)) {
            $placeholders = implode(',', array_fill(0, count($eleveIds), '?'));
            $stmt = $this->pdo->prepare("
                SELECT rq.*, c.nom as candidat_nom, c.prenom as candidat_prenom
                FROM resultat_quiz rq
                JOIN candidat c ON rq.idcandidat = c.idcandidat
                WHERE rq.idcandidat IN ($placeholders)
                ORDER BY rq.date_quiz DESC
            ");
            $stmt->execute($eleveIds);
            $resultatsQuiz = $stmt->fetchAll();
        }

        // Stats globales
        $nbElevesTotal = count($mesEleves);
        $nbQuizTotal = count($resultatsQuiz);
        $scoreMoyenGlobal = 0;
        $nbReussites = 0;

        if ($nbQuizTotal > 0) {
            $totalScore = array_sum(array_map(fn($r) => $r['score'] / $r['total_questions'] * 100, $resultatsQuiz));
            $scoreMoyenGlobal = round($totalScore / $nbQuizTotal);
            $nbReussites = round(count(array_filter($resultatsQuiz, fn($r) => ($r['score'] / $r['total_questions'] * 100) >= 70)) / $nbQuizTotal * 100);
        }

        require "vue/moniteur/evaluations.php";
    }

    public function profilMoniteur() {
        if (!isset($_SESSION['moniteur'])) { header("Location: index.php?page=login"); exit; }
        $moniteur = $_SESSION['moniteur'];
        $moniteurActuel = $this->moniteurModel->getByEmail($moniteur['email']);
        require "vue/moniteur/Profil.php";
    }

    public function updateMoniteur() {
        if (!isset($_SESSION['moniteur'])) { header("Location: index.php?page=login"); exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['moniteur']['idmoniteur'];
            $data = [
                'nom'       => $_POST['nom'],
                'prenom'    => $_POST['prenom'],
                'email'     => $_POST['email'],
                'telephone' => $_POST['telephone'] ?? null
            ];
            if (!empty($_POST['mdp'])) { $data['mdp'] = $_POST['mdp']; }
            $this->moniteurModel->update($id, $data);
            $_SESSION['moniteur'] = $this->moniteurModel->getByEmail($data['email']);
            header("Location: index.php?page=profil-moniteur&success=1");
            exit;
        }
    }

    // ========== ADMIN ==========

    public function dashboardAdmin() {
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit; }
        $admin = $_SESSION['admin'];
        require "vue/admin/dashboard.php";
    }

    public function facturesAdmin() {
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit; }

        $stmt = $this->pdo->query("
            SELECT c.*, f.libelle as formule_libelle, f.prix, f.duree
            FROM candidat c
            JOIN formule f ON c.idformule = f.idformule
            ORDER BY c.nom, c.prenom
        ");
        $candidats = $stmt->fetchAll();

        $formules = $this->formuleModel->getAll();

        // Stats
        $totalCandidats = count($candidats);
        $revenusTotal = array_sum(array_column($candidats, 'prix'));
        $nbEtudiants = count(array_filter($candidats, fn($c) => $c['etudiant']));
        $revenusApreReduc = array_sum(array_map(function($c) {
            $reduc = $c['etudiant'] ? 0.1 : 0;
            $ht = $c['prix'] * (1 - $reduc);
            return $ht * 1.20;
        }, $candidats));

        require "vue/admin/factures.php";
    }

    public function quizStatsAdmin() {
        if (!isset($_SESSION['admin'])) { header("Location: index.php?page=login"); exit; }

        // Tous les résultats
        $tousResultats = $this->pdo->query("
            SELECT rq.*, c.nom as candidat_nom, c.prenom as candidat_prenom
            FROM resultat_quiz rq
            JOIN candidat c ON rq.idcandidat = c.idcandidat
            ORDER BY rq.date_quiz DESC
        ")->fetchAll();

        // Stats globales
        $totalQuiz = count($tousResultats);
        $scoreMoyen = 0;
        $tauxReussite = 0;

        if ($totalQuiz > 0) {
            $totalPct = array_sum(array_map(fn($r) => $r['score'] / $r['total_questions'] * 100, $tousResultats));
            $scoreMoyen = round($totalPct / $totalQuiz);
            $tauxReussite = round(count(array_filter($tousResultats, fn($r) => ($r['score']/$r['total_questions']*100) >= 70)) / $totalQuiz * 100);
        }

        // Candidats ayant tenté
        $candidatsActifs = count(array_unique(array_column($tousResultats, 'idcandidat')));

        // Stats par candidat
        $statsParCandidat = $this->pdo->query("
            SELECT c.idcandidat, c.nom, c.prenom,
                   COUNT(rq.idresultat) as nb_quiz,
                   SUM(rq.score) as score_total,
                   MAX(rq.score) as meilleur_score,
                   MAX(rq.date_quiz) as dernier_quiz
            FROM candidat c
            JOIN resultat_quiz rq ON c.idcandidat = rq.idcandidat
            GROUP BY c.idcandidat, c.nom, c.prenom
            ORDER BY (SUM(rq.score) / COUNT(rq.idresultat)) DESC
        ")->fetchAll();

        // Distribution des scores (tranches 0-20, 21-40, ...)
        $distributionScores = [0, 0, 0, 0, 0];
        foreach ($tousResultats as $r) {
            $pct = $r['score'] / $r['total_questions'] * 100;
            $idx = min(4, floor($pct / 20));
            $distributionScores[$idx]++;
        }

        // Évolution 30 jours
        $evolLabels = [];
        $evolScores = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $evolLabels[] = date('d/m', strtotime($date));
            $joursResult = array_filter($tousResultats, fn($r) => substr($r['date_quiz'], 0, 10) === $date);
            if (count($joursResult) > 0) {
                $moy = array_sum(array_map(fn($r) => $r['score']/$r['total_questions']*100, $joursResult)) / count($joursResult);
                $evolScores[] = round($moy);
            } else {
                $evolScores[] = null;
            }
        }

        require "vue/admin/quiz-stats.php";
    }
}
?>
