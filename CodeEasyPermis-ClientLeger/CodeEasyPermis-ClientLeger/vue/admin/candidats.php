<?php $currentPage = 'candidats'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des candidats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>.container { max-width:100%; padding: 0; background: transparent; box-shadow: none; border-radius: 0; } body { padding: 0; }</style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

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

        .header h1 i {
            color: #ef4444;
        }

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
            background: #ef4444;
            color: white;
        }

        .btn-primary:hover {
            background: #dc2626;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }

        .search-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
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

        .badge-student {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-regular {
            background: #e5e7eb;
            color: #374151;
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

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
                <i class="fas fa-user-graduate"></i>
                Gestion des candidats
            </h1>
            <a href="index.php?page=edit-candidat" class="action-card">
                <i class="fas fa-plus"></i> Nouveau candidat
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?php
                if ($_GET['success'] == 'add') echo "Candidat ajouté avec succès !";
                if ($_GET['success'] == 'delete') echo "Candidat supprimé avec succès !";
                if ($_GET['success'] == 'update') echo "Candidat modifié avec succès !";
                ?>
            </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total candidats</h3>
                <div class="value"><?= count($candidats) ?></div>
            </div>
            <div class="stat-card">
                <h3>Étudiants</h3>
                <div class="value">
                    <?= count(array_filter($candidats, fn($c) => $c['etudiant'] == 1)) ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>Nouveaux ce mois</h3>
                <div class="value">0</div>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="🔍 Rechercher un candidat (nom, prénom, email)...">
        </div>

        <!-- Tableau -->
        <div class="table-container">
            <?php if (empty($candidats)): ?>
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p>Aucun candidat inscrit</p>
                </div>
            <?php else: ?>
                <table id="candidatsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Formule</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($candidats as $candidat): ?>
                            <tr>
                                <td>#<?= $candidat['idcandidat'] ?></td>
                                <td><strong><?= htmlspecialchars($candidat['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($candidat['prenom']) ?></td>
                                <td><?= htmlspecialchars($candidat['email']) ?></td>
                                <td><?= htmlspecialchars($candidat['libelle']) ?></td>
                                <td>
                                    <?php if ($candidat['etudiant']): ?>
                                        <span class="badge badge-student">🎓 Étudiant</span>
                                    <?php else: ?>
                                        <span class="badge badge-regular">Régulier</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="index.php?page=edit-candidat&id=<?= $candidat['idcandidat'] ?>" 
                                           class="btn-icon btn-edit" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?page=delete-candidat&id=<?= $candidat['idcandidat'] ?>" 
                                           class="btn-icon btn-delete" 
                                           title="Supprimer"
                                           onclick="return confirm('Voulez-vous vraiment supprimer ce candidat ?')">
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

    <script>
        // Recherche en temps réel
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#candidatsTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
    </div>
</body>
</html>