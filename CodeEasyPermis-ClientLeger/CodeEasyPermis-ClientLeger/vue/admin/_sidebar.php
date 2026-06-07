<?php
// Sidebar commune à toutes les pages admin
$currentPage = $_GET['page'] ?? 'admin';
?>
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-shield-alt"></i>
        <div>
            <div class="logo-text">EasyPermis</div>
            <div class="logo-subtitle">Administration</div>
        </div>
    </div>

    <nav class="menu">
        <a href="index.php?page=admin" class="menu-item <?= ($currentPage === 'admin') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="index.php?page=candidats" class="menu-item <?= ($currentPage === 'candidats' || $currentPage === 'edit-candidat') ? 'active' : '' ?>">
            <i class="fas fa-user-graduate"></i>
            <span>Candidats</span>
        </a>
        <a href="index.php?page=moniteurs-admin" class="menu-item <?= ($currentPage === 'moniteurs-admin' || $currentPage === 'edit-moniteur') ? 'active' : '' ?>">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Moniteurs</span>
        </a>
        <a href="index.php?page=formules" class="menu-item <?= ($currentPage === 'formules' || $currentPage === 'edit-formule') ? 'active' : '' ?>">
            <i class="fas fa-tags"></i>
            <span>Formules</span>
        </a>
        <a href="index.php?page=planning" class="menu-item <?= ($currentPage === 'planning') ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Planning</span>
        </a>
        <a href="index.php?page=vehicules" class="menu-item <?= ($currentPage === 'vehicules' || $currentPage === 'edit-vehicule') ? 'active' : '' ?>">
            <i class="fas fa-car"></i>
            <span>Véhicules</span>
        </a>
        <a href="index.php?page=questions-code" class="menu-item <?= ($currentPage === 'questions-code' || $currentPage === 'edit-question') ? 'active' : '' ?>">
            <i class="fas fa-question-circle"></i>
            <span>Questions Code</span>
        </a>
        <a href="index.php?page=factures-admin" class="menu-item <?= ($currentPage === 'factures-admin') ? 'active' : '' ?>">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Factures</span>
        </a>
        <a href="index.php?page=quiz-stats-admin" class="menu-item <?= ($currentPage === 'quiz-stats-admin') ? 'active' : '' ?>">
            <i class="fas fa-chart-bar"></i>
            <span>Stats Quiz</span>
        </a>
        <a href="index.php?page=statistiques" class="menu-item <?= ($currentPage === 'statistiques') ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i>
            <span>Statistiques</span>
        </a>
        <a href="index.php?page=logout" class="menu-item logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </nav>

    <div class="user-section">
        <div class="user-avatar">AD</div>
        <div class="user-info">
            <h4>Administrateur</h4>
            <p>Super Admin</p>
        </div>
    </div>
</div>
