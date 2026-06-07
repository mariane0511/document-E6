<?php
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";
require_once "modele/Formule.php";
require_once "modele/Lecon.php";

class AdminController {
    private $pdo;
    private $candidatModel;
    private $moniteurModel;
    private $formuleModel;
    private $leconModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
        $this->formuleModel = new Formule($pdo);
        $this->leconModel = new Lecon($pdo);
    }

    // Dashboard admin déjà géré par ProfilController

    // Liste des candidats
    public function candidats() {
        $candidats = $this->candidatModel->getAll();
        require "vue/admin/candidats.php";
    }

    // Modifier un candidat
    public function editCandidat() {
        $formules = $this->formuleModel->getAll();

        if (isset($_GET['id'])) {
            // Mode édition
            $stmt = $this->pdo->prepare("SELECT * FROM candidat WHERE idcandidat = ?");
            $stmt->execute([$_GET['id']]);
            $candidat = $stmt->fetch();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'datenaissance' => $_POST['datenaissance'] ?? null,
                    'sexe' => $_POST['sexe'] ?? null,
                    'idformule' => $_POST['idformule'],
                    'etudiant' => isset($_POST['etudiant']) ? 1 : 0
                ];

                if (!empty($_POST['mdp'])) {
                    $data['mdp'] = $_POST['mdp'];
                }

                $this->candidatModel->update($_GET['id'], $data);
                header("Location: index.php?page=candidats&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['email'],
                    $_POST['mdp'],
                    $_POST['idformule']
                ];

                $this->candidatModel->add($data);
                header("Location: index.php?page=candidats&success=add");
                exit;
            }
        }

        require "vue/admin/edit-candidat.php";
    }

    // Supprimer un candidat
    public function deleteCandidat() {
        if (isset($_GET['id'])) {
            $stmt = $this->pdo->prepare("DELETE FROM candidat WHERE idcandidat = ?");
            $stmt->execute([$_GET['id']]);
        }
        header("Location: index.php?page=candidats&success=delete");
        exit;
    }

    // Liste des moniteurs
    public function moniteurs() {
        $moniteurs = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();
        require "vue/admin/moniteurs.php";
    }

    // Modifier/Ajouter un moniteur
    public function editMoniteur() {
        if (isset($_GET['id'])) {
            // Mode édition
            $stmt = $this->pdo->prepare("SELECT * FROM moniteur WHERE idmoniteur = ?");
            $stmt->execute([$_GET['id']]);
            $moniteur = $stmt->fetch();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'telephone' => $_POST['telephone'] ?? null,
                    'date_embauche' => $_POST['date_embauche'] ?? null,
                    'type_permis' => $_POST['type_permis'] ?? null,
                    'sexe' => $_POST['sexe'] ?? null
                ];

                if (!empty($_POST['mdp'])) {
                    $data['mdp'] = $_POST['mdp'];
                }
            
                $this->moniteurModel->update($_GET['id'], $data);
                header("Location: index.php?page=moniteurs-admin&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Générer un nouvel ID
                $result = $this->pdo->query("SELECT MAX(idmoniteur) as max_id FROM moniteur")->fetch();
                $newId = ($result['max_id'] ?? 0) + 1;

                $stmt = $this->pdo->prepare("
                    INSERT INTO moniteur (idmoniteur, nom, prenom, email, mdp, telephone, date_embauche, type_permis, sexe)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $newId,
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['email'],
                    $_POST['mdp'],
                    $_POST['telephone'] ?? null,
                    $_POST['date_embauche'] ?? null,
                    $_POST['type_permis'] ?? null,
                    $_POST['sexe'] ?? null
                ]);

                header("Location: index.php?page=moniteurs-admin&success=add");
                exit;
            }
        }

        require "vue/admin/edit-moniteur.php";
    }

    // Supprimer un moniteur
    public function deleteMoniteur() {
        if (isset($_GET['id'])) {
            $stmt = $this->pdo->prepare("DELETE FROM moniteur WHERE idmoniteur = ?");
            $stmt->execute([$_GET['id']]);
        }
        header("Location: index.php?page=moniteurs-admin&success=delete");
        exit;
    }

    // Liste des formules
    public function formules() {
        $formules = $this->formuleModel->getAll();
        require "vue/admin/formules.php";
    }

    // Modifier/Ajouter une formule
    public function editFormule() {
        if (isset($_GET['id'])) {
            // Mode édition
            $formule = $this->formuleModel->getById($_GET['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'libelle' => $_POST['libelle'],
                    'prix' => $_POST['prix'],
                    'duree' => $_POST['duree'],
                    'typepublic' => $_POST['typepublic']
                ];

                $this->formuleModel->update($_GET['id'], $data);
                header("Location: index.php?page=formules&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newId = $this->formuleModel->getNewId();

                $data = [
                    'idformule' => $newId,
                    'libelle' => $_POST['libelle'],
                    'prix' => $_POST['prix'],
                    'duree' => $_POST['duree'],
                    'typepublic' => $_POST['typepublic']
                ];

                $this->formuleModel->add($data);
                header("Location: index.php?page=formules&success=add");
                exit;
            }
        }

        require "vue/admin/edit-formule.php";
    }

    // Supprimer une formule
    public function deleteFormule() {
        if (isset($_GET['id'])) {
            $this->formuleModel->delete($_GET['id']);
        }
        header("Location: index.php?page=formules&success=delete");
        exit;
    }

    // Afficher les statistiques
public function statistiques() {
    // Stats globales
    $stats = [];
    
    // Total candidats
    $stats['total_candidats'] = $this->pdo->query("SELECT COUNT(*) FROM candidat")->fetchColumn();
    
    // Nouveaux candidats ce mois (non disponible : la table candidat n'a pas de colonne date_inscription)
    $stats['nouveaux_candidats_mois'] = 0;
    
    // Total moniteurs
    $stats['total_moniteurs'] = $this->pdo->query("SELECT COUNT(*) FROM moniteur")->fetchColumn();
    
    // Leçons ce mois
    $stats['lecons_mois'] = $this->pdo->query("
        SELECT COUNT(*) FROM lecon 
        WHERE MONTH(datedebut) = MONTH(CURDATE())
        AND YEAR(datedebut) = YEAR(CURDATE())
    ")->fetchColumn();
    
    // Évolution leçons (simulée pour l'instant)
    $stats['evolution_lecons'] = 15;
    
    // Heures ce mois
    $result = $this->pdo->query("
        SELECT SUM(TIMESTAMPDIFF(HOUR, datedebut, datefin)) as total
        FROM lecon 
        WHERE MONTH(datedebut) = MONTH(CURDATE())
        AND YEAR(datedebut) = YEAR(CURDATE())
    ")->fetch();
    $stats['heures_mois'] = $result['total'] ?? 0;
    
    // Heures par jour en moyenne
    $stats['heures_par_jour'] = $stats['lecons_mois'] > 0 ? round($stats['heures_mois'] / 30, 1) : 0;
    
    // Revenus potentiels (somme des prix des formules des candidats)
    $result = $this->pdo->query("
        SELECT SUM(f.prix) as total
        FROM candidat c
        JOIN formule f ON c.idformule = f.idformule
    ")->fetch();
    $stats['revenus_potentiels'] = $result['total'] ?? 0;
    
    // Top moniteurs
    $top_moniteurs = $this->pdo->query("
        SELECT m.*,
               COUNT(DISTINCT l.idlecon) as nb_lecons,
               SUM(TIMESTAMPDIFF(HOUR, l.datedebut, l.datefin)) as nb_heures,
               COUNT(DISTINCT l.idcandidat) as nb_eleves
        FROM moniteur m
        LEFT JOIN lecon l ON m.idmoniteur = l.idmoniteur 
            AND MONTH(l.datedebut) = MONTH(CURDATE())
            AND YEAR(l.datedebut) = YEAR(CURDATE())
        GROUP BY m.idmoniteur
        ORDER BY nb_lecons DESC
        LIMIT 5
    ")->fetchAll();
    
    // Candidats récents
    $candidats_recents = $this->pdo->query("
        SELECT c.*, f.libelle
        FROM candidat c
        JOIN formule f ON c.idformule = f.idformule
        ORDER BY c.idcandidat DESC
        LIMIT 10
    ")->fetchAll();
    
    // Données pour graphique inscriptions (6 derniers mois)
    $mois_labels = [];
    $inscriptions_data = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-$i months"));
        $mois_labels[] = date('M Y', strtotime($date));
        
        // Pas de colonne date_inscription dans la table candidat — données non disponibles
        $inscriptions_data[] = 0;
    }
    
    // Données pour graphique formules
    $formules_stats = $this->pdo->query("
        SELECT f.libelle, COUNT(*) as nb
        FROM candidat c
        JOIN formule f ON c.idformule = f.idformule
        GROUP BY f.idformule
    ")->fetchAll();
    
    $formules_labels = array_column($formules_stats, 'libelle');
    $formules_data = array_column($formules_stats, 'nb');
    
    require "vue/admin/statistiques.php";
}
}
?>
