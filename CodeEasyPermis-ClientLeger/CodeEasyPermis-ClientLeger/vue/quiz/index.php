<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz Code de la Route</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 500;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 8px;
        }
        .header {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .header h1 {
            font-size: 36px;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .header p {
            color: #6b7280;
            font-size: 16px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
        .stat-icon.purple { background: #ede9fe; color: #8b5cf6; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }
        .action-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .action-section h2 {
            color: #1f2937;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .btn-start {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: transform 0.3s;
        }
        .btn-start:hover {
            transform: translateY(-3px);
        }
        .history {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .history h2 {
            color: #1f2937;
            margin-bottom: 20px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f9fafb;
            padding: 12px;
            text-align: left;
            color: #374151;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #6b7280;
        }
        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background: #fed7aa;
            color: #92400e;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php?page=candidat" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="header">
            <h1>📚 Quiz Code de la Route</h1>
            <p>Entraînez-vous au code avec des quiz aléatoires</p>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-value"><?= $stats['nb_quiz'] ?? 0 ?></div>
                <div class="stat-label">Quiz effectués</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value"><?= $stats['nb_reussis'] ?? 0 ?></div>
                <div class="stat-label">Quiz réussis (≥70%)</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-value">
                    <?= $stats['moyenne'] ? round($stats['moyenne'], 1) . '/10' : '-' ?>
                </div>
                <div class="stat-label">Score moyen</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-value">
                    <?= $stats['meilleur_score'] ?? '-' ?>/10
                </div>
                <div class="stat-label">Meilleur score</div>
            </div>
        </div>

        <!-- Démarrer un quiz -->
        <div class="action-section">
            <h2>Prêt à vous entraîner ?</h2>
            <p style="color: #6b7280; margin-bottom: 20px;">
                Répondez à 10 questions aléatoires pour tester vos connaissances
            </p>
            <a href="index.php?page=quiz-nouveau" class="btn-start">
                <i class="fas fa-play"></i>
                Démarrer un nouveau quiz
            </a>
        </div>

        <!-- Historique -->
        <div class="history">
            <h2><i class="fas fa-history"></i> Historique de vos quiz</h2>
            
            <?php if (empty($historique)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px;"></i>
                    <p>Vous n'avez pas encore passé de quiz</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Score</th>
                            <th>Temps</th>
                            <th>Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historique as $resultat): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($resultat['date_quiz'])) ?></td>
                                <td><strong><?= $resultat['score'] ?>/<?= $resultat['total_questions'] ?></strong></td>
                                <td><?= gmdate('i:s', $resultat['temps_total']) ?> min</td>
                                <td>
                                    <?php
                                    $pourcentage = ($resultat['score'] / $resultat['total_questions']) * 100;
                                    if ($pourcentage >= 70) {
                                        echo '<span class="badge badge-success">✓ Réussi</span>';
                                    } else {
                                        echo '<span class="badge badge-warning">✗ Échoué</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>