<?php
$currentPage = 'profil-candidat';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/candidat/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #6366f1; }
        .card { background: white; padding: 32px; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .profile-info { background: #f9fafb; padding: 24px; border-radius: 12px; margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 12px; align-items: center; }
        .info-label { font-weight: 600; width: 200px; color: #6b7280; font-size: 14px; }
        .info-value { color: #1f2937; font-size: 15px; }
        .formule-badge { background: #ede9fe; color: #6d28d9; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .lock-icon { color: #9ca3af; font-size: 14px; margin-left: 8px; }
        .btn { padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: #6366f1; color: white; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; font-size: 14px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; }
        .form-group input:focus { outline: none; border-color: #6366f1; }
        .form-group input:disabled { background: #f9fafb; color: #6b7280; cursor: not-allowed; }
        .locked-info { background: #fef9c3; border: 1px solid #fde68a; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: #92400e; font-size: 14px; }
        .password-requirements { background: #f0f9ff; border: 1px solid #bae6fd; padding: 16px; border-radius: 10px; margin-top: 8px; font-size: 13px; color: #0c4a6e; }
        .password-requirements ul { margin-left: 20px; margin-top: 6px; }
        .password-requirements li { margin-bottom: 4px; }
        .req { display: flex; align-items: center; gap: 6px; margin-bottom: 4px; font-size: 13px; }
        .req i { font-size: 12px; width: 16px; }
        .req.ok { color: #059669; }
        .req.ko { color: #9ca3af; }
        .strength-bar { height: 6px; border-radius: 4px; background: #e5e7eb; margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; transition: all 0.3s; }
        .strength-text { font-size: 12px; margin-top: 4px; font-weight: 600; }
        #edit-mode { display: none; }
    </style>
</head>
<body>
    <?php include 'vue/candidat/_sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-circle"></i> Mon Profil</h1>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> Profil mis à jour avec succès !</div>
        <?php endif; ?>

        <!-- Mode Lecture -->
        <div id="view-mode">
            <div class="card">
                <div class="profile-info">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Nom :</span>
                        <span class="info-value"><?= htmlspecialchars($candidatActuel['nom']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Prénom :</span>
                        <span class="info-value"><?= htmlspecialchars($candidatActuel['prenom']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-envelope" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Email :</span>
                        <span class="info-value"><?= htmlspecialchars($candidatActuel['email']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-birthday-cake" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Date de naissance :</span>
                        <span class="info-value"><?= $candidatActuel['datenaissance'] ?? 'Non renseignée' ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-graduation-cap" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Statut :</span>
                        <span class="info-value"><?= $candidatActuel['etudiant'] ? '🎓 Étudiant' : 'Non étudiant' ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-tag" style="width:16px;color:#9ca3af;margin-right:8px;"></i> Formule :</span>
                        <span class="info-value">
                            <span class="formule-badge"><?= htmlspecialchars($formule['libelle']) ?></span>
                            &nbsp;<?= $formule['prix'] ?>€
                            <i class="fas fa-lock lock-icon" title="La formule ne peut pas être changée après inscription"></i>
                        </span>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="toggleEditMode()">
                    <i class="fas fa-edit"></i> Modifier mon profil
                </button>
            </div>
        </div>

        <!-- Mode Édition -->
        <div id="edit-mode">
            <div class="card">
                <div class="locked-info">
                    <i class="fas fa-lock"></i>
                    <span>Votre <strong>formule d'inscription</strong> ne peut pas être modifiée après inscription. Pour tout changement, contactez l'auto-école.</span>
                </div>

                <form method="POST" action="index.php?page=update-candidat" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="nom" value="<?= htmlspecialchars($candidatActuel['nom']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom :</label>
                        <input type="text" name="prenom" value="<?= htmlspecialchars($candidatActuel['prenom']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($candidatActuel['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Date de naissance :</label>
                        <input type="date" name="datenaissance" value="<?= $candidatActuel['datenaissance'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Formule (non modifiable) :</label>
                        <input type="text" value="<?= htmlspecialchars($formule['libelle']) ?> — <?= $formule['prix'] ?>€" disabled>
                        <input type="hidden" name="idformule" value="<?= $candidatActuel['idformule'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Nouveau mot de passe <small style="font-weight:400;color:#9ca3af;">(laisser vide pour ne pas changer)</small></label>
                        <input type="password" name="mdp" id="mdp" placeholder="Nouveau mot de passe" oninput="checkPassword(this.value)">
                        <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                        <div class="strength-text" id="strength-text"></div>
                        <div style="margin-top: 12px;">
                            <div class="req ko" id="req-length"><i class="fas fa-circle"></i> Au moins 12 caractères</div>
                            <div class="req ko" id="req-upper"><i class="fas fa-circle"></i> Au moins 1 majuscule</div>
                            <div class="req ko" id="req-lower"><i class="fas fa-circle"></i> Au moins 1 minuscule</div>
                            <div class="req ko" id="req-digit"><i class="fas fa-circle"></i> Au moins 1 chiffre</div>
                            <div class="req ko" id="req-special"><i class="fas fa-circle"></i> Au moins 1 caractère spécial (!@#$%^&*...)</div>
                        </div>
                    </div>

                    <div style="display:flex;gap:12px;margin-top:10px;">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function toggleEditMode() {
        const v = document.getElementById('view-mode');
        const e = document.getElementById('edit-mode');
        if (v.style.display === 'none') { v.style.display = ''; e.style.display = 'none'; }
        else { v.style.display = 'none'; e.style.display = 'block'; }
    }

    function checkPassword(pwd) {
        if (!pwd) {
            document.getElementById('strength-fill').style.width = '0';
            document.getElementById('strength-text').textContent = '';
            ['req-length','req-upper','req-lower','req-digit','req-special'].forEach(id => {
                document.getElementById(id).className = 'req ko';
                document.getElementById(id).querySelector('i').className = 'fas fa-circle';
            });
            return;
        }
        const checks = {
            'req-length': pwd.length >= 12,
            'req-upper': /[A-Z]/.test(pwd),
            'req-lower': /[a-z]/.test(pwd),
            'req-digit': /[0-9]/.test(pwd),
            'req-special': /[^A-Za-z0-9]/.test(pwd)
        };
        let score = Object.values(checks).filter(Boolean).length;
        Object.entries(checks).forEach(([id, ok]) => {
            const el = document.getElementById(id);
            el.className = 'req ' + (ok ? 'ok' : 'ko');
            el.querySelector('i').className = ok ? 'fas fa-check-circle' : 'fas fa-circle';
        });
        const colors = ['#ef4444','#f59e0b','#f59e0b','#10b981','#10b981'];
        const labels = ['','Très faible','Faible','Moyen','Fort','Très fort'];
        const fill = document.getElementById('strength-fill');
        const text = document.getElementById('strength-text');
        fill.style.width = (score * 20) + '%';
        fill.style.background = colors[score-1] || '#e5e7eb';
        text.textContent = labels[score] || '';
        text.style.color = colors[score-1] || '#9ca3af';
    }

    function validateForm() {
        const mdp = document.getElementById('mdp').value;
        if (!mdp) return true; // Pas de changement de mdp
        const ok = mdp.length >= 12 && /[A-Z]/.test(mdp) && /[a-z]/.test(mdp) && /[0-9]/.test(mdp) && /[^A-Za-z0-9]/.test(mdp);
        if (!ok) {
            alert('Le mot de passe ne respecte pas les exigences de sécurité CNIL. Veuillez vérifier les critères affichés.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
