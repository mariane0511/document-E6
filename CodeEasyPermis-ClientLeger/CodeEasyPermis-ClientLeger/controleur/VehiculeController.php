<?php
require_once "modele/Vehicule.php";
require_once "modele/Moniteur.php";

class VehiculeController {
    private $pdo;
    private $vehiculeModel;
    private $moniteurModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->vehiculeModel = new Vehicule($pdo);
        $this->moniteurModel = new Moniteur($pdo);
    }

    // Liste des véhicules
    public function vehicules() {
        $vehicules = $this->vehiculeModel->getAll();
        require "vue/admin/vehicules.php";
    }

    // Ajouter/Modifier un véhicule
    public function editVehicule() {
        $modeles = $this->vehiculeModel->getAllModeles();
        $moniteurs = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();

        if (isset($_GET['id'])) {
            // Mode édition
            $vehicule = $this->vehiculeModel->getById($_GET['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'immatriculation' => strtoupper($_POST['immatriculation']),
                    'etat' => $_POST['etat'],
                    'idmoniteur' => !empty($_POST['idmoniteur']) ? $_POST['idmoniteur'] : null,
                    'idmodele' => $_POST['idmodele']
                ];

                $this->vehiculeModel->update($_GET['id'], $data);
                header("Location: index.php?page=vehicules&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newId = $this->vehiculeModel->getNewId();

                $data = [
                    'idvehicule' => $newId,
                    'immatriculation' => strtoupper($_POST['immatriculation']),
                    'etat' => $_POST['etat'],
                    'idmoniteur' => !empty($_POST['idmoniteur']) ? $_POST['idmoniteur'] : null,
                    'idmodele' => $_POST['idmodele']
                ];

                $this->vehiculeModel->add($data);
                header("Location: index.php?page=vehicules&success=add");
                exit;
            }
        }

        require "vue/admin/edit-vehicule.php";
    }

    // Supprimer un véhicule
    public function deleteVehicule() {
        if (isset($_GET['id'])) {
            $this->vehiculeModel->delete($_GET['id']);
        }
        header("Location: index.php?page=vehicules&success=delete");
        exit;
    }

    // Liste des modèles
    public function modeles() {
        $modeles = $this->vehiculeModel->getAllModeles();
        require "vue/admin/modeles.php";
    }

    // Ajouter/Modifier un modèle
    public function editModele() {
        if (isset($_GET['id'])) {
            // Mode édition
            $modele = $this->vehiculeModel->getModeleById($_GET['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'marque' => $_POST['marque'],
                    'nommodele' => $_POST['nommodele'],
                    'typeboite' => $_POST['typeboite']
                ];

                $this->vehiculeModel->updateModele($_GET['id'], $data);
                header("Location: index.php?page=modeles&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newId = $this->vehiculeModel->getNewModeleId();

                $data = [
                    'idmodele' => $newId,
                    'marque' => $_POST['marque'],
                    'nommodele' => $_POST['nommodele'],
                    'typeboite' => $_POST['typeboite']
                ];

                $this->vehiculeModel->addModele($data);
                header("Location: index.php?page=modeles&success=add");
                exit;
            }
        }

        require "vue/admin/edit-modele.php";
    }

    // Supprimer un modèle
    public function deleteModele() {
        if (isset($_GET['id'])) {
            $this->vehiculeModel->deleteModele($_GET['id']);
        }
        header("Location: index.php?page=modeles&success=delete");
        exit;
    }
}
?>