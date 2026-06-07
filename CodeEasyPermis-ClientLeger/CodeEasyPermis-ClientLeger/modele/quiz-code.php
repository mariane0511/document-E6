<?php
// quiz-code.php - Page du Quiz Code


// Base de données de questions
$questionsDatabase = [
    [
        'categorie' => 'Généralités',
        'question' => 'Un panneau de forme triangulaire avec un liseré rouge annonce :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'Une obligation', 'correct' => false],
            ['id' => 'B', 'texte' => 'Un danger', 'correct' => true],
            ['id' => 'C', 'texte' => 'Une interdiction', 'correct' => false],
            ['id' => 'D', 'texte' => 'Une indication', 'correct' => false]
        ],
        'explication' => 'Les panneaux triangulaires avec liseré rouge sont des panneaux de danger.'
    ],
    [
        'categorie' => 'Signalisation',
        'question' => 'Un panneau rond avec fond bleu indique :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'Une interdiction', 'correct' => false],
            ['id' => 'B', 'texte' => 'Un danger', 'correct' => false],
            ['id' => 'C', 'texte' => 'Une obligation', 'correct' => true],
            ['id' => 'D', 'texte' => 'Une indication', 'correct' => false]
        ],
        'explication' => 'Les panneaux ronds à fond bleu sont des panneaux d'obligation.'
    ],
    [
        'categorie' => 'Priorités',
        'question' => 'À une intersection sans signalisation, la priorité est :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'À droite', 'correct' => true],
            ['id' => 'B', 'texte' => 'À gauche', 'correct' => false],
            ['id' => 'C', 'texte' => 'Au véhicule le plus rapide', 'correct' => false],
            ['id' => 'D', 'texte' => 'Au véhicule le plus lourd', 'correct' => false]
        ],
        'explication' => 'En l'absence de signalisation, la priorité à droite s'applique.'
    ],
    [
        'categorie' => 'Vitesse',
        'question' => 'En agglomération, la vitesse maximale autorisée est de :',
        'reponses' => [
            ['id' => 'A', 'texte' => '30 km/h', 'correct' => false],
            ['id' => 'B', 'texte' => '50 km/h', 'correct' => true],
            ['id' => 'C', 'texte' => '70 km/h', 'correct' => false],
            ['id' => 'D', 'texte' => '90 km/h', 'correct' => false]
        ],
        'explication' => 'La vitesse maximale en agglomération est de 50 km/h sauf indication contraire.'
    ],
    [
        'categorie' => 'Arrêt et Stationnement',
        'question' => 'Un trait jaune continu au bord de la chaussée signifie :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'Stationnement autorisé', 'correct' => false],
            ['id' => 'B', 'texte' => 'Arrêt autorisé mais pas le stationnement', 'correct' => false],
            ['id' => 'C', 'texte' => 'Arrêt et stationnement interdits', 'correct' => true],
            ['id' => 'D', 'texte' => 'Zone de livraison', 'correct' => false]
        ],
        'explication' => 'Un trait jaune continu interdit l'arrêt et le stationnement.'
    ],
    [
        'categorie' => 'Distance de sécurité',
        'question' => 'Sur autoroute par temps sec, la distance de sécurité minimale est de :',
        'reponses' => [
            ['id' => 'A', 'texte' => '1 seconde', 'correct' => false],
            ['id' => 'B', 'texte' => '2 secondes', 'correct' => true],
            ['id' => 'C', 'texte' => '3 secondes', 'correct' => false],
            ['id' => 'D', 'texte' => '5 secondes', 'correct' => false]
        ],
        'explication' => 'Il faut respecter un intervalle de 2 secondes minimum entre deux véhicules.'
    ],
    [
        'categorie' => 'Alcool',
        'question' => 'Le taux d'alcoolémie maximal autorisé pour un conducteur confirmé est de :',
        'reponses' => [
            ['id' => 'A', 'texte' => '0,2 g/L', 'correct' => false],
            ['id' => 'B', 'texte' => '0,5 g/L', 'correct' => true],
            ['id' => 'C', 'texte' => '0,8 g/L', 'correct' => false],
            ['id' => 'D', 'texte' => '1 g/L', 'correct' => false]
        ],
        'explication' => 'Le taux maximal est de 0,5 g/L de sang (0,25 mg/L d'air expiré).'
    ],
    [
        'categorie' => 'Feux',
        'question' => 'Les feux de croisement doivent être allumés :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'Uniquement la nuit', 'correct' => false],
            ['id' => 'B', 'texte' => 'La nuit et par visibilité insuffisante', 'correct' => true],
            ['id' => 'C', 'texte' => 'Seulement en cas de pluie', 'correct' => false],
            ['id' => 'D', 'texte' => 'Uniquement sur autoroute', 'correct' => false]
        ],
        'explication' => 'Les feux doivent être allumés de nuit et dès que la visibilité est insuffisante.'
    ],
    [
        'categorie' => 'Dépassement',
        'question' => 'Il est interdit de dépasser :',
        'reponses' => [
            ['id' => 'A', 'texte' => '50 mètres avant un passage piéton', 'correct' => true],
            ['id' => 'B', 'texte' => '30 mètres avant un passage piéton', 'correct' => false],
            ['id' => 'C', 'texte' => '100 mètres avant un passage piéton', 'correct' => false],
            ['id' => 'D', 'texte' => 'Uniquement sur le passage piéton', 'correct' => false]
        ],
        'explication' => 'Le dépassement est interdit 50 mètres avant un passage piéton.'
    ],
    [
        'categorie' => 'Ceinture de sécurité',
        'question' => 'Le port de la ceinture de sécurité est obligatoire :',
        'reponses' => [
            ['id' => 'A', 'texte' => 'Uniquement sur autoroute', 'correct' => false],
            ['id' => 'B', 'texte' => 'À l'avant et à l'arrière du véhicule', 'correct' => true],
            ['id' => 'C', 'texte' => 'Uniquement à l'avant', 'correct' => false],
            ['id' => 'D', 'texte' => 'Seulement pour les enfants', 'correct' => false]
        ],
        'explication' => 'Tous les occupants doivent porter leur ceinture, à l'avant comme à l'arrière.'
    ]
];

