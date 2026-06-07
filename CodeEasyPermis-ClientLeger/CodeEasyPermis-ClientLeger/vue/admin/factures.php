<?php $currentPage = 'factures-admin'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Factures Candidats - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include 'vue/admin/_sidebar_css.php'; ?>
    <style>
        .page-header { margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 12px; }
        .page-header h1 i { color: #ef4444; }
        .page-header p { color: #6b7280; margin-top: 6px; }

        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 14px; padding: 22px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stat-card .icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px; }
        .stat-card .icon.red    { background: #fee2e2; color: #ef4444; }
        .stat-card .icon.green  { background: #d1fae5; color: #10b981; }
        .stat-card .icon.blue   { background: #dbeafe; color: #3b82f6; }
        .stat-card .icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-card .val { font-size: 28px; font-weight: 700; color: #1f2937; }
        .stat-card .lbl { font-size: 13px; color: #6b7280; margin-top: 4px; }

        .toolbar { background: white; padding: 16px 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
        .search-input { border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; outline: none; width: 260px; }
        .search-input:focus { border-color: #ef4444; }
        .filter-sel { border: 1px solid #e5e7eb; border-radius: 8px; padding: 9px 16px; font-size: 14px; outline: none; background: white; }
        .filter-sel:focus { border-color: #ef4444; }

        .table-section { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .table-header { padding: 22px 28px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
        .table-title { font-size: 18px; font-weight: 600; color: #1f2937; display: flex; align-items: center; gap: 10px; }
        .table-title i { color: #ef4444; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        thead th { padding: 13px 20px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; letter-spacing: 0.05em; }
        tbody td { padding: 15px 20px; border-top: 1px solid #f3f4f6; font-size: 14px; color: #374151; vertical-align: middle; }
        tbody tr:hover { background: #fafafa; }

        .avatar-sm { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: 700; flex-shrink: 0; }
        .candidat-cell { display: flex; align-items: center; gap: 12px; }
        .candidat-name { font-weight: 600; color: #111827; font-size: 14px; }
        .candidat-email { font-size: 12px; color: #9ca3af; }

        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .badge-etudiant { background: #ede9fe; color: #6d28d9; }
        .badge-adulte { background: #dbeafe; color: #1d4ed8; }

        .prix-cell { font-weight: 700; font-size: 16px; }
        .prix-reduit { color: #059669; }
        .prix-normal { color: #1f2937; }
        .reduction-tag { font-size: 11px; background: #d1fae5; color: #065f46; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 6px; }

        .btn-view { background: #fee2e2; color: #b91c1c; padding: 7px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; border: none; cursor: pointer; }
        .btn-view:hover { background: #ef4444; color: white; }

        /* Modal facture */
        .modal-overlay { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.active { display: flex; }
        .modal-facture { background: white; border-radius: 16px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 60px rgba(0,0,0,0.3); }
        .facture-top { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 36px 40px; border-radius: 16px 16px 0 0; }
        .facture-top-row { display: flex; justify-content: space-between; align-items: flex-start; }
        .company-name { font-size: 26px; font-weight: 700; }
        .company-sub { font-size: 13px; opacity: 0.8; margin-top: 4px; }
        .facture-num h3 { font-size: 18px; font-weight: 700; text-align: right; }
        .facture-num p { font-size: 12px; opacity: 0.8; text-align: right; }
        .facture-body { padding: 36px 40px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px; }
        .info-block h4 { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: 0.1em; margin-bottom: 10px; }
        .info-block p { color: #1f2937; font-size: 14px; margin-bottom: 3px; }
        .fact-table { width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; border: 1px solid #e5e7eb; margin-bottom: 24px; }
        .fact-table thead { background: #f9fafb; }
        .fact-table th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #6b7280; }
        .fact-table td { padding: 14px 16px; border-top: 1px solid #e5e7eb; font-size: 14px; color: #374151; }
        .total-block { display: flex; justify-content: flex-end; }
        .total-box { min-width: 280px; }
        .total-line { display: flex; justify-content: space-between; padding: 9px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; color: #6b7280; }
        .total-line:last-child { border: none; font-size: 17px; font-weight: 700; color: #1f2937; padding-top: 14px; }
        .total-line:last-child span:last-child { color: #ef4444; }
        .modal-footer { padding: 20px 40px; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 12px; }
        .btn-close { background: #e5e7eb; color: #374151; padding: 10px 22px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-close:hover { background: #d1d5db; }
        .btn-print { background: #ef4444; color: white; padding: 10px 22px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
        .btn-print:hover { background: #dc2626; }
    </style>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-file-invoice-dollar"></i> Factures Candidats</h1>
            <p>Consultez et gérez les factures de tous les candidats</p>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="icon red"><i class="fas fa-users"></i></div>
                <div class="val"><?= $totalCandidats ?></div>
                <div class="lbl">Candidats inscrits</div>
            </div>
            <div class="stat-card">
                <div class="icon green"><i class="fas fa-euro-sign"></i></div>
                <div class="val"><?= number_format($revenusTotal, 0, ',', ' ') ?> €</div>
                <div class="lbl">Revenus totaux</div>
            </div>
            <div class="stat-card">
                <div class="icon blue"><i class="fas fa-percentage"></i></div>
                <div class="val"><?= $nbEtudiants ?></div>
                <div class="lbl">Réductions étudiants</div>
            </div>
            <div class="stat-card">
                <div class="icon orange"><i class="fas fa-tags"></i></div>
                <div class="val"><?= number_format($revenusApreReduc, 0, ',', ' ') ?> €</div>
                <div class="lbl">Après réductions</div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <i class="fas fa-search" style="color:#9ca3af"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher un candidat...">
            <select class="filter-sel" id="formuleFilter" onchange="filterTable()">
                <option value="">Toutes les formules</option>
                <?php foreach($formules as $f): ?>
                <option value="<?= $f['idformule'] ?>"><?= htmlspecialchars($f['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tableau -->
        <div class="table-section">
            <div class="table-header">
                <h2 class="table-title"><i class="fas fa-list"></i> Liste des factures</h2>
                <span style="color:#9ca3af;font-size:13px"><?= count($candidats) ?> candidat<?= count($candidats) > 1 ? 's' : '' ?></span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Candidat</th>
                        <th>Formule</th>
                        <th>Prix HT</th>
                        <th>Réduction</th>
                        <th>Total TTC</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach($candidats as $c):
                        $prixHT = $c['prix'];
                        $reduc = $c['etudiant'] ? 0.1 : 0;
                        $montantReduc = $prixHT * $reduc;
                        $tva = ($prixHT - $montantReduc) * 0.20;
                        $total = $prixHT - $montantReduc + $tva;
                    ?>
                    <tr data-name="<?= strtolower($c['prenom'].' '.$c['nom']) ?>" data-formule="<?= $c['idformule'] ?>">
                        <td>
                            <div class="candidat-cell">
                                <div class="avatar-sm"><?= strtoupper(substr($c['prenom'],0,1).substr($c['nom'],0,1)) ?></div>
                                <div>
                                    <div class="candidat-name"><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?></div>
                                    <div class="candidat-email"><?= htmlspecialchars($c['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span><?= htmlspecialchars($c['formule_libelle']) ?></span><br>
                            <?php if($c['etudiant']): ?>
                            <span class="badge badge-etudiant">Étudiant</span>
                            <?php else: ?>
                            <span class="badge badge-adulte">Adulte</span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($prixHT, 2, ',', ' ') ?> €</td>
                        <td>
                            <?php if($c['etudiant']): ?>
                            <span style="color:#059669;font-weight:600">-<?= number_format($montantReduc,2,',', ' ') ?> € <span class="reduction-tag">-10%</span></span>
                            <?php else: ?>
                            <span style="color:#9ca3af">Aucune</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="prix-cell <?= $c['etudiant'] ? 'prix-reduit' : 'prix-normal' ?>">
                                <?= number_format($total, 2, ',', ' ') ?> €
                            </span>
                        </td>
                        <td>
                            <button class="btn-view" onclick='showFacture(<?= json_encode([
                                "id" => $c["idcandidat"],
                                "prenom" => $c["prenom"],
                                "nom" => $c["nom"],
                                "email" => $c["email"],
                                "formule" => $c["formule_libelle"],
                                "duree" => $c["duree"],
                                "prixHT" => $prixHT,
                                "reduc" => $montantReduc,
                                "etudiant" => (bool)$c["etudiant"],
                                "tva" => $tva,
                                "total" => $total
                            ]) ?>)'>
                                <i class="fas fa-eye"></i> Voir
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Facture -->
    <div class="modal-overlay" id="factureModal">
        <div class="modal-facture">
            <div class="facture-top">
                <div class="facture-top-row">
                    <div>
                        <div class="company-name">🚗 MAY-IT</div>
                        <div class="company-sub">Auto-École Certifiée</div>
                    </div>
                    <div class="facture-num">
                        <h3 id="mFactureNum">FACTURE #000</h3>
                        <p id="mFactureDate"></p>
                    </div>
                </div>
            </div>
            <div class="facture-body">
                <div class="info-grid">
                    <div class="info-block">
                        <h4>Émetteur</h4>
                        <p><strong>MAY-IT Auto-École</strong></p>
                        <p>123 Avenue de la Conduite</p>
                        <p>75001 Paris</p>
                        <p>contact@may-it.fr</p>
                    </div>
                    <div class="info-block">
                        <h4>Client</h4>
                        <p id="mClientName"></p>
                        <p id="mClientEmail"></p>
                    </div>
                </div>

                <table class="fact-table">
                    <thead>
                        <tr><th>Désignation</th><th>Durée</th><th>Prix HT</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="mFormule">-</td>
                            <td id="mDuree">-</td>
                            <td id="mPrixHT">-</td>
                        </tr>
                    </tbody>
                </table>

                <div class="total-block">
                    <div class="total-box">
                        <div class="total-line"><span>Sous-total HT</span><span id="mSousTotal">-</span></div>
                        <div class="total-line" id="mReducLine"><span>Réduction étudiant (10%)</span><span id="mReduc">-</span></div>
                        <div class="total-line"><span>TVA (20%)</span><span id="mTVA">-</span></div>
                        <div class="total-line"><span>Total TTC</span><span id="mTotal">-</span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-close" onclick="closeModal()">Fermer</button>
                <button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Imprimer</button>
            </div>
        </div>
    </div>

    <script>
    function fmt(n) {
        return n.toFixed(2).replace('.', ',') + ' €';
    }
    function showFacture(data) {
        document.getElementById('mFactureNum').textContent = 'FACTURE #' + String(data.id).padStart(4,'0');
        document.getElementById('mFactureDate').textContent = new Date().toLocaleDateString('fr-FR', {day:'2-digit', month:'long', year:'numeric'});
        document.getElementById('mClientName').textContent = data.prenom + ' ' + data.nom;
        document.getElementById('mClientEmail').textContent = data.email;
        document.getElementById('mFormule').textContent = 'Formation ' + data.formule;
        document.getElementById('mDuree').textContent = data.duree + ' heures';
        document.getElementById('mPrixHT').textContent = fmt(data.prixHT);
        document.getElementById('mSousTotal').textContent = fmt(data.prixHT);
        const reducLine = document.getElementById('mReducLine');
        if(data.etudiant) {
            reducLine.style.display = '';
            document.getElementById('mReduc').textContent = '- ' + fmt(data.reduc);
        } else {
            reducLine.style.display = 'none';
        }
        document.getElementById('mTVA').textContent = fmt(data.tva);
        document.getElementById('mTotal').textContent = fmt(data.total);
        document.getElementById('factureModal').classList.add('active');
    }
    function closeModal() {
        document.getElementById('factureModal').classList.remove('active');
    }
    document.getElementById('factureModal').addEventListener('click', function(e) {
        if(e.target === this) closeModal();
    });

    // Recherche + filtre
    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const formule = document.getElementById('formuleFilter').value;
        document.querySelectorAll('#tableBody tr').forEach(row => {
            const nameMatch = !search || row.dataset.name.includes(search);
            const formuleMatch = !formule || row.dataset.formule === formule;
            row.style.display = (nameMatch && formuleMatch) ? '' : 'none';
        });
    }
    document.getElementById('searchInput').addEventListener('input', filterTable);
    </script>
</body>
</html>
