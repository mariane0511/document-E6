<?php
require_once "modele/Candidat.php";

class CandidatController {

    private $model;

     public function dashboard() {
        require "vue/candidat/dashboard.php";
    }

    public function __construct($pdo) {
        $this->model = new Candidat($pdo);
    }

    
    public function add() {
        if ($_POST) {
            $this->model->add([
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                //password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                $_POST['mdp'],
                $_POST['idformule']
            ]);
            header("Location: index.php?page=candidats");
        }
        require "vue/candidat/add.php";
    }
}
?>