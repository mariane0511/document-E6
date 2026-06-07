<?php
require_once "modele/QuizCode.php";

class QuizController {
    private $pdo;
    private $quizModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->quizModel = new QuizCode($pdo);
    }

    // Afficher la page d'accueil du quiz
    public function index() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $idcandidat = $_SESSION['candidat']['idcandidat'];
        $stats = $this->quizModel->getStatsCandidat($idcandidat);
        $historique = $this->quizModel->getResultatsCandidat($idcandidat);

        require "vue/quiz/index.php";
    }

    // Démarrer un nouveau quiz
    public function nouveau() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $questions = $this->quizModel->getQuestionsAleatoires(10);
        $_SESSION['quiz_questions'] = $questions;
        $_SESSION['quiz_start_time'] = time();

        require "vue/quiz/quiz.php";
    }

    // Soumettre les réponses
    public function soumettre() {
        if (!isset($_SESSION['candidat']) || !isset($_SESSION['quiz_questions'])) {
            header("Location: index.php?page=quiz-code");
            exit;
        }

        $questions = $_SESSION['quiz_questions'];
        $score = 0;
        $reponses_utilisateur = [];

        foreach ($questions as $index => $question) {
            $reponse_user = $_POST['question_' . $index] ?? null;
            $reponses_utilisateur[$index] = [
                'reponse' => $reponse_user,
                'correcte' => $question['bonne_reponse'],
                'est_juste' => ($reponse_user === $question['bonne_reponse'])
            ];

            if ($reponse_user === $question['bonne_reponse']) {
                $score++;
            }
        }

        $temps_total = time() - $_SESSION['quiz_start_time'];
        $idcandidat = $_SESSION['candidat']['idcandidat'];

        // Enregistrer le résultat
        $this->quizModel->saveResultat($idcandidat, $score, count($questions), $temps_total);

        // Stocker pour affichage
        $_SESSION['quiz_resultat'] = [
            'score' => $score,
            'total' => count($questions),
            'temps' => $temps_total,
            'questions' => $questions,
            'reponses' => $reponses_utilisateur
        ];

        header("Location: index.php?page=quiz-resultat");
        exit;
    }

    // Afficher le résultat
    public function resultat() {
        if (!isset($_SESSION['quiz_resultat'])) {
            header("Location: index.php?page=quiz-code");
            exit;
        }

        $resultat = $_SESSION['quiz_resultat'];
        require "vue/quiz/resultat.php";

        // Nettoyer la session
        unset($_SESSION['quiz_questions']);
        unset($_SESSION['quiz_start_time']);
        unset($_SESSION['quiz_resultat']);
    }

    // Gestion admin des questions
    public function gestionQuestions() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $questions = $this->quizModel->getAllQuestions();
        require "vue/admin/questions-code.php";
    }

    // Ajouter/Modifier une question
    public function editQuestion() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if (isset($_GET['id'])) {
            // Mode édition
            $question = $this->quizModel->getQuestionById($_GET['id']);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'question' => $_POST['question'],
                    'option_a' => $_POST['option_a'],
                    'option_b' => $_POST['option_b'],
                    'option_c' => $_POST['option_c'],
                    'option_d' => $_POST['option_d'],
                    'bonne_reponse' => $_POST['bonne_reponse'],
                    'categorie' => $_POST['categorie'],
                    'image' => $_POST['image'] ?? null
                ];

                $this->quizModel->updateQuestion($_GET['id'], $data);
                header("Location: index.php?page=questions-code&success=update");
                exit;
            }
        } else {
            // Mode ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'question' => $_POST['question'],
                    'option_a' => $_POST['option_a'],
                    'option_b' => $_POST['option_b'],
                    'option_c' => $_POST['option_c'],
                    'option_d' => $_POST['option_d'],
                    'bonne_reponse' => $_POST['bonne_reponse'],
                    'categorie' => $_POST['categorie'],
                    'image' => $_POST['image'] ?? null
                ];

                $this->quizModel->addQuestion($data);
                header("Location: index.php?page=questions-code&success=add");
                exit;
            }
        }

        require "vue/admin/edit-question.php";
    }

    // Supprimer une question
    public function deleteQuestion() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if (isset($_GET['id'])) {
            $this->quizModel->deleteQuestion($_GET['id']);
        }
        header("Location: index.php?page=questions-code&success=delete");
        exit;
    }
}
?>