<?php $currentPage = 'vehicules'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($vehicule) ? 'Modifier' : 'Ajouter' ?> un véhicule</title>
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
            color: #3b82f6;
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
        h1 i { color: #3b82f6; }
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
            background: #3b82f6;
            color: white;
        }
        .btn-primary:hover {
            background: #2563eb;
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
        <a href="index.php?page=vehicules" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <h1>
            <i class="fas fa-<?= isset($vehicule) ? 'edit' : 'plus-circle' ?>"></i>
            <?= isset($vehicule) ? 'Modifier' : 'Ajouter' ?> un véhicule
        </h1>

        <form method="POST">
            <div class="form-group">
                <label>Immatriculation *</label>
                <input type="text" name="immatriculation" 
                       value="<?= $vehicule['immatriculation'] ?? '' ?>" 
                       placeholder="AB-123-CD"
                       pattern="[A-Z]{2}-[0-9]{3}-[A-Z]{2}"
                       title="Format : AB-123-CD"
                       style="text-transform: uppercase;"
                       required>
                <small style="color: #6b7280;">Format : AB-123-CD</small>
            </div>

            <div class="form-group">
                <label>Modèle *</label>
                <select name="idmodele" required>
                    <option value="">-- Choisir un modèle --</option>
                    <?php foreach ($modeles as $modele): ?>
                        <option value="<?= $modele['idmodele'] ?>"
                            <?= (isset($vehicule) && $vehicule['idmodele'] == $modele['idmodele']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($modele['marque'] . ' ' . $modele['nommodele']) ?> 
                            (<?= $modele['typeboite'] == 'auto' ? 'Automatique' : 'Manuelle' ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>État *</label>
                    <select name="etat" required>
                        <option value="disponible" <?= (isset($vehicule) && $vehicule['etat'] == 'disponible') ? 'selected' : '' ?>>Disponible</option>
                        <option value="en_maintenance" <?= (isset($vehicule) && $vehicule['etat'] == 'en_maintenance') ? 'selected' : '' ?>>En maintenance</option>
                        <option value="en_reparation" <?= (isset($vehicule) && $vehicule['etat'] == 'en_reparation') ? 'selected' : '' ?>>En réparation</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Moniteur assigné</label>
                    <select name="idmoniteur">
                        <option value="">-- Aucun --</option>
                        <?php foreach ($moniteurs as $moniteur): ?>
                            <option value="<?= $moniteur['idmoniteur'] ?>"
                                <?= (isset($vehicule) && $vehicule['idmoniteur'] == $moniteur['idmoniteur']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($moniteur['prenom'] . ' ' . $moniteur['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="index.php?page=vehicules" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>