<?php $currentPage = 'modeles'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des modèles</title>
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
        .container { max-width: 1200px; margin: 0 auto; }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8b5cf6;
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
        .modeles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        .modele-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            border-top: 4px solid #8b5cf6;
        }
        .modele-card:hover {
            transform: translateY(-5px);
        }
        .modele-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .modele-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #ede9fe;
            color: #8b5cf6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .modele-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }
        .modele-info {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .modele-actions {
            display: flex;
            gap: 10px;
        }
        .btn-icon {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
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
        <a href="index.php?page=vehicules" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour aux véhicules
        </a>

        <div class="header">
            <h1>
                <i class="fas fa-cog"></i>
                Gestion des modèles
            </h1>
            <a href="index.php?page=edit-modele" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau modèle
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Modèle ajouté avec succès !";
                if ($_GET['success'] == 'delete') echo "Modèle supprimé avec succès !";
                if ($_GET['success'] == 'update') echo "Modèle modifié avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($modeles)): ?>
            <div class="empty-state">
                <i class="fas fa-car"></i>
                <p>Aucun modèle créé</p>
            </div>
        <?php else: ?>
            <div class="modeles-grid">
                <?php foreach ($modeles as $modele): ?>
                    <div class="modele-card">
                        <div class="modele-header">
                            <div class="modele-icon">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <div>
                                <div class="modele-title"><?= htmlspecialchars($modele['marque']) ?></div>
                                <div style="color: #6b7280; font-size: 14px;">
                                    <?= htmlspecialchars($modele['nommodele']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modele-info">
                            <i class="fas fa-cogs"></i>
                            Type de boîte : <strong><?= $modele['typeboite'] == 'auto' ? 'Automatique' : 'Manuelle' ?></strong>
                        </div>

                        <div class="modele-actions">
                            <a href="index.php?page=edit-modele&id=<?= $modele['idmodele'] ?>" 
                               class="btn-icon btn-edit">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="index.php?page=delete-modele&id=<?= $modele['idmodele'] ?>" 
                               class="btn-icon btn-delete"
                               onclick="return confirm('Voulez-vous vraiment supprimer ce modèle ?')">
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