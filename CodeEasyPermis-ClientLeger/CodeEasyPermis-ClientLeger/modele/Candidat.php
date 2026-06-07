<?php
class Candidat {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        return $this->pdo->query("
            SELECT c.*, f.libelle
            FROM candidat c
            JOIN formule f ON c.idformule = f.idformule
        ")->fetchAll();
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO candidat (nom, prenom, email, mdp, idformule)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute($data);
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM candidat");
        return $stmt->fetchAll();
    }

    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM candidat WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function register($nom, $prenom, $email, $mdp, $idformule, $etudiant = 0) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO candidat (nom, prenom, email, mdp, idformule, etudiant)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$nom, $prenom, $email, $mdp, $idformule, $etudiant]);
    }

    public function getPrixAvecReduction($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT c.etudiant, f.prix, f.libelle
            FROM candidat c
            JOIN formule f ON c.idformule = f.idformule
            WHERE c.idcandidat = ?
        ");
        $stmt->execute([$idcandidat]);
        $result = $stmt->fetch();
        if (!$result) return null;

        $prixOriginal = $result['prix'];
        $reduction = 0;
        if ($result['etudiant'] == 1) {
            $reduction = $prixOriginal * 0.10;
        }
        return [
            'formule'       => $result['libelle'],
            'prix_original' => $prixOriginal,
            'reduction'     => $reduction,
            'prix_final'    => $prixOriginal - $reduction,
            'est_etudiant'  => $result['etudiant']
        ];
    }

    /**
     * Mise à jour du profil candidat.
     * IMPORTANT : idformule n'est PAS modifiable ici (bloqué volontairement).
     * Le contrôleur doit toujours passer l'idformule original du candidat.
     */
    public function update($id, $data) {
        $sql = "UPDATE candidat SET
                nom = ?,
                prenom = ?,
                email = ?,
                datenaissance = ?,
                sexe = ?";

        $params = [
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['datenaissance'],
            $data['sexe'] ?? null
        ];

        // Mot de passe uniquement si fourni
        if (isset($data['mdp']) && !empty($data['mdp'])) {
            $sql .= ", mdp = ?";
            $params[] = $data['mdp'];
        }

        // idformule : on la reçoit du contrôleur mais on ne la met PAS à jour
        // (formule verrouillée après inscription — décommenter si on veut autoriser)
        // if (isset($data['idformule'])) { $sql .= ", idformule = ?"; $params[] = $data['idformule']; }

        $sql .= " WHERE idcandidat = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
?>
