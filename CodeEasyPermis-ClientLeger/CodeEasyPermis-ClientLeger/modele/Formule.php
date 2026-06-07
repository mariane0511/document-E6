<?php
class Formule {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query("SELECT * FROM formule ORDER BY prix ASC")->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO formule (idformule, libelle, prix, duree, typepublic)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['idformule'],
            $data['libelle'],
            $data['prix'],
            $data['duree'],
            $data['typepublic']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE formule 
            SET libelle = ?, prix = ?, duree = ?, typepublic = ?
            WHERE idformule = ?
        ");
        return $stmt->execute([
            $data['libelle'],
            $data['prix'],
            $data['duree'],
            $data['typepublic'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM formule WHERE idformule = ?");
        return $stmt->execute([$id]);
    }

    public function getNewId() {
        $result = $this->pdo->query("SELECT MAX(idformule) as max_id FROM formule")->fetch();
        return ($result['max_id'] ?? 0) + 1;
    }
}
?>