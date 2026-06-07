<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .container {
            background: white; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 480px; width: 100%; padding: 50px 40px; text-align: center;
        }
        .icon-wrapper {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
        }
        .icon-wrapper i { font-size: 36px; color: white; }
        h1 { font-size: 26px; font-weight: 700; color: #1f2937; margin-bottom: 8px; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px; }
        .form-group input {
            width: 100%; padding: 14px; border: 1px solid #d1d5db;
            border-radius: 10px; font-size: 14px; transition: border-color 0.3s;
        }
        .form-group input:focus { outline: none; border-color: #6366f1; }
        .btn-submit {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white; border: none; border-radius: 10px; font-size: 16px;
            font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 16px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); }
        .error-box { background: #fee2e2; color: #991b1b; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; text-align: left; }
        .success-box { background: #d1fae5; color: #065f46; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .back-link { color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .req { display: flex; align-items: center; gap: 6px; margin-bottom: 4px; font-size: 12px; }
        .req i { font-size: 11px; width: 14px; }
        .req.ok { color: #059669; }
        .req.ko { color: #9ca3af; }
        .strength-bar { height: 5px; border-radius: 4px; background: #e5e7eb; margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; transition: all 0.3s; }
        .strength-text { font-size: 11px; margin-top: 3px; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">
    <div class="icon-wrapper"><i class="fas fa-lock"></i></div>
    <h1>Nouveau mot de passe</h1>
    <p class="subtitle">Choisissez un mot de passe sécurisé conforme aux exigences CNIL.</p>

    <?php if (isset($error)): ?>
        <div class="error-box"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="success-box"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!isset($success)): ?>
    <form method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
        <div class="form-group">
            <label><i class="fas fa-lock" style="color:#9ca3af;margin-right:6px;"></i> Nouveau mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Nouveau mot de passe" required oninput="checkPassword(this.value)">
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
            <label><i class="fas fa-lock" style="color:#9ca3af;margin-right:6px;"></i> Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer le mot de passe" required>
        </div>
        <button type="submit" class="btn-submit">
            <i class="fas fa-check"></i> Réinitialiser le mot de passe
        </button>
    </form>
    <?php endif; ?>

    <a href="index.php?page=login" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à la connexion
    </a>
</div>

<script>
function checkPassword(pwd) {
    const checks = {
        'req-length':  pwd.length >= 12,
        'req-upper':   /[A-Z]/.test(pwd),
        'req-lower':   /[a-z]/.test(pwd),
        'req-digit':   /[0-9]/.test(pwd),
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
    document.getElementById('strength-fill').style.width = (score * 20) + '%';
    document.getElementById('strength-fill').style.background = colors[score-1] || '#e5e7eb';
    document.getElementById('strength-text').textContent = labels[score] || '';
    document.getElementById('strength-text').style.color = colors[score-1] || '#9ca3af';
}

function validateForm() {
    const pwd = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    const ok = pwd.length >= 12 && /[A-Z]/.test(pwd) && /[a-z]/.test(pwd) && /[0-9]/.test(pwd) && /[^A-Za-z0-9]/.test(pwd);
    if (!ok) { alert('Le mot de passe ne respecte pas les exigences CNIL.'); return false; }
    if (pwd !== confirm) { alert('Les mots de passe ne correspondent pas.'); return false; }
    return true;
}
</script>
</body>
</html>
