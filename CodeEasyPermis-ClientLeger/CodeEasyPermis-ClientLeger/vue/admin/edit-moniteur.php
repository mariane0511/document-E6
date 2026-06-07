<?php $currentPage = 'moniteurs-admin'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($moniteur) ? 'Modifier' : 'Ajouter' ?> un moniteur</title>
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
            color: #f59e0b;
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
        h1 i { color: #f59e0b; }
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
            background: #f59e0b;
            color: white;
        }
        .btn-primary:hover {
            background: #d97706;
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
        <a href="index.php?page=moniteurs-admin" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <h1>
            <i class="fas fa-<?= isset($moniteur) ? 'edit' : 'user-plus' ?>"></i>
            <?= isset($moniteur) ? 'Modifier' : 'Ajouter' ?> un moniteur
        </h1>

        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" name="nom" value="<?= $moniteur['nom'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Prénom *</label>
                    <input type="text" name="prenom" value="<?= $moniteur['prenom'] ?? '' ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?= $moniteur['email'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label>Mot de passe <?= isset($moniteur) ? '(laisser vide pour ne pas changer)' : '*' ?></label>
                <input type="password" name="mdp" <?= isset($moniteur) ? '' : 'required' ?>>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="tel" name="telephone" value="<?= $moniteur['telephone'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label>Date d'embauche</label>
                    <input type="date" name="date_embauche" value="<?= $moniteur['date_embauche'] ?? '' ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Type de permis</label>
                    <select name="type_permis">
                        <option value="">-- Non renseigné --</option>
                        <option value="permis A" <?= (isset($moniteur) && $moniteur['type_permis'] == 'permis A') ? 'selected' : '' ?>>Permis A (moto)</option>
                        <option value="permis B" <?= (isset($moniteur) && $moniteur['type_permis'] == 'permis B') ? 'selected' : '' ?>>Permis B (voiture)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sexe</label>
                    <select name="sexe">
                        <option value="">-- Non renseigné --</option>
                        <option value="Femme" <?= (isset($moniteur) && $moniteur['sexe'] == 'Femme') ? 'selected' : '' ?>>Femme</option>
                        <option value="Homme" <?= (isset($moniteur) && $moniteur['sexe'] == 'Homme') ? 'selected' : '' ?>>Homme</option>
                        <option value="Autre" <?= (isset($moniteur) && $moniteur['sexe'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php?page=moniteurs-admin" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>