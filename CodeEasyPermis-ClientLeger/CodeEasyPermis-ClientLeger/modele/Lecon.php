<?php
class Lecon {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query("
            SELECT l.*,
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            ORDER BY l.datedebut DESC
        ")->fetchAll();
    }

   public function getById($idlecon) {
    $stmt = $this->pdo->prepare("
        SELECT l.*,
               c.nom as candidat_nom, c.prenom as candidat_prenom,
               m.nom as moniteur_nom, m.prenom as moniteur_prenom,
               v.immatriculation,
               mo.marque, mo.nommodele
        FROM lecon l
        JOIN candidat c ON l.idcandidat = c.idcandidat
        JOIN moniteur m ON l.idmoniteur = m.idmoniteur
        JOIN vehicule v ON l.idvehicule = v.idvehicule
        JOIN modele mo ON v.idmodele = mo.idmodele
        WHERE l.idlecon = ?
    ");
    $stmt->execute([$idlecon]);
    return $stmt->fetch();
}
    public function getByCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT l.*,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE l.idcandidat = ?
            ORDER BY l.datedebut DESC
        ");
        $stmt->execute([$idcandidat]);
        return $stmt->fetchAll();
    }

    public function getByMoniteur($idmoniteur) {
        $stmt = $this->pdo->prepare("
            SELECT l.*,
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE l.idmoniteur = ?
            ORDER BY l.datedebut DESC
        ");
        $stmt->execute([$idmoniteur]);
        return $stmt->fetchAll();
    }

    public function getProchaines($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT l.*,
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            WHERE l.datedebut >= NOW()
            ORDER BY l.datedebut ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getAujourdhui() {
        return $this->pdo->query("
            SELECT l.*,
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            WHERE DATE(l.datedebut) = CURDATE()
            ORDER BY l.datedebut ASC
        ")->fetchAll();
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO lecon (idlecon, datedebut, datefin, idcandidat, idmoniteur, idvehicule)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['idlecon'],
            $data['datedebut'],
            $data['datefin'],
            $data['idcandidat'],
            $data['idmoniteur'],
            $data['idvehicule']
        ]);
    }

    public function delete($idlecon) {
        $stmt = $this->pdo->prepare("DELETE FROM lecon WHERE idlecon = ?");
        return $stmt->execute([$idlecon]);
    }

    // Reporter une leçon : mettre à jour les dates
    public function updateDates($idlecon, $datedebut, $datefin) {
        $stmt = $this->pdo->prepare("UPDATE lecon SET datedebut = ?, datefin = ? WHERE idlecon = ?");
        return $stmt->execute([$datedebut, $datefin, $idlecon]);
    }

    // Annuler une leçon : mettre à jour le statut
    public function updateStatut($idlecon, $statut) {
        $stmt = $this->pdo->prepare("UPDATE lecon SET statut = ? WHERE idlecon = ?");
        return $stmt->execute([$statut, $idlecon]);
    }

    public function getHeuresCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(TIMESTAMPDIFF(HOUR, datedebut, datefin)) as total_heures
            FROM lecon
            WHERE idcandidat = ? AND datefin <= NOW() AND (statut IS NULL OR statut != 'annulee')
        ");
        $stmt->execute([$idcandidat]);
        $result = $stmt->fetch();
        return $result['total_heures'] ?? 0;
    }

    public function getHeuresMoniteurMois($idmoniteur) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(TIMESTAMPDIFF(HOUR, datedebut, datefin)) as total_heures
            FROM lecon
            WHERE idmoniteur = ?
            AND MONTH(datedebut) = MONTH(NOW())
            AND YEAR(datedebut) = YEAR(NOW())
            AND (statut IS NULL OR statut != 'annulee')
        ");
        $stmt->execute([$idmoniteur]);
        $result = $stmt->fetch();
        return $result['total_heures'] ?? 0;
    }

    public function getNewId() {
        $result = $this->pdo->query("SELECT MAX(idlecon) as max_id FROM lecon")->fetch();
        return ($result['max_id'] ?? 0) + 1;
    }

    public function getPlanning() {
        return $this->pdo->query("
            SELECT l.*,
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            ORDER BY l.datedebut ASC
        ")->fetchAll();
    }
}
?>
