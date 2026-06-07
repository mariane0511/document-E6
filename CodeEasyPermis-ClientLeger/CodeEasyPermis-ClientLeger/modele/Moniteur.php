<?php
class Moniteur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByEmail($email) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM moniteur WHERE email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function register($nom, $prenom, $email, $mdp) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO moniteur (nom, prenom, email, mdp)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nom, $prenom, $email, $mdp]);
    }

    // ✅ La méthode update() doit être DANS la classe
    public function update($id, $data) {
        $sql = "UPDATE moniteur SET
                nom = ?,
                prenom = ?,
                email = ?,
                telephone = ?,
                date_embauche = ?,
                type_permis = ?,
                sexe = ?";

        $params = [
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['date_embauche'] ?? null,
            $data['type_permis'] ?? null,
            $data['sexe'] ?? null,
        ];

        // Ajouter le mot de passe seulement s'il est fourni
        if (isset($data['mdp'])) {
            $sql .= ", mdp = ?";
            $params[] = $data['mdp'];
        }

        $sql .= " WHERE idmoniteur = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

} // ✅ Fermeture de la classe ICI
?>