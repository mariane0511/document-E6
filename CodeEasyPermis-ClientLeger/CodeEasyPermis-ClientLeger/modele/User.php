<?php
class User {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByEmail($email) {
        $requete = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($requete);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function register($nom, $prenom, $email, $mdp) {
    $stmt = $this->pdo->prepare("
        INSERT INTO user (nom, prenom, email, mdp, droits)
        VALUES (?, ?, ?, ?, 'admin')
    ");
    return $stmt->execute([
        $nom,
        $prenom,
        $email,
        //password_hash($mdp, PASSWORD_DEFAULT)
        $mdp
    ]);
}

}
?>