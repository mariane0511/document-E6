<?php $currentPage = 'questions-code'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des questions Code</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>.container { max-width:100%; padding: 0; background: transparent; box-shadow: none; border-radius: 0; } body { padding: 0; }</style>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ef4444;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 28px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header h1 i { color: #8b5cf6; }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #8b5cf6;
            color: white;
        }
        .btn-primary:hover {
            background: #7c3aed;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .questions-list {
            display: grid;
            gap: 20px;
        }
        .question-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #8b5cf6;
        }
        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        .question-text {
            flex: 1;
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-right: 20px;
        }
        .question-category {
            background: #ede9fe;
            color: #8b5cf6;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        .option-item {
            padding: 10px 15px;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 14px;
            color: #6b7280;
        }
        .option-item.correct {
            background: #d1fae5;
            color: #065f46;
            font-weight: 600;
            border: 2px solid #10b981;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn-icon {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }
        .btn-edit:hover {
            background: #bfdbfe;
        }
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }
        .btn-delete:hover {
            background: #fecaca;
        }
        .empty-state {
            background: white;
            text-align: center;
            padding: 80px 20px;
            border-radius: 16px;
            color: #9ca3af;
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>
    <div class="main-content">
    <div class="container">
        <a href="index.php?page=admin" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="header">
            <h1>
                <i class="fas fa-question-circle"></i>
                Gestion des questions Code
            </h1>
            <a href="index.php?page=edit-question" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle question
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Question ajoutée avec succès !";
                if ($_GET['success'] == 'delete') echo "Question supprimée avec succès !";
                if ($_GET['success'] == 'update') echo "Question modifiée avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($questions)): ?>
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <p>Aucune question créée</p>
            </div>
        <?php else: ?>
            <div class="questions-list">
                <?php foreach ($questions as $question): ?>
                    <div class="question-card">
                        <div class="question-header">
                            <div class="question-text">
                                <?= htmlspecialchars($question['question']) ?>
                            </div>
                            <span class="question-category">
                                <?= htmlspecialchars($question['categorie']) ?>
                            </span>
                        </div>
                        
                        <div class="options-grid">
                            <div class="option-item <?= $question['bonne_reponse'] == 'A' ? 'correct' : '' ?>">
                                <strong>A.</strong> <?= htmlspecialchars($question['option_a']) ?>
                                <?= $question['bonne_reponse'] == 'A' ? ' ✓' : '' ?>
                            </div>
                            <div class="option-item <?= $question['bonne_reponse'] == 'B' ? 'correct' : '' ?>">
                                <strong>B.</strong> <?= htmlspecialchars($question['option_b']) ?>
                                <?= $question['bonne_reponse'] == 'B' ? ' ✓' : '' ?>
                            </div>
                            <div class="option-item <?= $question['bonne_reponse'] == 'C' ? 'correct' : '' ?>">
                                <strong>C.</strong> <?= htmlspecialchars($question['option_c']) ?>
                                <?= $question['bonne_reponse'] == 'C' ? ' ✓' : '' ?>
                            </div>
                            <div class="option-item <?= $question['bonne_reponse'] == 'D' ? 'correct' : '' ?>">
                                <strong>D.</strong> <?= htmlspecialchars($question['option_d']) ?>
                                <?= $question['bonne_reponse'] == 'D' ? ' ✓' : '' ?>
                            </div>
                        </div>
                        
                        <div class="actions">
                            <a href="index.php?page=edit-question&id=<?= $question['idquestion'] ?>" 
                               class="btn-icon btn-edit">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="index.php?page=delete-question&id=<?= $question['idquestion'] ?>" 
                               class="btn-icon btn-delete"
                               onclick="return confirm('Voulez-vous vraiment supprimer cette question ?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>