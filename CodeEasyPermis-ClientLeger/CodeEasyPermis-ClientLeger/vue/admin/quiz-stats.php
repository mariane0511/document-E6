<?php $currentPage = 'quiz-stats-admin'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques Quiz - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #ef4444; }
        .page-header p { color: #6b7280; margin-top: 6px; }

        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stat-card .icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px; }
        .stat-card .icon.red    { background: #fee2e2; color: #ef4444; }
        .stat-card .icon.green  { background: #d1fae5; color: #10b981; }
        .stat-card .icon.blue   { background: #dbeafe; color: #3b82f6; }
        .stat-card .icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-card .val { font-size: 28px; font-weight: 700; color: #1f2937; }
        .stat-card .lbl { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .charts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; }
        .chart-card { background: white; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .chart-title { font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
        .chart-title i { color: #ef4444; }
        .chart-canvas { max-height: 220px; }

        .table-section { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 28px; }
        .table-header { padding: 22px 28px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 18px; font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 10px; }
        .table-title i { color: #ef4444; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        thead th { padding: 13px 20px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.05em; }
        tbody td { padding: 15px 20px; border-top: 1px solid #f3f4f6; font-size: 14px; color: #374151; vertical-align: middle; }
        tbody tr:hover { background: #fafafa; }

        .avatar-sm { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 700; flex-shrink: 0; }
        .cand-cell { display: flex; align-items: center; gap: 12px; }

        .score-bar-wrap { display: flex; align-items: center; gap: 10px; }
        .score-bar { flex: 1; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; max-width: 90px; }
        .score-fill { height: 100%; border-radius: 4px; }
        .score-fill.good { background: #10b981; }
        .score-fill.mid  { background: #f59e0b; }
        .score-fill.bad  { background: #ef4444; }
        .score-text.good { color: #059669; font-weight: 700; }
        .score-text.mid  { color: #d97706; font-weight: 700; }
        .score-text.bad  { color: #dc2626; font-weight: 700; }

        .toolbar { background: white; padding: 14px 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 22px; display: flex; gap: 14px; align-items: center; }
        .search-input { border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px 14px; font-size: 14px; outline: none; width: 240px; }
        .search-input:focus { border-color: #ef4444; }

        .empty-state { text-align: center; padding: 60px; color: #9ca3af; }
        .empty-state i { font-size: 48px; margin-bottom: 12px; opacity: 0.3; display: block; }

        .rank-badge { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .rank-1 { background: #fef3c7; color: #92400e; }
        .rank-2 { background: #f3f4f6; color: #374151; }
        .rank-3 { background: #fde8d3; color: #9a3412; }
    </style>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-chart-bar"></i> Statistiques Quiz</h1>
            <p>Vue globale des performances aux quiz code de tous les candidats</p>
        </div>

        <!-- Stats globales -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="icon red"><i class="fas fa-tasks"></i></div>
                <div class="val"><?= $totalQuiz ?></div>
                <div class="lbl">Quiz passés (total)</div>
            </div>
            <div class="stat-card">
                <div class="icon green"><i class="fas fa-percentage"></i></div>
                <div class="val"><?= $scoreMoyen ?>%</div>
                <div class="lbl">Score moyen global</div>
            </div>
            <div class="stat-card">
                <div class="icon blue"><i class="fas fa-trophy"></i></div>
                <div class="val"><?= $tauxReussite ?>%</div>
                <div class="lbl">Taux de réussite ≥70%</div>
            </div>
            <div class="stat-card">
                <div class="icon orange"><i class="fas fa-user-check"></i></div>
                <div class="val"><?= $candidatsActifs ?></div>
                <div class="lbl">Candidats ayant tenté</div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-bar"></i> Distribution des scores</div>
                <canvas class="chart-canvas" id="distChart"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-line"></i> Évolution (30 derniers jours)</div>
                <canvas class="chart-canvas" id="evolChart"></canvas>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <i class="fas fa-search" style="color:#9ca3af"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher un candidat...">
            <span style="color:#9ca3af;font-size:13px;margin-left:auto">Cliquer sur un candidat pour voir le détail</span>
        </div>

        <!-- Tableau par candidat -->
        <div class="table-section">
            <div class="table-header">
                <h2 class="table-title"><i class="fas fa-users"></i> Résultats par candidat</h2>
                <span style="color:#9ca3af;font-size:13px"><?= count($statsParCandidat) ?> candidat<?= count($statsParCandidat) > 1 ? 's' : '' ?></span>
            </div>
            <?php if(empty($statsParCandidat)): ?>
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Aucun résultat de quiz disponible.</p></div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Candidat</th>
                        <th>Quiz passés</th>
                        <th>Score moyen</th>
                        <th>Meilleur score</th>
                        <th>Dernier quiz</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach($statsParCandidat as $i => $c):
                        $pct = $c['nb_quiz'] > 0 ? round($c['score_total'] / ($c['nb_quiz'] * 10) * 100) : 0;
                        $bestPct = round($c['meilleur_score'] / 10 * 100);
                        $cls = $pct >= 70 ? 'good' : ($pct >= 50 ? 'mid' : 'bad');
                        $rank = $i + 1;
                    ?>
                    <tr data-name="<?= strtolower($c['prenom'].' '.$c['nom']) ?>">
                        <td>
                            <div class="rank-badge <?= $rank <= 3 ? 'rank-'.$rank : '' ?>"><?= $rank ?></div>
                        </td>
                        <td>
                            <div class="cand-cell">
                                <div class="avatar-sm"><?= strtoupper(substr($c['prenom'],0,1).substr($c['nom'],0,1)) ?></div>
                                <span><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?></span>
                            </div>
                        </td>
                        <td><?= $c['nb_quiz'] ?></td>
                        <td>
                            <div class="score-bar-wrap">
                                <div class="score-bar"><div class="score-fill <?= $cls ?>" style="width:<?= $pct ?>%"></div></div>
                                <span class="score-text <?= $cls ?>"><?= $pct ?>%</span>
                            </div>
                        </td>
                        <td>
                            <span style="color:<?= $bestPct>=70?'#059669':($bestPct>=50?'#d97706':'#dc2626') ?>;font-weight:700">
                                <?= $c['meilleur_score'] ?>/10 (<?= $bestPct ?>%)
                            </span>
                        </td>
                        <td><?= $c['dernier_quiz'] ? date('d/m/Y', strtotime($c['dernier_quiz'])) : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- Historique complet -->
        <div class="table-section">
            <div class="table-header">
                <h2 class="table-title"><i class="fas fa-history"></i> Historique complet</h2>
                <span style="color:#9ca3af;font-size:13px"><?= count($tousResultats) ?> résultat<?= count($tousResultats)>1?'s':'' ?></span>
            </div>
            <?php if(empty($tousResultats)): ?>
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Aucun résultat.</p></div>
            <?php else: ?>
            <table>
                <thead>
                    <tr><th>Candidat</th><th>Date</th><th>Score</th><th>Temps</th><th>Résultat</th></tr>
                </thead>
                <tbody>
                    <?php foreach($tousResultats as $r):
                        $p = round($r['score']/$r['total_questions']*100);
                        $c2 = $p>=70?'good':($p>=50?'mid':'bad');
                        $lbl = $p>=70?'Réussi':($p>=50?'Moyen':'Échoué');
                        $mins = floor($r['temps_total']/60); $secs = $r['temps_total']%60;
                    ?>
                    <tr>
                        <td>
                            <div class="cand-cell">
                                <div class="avatar-sm"><?= strtoupper(substr($r['candidat_prenom'],0,1).substr($r['candidat_nom'],0,1)) ?></div>
                                <span><?= htmlspecialchars($r['candidat_prenom'].' '.$r['candidat_nom']) ?></span>
                            </div>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($r['date_quiz'])) ?></td>
                        <td>
                            <div class="score-bar-wrap">
                                <div class="score-bar"><div class="score-fill <?= $c2 ?>" style="width:<?= $p ?>%"></div></div>
                                <span class="score-text <?= $c2 ?>"><?= $r['score'] ?>/<?= $r['total_questions'] ?></span>
                            </div>
                        </td>
                        <td><?= $mins ?>m <?= $secs ?>s</td>
                        <td><span style="background:<?= $c2==='good'?'#d1fae5':($c2==='mid'?'#fef3c7':'#fee2e2') ?>;color:<?= $c2==='good'?'#065f46':($c2==='mid'?'#92400e':'#991b1b') ?>;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700"><?= $lbl ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Distribution des scores
    new Chart(document.getElementById('distChart'), {
        type: 'bar',
        data: {
            labels: ['0-20%','21-40%','41-60%','61-80%','81-100%'],
            datasets: [{
                label: 'Nombre de quiz',
                data: <?= json_encode($distributionScores) ?>,
                backgroundColor: ['#fee2e2','#fed7aa','#fef3c7','#d1fae5','#a7f3d0'],
                borderColor: ['#ef4444','#f59e0b','#eab308','#10b981','#059669'],
                borderWidth: 2, borderRadius: 8
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });

    // Évolution
    new Chart(document.getElementById('evolChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode($evolLabels) ?>,
            datasets: [{
                label: 'Score moyen (%)',
                data: <?= json_encode($evolScores) ?>,
                borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)',
                borderWidth: 2, fill: true, tension: 0.4,
                pointBackgroundColor: '#ef4444'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } }
    });

    // Recherche
    document.getElementById('searchInput').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            row.style.display = row.dataset.name.includes(q) ? '' : 'none';
        });
    });
    </script>
</body>
</html>
