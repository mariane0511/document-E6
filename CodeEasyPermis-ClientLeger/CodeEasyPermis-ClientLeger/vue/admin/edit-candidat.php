<?php $currentPage = 'candidats'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($candidat) ? 'Modifier' : 'Ajouter' ?> un candidat</title>
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
            max-width: 800px;
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
            color: #ef4444;
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
        h1 i { color: #ef4444; }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
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
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .checkbox-group input[type="checkbox"] {
            width: auto;
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
            background: #ef4444;
            color: white;
        }
        .btn-primary:hover {
            background: #dc2626;
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
        <a href="index.php?page=candidats" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <h1>
            <i class="fas fa-<?= isset($candidat) ? 'edit' : 'user-plus' ?>"></i>
            <?= isset($candidat) ? 'Modifier' : 'Ajouter' ?> un candidat
        </h1>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" name="nom" value="<?= $candidat['nom'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Prénom *</label>
                    <input type="text" name="prenom" value="<?= $candidat['prenom'] ?? '' ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?= $candidat['email'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label>Mot de passe <?= isset($candidat) ? '(laisser vide pour ne pas changer)' : '*' ?></label>
                <input type="password" name="mdp" <?= isset($candidat) ? '' : 'required' ?>>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date de naissance</label>
                    <input type="date" name="datenaissance" value="<?= $candidat['datenaissance'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="">-- Non renseigné --</option>
                        <option value="Femme" <?= (isset($candidat) && $candidat['sexe'] == 'Femme') ? 'selected' : '' ?>>Femme</option>
                        <option value="Homme" <?= (isset($candidat) && $candidat['sexe'] == 'Homme') ? 'selected' : '' ?>>Homme</option>
                        <option value="Autre" <?= (isset($candidat) && $candidat['sexe'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Formule *</label>
                <select name="idformule" required>
                    <option value="">-- Choisir une formule --</option>
                    <?php foreach ($formules as $f): ?>
                        <option value="<?= $f['idformule'] ?>" 
                            <?= (isset($candidat) && $candidat['idformule'] == $f['idformule']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['libelle']) ?> - <?= $f['prix'] ?>€
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="etudiant" value="1" id="etudiant"
                        <?= (isset($candidat) && $candidat['etudiant']) ? 'checked' : '' ?>>
                    <label for="etudiant" style="margin: 0;">Étudiant (réduction de 10%)</label>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php?page=candidats" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>