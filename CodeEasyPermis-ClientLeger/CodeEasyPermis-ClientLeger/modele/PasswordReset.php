<?php
class PasswordReset {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Générer un token de réinitialisation
    public function createToken($email) {
        // Générer un token unique
        $token = bin2hex(random_bytes(32));
        
        // Supprimer les anciens tokens pour cet email
        $stmt = $this->pdo->prepare("DELETE FROM password_reset WHERE email = ?");
        $stmt->execute([$email]);
        
        // Insérer le nouveau token (expires_at = +1 heure)
        $stmt = $this->pdo->prepare("
            INSERT INTO password_reset (email, token, created_at, expires_at)
            VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR))
        ");
        $stmt->execute([$email, $token]);
        
        return $token;
    }

    // Vérifier si un token est valide (moins de 1 heure)
    public function verifyToken($token) {
        $stmt = $this->pdo->prepare("
            SELECT email FROM password_reset 
            WHERE token = ? 
            AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    // Supprimer un token après utilisation
    public function deleteToken($token) {
        $stmt = $this->pdo->prepare("DELETE FROM password_reset WHERE token = ?");
        return $stmt->execute([$token]);
    }

    // Vérifier si un email existe (candidat ou moniteur)
    public function emailExists($email) {
        // Vérifier dans candidat
        $stmt = $this->pdo->prepare("SELECT idcandidat FROM candidat WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['type' => 'candidat', 'exists' => true];
        }

        // Vérifier dans moniteur
        $stmt = $this->pdo->prepare("SELECT idmoniteur FROM moniteur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['type' => 'moniteur', 'exists' => true];
        }

        // Vérifier dans user (admin)
        $stmt = $this->pdo->prepare("SELECT iduser FROM user WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['type' => 'admin', 'exists' => true];
        }

        return ['exists' => false];
    }

    // Mettre à jour le mot de passe
    public function updatePassword($email, $newPassword) {
        // Déterminer le type d'utilisateur
        $userType = $this->emailExists($email);
        
        if (!$userType['exists']) {
            return false;
        }

        switch ($userType['type']) {
            case 'candidat':
                $stmt = $this->pdo->prepare("UPDATE candidat SET mdp = ? WHERE email = ?");
                break;
            case 'moniteur':
                $stmt = $this->pdo->prepare("UPDATE moniteur SET mdp = ? WHERE email = ?");
                break;
            case 'admin':
                $stmt = $this->pdo->prepare("UPDATE user SET mdp = ? WHERE email = ?");
                break;
            default:
                return false;
        }

        return $stmt->execute([$newPassword, $email]);
    }
}
?>