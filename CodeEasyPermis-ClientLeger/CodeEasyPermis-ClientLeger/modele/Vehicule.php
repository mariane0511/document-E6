<?php
class Vehicule {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query("
            SELECT v.*, 
                   mo.marque, mo.nommodele, mo.typeboite,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom
            FROM vehicule v
            JOIN modele mo ON v.idmodele = mo.idmodele
            LEFT JOIN moniteur m ON v.idmoniteur = m.idmoniteur
            ORDER BY v.idvehicule DESC
        ")->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT v.*, 
                   mo.marque, mo.nommodele, mo.typeboite
            FROM vehicule v
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE v.idvehicule = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getDisponibles() {
        return $this->pdo->query("
            SELECT v.*, 
                   mo.marque, mo.nommodele, mo.typeboite
            FROM vehicule v
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE v.etat = 'disponible' OR v.etat IS NULL
        ")->fetchAll();
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO vehicule (idvehicule, immatriculation, etat, idmoniteur, idmodele)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['idvehicule'],
            $data['immatriculation'],
            $data['etat'],
            $data['idmoniteur'],
            $data['idmodele']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE vehicule 
            SET immatriculation = ?, etat = ?, idmoniteur = ?, idmodele = ?
            WHERE idvehicule = ?
        ");
        return $stmt->execute([
            $data['immatriculation'],
            $data['etat'],
            $data['idmoniteur'],
            $data['idmodele'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM vehicule WHERE idvehicule = ?");
        return $stmt->execute([$id]);
    }

    public function getNewId() {
        $result = $this->pdo->query("SELECT MAX(idvehicule) as max_id FROM vehicule")->fetch();
        return ($result['max_id'] ?? 0) + 1;
    }

    // Méthodes pour les modèles
    public function getAllModeles() {
        return $this->pdo->query("SELECT * FROM modele ORDER BY marque, nommodele")->fetchAll();
    }

    public function getModeleById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM modele WHERE idmodele = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addModele($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO modele (idmodele, marque, nommodele, typeboite)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['idmodele'],
            $data['marque'],
            $data['nommodele'],
            $data['typeboite']
        ]);
    }

    public function updateModele($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE modele 
            SET marque = ?, nommodele = ?, typeboite = ?
            WHERE idmodele = ?
        ");
        return $stmt->execute([
            $data['marque'],
            $data['nommodele'],
            $data['typeboite'],
            $id
        ]);
    }

    public function deleteModele($id) {
        $stmt = $this->pdo->prepare("DELETE FROM modele WHERE idmodele = ?");
        return $stmt->execute([$id]);
    }

    public function getNewModeleId() {
        $result = $this->pdo->query("SELECT MAX(idmodele) as max_id FROM modele")->fetch();
        return ($result['max_id'] ?? 0) + 1;
    }
}
?>