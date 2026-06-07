<?php $currentPage = 'mes-eleves'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Élèves - Moniteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/moniteur/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #f59e0b; }
        .page-header p { color: #6b7280; margin-top: 6px; }

        .search-bar { background: white; padding: 20px 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; display: flex; gap: 16px; align-items: center; }
        .search-input { flex: 1; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px 16px; font-size: 15px; outline: none; }
        .search-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }

        .eleves-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px; }
        .eleve-card { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 24px; transition: all 0.3s; border: 2px solid transparent; }
        .eleve-card:hover { border-color: #f59e0b; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .eleve-header { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
        .eleve-avatar { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px; flex-shrink: 0; }
        .eleve-name { font-size: 17px; font-weight: 600; color: #1f2937; }
        .eleve-formule { font-size: 13px; color: #6b7280; background: #f3f4f6; padding: 3px 10px; border-radius: 20px; display: inline-block; margin-top: 4px; }

        .eleve-stats { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .mini-stat { background: #f9fafb; border-radius: 10px; padding: 12px; text-align: center; }
        .mini-stat .val { font-size: 20px; font-weight: 700; color: #1f2937; }
        .mini-stat .lbl { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        .eleve-actions { display: flex; gap: 10px; }
        .btn-sm { padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-orange { background: #fed7aa; color: #b45309; }
        .btn-orange:hover { background: #f59e0b; color: white; }
        .btn-blue { background: #dbeafe; color: #1d4ed8; }
        .btn-blue:hover { background: #3b82f6; color: white; }

        .empty-state { text-align: center; padding: 80px 20px; color: #9ca3af; background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .empty-state i { font-size: 64px; margin-bottom: 16px; opacity: 0.3; display: block; }
        .empty-state h3 { font-size: 20px; color: #6b7280; margin-bottom: 8px; }

        .badge-quiz { display: inline-flex; align-items: center; gap: 5px; background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-quiz.low { background: #fee2e2; color: #991b1b; }
        .badge-quiz.mid { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <?php include 'vue/moniteur/_sidebar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-users"></i> Mes Élèves</h1>
            <p>Liste des candidats qui ont des leçons avec vous</p>
        </div>

        <div class="search-bar">
            <i class="fas fa-search" style="color:#9ca3af"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher un élève...">
            <span style="color:#9ca3af;font-size:14px"><?= count($mesEleves) ?> élève<?= count($mesEleves) > 1 ? 's' : '' ?></span>
        </div>

        <?php if (empty($mesEleves)): ?>
        <div class="empty-state">
            <i class="fas fa-user-graduate"></i>
            <h3>Aucun élève pour l'instant</h3>
            <p>Les élèves apparaîtront ici une fois que des leçons leur seront assignées.</p>
        </div>
        <?php else: ?>
        <div class="eleves-grid" id="elevesGrid">
            <?php foreach($mesEleves as $eleve): ?>
            <div class="eleve-card" data-name="<?= strtolower($eleve['prenom'] . ' ' . $eleve['nom']) ?>">
                <div class="eleve-header">
                    <div class="eleve-avatar">
                        <?= strtoupper(substr($eleve['prenom'],0,1) . substr($eleve['nom'],0,1)) ?>
                    </div>
                    <div>
                        <div class="eleve-name"><?= htmlspecialchars($eleve['prenom'] . ' ' . $eleve['nom']) ?></div>
                        <span class="eleve-formule"><?= htmlspecialchars($eleve['formule_libelle'] ?? 'N/A') ?></span>
                    </div>
                </div>

                <div class="eleve-stats">
                    <div class="mini-stat">
                        <div class="val"><?= $eleve['nb_lecons'] ?></div>
                        <div class="lbl">Leçons</div>
                    </div>
                    <div class="mini-stat">
                        <div class="val"><?= $eleve['heures_conduites'] ?>h</div>
                        <div class="lbl">Heures</div>
                    </div>
                    <div class="mini-stat">
                        <div class="val">
                            <?php if($eleve['nb_quiz'] > 0): ?>
                                <?php
                                $pct = round($eleve['score_moyen']/10*100);
                                $cls = $pct >= 70 ? '' : ($pct >= 50 ? 'mid' : 'low');
                                ?>
                                <span class="badge-quiz <?= $cls ?>"><?= $pct ?>%</span>
                            <?php else: ?>
                                <span style="color:#9ca3af;font-size:13px">-</span>
                            <?php endif; ?>
                        </div>
                        <div class="lbl">Quiz moy.</div>
                    </div>
                </div>

                <div class="eleve-actions">
                    <a href="index.php?page=evaluations&eleve=<?= $eleve['idcandidat'] ?>" class="btn-sm btn-orange">
                        <i class="fas fa-chart-bar"></i> Stats Quiz
                    </a>
                    <a href="index.php?page=planning&candidat=<?= $eleve['idcandidat'] ?>" class="btn-sm btn-blue">
                        <i class="fas fa-calendar"></i> Planning
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
    document.getElementById('searchInput')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.eleve-card').forEach(card => {
            card.style.display = card.dataset.name.includes(q) ? '' : 'none';
        });
    });
    </script>
</body>
</html>
