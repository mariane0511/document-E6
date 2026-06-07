<?php $currentPage = 'vehicules'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des véhicules</title>
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
        .header h1 i { color: #3b82f6; }
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
            margin-right: 10px;
        }
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        .btn-primary:hover {
            background: #2563eb;
        }
        .btn-secondary {
            background: #8b5cf6;
            color: white;
        }
        .btn-secondary:hover {
            background: #7c3aed;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #f9fafb;
        }
        th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            padding: 16px 20px;
            color: #6b7280;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:hover {
            background: #f9fafb;
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
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn-icon {
            padding: 6px 10px;
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
            text-align: center;
            padding: 80px 20px;
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
                <i class="fas fa-car"></i>
                Gestion des véhicules
            </h1>
            <div>
                <a href="index.php?page=modeles" class="btn btn-secondary">
                    <i class="fas fa-cog"></i> Gérer les modèles
                </a>
                <a href="index.php?page=edit-vehicule" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau véhicule
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Véhicule ajouté avec succès !";
                if ($_GET['success'] == 'delete') echo "Véhicule supprimé avec succès !";
                if ($_GET['success'] == 'update') echo "Véhicule modifié avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (empty($vehicules)): ?>
                <div class="empty-state">
                    <i class="fas fa-car-side"></i>
                    <p>Aucun véhicule enregistré</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Immatriculation</th>
                            <th>Marque / Modèle</th>
                            <th>Type de boîte</th>
                            <th>Moniteur assigné</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehicules as $vehicule): ?>
                            <tr>
                                <td>#<?= $vehicule['idvehicule'] ?></td>
                                <td><strong><?= htmlspecialchars($vehicule['immatriculation']) ?></strong></td>
                                <td><?= htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['nommodele']) ?></td>
                                <td>
                                    <?php if ($vehicule['typeboite'] == 'auto'): ?>
                                        <span class="badge badge-info">Automatique</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Manuelle</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($vehicule['moniteur_nom']): ?>
                                        <?= htmlspecialchars($vehicule['moniteur_prenom'] . ' ' . $vehicule['moniteur_nom']) ?>
                                    <?php else: ?>
                                        <span style="color: #9ca3af;">Non assigné</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $etat = $vehicule['etat'] ?? 'disponible';
                                    if ($etat == 'disponible') {
                                        echo '<span class="badge badge-success">Disponible</span>';
                                    } elseif ($etat == 'en_reparation') {
                                        echo '<span class="badge badge-danger">En réparation</span>';
                                    } else {
                                        echo '<span class="badge badge-warning">En maintenance</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="index.php?page=edit-vehicule&id=<?= $vehicule['idvehicule'] ?>" 
                                           class="btn-icon btn-edit" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?page=delete-vehicule&id=<?= $vehicule['idvehicule'] ?>" 
                                           class="btn-icon btn-delete" 
                                           title="Supprimer"
                                           onclick="return confirm('Voulez-vous vraiment supprimer ce véhicule ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    </div>
</body>
</html>