// Gestion des actions du quiz
$quizAction = $_GET['quiz_action'] ?? 'accueil';

if ($quizAction === 'demarrer' && isset($_GET['nb'])) {
    $nbQuestions = (int)$_GET['nb'];
    shuffle($questionsDatabase);
    $_SESSION['quiz_questions'] = array_slice($questionsDatabase, 0, $nbQuestions);
    $_SESSION['quiz_index'] = 0;
    $_SESSION['quiz_score'] = 0;
    $_SESSION['quiz_historique'] = [];
    
    header('Location: index.php?page=quiz-code&quiz_action=quiz');
    exit;
}

if ($quizAction === 'valider' && isset($_POST['reponse'])) {
    $indexActuel = $_SESSION['quiz_index'];
    $questionActuelle = $_SESSION['quiz_questions'][$indexActuel];
    $reponseUtilisateur = $_POST['reponse'];
    
    $estCorrect = false;
    foreach ($questionActuelle['reponses'] as $reponse) {
        if ($reponse['id'] === $reponseUtilisateur && $reponse['correct']) {
            $estCorrect = true;
            $_SESSION['quiz_score']++;
            break;
        }
    }
    
    $_SESSION['quiz_historique'][] = [
        'question' => $questionActuelle['question'],
        'reponse' => $reponseUtilisateur,
        'correct' => $estCorrect
    ];
    
    $_SESSION['quiz_reponse_validee'] = $reponseUtilisateur;
    $_SESSION['quiz_est_correct'] = $estCorrect;
    
    header('Location: index.php?page=quiz-code&quiz_action=quiz');
    exit;
}

if ($quizAction === 'suivant') {
    $_SESSION['quiz_index']++;
    unset($_SESSION['quiz_reponse_validee']);
    unset($_SESSION['quiz_est_correct']);
    
    if ($_SESSION['quiz_index'] >= count($_SESSION['quiz_questions'])) {
        header('Location: index.php?page=quiz-code&quiz_action=resultats');
    } else {
        header('Location: index.php?page=quiz-code&quiz_action=quiz');
    }
    exit;
}

