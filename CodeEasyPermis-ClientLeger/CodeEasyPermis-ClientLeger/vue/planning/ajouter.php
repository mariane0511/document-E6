<?php $currentPage = 'planning'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une leçon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>
        .form-card {
            max-width: 800px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6366f1;
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
        h1 i { color: #6366f1; }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .form-group { margin-bottom: 20px; }
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary { background: #6366f1; color: white; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-secondary { background: #e5e7eb; color: #374151; margin-left: 10px; }
    </style>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>

    <div class="main-content">
        <div class="form-card">
            <a href="index.php?page=planning" class="back-btn">
                <i class="fas fa-arrow-left"></i> Retour au planning
            </a>

            <h1>
                <i class="fas fa-plus-circle"></i>
                Ajouter une leçon
            </h1>

            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Candidat *</label>
                    <select name="idcandidat" required>
                        <option value="">-- Choisir un candidat --</option>
                        <?php foreach ($candidats as $c): ?>
                            <option value="<?= $c['idcandidat'] ?>">
                                <?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Moniteur *</label>
                    <select name="idmoniteur" required>
                        <option value="">-- Choisir un moniteur --</option>
                        <?php foreach ($moniteurs as $m): ?>
                            <option value="<?= $m['idmoniteur'] ?>">
                                <?= htmlspecialchars($m['prenom'] . ' ' . $m['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Véhicule *</label>
                    <select name="idvehicule" required>
                        <option value="">-- Choisir un véhicule --</option>
                        <?php foreach ($vehicules as $v): ?>
                            <option value="<?= $v['idvehicule'] ?>">
                                <?= htmlspecialchars($v['marque'] . ' ' . $v['nommodele']) ?> - <?= $v['immatriculation'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Date et heure de début *</label>
                        <input type="datetime-local" name="datedebut" required>
                    </div>
                    <div class="form-group">
                        <label>Date et heure de fin *</label>
                        <input type="datetime-local" name="datefin" required>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer la leçon
                    </button>
                    <a href="index.php?page=planning" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>