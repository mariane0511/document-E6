<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats du Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .score-card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .score-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 700;
            position: relative;
        }
        
        .score-circle.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .score-circle.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        
        .score-circle.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .score-label {
            font-size: 16px;
            font-weight: 500;
            margin-top: 10px;
        }
        
        .result-title {
            font-size: 32px;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .result-message {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 30px;
        }
        
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-item {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
        }
        
        .stat-item i {
            font-size: 24px;
            color: #8b5cf6;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
        }
        
        .corrections {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .corrections h2 {
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 25px;
        }
        
        .correction-item {
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid #e5e7eb;
        }
        
        .correction-item.correct {
            background: #d1fae5;
            border-left-color: #10b981;
        }
        
        .correction-item.incorrect {
            background: #fee2e2;
            border-left-color: #ef4444;
        }
        
        .question-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .answer-option {
            padding: 10px 15px;
            margin: 8px 0;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .answer-option.user-answer {
            background: #dbeafe;
            border: 2px solid #3b82f6;
        }
        
        .answer-option.correct-answer {
            background: #d1fae5;
            border: 2px solid #10b981;
            font-weight: 600;
        }
        
        .answer-option.wrong-answer {
            background: #fee2e2;
            border: 2px solid #ef4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $score = $resultat['score'];
        $total = $resultat['total'];
        $pourcentage = ($score / $total) * 100;
        $temps_minutes = floor($resultat['temps'] / 60);
        $temps_secondes = $resultat['temps'] % 60;
        
        // Déterminer le statut
        if ($pourcentage >= 70) {
            $status = 'success';
            $message = '🎉 Félicitations ! Quiz réussi !';
            $icon = 'fa-check-circle';
        } elseif ($pourcentage >= 50) {
            $status = 'warning';
            $message = '📚 Continuez vos efforts !';
            $icon = 'fa-exclamation-circle';
        } else {
            $status = 'danger';
            $message = '💪 Ne vous découragez pas, réessayez !';
            $icon = 'fa-times-circle';
        }
        ?>
        
        <!-- Carte de score -->
        <div class="score-card">
            <div class="score-circle <?= $status ?>">
                <div>
                    <div><?= $score ?>/<?= $total ?></div>
                    <div class="score-label"><?= round($pourcentage) ?>%</div>
                </div>
            </div>
            
            <h1 class="result-title"><?= $message ?></h1>
            <p class="result-message">
                Vous avez obtenu <?= $score ?> bonne(s) réponse(s) sur <?= $total ?> questions
            </p>
            
            <div class="stats-row">
                <div class="stat-item">
                    <i class="fas fa-check"></i>
                    <div class="stat-value"><?= $score ?></div>
                    <div class="stat-label">Bonnes réponses</div>
                </div>
                
                <div class="stat-item">
                    <i class="fas fa-times"></i>
                    <div class="stat-value"><?= $total - $score ?></div>
                    <div class="stat-label">Erreurs</div>
                </div>
                
                <div class="stat-item">
                    <i class="fas fa-clock"></i>
                    <div class="stat-value"><?= sprintf('%02d:%02d', $temps_minutes, $temps_secondes) ?></div>
                    <div class="stat-label">Temps écoulé</div>
                </div>
            </div>
            
            <div class="actions">
                <a href="index.php?page=quiz-nouveau" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Refaire un quiz
                </a>
                <a href="index.php?page=quiz-code" class="btn btn-secondary">
                    <i class="fas fa-chart-bar"></i> Voir mes statistiques
                </a>
            </div>
        </div>
        
        <!-- Corrections détaillées -->
        <div class="corrections">
            <h2><i class="fas fa-book-open"></i> Corrections détaillées</h2>
            
            <?php foreach ($resultat['questions'] as $index => $question): ?>
                <?php 
                $reponse_user = $resultat['reponses'][$index];
                $est_correcte = $reponse_user['est_juste'];
                ?>
                
                <div class="correction-item <?= $est_correcte ? 'correct' : 'incorrect' ?>">
                    <div class="question-title">
                        <?php if ($est_correcte): ?>
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle" style="color: #ef4444;"></i>
                        <?php endif; ?>
                        Question <?= $index + 1 ?> : <?= htmlspecialchars($question['question']) ?>
                    </div>
                    
                    <?php
                    $options = ['A', 'B', 'C', 'D'];
                    foreach ($options as $opt):
                        $optionText = $question['option_' . strtolower($opt)];
                        $isUserAnswer = ($reponse_user['reponse'] === $opt);
                        $isCorrectAnswer = ($question['bonne_reponse'] === $opt);
                        
                        $class = '';
                        if ($isCorrectAnswer) {
                            $class = 'correct-answer';
                        } elseif ($isUserAnswer && !$isCorrectAnswer) {
                            $class = 'wrong-answer';
                        } elseif ($isUserAnswer) {
                            $class = 'user-answer';
                        }
                    ?>
                        <?php if ($class): ?>
                            <div class="answer-option <?= $class ?>">
                                <?php if ($isCorrectAnswer): ?>
                                    <i class="fas fa-check" style="color: #10b981;"></i>
                                <?php elseif ($isUserAnswer && !$isCorrectAnswer): ?>
                                    <i class="fas fa-times" style="color: #ef4444;"></i>
                                <?php endif; ?>
                                <strong><?= $opt ?>.</strong> <?= htmlspecialchars($optionText) ?>
                                
                                <?php if ($isCorrectAnswer): ?>
                                    <span style="float: right; color: #10b981; font-weight: 600;">✓ Bonne réponse</span>
                                <?php elseif ($isUserAnswer): ?>
                                    <span style="float: right; color: #ef4444; font-weight: 600;">✗ Votre réponse</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>