<?php
$currentPage = 'mes-lecons';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes leçons - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/candidat/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #6366f1; }
        .page-header p { color: #6b7280; margin-top: 6px; }
        .lecons-grid { display: grid; gap: 20px; }
        .lecon-card {
            background: white; padding: 24px; border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #6366f1;
        }
        .lecon-card.passed { border-left-color: #9ca3af; opacity: 0.7; }
        .lecon-card.cancelled { border-left-color: #ef4444; opacity: 0.8; }
        .lecon-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
        .lecon-date { font-size: 16px; font-weight: 600; color: #6366f1; }
        .lecon-card.passed .lecon-date { color: #9ca3af; }
        .lecon-card.cancelled .lecon-date { color: #ef4444; }
        .lecon-details { display: grid; gap: 10px; }
        .detail-item { display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 14px; }
        .detail-item i { color: #9ca3af; width: 20px; }
        .lecon-actions { display: flex; gap: 10px; margin-top: 16px; }
        .btn-action {
            padding: 8px 18px; border: none; border-radius: 8px; cursor: pointer;
            font-size: 13px; font-weight: 600; transition: all 0.3s; display: flex; align-items: center; gap: 6px;
        }
        .btn-reporter { background: #fef3c7; color: #92400e; }
        .btn-reporter:hover { background: #fde68a; }
        .btn-annuler { background: #fee2e2; color: #991b1b; }
        .btn-annuler:hover { background: #fecaca; }
        .status-badge {
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .badge-upcoming { background: #ede9fe; color: #6d28d9; }
        .badge-passed { background: #f3f4f6; color: #6b7280; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .empty-state { background: white; padding: 80px 20px; border-radius: 16px; text-align: center; color: #9ca3af; }
        .empty-state i { font-size: 64px; margin-bottom: 16px; opacity: 0.3; display: block; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .reporter-form { display: none; margin-top: 16px; padding: 16px; background: #f9fafb; border-radius: 10px; }
        .reporter-form.active { display: block; }
        .reporter-form label { font-size: 14px; font-weight: 600; color: #374151; display: block; margin-bottom: 6px; }
        .reporter-form input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; margin-bottom: 10px; }
        .btn-confirm { background: #6366f1; color: white; padding: 8px 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-right: 8px; }
        .btn-cancel-form { background: #e5e7eb; color: #374151; padding: 8px 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <?php include 'vue/candidat/_sidebar.php'; ?>

    <!-- Modal annulation -->
    <div class="modal-overlay" id="modal-annulation">
        <div class="modal">
            <div class="modal-icon">⚠️</div>
            <h2>Annuler cette leçon ?</h2>
            <p>Êtes-vous sûr de vouloir annuler cette leçon de conduite ? Cette action est irréversible.</p>
            <form method="POST" action="index.php?page=annuler-lecon" id="form-annulation">
                <input type="hidden" name="idlecon" id="idlecon-annulation">
                <button type="submit" class="modal-btn modal-btn-danger"><i class="fas fa-times"></i> Confirmer l'annulation</button>
                <button type="button" class="modal-btn modal-btn-secondary" onclick="fermerModal()">Retour</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-calendar-alt"></i> Mes leçons de conduite</h1>
            <p>Retrouvez toutes vos leçons passées et à venir. Vous pouvez reporter ou annuler une leçon future.</p>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'reporter'): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> Leçon reportée avec succès !</div>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'annuler'): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> Leçon annulée avec succès.</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert-error"><i class="fas fa-exclamation-triangle"></i>
                <?php
                    $errors = [
                        'passe' => 'Impossible de modifier une leçon déjà passée.',
                        'delai' => 'Vous ne pouvez pas modifier une leçon moins de 24h avant son début.',
                        'date_invalide' => 'La nouvelle date doit être dans le futur.',
                    ];
                    echo $errors[$_GET['error']] ?? 'Une erreur est survenue.';
                ?>
            </div>
        <?php endif; ?>

        <div class="lecons-grid">
            <?php if (empty($lecons)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>Aucune leçon planifiée pour le moment</p>
                </div>
            <?php else: ?>
                <?php foreach ($lecons as $lecon): ?>
                    <?php
                    $isPassed = strtotime($lecon['datedebut']) < time();
                    $isCancelled = isset($lecon['statut']) && $lecon['statut'] === 'annulee';
                    $canModify = !$isPassed && !$isCancelled && (strtotime($lecon['datedebut']) - time() > 86400);
                    $cardClass = $isCancelled ? 'cancelled' : ($isPassed ? 'passed' : '');
                    ?>
                    <div class="lecon-card <?= $cardClass ?>">
                        <div class="lecon-card-header">
                            <div class="lecon-date">
                                <i class="fas fa-clock"></i>
                                <?= date('d/m/Y à H:i', strtotime($lecon['datedebut'])) ?>
                                - <?= date('H:i', strtotime($lecon['datefin'])) ?>
                            </div>
                            <?php if ($isCancelled): ?>
                                <span class="status-badge badge-cancelled"><i class="fas fa-ban"></i> Annulée</span>
                            <?php elseif ($isPassed): ?>
                                <span class="status-badge badge-passed"><i class="fas fa-check"></i> Terminée</span>
                            <?php else: ?>
                                <span class="status-badge badge-upcoming"><i class="fas fa-clock"></i> À venir</span>
                            <?php endif; ?>
                        </div>

                        <div class="lecon-details">
                            <div class="detail-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <strong>Moniteur :</strong>&nbsp; <?= htmlspecialchars($lecon['moniteur_prenom'] . ' ' . $lecon['moniteur_nom']) ?>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-car"></i>
                                <strong>Véhicule :</strong>&nbsp; <?= htmlspecialchars($lecon['marque'] . ' ' . $lecon['nommodele']) ?> (<?= $lecon['immatriculation'] ?>)
                            </div>
                        </div>

                        <?php if ($canModify): ?>
                        <div class="lecon-actions">
                            <button class="btn-action btn-reporter" onclick="toggleReporter(<?= $lecon['idlecon'] ?>)">
                                <i class="fas fa-calendar-alt"></i> Reporter
                            </button>
                            <button class="btn-action btn-annuler" onclick="confirmerAnnulation(<?= $lecon['idlecon'] ?>)">
                                <i class="fas fa-times-circle"></i> Annuler
                            </button>
                        </div>

                        <!-- Formulaire reporter -->
                        <div class="reporter-form" id="reporter-<?= $lecon['idlecon'] ?>">
                            <form method="POST" action="index.php?page=reporter-lecon">
                                <input type="hidden" name="idlecon" value="<?= $lecon['idlecon'] ?>">
                                <label>Nouvelle date et heure de début :</label>
                                <input type="datetime-local" name="nouvelle_date" required
                                    min="<?= date('Y-m-d\TH:i', strtotime('+25 hours')) ?>">
                                <label>Nouvelle heure de fin :</label>
                                <input type="datetime-local" name="nouvelle_date_fin" required
                                    min="<?= date('Y-m-d\TH:i', strtotime('+26 hours')) ?>">
                                <button type="submit" class="btn-confirm"><i class="fas fa-check"></i> Confirmer le report</button>
                                <button type="button" class="btn-cancel-form" onclick="toggleReporter(<?= $lecon['idlecon'] ?>)">Annuler</button>
                            </form>
                        </div>
                        <?php elseif (!$isPassed && !$isCancelled): ?>
                            <p style="margin-top:12px; font-size:12px; color:#9ca3af;">
                                <i class="fas fa-info-circle"></i> Modification impossible moins de 24h avant la leçon
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function toggleReporter(id) {
        const form = document.getElementById('reporter-' + id);
        form.classList.toggle('active');
    }
    function confirmerAnnulation(id) {
        document.getElementById('idlecon-annulation').value = id;
        document.getElementById('modal-annulation').classList.add('active');
    }
    function fermerModal() {
        document.getElementById('modal-annulation').classList.remove('active');
    }
    document.getElementById('modal-annulation').addEventListener('click', function(e) {
        if (e.target === this) fermerModal();
    });
    </script>
</body>
</html>
