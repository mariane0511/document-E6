<?php $currentPage = 'profil-moniteur'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Moniteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/moniteur/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #f59e0b; }
        .profile-card { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; max-width: 700px; }
        .profile-banner { background: linear-gradient(135deg, #f59e0b, #d97706); height: 120px; }
        .profile-body { padding: 0 36px 36px; }
        .avatar-wrap { margin-top: -50px; margin-bottom: 20px; }
        .avatar-lg { width: 90px; height: 90px; border-radius: 50%; background: white; border: 4px solid white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: #f59e0b; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .profile-name { font-size: 22px; font-weight: 700; color: #1f2937; margin-bottom: 4px; }
        .profile-role { color: #9ca3af; font-size: 14px; display: flex; align-items: center; gap: 6px; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }
        .info-item label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: 0.08em; display: block; margin-bottom: 6px; }
        .info-item p { font-size: 15px; color: #1f2937; font-weight: 500; }
        .success-msg { background: #d1fae5; color: #065f46; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; }
        .btn-edit { background: #f59e0b; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-edit:hover { background: #d97706; }
        /* Form */
        #edit-mode { display: none; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 600; color: #374151; }
        .form-group input { border: 1px solid #e5e7eb; border-radius: 8px; padding: 11px 14px; font-size: 14px; outline: none; transition: border 0.2s; }
        .form-group input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }
        .form-full { grid-column: 1 / -1; }
        .btn-save { background: #f59e0b; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-save:hover { background: #d97706; }
        .btn-cancel { background: #e5e7eb; color: #374151; padding: 12px 22px; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; margin-left: 10px; }
        .btn-cancel:hover { background: #d1d5db; }
    </style>
</head>
<body>
    <?php include 'vue/moniteur/_sidebar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-circle"></i> Mon Profil</h1>
        </div>

        <div class="profile-card">
            <div class="profile-banner"></div>
            <div class="profile-body">
                <div class="avatar-wrap">
                    <div class="avatar-lg"><?= strtoupper(substr($moniteurActuel['prenom'],0,1).substr($moniteurActuel['nom'],0,1)) ?></div>
                </div>
                <div class="profile-name"><?= htmlspecialchars($moniteurActuel['prenom'].' '.$moniteurActuel['nom']) ?></div>
                <div class="profile-role"><i class="fas fa-chalkboard-teacher"></i> Moniteur de conduite</div>
                <hr class="divider">

                <?php if (isset($_GET['success'])): ?>
                <div class="success-msg"><i class="fas fa-check-circle"></i> Profil mis à jour avec succès !</div>
                <?php endif; ?>

                <!-- Vue -->
                <div id="view-mode">
                    <div class="info-grid">
                        <div class="info-item"><label>Nom</label><p><?= htmlspecialchars($moniteurActuel['nom']) ?></p></div>
                        <div class="info-item"><label>Prénom</label><p><?= htmlspecialchars($moniteurActuel['prenom']) ?></p></div>
                        <div class="info-item"><label>Email</label><p><?= htmlspecialchars($moniteurActuel['email']) ?></p></div>
                        <div class="info-item"><label>Téléphone</label><p><?= $moniteurActuel['telephone'] ?? 'Non renseigné' ?></p></div>
                        <div class="info-item"><label>Type de permis</label><p><?= htmlspecialchars($moniteurActuel['type_permis'] ?? 'N/A') ?></p></div>
                        <div class="info-item"><label>Date d'embauche</label><p><?= $moniteurActuel['date_embauche'] ? date('d/m/Y', strtotime($moniteurActuel['date_embauche'])) : 'N/A' ?></p></div>
                    </div>
                    <button class="btn-edit" onclick="toggleEdit()"><i class="fas fa-edit"></i> Modifier mon profil</button>
                </div>

                <!-- Édition -->
                <div id="edit-mode">
                    <form method="POST" action="index.php?page=update-moniteur">
                        <div class="form-grid">
                            <div class="form-group"><label>Nom</label><input type="text" name="nom" value="<?= htmlspecialchars($moniteurActuel['nom']) ?>" required></div>
                            <div class="form-group"><label>Prénom</label><input type="text" name="prenom" value="<?= htmlspecialchars($moniteurActuel['prenom']) ?>" required></div>
                            <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($moniteurActuel['email']) ?>" required></div>
                            <div class="form-group"><label>Téléphone</label><input type="tel" name="telephone" value="<?= htmlspecialchars($moniteurActuel['telephone'] ?? '') ?>"></div>
                            <div class="form-group form-full"><label>Nouveau mot de passe <span style="color:#9ca3af;font-weight:400">(laisser vide pour conserver)</span></label><input type="password" name="mdp" placeholder="Nouveau mot de passe"></div>
                        </div>
                        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Enregistrer</button>
                        <button type="button" class="btn-cancel" onclick="toggleEdit()">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    function toggleEdit() {
        const v = document.getElementById('view-mode');
        const e = document.getElementById('edit-mode');
        v.style.display = v.style.display === 'none' ? '' : 'none';
        e.style.display = e.style.display === 'none' ? '' : 'none';
    }
    </script>
</body>
</html>
