<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - MAY-IT</title>
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
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 30px; line-height: 1.6; }
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
        .back-link { color: #6366f1; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .error-box { background: #fee2e2; color: #991b1b; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        /* Boite de lien de réinitialisation (mode test) */
        .reset-box { background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 14px; padding: 28px; margin-bottom: 24px; text-align: left; }
        .reset-box h3 { color: #059669; font-size: 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .reset-box p { color: #374151; font-size: 13px; margin-bottom: 16px; line-height: 1.6; }
        .link-display {
            background: white; border: 1px solid #d1d5db; border-radius: 8px;
            padding: 12px; font-size: 12px; color: #6366f1; word-break: break-all;
            margin-bottom: 14px; font-family: monospace;
        }
        .btn-copy {
            background: #6366f1; color: white; padding: 10px 20px; border: none;
            border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;
        }
        .btn-copy:hover { background: #4f46e5; }
        .btn-copy.copied { background: #10b981; }
        .test-badge { background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-left: 8px; }
    </style>
</head>
<body>
<div class="container">
    <div class="icon-wrapper"><i class="fas fa-key"></i></div>
    <h1>Mot de passe oublié</h1>
    <p class="subtitle">Entrez votre adresse email. Un lien de réinitialisation vous sera généré.</p>

    <?php if (isset($error)): ?>
        <div class="error-box"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['reset_link'])): ?>
        <div class="reset-box">
            <h3><i class="fas fa-check-circle"></i> Lien généré ! <span class="test-badge">Mode test</span></h3>
            <p>En production, ce lien serait envoyé par email à <strong><?= htmlspecialchars($_SESSION['reset_email'] ?? '') ?></strong>. Pour l'instant, vous pouvez le copier et l'ouvrir directement :</p>
            <div class="link-display" id="reset-link-text"><?= htmlspecialchars($_SESSION['reset_link']) ?></div>
            <button class="btn-copy" id="btn-copy" onclick="copyLink()">
                <i class="fas fa-copy"></i> Copier le lien
            </button>
        </div>
        <?php unset($_SESSION['reset_link'], $_SESSION['reset_email']); ?>
    <?php endif; ?>

    <?php if (!isset($success)): ?>
    <form method="POST">
        <div class="form-group">
            <label><i class="fas fa-envelope" style="color:#9ca3af;margin-right:6px;"></i> Adresse email</label>
            <input type="email" name="email" placeholder="votre@email.fr" required autofocus>
        </div>
        <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i> Générer le lien
        </button>
    </form>
    <?php endif; ?>

    <a href="index.php?page=login" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à la connexion
    </a>
</div>

<script>
function copyLink() {
    const text = document.getElementById('reset-link-text').textContent;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('btn-copy');
        btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-copy"></i> Copier le lien';
            btn.classList.remove('copied');
        }, 2500);
    });
}
</script>
</body>
</html>
