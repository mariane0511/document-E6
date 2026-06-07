<?php
require_once "modele/User.php";
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";

class AuthController {

    private $pdo;
    private $userModel;
    private $candidatModel;
    private $moniteurModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
    }

    public function login() {
        if (!isset($_POST['email'], $_POST['mdp'], $_POST['role'])) {
            require "vue/auth/login.php";
            return;
        }

        $email = $_POST['email'];
        $mdp   = $_POST['mdp'];
        $role  = $_POST['role'];

        if ($role === 'admin') {
            $admin = $this->userModel->getByEmail($email);

            if ($admin && $admin['mdp'] === $mdp && $admin['droits'] === 'admin') {
                unset($_SESSION['candidat'], $_SESSION['moniteur']);
                $_SESSION['admin'] = $admin;
                header("Location: index.php?page=admin");
                exit;
            }
        }

        if ($role === 'candidat') {
            $candidat = $this->candidatModel->getByEmail($email);
            if ($candidat && $candidat['mdp'] === $mdp) {
                unset($_SESSION['admin'], $_SESSION['moniteur']);
                $_SESSION['candidat'] = $candidat;
                header("Location: index.php?page=candidat");
                exit;
            }
        }

        if ($role === 'moniteur') {
            $moniteur = $this->moniteurModel->getByEmail($email);
            if ($moniteur && $moniteur['mdp'] === $mdp) {
                unset($_SESSION['admin'], $_SESSION['candidat']);
                $_SESSION['moniteur'] = $moniteur;
                header("Location: index.php?page=moniteur");
                exit;
            }
        }

        $erreur = "Identifiants ou rôle incorrects";
        require "vue/auth/login.php";
    }

    public function register() {
        if (!isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp'], $_POST['role'])) {
            $pdo = $this->pdo;
            require "vue/auth/register.php";
            return;
        }

        $role = $_POST['role'];

        // ===== CANDIDAT =====
        if ($role === 'candidat') {
            if (!isset($_POST['idformule']) || empty($_POST['idformule'])) {
                $erreur = "Veuillez choisir une formule";
                $pdo = $this->pdo;
                require "vue/auth/register.php";
                return;
            }

            // Vérifier si l'email existe déjà (candidat ou moniteur)
            $existingCandidat = $this->candidatModel->getByEmail($_POST['email']);
            $existingMoniteur = $this->moniteurModel->getByEmail($_POST['email']);

            if ($existingCandidat || $existingMoniteur) {
                $erreur = "email_existant";
                $pdo = $this->pdo;
                require "vue/auth/register.php";
                return;
            }

            // Validation CNIL mot de passe
            $mdp = $_POST['mdp'];
            $mdpValide = strlen($mdp) >= 12
                && preg_match('/[A-Z]/', $mdp)
                && preg_match('/[a-z]/', $mdp)
                && preg_match('/[0-9]/', $mdp)
                && preg_match('/[^A-Za-z0-9]/', $mdp);

            if (!$mdpValide) {
                $erreur = "Le mot de passe ne respecte pas les exigences de sécurité CNIL (12 caractères min., majuscule, minuscule, chiffre, caractère spécial).";
                $pdo = $this->pdo;
                require "vue/auth/register.php";
                return;
            }

            $etudiant = isset($_POST['etudiant']) ? 1 : 0;

            $this->candidatModel->register(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['mdp'],
                $_POST['idformule'],
                $etudiant
            );
        }

        // ===== MONITEUR =====
        if ($role === 'moniteur') {
            $existingMoniteur = $this->moniteurModel->getByEmail($_POST['email']);
            $existingCandidat = $this->candidatModel->getByEmail($_POST['email']);
            if ($existingMoniteur || $existingCandidat) {
                $erreur = "email_existant";
                $pdo = $this->pdo;
                require "vue/auth/register.php";
                return;
            }

            $mdp = $_POST['mdp'];
            $mdpValide = strlen($mdp) >= 12
                && preg_match('/[A-Z]/', $mdp)
                && preg_match('/[a-z]/', $mdp)
                && preg_match('/[0-9]/', $mdp)
                && preg_match('/[^A-Za-z0-9]/', $mdp);

            if (!$mdpValide) {
                $erreur = "Le mot de passe ne respecte pas les exigences de sécurité CNIL (12 caractères min., majuscule, minuscule, chiffre, caractère spécial).";
                $pdo = $this->pdo;
                require "vue/auth/register.php";
                return;
            }

            $this->moniteurModel->register(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['mdp']
            );
        }

        header("Location: index.php?page=login&registered=1");
        exit;
    }
}
