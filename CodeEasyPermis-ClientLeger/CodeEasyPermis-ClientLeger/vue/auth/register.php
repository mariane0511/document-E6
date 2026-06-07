<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }
        .container {
            background: white; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 540px; width: 100%; padding: 40px;
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo i { font-size: 40px; color: #6366f1; }
        .logo h1 { font-size: 24px; font-weight: 700; color: #1f2937; margin-top: 10px; }
        .logo p { color: #6b7280; font-size: 14px; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 6px; }
        .form-group input, .form-group select {
            width: 100%; padding: 12px 14px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #6366f1; }
        .req { display: flex; align-items: center; gap: 6px; margin-bottom: 4px; font-size: 12px; }
        .req i { font-size: 11px; width: 14px; }
        .req.ok { color: #059669; }
        .req.ko { color: #9ca3af; }
        .strength-bar { height: 5px; border-radius: 4px; background: #e5e7eb; margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; transition: all 0.3s; }
        .strength-text { font-size: 11px; margin-top: 3px; font-weight: 600; }
        .btn-submit {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white; border: none; border-radius: 10px; font-size: 16px;
            font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); }
        .prix-info { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 8px; font-size: 14px; color: #065f46; margin-top: 8px; display: none; }
        .link { text-align: center; margin-top: 20px; }
        .link a { color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500; }
        /* Modal popup */
        .modal-overlay {
            display: none; position: fixed; top:0; left:0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.5);
            z-index: 1000; align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white; border-radius: 16px; padding: 40px;
            max-width: 420px; width: 90%; text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .modal-icon { font-size: 56px; margin-bottom: 16px; }
        .modal h2 { color: #1f2937; margin-bottom: 10px; font-size: 20px; }
        .modal p { color: #6b7280; font-size: 14px; margin-bottom: 24px; line-height: 1.6; }
        .modal-btn {
            padding: 11px 24px; border: none; border-radius: 8px;
            cursor: pointer; font-size: 14px; font-weight: 600;
        }
        .modal-btn-primary { background: #6366f1; color: white; }
        .error-alert { background: #fee2e2; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 14px; }
        #candidat-fields { display: none; }
    </style>
</head>
<body>

<!-- Modal email déjà utilisé -->
<div class="modal-overlay" id="modal-email">
    <div class="modal">
        <div class="modal-icon">✉️</div>
        <h2>Adresse email déjà utilisée</h2>
        <p>Cette adresse email est déjà associée à un compte. Veuillez utiliser une autre adresse email ou connectez-vous.</p>
        <button class="modal-btn modal-btn-primary" onclick="fermerModalEmail()">
            <i class="fas fa-edit"></i> Changer d'email
        </button>
    </div>
</div>

<div class="container">
    <div class="logo">
        <i class="fas fa-car"></i>
        <h1>EasyPermis</h1>
        <p>Créer votre compte</p>
    </div>

    <?php if (isset($erreur)): ?>
        <div class="error-alert"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST" id="registerForm" onsubmit="return validateRegister()">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" placeholder="Votre prénom" required>
        </div>
        <div class="form-group">
            <label>Adresse email</label>
            <input type="email" name="email" id="email" placeholder="votre@email.fr" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="mdp" id="mdp" placeholder="Créer un mot de passe sécurisé" required oninput="checkPassword(this.value)">
            <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
            <div class="strength-text" id="strength-text"></div>
            <div style="margin-top:8px;">
                <div class="req ko" id="req-length"><i class="fas fa-circle"></i> Au moins 12 caractères</div>
                <div class="req ko" id="req-upper"><i class="fas fa-circle"></i> Au moins 1 majuscule</div>
                <div class="req ko" id="req-lower"><i class="fas fa-circle"></i> Au moins 1 minuscule</div>
                <div class="req ko" id="req-digit"><i class="fas fa-circle"></i> Au moins 1 chiffre</div>
                <div class="req ko" id="req-special"><i class="fas fa-circle"></i> Au moins 1 caractère spécial (!@#$...)</div>
            </div>
        </div>
        <div class="form-group">
            <label>Je m'inscris comme :</label>
            <select name="role" id="role" required>
                <option value="">-- Choisir un rôle --</option>
                <option value="candidat">Candidat</option>
            </select>
        </div>

        <div id="candidat-fields">
            <div class="form-group">
                <label>
                    <input type="checkbox" name="etudiant" value="1" id="etudiant-checkbox">
                    Je suis étudiant(e) — réduction de 10%
                </label>
            </div>
            <div class="form-group">
                <label>Formule de conduite :</label>
                <select name="idformule" id="idformule">
                    <option value="">-- Choisir une formule --</option>
                    <?php
                    if (isset($pdo)) {
                        $formules = $pdo->query("SELECT * FROM formule")->fetchAll();
                        foreach ($formules as $f) {
                            echo "<option value='{$f['idformule']}' data-prix='{$f['prix']}' data-duree='{$f['duree']}'>";
                            echo "{$f['libelle']} — {$f['prix']}€ ({$f['duree']}h)";
                            echo "</option>";
                        }
                    }
                    ?>
                </select>
                <div class="prix-info" id="prix-info"></div>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-user-plus"></i> Créer mon compte
        </button>
    </form>

    <div class="link">
        <a href="index.php?page=login">Déjà un compte ? Se connecter</a>
    </div>
</div>

<script>
const roleSelect = document.getElementById('role');
const candidatFields = document.getElementById('candidat-fields');
const formuleSelect = document.getElementById('idformule');
const etudiantCheckbox = document.getElementById('etudiant-checkbox');
const prixInfo = document.getElementById('prix-info');

roleSelect.addEventListener('change', function() {
    if (this.value === 'candidat') {
        candidatFields.style.display = 'block';
        formuleSelect.required = true;
    } else {
        candidatFields.style.display = 'none';
        formuleSelect.required = false;
        prixInfo.style.display = 'none';
    }
});

function updatePrice() {
    const opt = formuleSelect.options[formuleSelect.selectedIndex];
    if (!opt.value) { prixInfo.style.display = 'none'; return; }
    let prix = parseFloat(opt.dataset.prix);
    let duree = opt.dataset.duree;
    let html = '';
    if (etudiantCheckbox.checked) {
        const reduc = prix * 0.10;
        prix = prix - reduc;
        html = `✅ Prix étudiant : <strong>${prix.toFixed(2)}€</strong> <small>(réduction de ${reduc.toFixed(2)}€)</small> — ${duree}h de conduite`;
    } else {
        html = `✅ Prix : <strong>${prix.toFixed(2)}€</strong> — ${duree}h de conduite`;
    }
    prixInfo.innerHTML = html;
    prixInfo.style.display = 'block';
}
formuleSelect.addEventListener('change', updatePrice);
etudiantCheckbox.addEventListener('change', updatePrice);

function checkPassword(pwd) {
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

function validateRegister() {
    const mdp = document.getElementById('mdp').value;
    const ok = mdp.length >= 12 && /[A-Z]/.test(mdp) && /[a-z]/.test(mdp) && /[0-9]/.test(mdp) && /[^A-Za-z0-9]/.test(mdp);
    if (!ok) {
        alert('Le mot de passe ne respecte pas les exigences de sécurité (CNIL). Veuillez respecter tous les critères affichés.');
        return false;
    }
    return true;
}

function fermerModalEmail() {
    document.getElementById('modal-email').classList.remove('active');
    document.getElementById('email').focus();
    document.getElementById('email').select();
}

<?php if (isset($erreur) && strpos($erreur, 'email') !== false): ?>
document.getElementById('modal-email').classList.add('active');
<?php endif; ?>
</script>
</body>
</html>
