<?php $currentPage = 'moniteurs-admin'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des moniteurs</title>
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
        .header h1 i { color: #f59e0b; }
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
            background: #f59e0b;
            color: white;
        }
        .btn-primary:hover {
            background: #d97706;
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
        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
                <i class="fas fa-chalkboard-teacher"></i>
                Gestion des moniteurs
            </h1>
            <a href="index.php?page=add-moniteur" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau moniteur
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Moniteur ajouté avec succès !";
                if ($_GET['success'] == 'delete') echo "Moniteur supprimé avec succès !";
                if ($_GET['success'] == 'update') echo "Moniteur modifié avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <?php if (empty($moniteurs)): ?>
                <div class="empty-state">
                    <i class="fas fa-user-slash"></i>
                    <p>Aucun moniteur enregistré</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Type de permis</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($moniteurs as $moniteur): ?>
                            <tr>
                                <td>#<?= $moniteur['idmoniteur'] ?></td>
                                <td><strong><?= htmlspecialchars($moniteur['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($moniteur['prenom']) ?></td>
                                <td><?= htmlspecialchars($moniteur['email']) ?></td>
                                <td><?= htmlspecialchars($moniteur['telephone'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($moniteur['type_permis'] ?? '-') ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="index.php?page=edit-moniteur&id=<?= $moniteur['idmoniteur'] ?>" 
                                           class="btn-icon btn-edit" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?page=delete-moniteur&id=<?= $moniteur['idmoniteur'] ?>" 
                                           class="btn-icon btn-delete" 
                                           title="Supprimer"
                                           onclick="return confirm('Voulez-vous vraiment supprimer ce moniteur ?')">
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