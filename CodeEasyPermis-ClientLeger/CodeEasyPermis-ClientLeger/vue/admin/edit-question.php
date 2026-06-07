<?php $currentPage = 'questions-code'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($question) ? 'Modifier' : 'Ajouter' ?> une question</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>.container { max-width:100%; padding: 0; background: transparent; box-shadow: none; border-radius: 0; } body { padding: 0; }</style>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8b5cf6;
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 500;
        }
        h1 {
            color: #1f2937;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        h1 i { color: #8b5cf6; }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .options-section {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .options-section h3 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #8b5cf6;
            color: white;
        }
        .btn-primary:hover {
            background: #7c3aed;
        }
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
            margin-left: 10px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>
    <div class="main-content">
    <div class="container">
        <a href="index.php?page=questions-code" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <h1>
            <i class="fas fa-<?= isset($question) ? 'edit' : 'plus-circle' ?>"></i>
            <?= isset($question) ? 'Modifier' : 'Ajouter' ?> une question
        </h1>

        <form method="POST">
            <div class="form-group">
                <label>Question *</label>
                <textarea name="question" required><?= $question['question'] ?? '' ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Catégorie *</label>
                    <select name="categorie" required>
                        <option value="">-- Choisir --</option>
                        <option value="Signalisation" <?= (isset($question) && $question['categorie'] == 'Signalisation') ? 'selected' : '' ?>>Signalisation</option>
                        <option value="Vitesse" <?= (isset($question) && $question['categorie'] == 'Vitesse') ? 'selected' : '' ?>>Vitesse</option>
                        <option value="Sécurité" <?= (isset($question) && $question['categorie'] == 'Sécurité') ? 'selected' : '' ?>>Sécurité</option>
                        <option value="Alcool" <?= (isset($question) && $question['categorie'] == 'Alcool') ? 'selected' : '' ?>>Alcool</option>
                        <option value="Mécanique" <?= (isset($question) && $question['categorie'] == 'Mécanique') ? 'selected' : '' ?>>Mécanique</option>
                        <option value="Permis" <?= (isset($question) && $question['categorie'] == 'Permis') ? 'selected' : '' ?>>Permis</option>
                        <option value="Général" <?= (isset($question) && $question['categorie'] == 'Général') ? 'selected' : '' ?>>Général</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Bonne réponse *</label>
                    <select name="bonne_reponse" required>
                        <option value="">-- Choisir --</option>
                        <option value="A" <?= (isset($question) && $question['bonne_reponse'] == 'A') ? 'selected' : '' ?>>A</option>
                        <option value="B" <?= (isset($question) && $question['bonne_reponse'] == 'B') ? 'selected' : '' ?>>B</option>
                        <option value="C" <?= (isset($question) && $question['bonne_reponse'] == 'C') ? 'selected' : '' ?>>C</option>
                        <option value="D" <?= (isset($question) && $question['bonne_reponse'] == 'D') ? 'selected' : '' ?>>D</option>
                    </select>
                </div>
            </div>

            <div class="options-section">
                <h3>Options de réponse</h3>
                
                <div class="form-group">
                    <label>Option A *</label>
                    <input type="text" name="option_a" value="<?= $question['option_a'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Option B *</label>
                    <input type="text" name="option_b" value="<?= $question['option_b'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Option C *</label>
                    <input type="text" name="option_c" value="<?= $question['option_c'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Option D *</label>
                    <input type="text" name="option_d" value="<?= $question['option_d'] ?? '' ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Image (URL - optionnel)</label>
                <input type="text" name="image" value="<?= $question['image'] ?? '' ?>" placeholder="https://...">
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php?page=questions-code" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>