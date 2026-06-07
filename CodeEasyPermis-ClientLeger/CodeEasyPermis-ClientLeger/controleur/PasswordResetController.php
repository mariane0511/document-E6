<?php
require_once "modele/PasswordReset.php";

class PasswordResetController {
    private $pdo;
    private $resetModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->resetModel = new PasswordReset($pdo);
    }

    // Afficher le formulaire de demande
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Vérifier si l'email existe
            $userType = $this->resetModel->emailExists($email);

            if ($userType['exists']) {
                // Générer un token
                $token = $this->resetModel->createToken($email);

                // Construire le lien de réinitialisation
               $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$resetLink = "http://" . $_SERVER['HTTP_HOST'] . $scriptDir . "/index.php?page=reset-password&token=" . $token;

                // VERSION TEST : Stocker le lien en session pour l'afficher
                $_SESSION['reset_link'] = $resetLink;
                $_SESSION['reset_email'] = $email;

                $success = "Lien de réinitialisation généré avec succès !";
            } else {
                $error = "Aucun compte n'est associé à cet email.";
            }
        }

        require "vue/auth/forgot_password.php";
    }

    // Afficher le formulaire de réinitialisation
    public function resetPassword() {
        if (!isset($_GET['token'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $token = $_GET['token'];
        $tokenData = $this->resetModel->verifyToken($token);

        if (!$tokenData) {
            $error = "Ce lien de réinitialisation est invalide ou a expiré (validité : 1 heure).";
            require "vue/auth/reset_password.php";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (!(
                strlen($newPassword) >= 12 &&
                preg_match("/[A-Z]/", $newPassword) &&
                preg_match("/[a-z]/", $newPassword) &&
                preg_match("/[0-9]/", $newPassword) &&
                preg_match("/[^A-Za-z0-9]/", $newPassword)
            )) {
                $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            } else {
                // Mettre à jour le mot de passe
                if ($this->resetModel->updatePassword($tokenData['email'], $newPassword)) {
                    // Supprimer le token
                    $this->resetModel->deleteToken($token);

                    $success = "Votre mot de passe a été réinitialisé avec succès !";
                    $_SESSION['reset_success'] = true;
                    header("Location: index.php?page=login&reset=success");
                    exit;
                } else {
                    $error = "Une erreur est survenue. Veuillez réessayer.";
                }
            }
        }

        require "vue/auth/reset_password.php";
    }
}
?>