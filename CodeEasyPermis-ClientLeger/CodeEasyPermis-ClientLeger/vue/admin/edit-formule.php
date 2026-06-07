<?php $currentPage = 'formules'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($formule) ? 'Modifier' : 'Ajouter' ?> une formule</title>
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
            max-width: 700px;
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
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
        <a href="index.php?page=formules" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <h1>
            <i class="fas fa-<?= isset($formule) ? 'edit' : 'plus-circle' ?>"></i>
            <?= isset($formule) ? 'Modifier' : 'Ajouter' ?> une formule
        </h1>

        <form method="POST">
            <div class="form-group">
                <label>Nom de la formule *</label>
                <input type="text" name="libelle" value="<?= $formule['libelle'] ?? '' ?>" 
                       placeholder="Ex: Formule Classique" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prix (€) *</label>
                    <input type="number" step="0.01" name="prix" value="<?= $formule['prix'] ?? '' ?>" 
                           placeholder="800.00" required>
                </div>

                <div class="form-group">
                    <label>Durée (heures) *</label>
                    <input type="number" name="duree" value="<?= $formule['duree'] ?? '' ?>" 
                           placeholder="20" required>
                </div>
            </div>

            <div class="form-group">
                <label>Type de public *</label>
                <input type="text" name="typepublic" value="<?= $formule['typepublic'] ?? '' ?>" 
                       placeholder="Ex: Adulte, Etudiant, Tous" required>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php?page=formules" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>