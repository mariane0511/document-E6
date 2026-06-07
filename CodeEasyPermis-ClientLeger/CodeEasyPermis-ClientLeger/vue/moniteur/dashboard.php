<?php $currentPage = 'moniteur'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Moniteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/moniteur/_sidebar_css.php'; ?>
    <style>
        .greeting { font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .wave { display: inline-block; animation: wave 2s infinite; }
        @keyframes wave { 0%,100%{transform:rotate(0)} 25%{transform:rotate(20deg)} 75%{transform:rotate(-20deg)} }
        .subtitle { color: #6b7280; font-size: 16px; }
        .header { margin-bottom: 40px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 28px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; font-size: 26px; }
        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-icon.blue   { background: #dbeafe; color: #3b82f6; }
        .stat-icon.green  { background: #d1fae5; color: #10b981; }
        .stat-icon.purple { background: #ede9fe; color: #8b5cf6; }
        .stat-value { font-size: 36px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .stat-label { color: #6b7280; font-size: 14px; }
        .section { background: white; padding: 32px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .section-title { display: flex; align-items: center; gap: 12px; font-size: 20px; font-weight: 600; color: #1f2937; }
        .section-title i { color: #f59e0b; }
        .see-all { color: #f59e0b; text-decoration: none; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 6px; }
        .lecon-row { display: flex; align-items: center; padding: 14px 0; border-bottom: 1px solid #f3f4f6; gap: 16px; }
        .lecon-row:last-child { border-bottom: none; }
        .lecon-time { background: #fed7aa; color: #b45309; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; white-space: nowrap; }
        .lecon-info { flex: 1; }
        .lecon-info strong { color: #1f2937; font-size: 15px; display: block; }
        .lecon-info span { color: #6b7280; font-size: 13px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
        .empty-state i { font-size: 64px; margin-bottom: 16px; opacity: 0.3; display: block; }
        .action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }
        .action-card { background: linear-gradient(135deg, #f3f4f6, #ffffff); padding: 28px; border-radius: 16px; border: 2px solid #e5e7eb; transition: all 0.3s; text-decoration: none; color: inherit; display: block; }
        .action-card:hover { border-color: #f59e0b; transform: translateY(-3px); box-shadow: 0 8px 20px rgba(245,158,11,0.15); }
        .action-card-icon { width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 18px; }
        .action-card-icon.orange { background: #fed7aa; color: #f59e0b; }
        .action-card-icon.blue { background: #dbeafe; color: #3b82f6; }
        .action-card-icon.green { background: #d1fae5; color: #10b981; }
        .action-card h3 { font-size: 18px; color: #1f2937; margin-bottom: 8px; }
        .action-card p { color: #6b7280; font-size: 14px; line-height: 1.5; }
        .success-alert { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 18px 24px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; }
    </style>
</head>
<body>
    <?php include 'vue/moniteur/_sidebar.php'; ?>
    <div class="main-content">
        <div class="header">
            <h1 class="greeting">Bonjour <?= htmlspecialchars($moniteurActuel['prenom']) ?> <span class="wave">👋</span></h1>
            <p class="subtitle">Voici votre activité du jour</p>
        </div>
        <?php if (isset($_GET['success'])): ?>
        <div class="success-alert"><i class="fas fa-check-circle"></i><span>Bienvenue ! Votre compte moniteur a été créé avec succès.</span></div>
        <?php endif; ?>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-users"></i></div><div class="stat-value"><?= $nbEleves ?></div><div class="stat-label">Élèves actifs</div></div>
            <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div><div class="stat-value"><?= $nbLeconsAujourdhui ?></div><div class="stat-label">Leçons aujourd'hui</div></div>
            <div class="stat-card"><div class="stat-icon green"><i class="fas fa-clock"></i></div><div class="stat-value"><?= $heuresMois ?>h</div><div class="stat-label">Heures ce mois</div></div>
            <div class="stat-card"><div class="stat-icon purple"><i class="fas fa-star"></i></div><div class="stat-value"><?= $nbEleves ?></div><div class="stat-label">Élèves assignés</div></div>
        </div>
        <div class="section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-calendar-day"></i> Planning du jour</h2>
                <a href="index.php?page=planning" class="see-all">Voir tout <i class="fas fa-arrow-right"></i></a>
            </div>
            <?php if (!empty($mesLeconsAujourdhui)): ?>
                <?php foreach($mesLeconsAujourdhui as $lecon): ?>
                <div class="lecon-row">
                    <div class="lecon-time"><?= date('H:i', strtotime($lecon['datedebut'])) ?> - <?= date('H:i', strtotime($lecon['datefin'])) ?></div>
                    <div class="lecon-info">
                        <strong><?= htmlspecialchars($lecon['candidat_prenom'] . ' ' . $lecon['candidat_nom']) ?></strong>
                        <span><i class="fas fa-car" style="margin-right:4px"></i><?= htmlspecialchars($lecon['immatriculation']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-calendar-times"></i><p>Aucune leçon prévue aujourd'hui</p></div>
            <?php endif; ?>
        </div>
        <div class="action-grid">
            <a href="index.php?page=planning" class="action-card"><div class="action-card-icon orange"><i class="fas fa-calendar-plus"></i></div><h3>Gérer mon planning</h3><p>Planifier et consulter les leçons de conduite</p></a>
            <a href="index.php?page=mes-eleves" class="action-card"><div class="action-card-icon blue"><i class="fas fa-user-graduate"></i></div><h3>Voir mes élèves</h3><p>Consulter la liste de vos élèves assignés</p></a>
            <a href="index.php?page=evaluations" class="action-card"><div class="action-card-icon green"><i class="fas fa-clipboard-check"></i></div><h3>Évaluations Quiz</h3><p>Voir les statistiques des quiz de vos élèves</p></a>
        </div>
    </div>
</body>
</html>
