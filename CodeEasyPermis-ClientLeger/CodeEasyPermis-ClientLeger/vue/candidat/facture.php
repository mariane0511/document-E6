<?php
$currentPage = 'facture';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Facture - MAY-IT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/candidat/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #6366f1; }
        .facture-container { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .facture-header { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; padding: 40px; }
        .facture-header-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; }
        .company-name { font-size: 28px; font-weight: 700; }
        .company-sub { font-size: 14px; opacity: 0.8; margin-top: 4px; }
        .facture-num { text-align: right; }
        .facture-num h2 { font-size: 20px; font-weight: 700; }
        .facture-num p { font-size: 13px; opacity: 0.8; margin-top: 4px; }
        .facture-body { padding: 40px; }
        .facture-infos { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
        .info-block h3 { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: 0.1em; margin-bottom: 12px; }
        .info-block p { color: #1f2937; font-size: 15px; margin-bottom: 4px; }
        .info-block strong { color: #374151; }
        .table-wrapper { border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        thead th { padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.05em; }
        tbody td { padding: 16px 20px; border-top: 1px solid #e5e7eb; color: #374151; font-size: 15px; }
        .total-section { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .total-box { min-width: 300px; }
        .total-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-size: 15px; color: #6b7280; }
        .total-row:last-child { border-bottom: none; font-size: 18px; font-weight: 700; color: #1f2937; padding-top: 16px; }
        .total-row span:last-child { color: #6366f1; }
        .reduction-badge { background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; margin-left: 8px; }
        .print-btn {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white; padding: 14px 28px; border: none; border-radius: 10px;
            cursor: pointer; font-size: 15px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s;
        }
        .print-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,0.4); }
        .status-payee { background: #d1fae5; color: #065f46; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
        .facture-footer { text-align: center; padding: 20px; background: #f9fafb; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 13px; }

        @media print {
            .sidebar, .print-btn, .page-header { display: none !important; }
            .main-content { padding: 0 !important; }
            body { display: block !important; background: white !important; }
            .facture-container { box-shadow: none !important; border-radius: 0; }
        }
    </style>
</head>
<body>
    <?php include 'vue/candidat/_sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-file-invoice"></i> Ma facture</h1>
        </div>

        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
            <button class="print-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer la facture
            </button>
            <span class="status-payee"><i class="fas fa-check-circle"></i> Inscription confirmée</span>
        </div>

        <div class="facture-container">
            <!-- En-tête facture -->
            <div class="facture-header">
                <div class="facture-header-top">
                    <div>
                        <div class="company-name"><i class="fas fa-car"></i> EasyPermis</div>
                        <div class="company-sub">Auto-école numérique</div>
                    </div>
                    <div class="facture-num">
                        <h2>FACTURE</h2>
                        <p>N° <?= str_pad($candidatActuel['idcandidat'], 6, '0', STR_PAD_LEFT) ?>-<?= date('Y') ?></p>
                        <p>Date : <?= date('d/m/Y') ?></p>
                    </div>
                </div>
            </div>

            <!-- Corps facture -->
            <div class="facture-body">
                <div class="facture-infos">
                    <div class="info-block">
                        <h3>Émis par</h3>
                        <p><strong>MAY-IT Auto-école</strong></p>
                        <p>123 Rue de la République</p>
                        <p>75001 Paris, France</p>
                        <p>contact@may-it.fr</p>
                        <p>SIRET : 000 000 000 00000</p>
                    </div>
                    <div class="info-block">
                        <h3>Facturé à</h3>
                        <p><strong><?= htmlspecialchars($candidatActuel['prenom'] . ' ' . $candidatActuel['nom']) ?></strong></p>
                        <p><?= htmlspecialchars($candidatActuel['email']) ?></p>
                        <?php if (!empty($candidatActuel['datenaissance'])): ?>
                        <p>Né(e) le : <?= date('d/m/Y', strtotime($candidatActuel['datenaissance'])) ?></p>
                        <?php endif; ?>
                        <?php if ($candidatActuel['etudiant']): ?>
                        <p><span class="reduction-badge">🎓 Statut étudiant</span></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tableau des prestations -->
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Détails</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($formule['libelle']) ?></strong><br>
                                    <small style="color:#9ca3af;">Formation à la conduite</small>
                                </td>
                                <td>
                                    <?= $formule['duree'] ?>h de conduite
                                    <?php if ($candidatActuel['etudiant']): ?>
                                        <br><span class="reduction-badge">Réduction étudiant -10%</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($formule['prix'], 2, ',', ' ') ?> €</td>
                                <td>
                                    <?php
                                    $prixFinal = $formule['prix'];
                                    $reduction = 0;
                                    if ($candidatActuel['etudiant']) {
                                        $reduction = $formule['prix'] * 0.10;
                                        $prixFinal = $formule['prix'] - $reduction;
                                    }
                                    ?>
                                    <?= number_format($prixFinal, 2, ',', ' ') ?> €
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="total-section">
                    <div class="total-box">
                        <div class="total-row">
                            <span>Sous-total HT</span>
                            <span><?= number_format($formule['prix'], 2, ',', ' ') ?> €</span>
                        </div>
                        <?php if ($reduction > 0): ?>
                        <div class="total-row" style="color: #059669;">
                            <span>Réduction étudiant (-10%)</span>
                            <span>- <?= number_format($reduction, 2, ',', ' ') ?> €</span>
                        </div>
                        <?php endif; ?>
                        <div class="total-row">
                            <span>TVA (0% - exonéré)</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="total-row">
                            <span>TOTAL TTC</span>
                            <span><?= number_format($prixFinal, 2, ',', ' ') ?> €</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="facture-footer">
                MAY-IT Auto-école — Merci de votre confiance ! — contact@may-it.fr
            </div>
        </div>
    </div>
</body>
</html>
