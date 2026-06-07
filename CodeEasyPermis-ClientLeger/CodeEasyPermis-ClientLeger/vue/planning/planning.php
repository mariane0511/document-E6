<?php $currentPage = 'planning'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des leçons</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if (isset($_SESSION['moniteur'])): ?>
        <?php include 'vue/moniteur/_sidebar_css.php'; ?>
    <?php else: ?>
        <?php include 'vue/admin/_sidebar_css.php'; ?>
    <?php endif; ?>
    <style>
        .header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 i { color: #6366f1; }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary { background: #6366f1; color: white; }
        .btn-primary:hover { background: #4f46e5; }

        .calendar-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .calendar-nav { display: flex; gap: 15px; align-items: center; }

        .calendar-nav button {
            padding: 10px 15px;
            background: #f3f4f6;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: #6b7280;
            font-size: 14px;
        }

        .calendar-nav button:hover { background: #e5e7eb; }

        .month-title { font-size: 20px; font-weight: 600; color: #1f2937; }

        .lecons-list { display: grid; gap: 15px; }

        .lecon-card {
            background: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #6366f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }

        .lecon-card:hover { background: #f3f4f6; transform: translateX(5px); }

        .lecon-info { flex: 1; }

        .lecon-time {
            font-size: 14px;
            color: #6366f1;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .lecon-details { display: flex; gap: 20px; flex-wrap: wrap; }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 14px;
        }

        .detail-item i { color: #9ca3af; }

        .lecon-actions { display: flex; gap: 10px; }

        .btn-icon {
            padding: 8px 12px;
            background: #fee2e2;
            color: #ef4444;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-icon:hover { background: #fecaca; }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #9ca3af;
        }

        .empty-state i { font-size: 64px; margin-bottom: 16px; opacity: 0.3; }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group { flex: 1; min-width: 200px; }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['moniteur'])): ?>
        <?php include 'vue/moniteur/_sidebar.php'; ?>
    <?php else: ?>
        <?php include 'vue/admin/_sidebar.php'; ?>
    <?php endif; ?>

    <div class="main-content">
        <div class="header">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                <?= isset($_SESSION['moniteur']) ? 'Mon Planning' : 'Planning des leçons' ?>
            </h1>
            <?php if (isset($_SESSION['admin'])): ?>
            <a href="index.php?page=ajouter-lecon" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle leçon
            </a>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['admin'])): ?>
        <!-- Filtres (admin uniquement) -->
        <div class="filters">
            <div class="filter-group">
                <label>Date</label>
                <input type="date" id="filter-date" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>Moniteur</label>
                <select id="filter-moniteur">
                    <option value="">Tous les moniteurs</option>
                    <?php
                    $moniteursList = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();
                    foreach ($moniteursList as $m) {
                        echo "<option value='{$m['idmoniteur']}'>{$m['prenom']} {$m['nom']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Candidat</label>
                <select id="filter-candidat">
                    <option value="">Tous les candidats</option>
                    <?php
                    $candidatsList = $this->pdo->query("SELECT * FROM candidat")->fetchAll();
                    foreach ($candidatsList as $c) {
                        echo "<option value='{$c['idcandidat']}'>{$c['prenom']} {$c['nom']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php endif; ?>

        <!-- Liste des leçons -->
        <div class="calendar-section">
            <div class="calendar-header">
                <h2 class="month-title">Leçons planifiées</h2>
                <div class="calendar-nav">
                    <button><i class="fas fa-chevron-left"></i> Précédent</button>
                    <button>Aujourd'hui</button>
                    <button>Suivant <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <div class="lecons-list">
                <?php if (empty($lecons)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>Aucune leçon planifiée</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($lecons as $lecon): ?>
                        <div class="lecon-card">
                            <div class="lecon-info">
                                <div class="lecon-time">
                                    <i class="fas fa-clock"></i>
                                    <?= date('d/m/Y H:i', strtotime($lecon['datedebut'])) ?> 
                                    - 
                                    <?= date('H:i', strtotime($lecon['datefin'])) ?>
                                </div>
                                <div class="lecon-details">
                                    <div class="detail-item">
                                        <i class="fas fa-user"></i>
                                        <strong>Candidat:</strong> <?= htmlspecialchars($lecon['candidat_prenom'] . ' ' . $lecon['candidat_nom']) ?>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <strong>Moniteur:</strong> <?= htmlspecialchars($lecon['moniteur_prenom'] . ' ' . $lecon['moniteur_nom']) ?>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-car"></i>
                                        <strong>Véhicule:</strong> <?= htmlspecialchars($lecon['marque'] . ' ' . $lecon['nommodele']) ?> (<?= $lecon['immatriculation'] ?>)
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['admin'])): ?>
                            <div class="lecon-actions">
                                <a href="index.php?page=modifier-lecon&id=<?= $lecon['idlecon'] ?>"
                                   class="btn-icon" style="background:#dbeafe;color:#1d4ed8;margin-right:6px" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?page=supprimer-lecon&id=<?= $lecon['idlecon'] ?>"
                                   class="btn-icon"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette leçon ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('filter-date').addEventListener('change', function() {
            const date = this.value;
            window.location.href = `index.php?page=planning&date=${date}`;
        });
    </script>
</body>
</html>