<?php
// Sidebar commune à toutes les pages candidat
// Inclure cette sidebar dans toutes les pages candidat
$currentPage = $_GET['page'] ?? 'candidat';
?>
<div class="sidebar">
    <div class="logo">
        <i class="fas fa-car"></i>
        <div>
            <div class="logo-text">EasyPermis</div>
            <div class="logo-subtitle">Espace Élève</div>
        </div>
    </div>

    <nav class="menu">
        <a href="index.php?page=candidat" class="menu-item <?= ($currentPage === 'candidat') ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i>
            <span>Tableau de bord</span>
        </a>
        <a href="index.php?page=mes-lecons" class="menu-item <?= ($currentPage === 'mes-lecons') ? 'active' : '' ?>">
            <i class="fas fa-calendar"></i>
            <span>Mes leçons</span>
        </a>
        <a href="index.php?page=quiz-code" class="menu-item <?= ($currentPage === 'quiz-code') ? 'active' : '' ?>">
            <i class="fas fa-book-open"></i>
            <span>Quiz Code</span>
        </a>
        <a href="index.php?page=facture" class="menu-item <?= ($currentPage === 'facture') ? 'active' : '' ?>">
            <i class="fas fa-file-invoice"></i>
            <span>Ma facture</span>
        </a>
        <a href="index.php?page=profil-candidat" class="menu-item <?= ($currentPage === 'profil-candidat') ? 'active' : '' ?>">
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
            <?= strtoupper(substr($candidatActuel['prenom'], 0, 1) . substr($candidatActuel['nom'], 0, 1)) ?>
        </div>
        <div class="user-info">
            <h4><?= htmlspecialchars($candidatActuel['prenom'] . ' ' . $candidatActuel['nom']) ?></h4>
            <p>Élève</p>
        </div>
    </div>
</div>