if ($quizAction === 'recommencer') {
    unset($_SESSION['quiz_questions']);
    unset($_SESSION['quiz_index']);
    unset($_SESSION['quiz_score']);
    unset($_SESSION['quiz_historique']);
    unset($_SESSION['quiz_reponse_validee']);
    unset($_SESSION['quiz_est_correct']);
    
    header('Location: index.php?page=quiz-code');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Code - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .quiz-container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .quiz-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .quiz-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .quiz-header p {
            opacity: 0.9;
        }

        .quiz-content {
            padding: 40px;
        }

        /* Écran d'accueil */
        .welcome-icon {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-icon i {
            font-size: 80px;
            color: #667eea;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 40px 0;
        }

        .stat-box {
            text-align: center;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 16px;
        }

        .stat-box .number {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 8px;
        }

        .stat-box .label {
            color: #6b7280;
            font-size: 14px;
        }

        .quiz-buttons {
            display: grid;
            gap: 16px;
        }

        .quiz-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 18px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .quiz-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .quiz-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .quiz-btn-secondary {
            background: #f3f4f6;
            color: #667eea;
        }

        .quiz-btn-secondary:hover {
            background: #e5e7eb;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .back-link:hover {
            gap: 12px;
        }

        /* Quiz en cours */
        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .question-counter {
            font-weight: 600;
            color: #6b7280;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        .category-badge {
            display: inline-block;
            background: #e0e7ff;
            color: #667eea;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .question-text {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 30px;
            line-height: 1.4;
        }

        .answers-list {
            display: grid;
            gap: 12px;
            margin-bottom: 30px;
        }

        .answer-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .answer-item:hover:not(.disabled) {
            border-color: #667eea;
            background: #f8f9fa;
        }

        .answer-item.selected {
            border-color: #667eea;
            background: #e0e7ff;
        }

        .answer-item.correct {
            border-color: #10b981;
            background: #d1fae5;
        }

        .answer-item.incorrect {
            border-color: #ef4444;
            background: #fee2e2;
        }

        .answer-item.disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .answer-letter {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid currentColor;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .answer-text {
            flex: 1;
            color: #1f2937;
        }

        .answer-icon {
            font-size: 20px;
        }

        .explanation-box {
            background: #e0e7ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .explanation-title {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .explanation-text {
            color: #4b5563;
            line-height: 1.6;
        }

        /* Résultats */
        .result-icon {
            text-align: center;
            margin-bottom: 30px;
        }

        .result-icon i {
            font-size: 80px;
        }

        .result-icon.success i {
            color: #10b981;
        }

        .result-icon.failure i {
            color: #f59e0b;
        }

        .result-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .result-title.success {
            color: #10b981;
        }

        .result-title.failure {
            color: #f59e0b;
        }

        .result-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 40px;
        }

        .score-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 40px;
        }

        .score-big {
            font-size: 64px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .score-percentage {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .score-label {
            opacity: 0.9;
        }

        .results-list {
            display: grid;
            gap: 12px;
            margin-bottom: 30px;
        }

        .result-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: 12px;
        }

        .result-item.correct {
            background: #d1fae5;
            border: 2px solid #10b981;
        }

        .result-item.incorrect {
            background: #fee2e2;
            border: 2px solid #ef4444;
        }

        .result-item-icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .result-item.correct .result-item-icon {
            color: #10b981;
        }

        .result-item.incorrect .result-item-icon {
            color: #ef4444;
        }

        .result-item-text {
            flex: 1;
            color: #1f2937;
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: 1fr;
            }

            .quiz-content {
                padding: 24px;
            }

            .question-text {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <?php if ($quizAction === 'accueil'): ?>
            <!-- Écran d'accueil du quiz -->
            <div class="quiz-header">
                <h1>Quiz Code de la Route</h1>
                <p>Entraînez-vous avec des questions aléatoires</p>
            </div>
            
            <div class="quiz-content">
                <a href="index.php?page=candidat" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Retour au tableau de bord
                </a>

                <div class="welcome-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>

                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">10+</div>
                        <div class="label">Questions</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">7</div>
                        <div class="label">Catégories</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">∞</div>
                        <div class="label">Quiz illimités</div>
                    </div>
                </div>

                <div class="quiz-buttons">
                    <a href="index.php?page=quiz-code&quiz_action=demarrer&nb=5" class="quiz-btn quiz-btn-primary">
                        <i class="fas fa-play"></i>
                        Commencer un Quiz (5 questions)
                    </a>
                    <a href="index.php?page=quiz-code&quiz_action=demarrer&nb=10" class="quiz-btn quiz-btn-secondary">
                        <i class="fas fa-bolt"></i>
                        Quiz Intensif (10 questions)
                    </a>
                </div>
            </div>

        <?php elseif ($quizAction === 'quiz'): ?>
            <?php
            $indexActuel = $_SESSION['quiz_index'];
            $questionActuelle = $_SESSION['quiz_questions'][$indexActuel];
            $totalQuestions = count($_SESSION['quiz_questions']);
            $progression = (($indexActuel + 1) / $totalQuestions) * 100;
            $reponseValidee = $_SESSION['quiz_reponse_validee'] ?? null;
            ?>
            
            <!-- Quiz en cours -->
            <div class="quiz-header">
                <h1>Question <?= $indexActuel + 1 ?>/<?= $totalQuestions ?></h1>
            </div>
            
            <div class="quiz-content">
                <div class="progress-header">
                    <a href="index.php?page=quiz-code&quiz_action=recommencer" class="back-link">
                        <i class="fas fa-times"></i>
                        Abandonner
                    </a>
                    <span class="question-counter">Question <?= $indexActuel + 1 ?> sur <?= $totalQuestions ?></span>
                </div>

                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $progression ?>%"></div>
                </div>

                <span class="category-badge"><?= htmlspecialchars($questionActuelle['categorie']) ?></span>
                
                <h2 class="question-text"><?= htmlspecialchars($questionActuelle['question']) ?></h2>

                <form method="POST" action="index.php?page=quiz-code&quiz_action=valider" id="quizForm">
                    <div class="answers-list">
                        <?php foreach ($questionActuelle['reponses'] as $reponse): ?>
                            <?php
                            $classes = 'answer-item';
                            if ($reponseValidee) {
                                $classes .= ' disabled';
                                if ($reponse['correct']) {
                                    $classes .= ' correct';
                                } elseif ($reponseValidee === $reponse['id'] && !$reponse['correct']) {
                                    $classes .= ' incorrect';
                                }
                            }
                            ?>
                            
                            <label class="<?= $classes ?>" onclick="if(!this.classList.contains('disabled')) selectAnswer(this)">
                                <input type="radio" name="reponse" value="<?= $reponse['id'] ?>" style="display: none;" <?= $reponseValidee ? 'disabled' : '' ?> required>
                                <div class="answer-letter"><?= $reponse['id'] ?></div>
                                <div class="answer-text"><?= htmlspecialchars($reponse['texte']) ?></div>
                                <?php if ($reponseValidee): ?>
                                    <?php if ($reponse['correct']): ?>
                                        <i class="fas fa-check-circle answer-icon" style="color: #10b981;"></i>
                                    <?php elseif ($reponseValidee === $reponse['id'] && !$reponse['correct']): ?>
                                        <i class="fas fa-times-circle answer-icon" style="color: #ef4444;"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($reponseValidee): ?>
                        <div class="explanation-box">
                            <div class="explanation-title">
                                <i class="fas fa-lightbulb"></i>
                                Explication
                            </div>
                            <div class="explanation-text"><?= htmlspecialchars($questionActuelle['explication']) ?></div>
                        </div>
                        
                        <a href="index.php?page=quiz-code&quiz_action=suivant" class="quiz-btn quiz-btn-primary" style="width: 100%;">
                            <?= $indexActuel < $totalQuestions - 1 ? 'Question suivante' : 'Voir les résultats' ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <button type="submit" class="quiz-btn quiz-btn-primary" style="width: 100%;">
                            Valider la réponse
                        </button>
                    <?php endif; ?>
                </form>
            </div>

        <?php elseif ($quizAction === 'resultats'): ?>
            <?php
            $score = $_SESSION['quiz_score'];
            $totalQuestions = count($_SESSION['quiz_questions']);
            $pourcentage = round(($score / $totalQuestions) * 100);
            $estReussi = $pourcentage >= 70;
            ?>
            
            <!-- Résultats -->
            <div class="quiz-header">
                <h1>Résultats du Quiz</h1>
            </div>
            
            <div class="quiz-content">
                <div class="result-icon <?= $estReussi ? 'success' : 'failure' ?>">
                    <i class="fas fa-<?= $estReussi ? 'check-circle' : 'exclamation-circle' ?>"></i>
                </div>

                <h2 class="result-title <?= $estReussi ? 'success' : 'failure' ?>">
                    <?= $estReussi ? 'Félicitations ! 🎉' : 'Continuez vos efforts ! 💪' ?>
                </h2>
                <p class="result-subtitle">
                    <?= $estReussi ? 'Vous avez réussi le quiz' : 'Il faut au moins 70% pour réussir' ?>
                </p>

                <div class="score-box">
                    <div class="score-big"><?= $score ?>/<?= $totalQuestions ?></div>
                    <div class="score-percentage"><?= $pourcentage ?>%</div>
                    <div class="score-label">Bonnes réponses</div>
                </div>

                <h3 style="margin-bottom: 16px; color: #1f2937;">Détail de vos réponses :</h3>
                <div class="results-list">
                    <?php foreach ($_SESSION['quiz_historique'] as $item): ?>
                        <div class="result-item <?= $item['correct'] ? 'correct' : 'incorrect' ?>">
                            <i class="fas fa-<?= $item['correct'] ? 'check' : 'times' ?> result-item-icon"></i>
                            <div class="result-item-text"><?= htmlspecialchars($item['question']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="quiz-buttons">
                    <a href="index.php?page=quiz-code&quiz_action=demarrer&nb=<?= $totalQuestions ?>" class="quiz-btn quiz-btn-primary">
                        <i class="fas fa-redo"></i>
                        Nouveau quiz
                    </a>
                    <a href="index.php?page=candidat" class="quiz-btn quiz-btn-secondary">
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function selectAnswer(label) {
            // Retirer la classe selected de tous les labels
            document.querySelectorAll('.answer-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Ajouter la classe selected au label cliqué
            label.classList.add('selected');
            
            // Cocher le radio button
            label.querySelector('input[type="radio"]').checked = true;
        }
    </script>
</body>
</html>