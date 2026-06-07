<?php $currentPage = 'evaluations'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluations Quiz - Moniteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/moniteur/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #f59e0b; }
        .page-header p { color: #6b7280; margin-top: 6px; }

        .stats-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px; }
        .sum-card { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 16px; }
        .sum-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .sum-icon.orange { background: #fed7aa; color: #f59e0b; }
        .sum-icon.blue   { background: #dbeafe; color: #3b82f6; }
        .sum-icon.green  { background: #d1fae5; color: #10b981; }
        .sum-icon.purple { background: #ede9fe; color: #8b5cf6; }
        .sum-val { font-size: 26px; font-weight: 700; color: #1f2937; }
        .sum-lbl { font-size: 13px; color: #6b7280; }

        /* Filtre élève */
        .filter-bar { background: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
        .filter-select { border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; outline: none; background: white; }
        .filter-select:focus { border-color: #f59e0b; }
        .filter-label { font-size: 14px; color: #374151; font-weight: 500; }

        /* Tableau des résultats */
        .table-section { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .table-header { padding: 24px 28px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 18px; font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 10px; }
        .table-title i { color: #f59e0b; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        thead th { padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.05em; }
        tbody td { padding: 16px 20px; border-top: 1px solid #f3f4f6; font-size: 14px; color: #374151; vertical-align: middle; }
        tbody tr:hover { background: #fafafa; }

        .score-bar-wrap { display: flex; align-items: center; gap: 10px; }
        .score-bar { flex: 1; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; max-width: 100px; }
        .score-fill { height: 100%; border-radius: 4px; }
        .score-fill.good  { background: #10b981; }
        .score-fill.mid   { background: #f59e0b; }
        .score-fill.bad   { background: #ef4444; }
        .score-text { font-weight: 700; min-width: 40px; }
        .score-text.good  { color: #059669; }
        .score-text.mid   { color: #d97706; }
        .score-text.bad   { color: #dc2626; }

        .badge-eleve { display: inline-flex; align-items: center; gap: 8px; }
        .avatar-sm { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 700; flex-shrink: 0; }

        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
        .empty-state i { font-size: 48px; margin-bottom: 12px; opacity: 0.3; display: block; }
    </style>
</head>
<body>
    <?php include 'vue/moniteur/_sidebar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-clipboard-check"></i> Évaluations Quiz</h1>
            <p>Statistiques des quiz code de vos élèves</p>
        </div>

        <!-- Résumé global -->
        <div class="stats-summary">
            <div class="sum-card">
                <div class="sum-icon orange"><i class="fas fa-users"></i></div>
                <div><div class="sum-val"><?= $nbElevesTotal ?></div><div class="sum-lbl">Élèves suivis</div></div>
            </div>
            <div class="sum-card">
                <div class="sum-icon blue"><i class="fas fa-tasks"></i></div>
                <div><div class="sum-val"><?= $nbQuizTotal ?></div><div class="sum-lbl">Quiz passés</div></div>
            </div>
            <div class="sum-card">
                <div class="sum-icon green"><i class="fas fa-percentage"></i></div>
                <div><div class="sum-val"><?= $scoreMoyenGlobal ?>%</div><div class="sum-lbl">Score moyen</div></div>
            </div>
            <div class="sum-card">
                <div class="sum-icon purple"><i class="fas fa-trophy"></i></div>
                <div><div class="sum-val"><?= $nbReussites ?>%</div><div class="sum-lbl">Taux de réussite</div></div>
            </div>
        </div>

        <!-- Filtre -->
        <div class="filter-bar">
            <span class="filter-label"><i class="fas fa-filter" style="margin-right:6px"></i>Filtrer par élève :</span>
            <select class="filter-select" id="eleveFilter" onchange="filterTable()">
                <option value="">Tous les élèves</option>
                <?php foreach($mesEleves as $eleve): ?>
                <option value="<?= $eleve['idcandidat'] ?>" <?= (isset($_GET['eleve']) && $_GET['eleve'] == $eleve['idcandidat']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tableau des résultats -->
        <div class="table-section">
            <div class="table-header">
                <h2 class="table-title"><i class="fas fa-list-alt"></i> Historique des résultats</h2>
                <span style="color:#9ca3af;font-size:13px"><?= count($resultatsQuiz) ?> résultat<?= count($resultatsQuiz) > 1 ? 's' : '' ?></span>
            </div>
            <?php if (empty($resultatsQuiz)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Aucun résultat de quiz pour vos élèves pour l'instant.</p>
            </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Élève</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Résultat</th>
                        <th>Temps</th>
                    </tr>
                </thead>
                <tbody id="quizTableBody">
                    <?php foreach($resultatsQuiz as $res):
                        $pct = round($res['score'] / $res['total_questions'] * 100);
                        $cls = $pct >= 70 ? 'good' : ($pct >= 50 ? 'mid' : 'bad');
                        $label = $pct >= 70 ? 'Réussi' : ($pct >= 50 ? 'Moyen' : 'Échoué');
                        $mins = floor($res['temps_total'] / 60);
                        $secs = $res['temps_total'] % 60;
                    ?>
                    <tr data-eleve="<?= $res['idcandidat'] ?>">
                        <td>
                            <div class="badge-eleve">
                                <div class="avatar-sm"><?= strtoupper(substr($res['candidat_prenom'],0,1).substr($res['candidat_nom'],0,1)) ?></div>
                                <span><?= htmlspecialchars($res['candidat_prenom'] . ' ' . $res['candidat_nom']) ?></span>
                            </div>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($res['date_quiz'])) ?></td>
                        <td>
                            <div class="score-bar-wrap">
                                <div class="score-bar"><div class="score-fill <?= $cls ?>" style="width:<?= $pct ?>%"></div></div>
                                <span class="score-text <?= $cls ?>"><?= $res['score'] ?>/<?= $res['total_questions'] ?></span>
                            </div>
                        </td>
                        <td>
                            <span style="background:<?= $cls==='good'?'#d1fae5':($cls==='mid'?'#fef3c7':'#fee2e2') ?>;color:<?= $cls==='good'?'#065f46':($cls==='mid'?'#92400e':'#991b1b') ?>;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700">
                                <?= $label ?>
                            </span>
                        </td>
                        <td><?= $mins ?>m <?= $secs ?>s</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function filterTable() {
        const val = document.getElementById('eleveFilter').value;
        document.querySelectorAll('#quizTableBody tr').forEach(row => {
            row.style.display = (!val || row.dataset.eleve === val) ? '' : 'none';
        });
    }
    // Appliquer le filtre initial si paramètre GET
    const urlEleve = new URLSearchParams(window.location.search).get('eleve');
    if (urlEleve) {
        document.getElementById('eleveFilter').value = urlEleve;
        filterTable();
    }
    </script>
</body>
</html>
