<?php
class QuizCode {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer des questions aléatoires
    public function getQuestionsAleatoires($nombre = 10) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM question_code 
            ORDER BY RAND() 
            LIMIT ?
        ");
       $stmt->bindValue(1, (int)$nombre, PDO::PARAM_INT);
       $stmt->execute();
        return $stmt->fetchAll();
    }

    // Récupérer toutes les questions
    public function getAllQuestions() {
        return $this->pdo->query("
            SELECT * FROM question_code 
            ORDER BY idquestion DESC
        ")->fetchAll();
    }

    // Récupérer une question par ID
    public function getQuestionById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM question_code WHERE idquestion = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Ajouter une question
    public function addQuestion($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO question_code (question, option_a, option_b, option_c, option_d, bonne_reponse, categorie, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['question'],
            $data['option_a'],
            $data['option_b'],
            $data['option_c'],
            $data['option_d'],
            $data['bonne_reponse'],
            $data['categorie'],
            $data['image'] ?? null
        ]);
    }

    // Modifier une question
    public function updateQuestion($id, $data) {
        $stmt = $this->pdo->prepare("
            UPDATE question_code 
            SET question = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, 
                bonne_reponse = ?, categorie = ?, image = ?
            WHERE idquestion = ?
        ");
        return $stmt->execute([
            $data['question'],
            $data['option_a'],
            $data['option_b'],
            $data['option_c'],
            $data['option_d'],
            $data['bonne_reponse'],
            $data['categorie'],
            $data['image'] ?? null,
            $id
        ]);
    }

    // Supprimer une question
    public function deleteQuestion($id) {
        $stmt = $this->pdo->prepare("DELETE FROM question_code WHERE idquestion = ?");
        return $stmt->execute([$id]);
    }

    // Enregistrer un résultat de quiz
    public function saveResultat($idcandidat, $score, $total, $temps) {
        $stmt = $this->pdo->prepare("
            INSERT INTO resultat_quiz (idcandidat, date_quiz, score, total_questions, temps_total)
            VALUES (?, NOW(), ?, ?, ?)
        ");
        return $stmt->execute([$idcandidat, $score, $total, $temps]);
    }

    // Récupérer les résultats d'un candidat
    public function getResultatsCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM resultat_quiz 
            WHERE idcandidat = ? 
            ORDER BY date_quiz DESC
        ");
        $stmt->execute([$idcandidat]);
        return $stmt->fetchAll();
    }

    // Récupérer les statistiques d'un candidat
    public function getStatsCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT 
                COUNT(*) as nb_quiz,
                AVG(score) as moyenne,
                MAX(score) as meilleur_score,
                SUM(CASE WHEN score >= total_questions * 0.7 THEN 1 ELSE 0 END) as nb_reussis
            FROM resultat_quiz 
            WHERE idcandidat = ?
        ");
        $stmt->execute([$idcandidat]);
        return $stmt->fetch();
    }
}
?>