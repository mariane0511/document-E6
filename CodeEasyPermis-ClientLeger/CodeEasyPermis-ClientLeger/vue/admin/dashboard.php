<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administrateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .logo i {
            font-size: 32px;
            color: #ef4444;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .logo-subtitle {
            font-size: 12px;
            color: #9ca3af;
        }

        .menu {
            flex: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }

        .menu-item:hover {
            background: #f3f4f6;
            color: #ef4444;
        }

        .menu-item.active {
            background: #ef4444;
            color: white;
        }

        .menu-item i {
            width: 20px;
            font-size: 18px;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            margin-top: 20px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-info h4 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .user-info p {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 50px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 40px;
        }

        .greeting {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .greeting .wave {
            display: inline-block;
            animation: wave 2s infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-20deg); }
        }

        .subtitle {
            color: #6b7280;
            font-size: 16px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 26px;
        }

        .stat-icon.red { background: #fee2e2; color: #ef4444; }
        .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.purple { background: #ede9fe; color: #8b5cf6; }
        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .action-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .action-card:hover {
            border-color: #ef4444;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.15);
        }

        .action-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .action-icon.red { background: #fee2e2; color: #ef4444; }
        .action-icon.blue { background: #dbeafe; color: #3b82f6; }
        .action-icon.green { background: #d1fae5; color: #10b981; }

        .action-card h3 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .action-card p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .logout-btn {
            color: #ef4444;
        }

        .logout-btn:hover {
            background: #fee2e2;
        }
    </style>
    <?php include 'vue/admin/_sidebar_css.php'; ?>
</head>
<body>
    <?php include 'vue/admin/_sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 class="greeting">
                Tableau de bord Administrateur <span class="wave">⚙️</span>
            </h1>
            <p class="subtitle">Gérez votre auto-école en un coup d'œil</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-value">
                    <?php 
                    $nbCandidats = $this->pdo->query("SELECT COUNT(*) FROM candidat")->fetchColumn();
                    echo $nbCandidats;
                    ?>
                </div>
                <div class="stat-label">Candidats inscrits</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-value">
                    <?php 
                    $nbMoniteurs = $this->pdo->query("SELECT COUNT(*) FROM moniteur")->fetchColumn();
                    echo $nbMoniteurs;
                    ?>
                </div>
                <div class="stat-label">Moniteurs actifs</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <div class="stat-value">
                    <?php 
                    // Revenus du mois (à adapter selon votre structure)
                    echo "0€";
                    ?>
                </div>
                <div class="stat-label">Revenus ce mois</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Leçons aujourd'hui</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-value">
                    <?php 
                    $nbFormules = $this->pdo->query("SELECT COUNT(*) FROM formule")->fetchColumn();
                    echo $nbFormules;
                    ?>
                </div>
                <div class="stat-label">Formules disponibles</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h2 style="font-size: 24px; color: #1f2937; margin-bottom: 24px;">
            <i class="fas fa-bolt" style="color: #ef4444;"></i> Actions rapides
        </h2>

        <div class="quick-actions">
            <a href="index.php?page=edit-candidat" class="action-card">
                <div class="action-card-header">
                    <div class="action-icon blue">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3>Gérer les candidats</h3>
                </div>
                <p>Ajouter, modifier ou supprimer des candidats</p>
            </a>

            <a href="index.php?page=moniteurs-admin" class="action-card">
                <div class="action-card-header">
                    <div class="action-icon red">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>Gérer les moniteurs</h3>
                </div>
                <p>Administrer l'équipe de moniteurs</p>
            </a>

            <a href="index.php?page=planning" class="action-card">
                <div class="action-card-header">
                    <div class="action-icon green">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Consulter le planning</h3>
                </div>
                <p>Voir toutes les leçons planifiées</p>
            </a>
        </div>
    </div>
</body>
</html>