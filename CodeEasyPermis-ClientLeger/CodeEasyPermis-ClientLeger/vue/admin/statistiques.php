<?php $currentPage = 'statistiques'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>.container { max-width:100%; padding: 0; background: transparent; box-shadow: none; border-radius: 0; } body { padding: 0; }</style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .header h1 i {
            color: #ef4444;
        }

        .header p {
            color: #6b7280;
        }

        /* Stats globales */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.purple { background: #ede9fe; color: #8b5cf6; }
        .stat-icon.red { background: #fee2e2; color: #ef4444; }

        .stat-info h3 {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-trend {
            margin-top: 8px;
            font-size: 14px;
        }

        .trend-up {
            color: #10b981;
        }

        .trend-down {
            color: #ef4444;
        }

        /* Graphiques */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .chart-card h2 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-card h2 i {
            color: #ef4444;
        }

        /* Tableaux */
        .table-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .table-section h2 {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-section h2 i {
            color: #ef4444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px 16px;
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

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
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
                <i class="fas fa-chart-bar"></i>
                Statistiques et Analyses
            </h1>
            <p>Vue d'ensemble des performances de votre auto-école</p>
        </div>

        <!-- Stats globales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Candidats</h3>
                    </div>
                </div>
                <div class="stat-value"><?= $stats['total_candidats'] ?></div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +<?= $stats['nouveaux_candidats_mois'] ?> ce mois
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon orange">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Moniteurs Actifs</h3>
                    </div>
                </div>
                <div class="stat-value"><?= $stats['total_moniteurs'] ?></div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-check"></i> Tous actifs
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Leçons ce mois</h3>
                    </div>
                </div>
                <div class="stat-value"><?= $stats['lecons_mois'] ?></div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> +<?= $stats['evolution_lecons'] ?>% vs mois dernier
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Heures ce mois</h3>
                    </div>
                </div>
                <div class="stat-value"><?= $stats['heures_mois'] ?>h</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i> <?= $stats['heures_par_jour'] ?>h/jour en moyenne
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Revenus potentiels</h3>
                    </div>
                </div>
                <div class="stat-value"><?= number_format($stats['revenus_potentiels'], 0, ',', ' ') ?>€</div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-info-circle"></i> Basé sur les inscriptions
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="charts-grid">
            <!-- Graphique des inscriptions -->
            <div class="chart-card">
                <h2>
                    <i class="fas fa-chart-line"></i>
                    Inscriptions par mois
                </h2>
                <canvas id="chartInscriptions"></canvas>
            </div>

            <!-- Graphique des formules -->
            <div class="chart-card">
                <h2>
                    <i class="fas fa-chart-pie"></i>
                    Répartition des formules
                </h2>
                <canvas id="chartFormules"></canvas>
            </div>
        </div>

        <!-- Top moniteurs -->
        <div class="table-section">
            <h2>
                <i class="fas fa-trophy"></i>
                Top Moniteurs (par nombre de leçons ce mois)
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Moniteur</th>
                        <th>Leçons ce mois</th>
                        <th>Heures ce mois</th>
                        <th>Élèves actifs</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($top_moniteurs)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #9ca3af; padding: 40px;">
                                Aucune donnée disponible
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($top_moniteurs as $index => $moniteur): ?>
                            <tr>
                                <td>
                                    <strong style="font-size: 18px; color: #ef4444;">
                                        #<?= $index + 1 ?>
                                    </strong>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($moniteur['prenom'] . ' ' . $moniteur['nom']) ?></strong>
                                </td>
                                <td><?= $moniteur['nb_lecons'] ?? 0 ?> leçons</td>
                                <td><?= $moniteur['nb_heures'] ?? 0 ?>h</td>
                                <td><?= $moniteur['nb_eleves'] ?? 0 ?> élèves</td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Actif
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Candidats récents -->
        <div class="table-section">
            <h2>
                <i class="fas fa-user-clock"></i>
                Dernières inscriptions
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Candidat</th>
                        <th>Email</th>
                        <th>Formule</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($candidats_recents)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #9ca3af; padding: 40px;">
                                Aucune inscription récente
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($candidats_recents as $candidat): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($candidat['date_inscription'] ?? 'now')) ?></td>
                                <td><strong><?= htmlspecialchars($candidat['prenom'] . ' ' . $candidat['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($candidat['email']) ?></td>
                                <td><?= htmlspecialchars($candidat['libelle']) ?></td>
                                <td>
                                    <?php if ($candidat['etudiant']): ?>
                                        <span class="badge badge-info">🎓 Étudiant</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Régulier</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Graphique des inscriptions
        const ctxInscriptions = document.getElementById('chartInscriptions').getContext('2d');
        new Chart(ctxInscriptions, {
            type: 'line',
            data: {
                labels: <?= json_encode($mois_labels) ?>,
                datasets: [{
                    label: 'Inscriptions',
                    data: <?= json_encode($inscriptions_data) ?>,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Graphique des formules
        const ctxFormules = document.getElementById('chartFormules').getContext('2d');
        new Chart(ctxFormules, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($formules_labels) ?>,
                datasets: [{
                    data: <?= json_encode($formules_data) ?>,
                    backgroundColor: [
                        '#ef4444',
                        '#f59e0b',
                        '#10b981',
                        '#3b82f6',
                        '#8b5cf6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
    </div>
</body>
</html>