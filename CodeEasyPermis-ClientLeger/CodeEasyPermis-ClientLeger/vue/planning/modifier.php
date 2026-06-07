<?php
// Détecter le rôle pour la sidebar
$isAdmin = isset($_SESSION['admin']);
$isMoniteur = isset($_SESSION['moniteur']);
$currentPage = 'planning';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une leçon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if($isAdmin): include 'vue/admin/_sidebar_css.php'; elseif($isMoniteur): include 'vue/moniteur/_sidebar_css.php'; endif; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 26px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: <?= $isAdmin ? '#ef4444' : '#f59e0b' ?>; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 36px; max-width: 700px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; }
        .form-group select, .form-group input[type="datetime-local"] {
            border: 1px solid #e5e7eb; border-radius: 8px; padding: 11px 14px; font-size: 14px; outline: none; background: white;
        }
        .form-group select:focus, .form-group input:focus { border-color: <?= $isAdmin ? '#ef4444' : '#f59e0b' ?>; box-shadow: 0 0 0 3px <?= $isAdmin ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)' ?>; }
        .form-full { grid-column: 1 / -1; }
        .lecon-info { background: #f9fafb; border-radius: 10px; padding: 18px; margin-bottom: 24px; }
        .lecon-info p { font-size: 14px; color: #6b7280; margin-bottom: 6px; }
        .lecon-info strong { color: #1f2937; }
        .btn-save { background: <?= $isAdmin ? '#ef4444' : '#f59e0b' ?>; color: white; padding: 13px 28px; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; transition: all 0.2s; }
        .btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-cancel { background: #e5e7eb; color: #374151; padding: 13px 24px; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; margin-left: 12px; }
        .btn-cancel:hover { background: #d1d5db; }
        .section-label { font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <?php if($isAdmin): include 'vue/admin/_sidebar.php'; elseif($isMoniteur): include 'vue/moniteur/_sidebar.php'; endif; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-edit"></i> Modifier la leçon #<?= $lecon['idlecon'] ?></h1>
        </div>

        <div class="form-card">
            <!-- Info actuelle -->
            <div class="lecon-info">
                <p><strong>Candidat actuel :</strong> <?= htmlspecialchars($lecon['candidat_prenom'] . ' ' . $lecon['candidat_nom']) ?></p>
                <p><strong>Moniteur actuel :</strong> <?= htmlspecialchars($lecon['moniteur_prenom'] . ' ' . $lecon['moniteur_nom']) ?></p>
                <p><strong>Véhicule :</strong> <?= htmlspecialchars($lecon['immatriculation']) ?> — <?= htmlspecialchars($lecon['marque'] . ' ' . $lecon['nommodele']) ?></p>
                <p><strong>Statut :</strong> <?= htmlspecialchars($lecon['statut'] ?? 'planifiée') ?></p>
            </div>

            <form method="POST" action="index.php?page=modifier-lecon&id=<?= $lecon['idlecon'] ?>">
                <div class="section-label"><i class="fas fa-clock" style="margin-right:8px"></i>Horaires</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Date et heure de début</label>
                        <input type="datetime-local" name="datedebut"
                               value="<?= date('Y-m-d\TH:i', strtotime($lecon['datedebut'])) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Date et heure de fin</label>
                        <input type="datetime-local" name="datefin"
                               value="<?= date('Y-m-d\TH:i', strtotime($lecon['datefin'])) ?>" required>
                    </div>
                </div>

                <div class="section-label" style="margin-top:20px"><i class="fas fa-users" style="margin-right:8px"></i>Participants</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Candidat</label>
                        <select name="idcandidat">
                            <?php foreach($candidats as $c): ?>
                            <option value="<?= $c['idcandidat'] ?>" <?= $c['idcandidat'] == $lecon['idcandidat'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Moniteur</label>
                        <select name="idmoniteur">
                            <?php foreach($moniteurs as $m): ?>
                            <option value="<?= $m['idmoniteur'] ?>" <?= $m['idmoniteur'] == $lecon['idmoniteur'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['prenom'] . ' ' . $m['nom']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Véhicule</label>
                        <select name="idvehicule">
                            <?php foreach($vehicules as $v): ?>
                            <option value="<?= $v['idvehicule'] ?>" <?= $v['idvehicule'] == $lecon['idvehicule'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($v['immatriculation'] . ' — ' . $v['marque'] . ' ' . $v['nommodele']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-top:16px">
                    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                    <a href="index.php?page=planning" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
