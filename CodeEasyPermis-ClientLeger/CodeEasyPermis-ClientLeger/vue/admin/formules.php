<?php $currentPage = 'formules'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des formules</title>
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
        .formules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        .formule-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid #8b5cf6;
        }
        .formule-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .formule-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }
        .formule-price {
            font-size: 32px;
            font-weight: 700;
            color: #8b5cf6;
            margin-bottom: 16px;
        }
        .formule-details {
            display: grid;
            gap: 10px;
            margin-bottom: 20px;
        }
        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6b7280;
            font-size: 14px;
        }
        .detail-item i {
            color: #9ca3af;
        }
        .formule-actions {
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
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
                <i class="fas fa-tags"></i>
                Gestion des formules
            </h1>
            <a href="index.php?page=add-formule" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle formule
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Formule ajoutée avec succès !";
                if ($_GET['success'] == 'delete') echo "Formule supprimée avec succès !";
                if ($_GET['success'] == 'update') echo "Formule modifiée avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($formules)): ?>
            <div class="empty-state">
                <i class="fas fa-tag"></i>
                <p>Aucune formule créée</p>
            </div>
        <?php else: ?>
            <div class="formules-grid">
                <?php foreach ($formules as $formule): ?>
                    <div class="formule-card">
                        <div class="formule-title"><?= htmlspecialchars($formule['libelle']) ?></div>
                        <div class="formule-price"><?= number_format($formule['prix'], 2) ?>€</div>
                        
                        <div class="formule-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span><?= $formule['duree'] ?> heures de conduite</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-users"></i>
                                <span>Public : <?= htmlspecialchars($formule['typepublic']) ?></span>
                            </div>
                        </div>

                        <div class="formule-actions">
                            <a href="index.php?page=edit-formule&id=<?= $formule['idformule'] ?>" 
                               class="btn-icon btn-edit">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="index.php?page=delete-formule&id=<?= $formule['idformule'] ?>" 
                               class="btn-icon btn-delete"
                               onclick="return confirm('Voulez-vous vraiment supprimer cette formule ?')">
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