<?php
// Sidebar commune à toutes les pages moniteur
$currentPage = $_GET['page'] ?? 'moniteur';
?>
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-chalkboard-teacher"></i>
        <div>
            <div class="logo-text">EasyPermis</div>
            <div class="logo-subtitle">Espace Moniteur</div>
        </div>
    </div>

    <nav class="menu">
        <a href="index.php?page=moniteur" class="menu-item <?= ($currentPage === 'moniteur') ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="index.php?page=planning" class="menu-item <?= ($currentPage === 'planning') ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Mon planning</span>
        </a>
        <a href="index.php?page=mes-eleves" class="menu-item <?= ($currentPage === 'mes-eleves') ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Mes élèves</span>
        </a>
        <a href="index.php?page=evaluations" class="menu-item <?= ($currentPage === 'evaluations') ? 'active' : '' ?>">
            <i class="fas fa-clipboard-check"></i>
            <span>Évaluations</span>
        </a>
        <a href="index.php?page=profil-moniteur" class="menu-item <?= ($currentPage === 'profil-moniteur') ? 'active' : '' ?>">
            <i class="fas fa-user-circle"></i>
            <span>Mon profil</span>
        </a>
        <a href="index.php?page=logout" class="menu-item logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </nav>

    <div class="user-section">
        <div class="user-avatar">
            <?= strtoupper(substr($moniteurActuel['prenom'], 0, 1) . substr($moniteurActuel['nom'], 0, 1)) ?>
        </div>
        <div class="user-info">
            <h4><?= htmlspecialchars($moniteurActuel['prenom'] . ' ' . $moniteurActuel['nom']) ?></h4>
            <p>Moniteur</p>
        </div>
    </div>
</div>
