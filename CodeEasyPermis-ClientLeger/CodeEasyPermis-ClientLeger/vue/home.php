<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPermis - Auto-École Professionnelle</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0066CC;
            --primary-dark: #0052a3;
            --secondary: #10b981;
            --dark-text: #1a1a1a;
            --gray-text: #6b7280;
            --light-bg: #f9fafb;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dark-text);
            background: white;
            line-height: 1.6;
        }

        /* Header & Navigation */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            animation: slideDown 0.6s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.2);
        }

        .logo-text h1 {
            font-size: 1.5rem;
            color: var(--dark-text);
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-text p {
            font-size: 0.75rem;
            color: var(--gray-text);
            font-weight: 400;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--gray-text);
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            transition: color 0.3s ease;
            padding: 0.5rem 0;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--primary);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -1.2rem;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            border-radius: 3px 3px 0 0;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .phone-link {
            color: var(--gray-text);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }

        .phone-link:hover {
            color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.15);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.25);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            padding: 0.75rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: var(--light-bg);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            margin-top: 88px;
            min-height: calc(100vh - 88px);
            display: flex;
            align-items: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(0, 102, 204, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            animation: fadeInLeft 0.8s ease;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 2rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(0, 102, 204, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(0, 102, 204, 0);
            }
        }

        .hero h2 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero h2 .highlight {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--gray-text);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 540px;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .hero-actions .btn-primary {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats {
            display: flex;
            gap: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .stat-item:nth-child(1) { animation-delay: 0.3s; }
        .stat-item:nth-child(2) { animation-delay: 0.5s; }
        .stat-item:nth-child(3) { animation-delay: 0.7s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: var(--light-bg);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .stat-text span {
            display: block;
            font-size: 0.8rem;
            color: var(--gray-text);
            margin-bottom: 0.1rem;
        }

        .stat-text strong {
            font-size: 0.95rem;
            color: var(--dark-text);
            font-weight: 600;
        }

        /* Hero Image */
        .hero-image {
            position: relative;
            animation: fadeInRight 0.8s ease;
        }

        .hero-image-wrapper {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            transition: transform 0.5s ease;
        }

        .hero-image-wrapper:hover {
            transform: scale(1.02);
        }

        .hero-image-wrapper img {
            width: 100%;
            height: auto;
            display: block;
        }

        .success-badge {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            background: white;
            padding: 1.25rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInLeft 1s ease 0.5s backwards;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .success-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--secondary) 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .success-text {
            line-height: 1.4;
        }

        .success-text strong {
            display: block;
            font-size: 1rem;
            color: var(--dark-text);
            font-weight: 600;
        }

        .success-text span {
            font-size: 0.85rem;
            color: var(--gray-text);
        }

        /* Sections communes */
        section {
            padding: 5rem 2rem;
        }

        .section-header {
            max-width: 800px;
            margin: 0 auto 4rem;
            text-align: center;
        }

        .section-header .label {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
        }

        .section-header h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--gray-text);
            line-height: 1.7;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Formations Section */
        #formations {
            background: var(--light-bg);
        }

        .formations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .formation-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .formation-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 102, 204, 0.15);
            border-color: var(--primary);
        }

        .formation-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .formation-card h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .formation-card p {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .formation-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .formation-features li {
            padding: 0.5rem 0;
            color: var(--gray-text);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .formation-features li::before {
            content: "✓";
            color: var(--secondary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .formation-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .formation-price span {
            font-size: 0.9rem;
            color: var(--gray-text);
            font-weight: 400;
        }

        /* À Propos Section */
        #apropos {
            background: white;
        }

        .apropos-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .apropos-image {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .apropos-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .apropos-text h4 {
            font-size: 1.25rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .apropos-text h3 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: -0.5px;
        }

        .apropos-text p {
            color: var(--gray-text);
            margin-bottom: 1.5rem;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .value-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .value-icon {
            width: 48px;
            height: 48px;
            background: var(--light-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .value-text h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .value-text p {
            font-size: 0.95rem;
            color: var(--gray-text);
            margin: 0;
        }

        /* Tarifs Section */
        #tarifs {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        #tarifs .section-header .label {
            color: rgba(255, 255, 255, 0.9);
        }

        #tarifs .section-header h3,
        #tarifs .section-header p {
            color: white;
        }

        .tarifs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .tarif-card {
            background: white;
            color: var(--dark-text);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .tarif-card.featured {
            transform: scale(1.05);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .tarif-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .tarif-label {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .tarif-card.featured .tarif-label {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            display: inline-block;
        }

        .tarif-card h4 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .tarif-price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .tarif-price span {
            font-size: 1.25rem;
            font-weight: 400;
        }

        .tarif-duration {
            color: var(--gray-text);
            margin-bottom: 2rem;
        }

        .tarif-features {
            list-style: none;
            text-align: left;
            margin-bottom: 2rem;
        }

        .tarif-features li {
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .tarif-features li:last-child {
            border-bottom: none;
        }

        .tarif-features li::before {
            content: "✓";
            color: var(--secondary);
            font-weight: 700;
        }

        /* Contact Section */
        #contact {
            background: var(--light-bg);
        }

        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-info h4 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: var(--gray-text);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .contact-methods {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-method {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.5rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .contact-method:hover {
            box-shadow: 0 8px 24px rgba(0, 102, 204, 0.1);
            transform: translateX(8px);
        }

        .contact-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .contact-method-text h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .contact-method-text p {
            margin: 0;
            color: var(--gray-text);
        }

        .contact-form {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Footer */
        footer {
            background: var(--dark-text);
            color: white;
            padding: 3rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container,
            .apropos-content,
            .contact-container {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .hero h2,
            .apropos-text h3 {
                font-size: 2.75rem;
            }

            .nav-links {
                display: none;
            }

            .tarif-card.featured {
                transform: scale(1);
            }
        }

        @media (max-width: 640px) {
            .hero h2,
            .apropos-text h3 {
                font-size: 2rem;
            }

            .section-header h3 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .stats {
                flex-direction: column;
                gap: 1.5rem;
            }

            .hero-actions {
                flex-direction: column;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .formations-grid,
            .tarifs-grid {
                grid-template-columns: 1fr;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="#" class="logo">
                

                <img src="images/logo.png" alt="Logo EasyPermis" style="width: 50px; height: 50px;">
                 
                <div class="logo-text">
                    <h1>EasyPermis</h1>
                    <p>Auto-École</p>
                </div>
            </a>
            
            <ul class="nav-links">
                <li><a href="#accueil" class="active">Accueil</a></li>
                <li><a href="#formations">Formations</a></li>
                <li><a href="#apropos">À propos</a></li>
                <li><a href="#tarifs">Tarifs</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <a href="tel:0759655833" class="phone-link">
                    📞 01 23 45 67 89
                </a>
                <a href="index.php?page=register" class="btn-primary">Inscription</a>
                <a href="index.php?page=login" class="btn-secondary">Connexion</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="hero-container">
            <div class="hero-content">
                <div class="badge">
                    📈 La référence depuis 2025
                </div>
                
                <h2>
                    Votre réussite, <span class="highlight">notre passion</span>
                </h2>
                
                <p>
                    Obtenez votre permis de conduire avec EasyPermis, l'auto-école qui place votre succès au cœur de ses priorités. Formations complètes et moniteurs experts.
                </p>

                <div class="hero-actions">
                    <a href="#contact" class="btn-primary">
                        Commencer maintenant
                        <span>→</span>
                    </a>
                    <a href="#formations" class="btn-secondary">Nos formations</a>
                </div>

                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-icon">✓</div>
                        <div class="stat-text">
                            <span>Taux de réussite</span>
                            <strong>50%</strong>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">👨‍🏫</div>
                        <div class="stat-text">
                            <span>Moniteurs diplômés</span>
                            <strong>Certifiés</strong>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">🚗</div>
                        <div class="stat-text">
                            <span>Véhicules récents</span>
                            <strong>Flotte 2025</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&h=600&fit=crop" alt="Jeune conductrice souriante au volant">
                    
                    <div class="success-badge">
                        <div class="success-circle">50%</div>
                        <div class="success-text">
                            <strong>Taux de réussite</strong>
                            <span>Permis B 2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formations Section -->
    <section id="formations">
        <div class="container">
            <div class="section-header">
                <div class="label">Nos Formations</div>
                <h3>Trouvez la formation qui vous correspond</h3>
                <p>Des programmes adaptés à tous les profils, du débutant au perfectionnement</p>
            </div>

            <div class="formations-grid">
                <div class="formation-card">
                    <div class="formation-icon">🚗</div>
                    <h4>Permis B Classique</h4>
                    <p>La formation traditionnelle pour apprendre à conduire en toute sécurité avec nos moniteurs expérimentés.</p>
                    <ul class="formation-features">
                        <li>20h de conduite minimum</li>
                        <li>Formation au code incluse</li>
                        <li>Véhicules récents</li>
                        <li>Horaires flexibles</li>
                    </ul>
                    <div class="formation-price">
                        1 290€ <span>TTC</span>
                    </div>
                    <a href="index.php?page=register" class="btn-primary" style="display: block; text-align: center;">S'inscrire</a>
                </div>

                <div class="formation-card">
                    <div class="formation-icon">⚡</div>
                    <h4>Permis Accéléré</h4>
                    <p>Obtenez votre permis en quelques semaines avec notre formule intensive et personnalisée.</p>
                    <ul class="formation-features">
                        <li>Formation intensive 2-3 semaines</li>
                        <li>Planning dédié</li>
                        <li>Passage express à l'examen</li>
                        <li>Moniteur attitré</li>
                    </ul>
                    <div class="formation-price">
                        1 890€ <span>TTC</span>
                    </div>
                    <a href="index.php?page=register" class="btn-primary" style="display: block; text-align: center;">S'inscrire</a>
                </div>

                <div class="formation-card">
                    <div class="formation-icon">🎯</div>
                    <h4>Conduite Accompagnée</h4>
                    <p>Apprenez à conduire dès 15 ans avec la conduite accompagnée pour plus d'expérience.</p>
                    <ul class="formation-features">
                        <li>Dès 15 ans</li>
                        <li>Formation progressive</li>
                        <li>Meilleur taux de réussite</li>
                        <li>Suivi personnalisé</li>
                    </ul>
                    <div class="formation-price">
                        1 490€ <span>TTC</span>
                    </div>
                    <a href="index.php?page=register" class="btn-primary" style="display: block; text-align: center;">S'inscrire</a>
                </div>
            </div>
        </div>
    </section>

    <!-- À Propos Section -->
    <section id="apropos">
        <div class="container">
            <div class="apropos-content">
                <div class="apropos-image">
                    <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=700&h=700&fit=crop" alt="Auto-école MAY IT">
                </div>

                <div class="apropos-text">
                    <h4>À propos de nous</h4>
                    <h3>Une auto-école de confiance depuis 2025</h3>
                    <p>
                        EasyPermis est bien plus qu'une simple auto-école. Nous sommes une équipe passionnée dédiée à votre réussite. Avec un taux de réussite de 50%, nous formons chaque année des centaines de nouveaux conducteurs confiants et responsables.
                    </p>
                    <p>
                        Notre approche pédagogique moderne, nos véhicules récents et nos moniteurs diplômés d'État garantissent une formation de qualité dans les meilleures conditions.
                    </p>

                    <div class="values-grid">
                        <div class="value-item">
                            <div class="value-icon">🎓</div>
                            <div class="value-text">
                                <h5>Expertise</h5>
                                <p>Moniteurs certifiés et expérimentés</p>
                            </div>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">💪</div>
                            <div class="value-text">
                                <h5>Accompagnement</h5>
                                <p>Suivi personnalisé de A à Z</p>
                            </div>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">🚘</div>
                            <div class="value-text">
                                <h5>Matériel récent</h5>
                                <p>Flotte de véhicules 2025</p>
                            </div>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">⭐</div>
                            <div class="value-text">
                                <h5>Taux de réussite</h5>
                                <p>50% de réussite en 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarifs Section -->
    <section id="tarifs">
        <div class="container">
            <div class="section-header">
                <div class="label">Nos Tarifs</div>
                <h3>Des formules transparentes et adaptées</h3>
                <p>Choisissez la formule qui correspond à vos besoins et votre budget</p>
            </div>

            <div class="tarifs-grid">
                <div class="tarif-card">
                    <div class="tarif-label">Découverte</div>
                    <h4>Permis Code</h4>
                    <div class="tarif-price">390€</div>
                    <div class="tarif-duration">Formation au code uniquement</div>
                    <ul class="tarif-features">
                        <li>Accès plateforme en ligne</li>
                        <li>Séances de code illimitées</li>
                        <li>Application mobile</li>
                        <li>Suivi pédagogique</li>
                    </ul>
                    <a href="#contact" class="btn-secondary" style="display: block; text-align: center; width: 100%;">Choisir</a>
                </div>

                <div class="tarif-card featured">
                    <div class="tarif-label">Populaire</div>
                    <h4>Formule Complète</h4>
                    <div class="tarif-price">1290€</div>
                    <div class="tarif-duration">Code + 20h de conduite</div>
                    <ul class="tarif-features">
                        <li>Formation code complète</li>
                        <li>20h de conduite</li>
                        <li>Frais d'examen inclus</li>
                        <li>Livret d'apprentissage</li>
                        <li>Véhicule récent</li>
                    </ul>
                    <a href="#contact" class="btn-primary" style="display: block; text-align: center; width: 100%;">Choisir</a>
                </div>

                <div class="tarif-card">
                    <div class="tarif-label">Premium</div>
                    <h4>Heure supplémentaire</h4>
                    <div class="tarif-price">50€</div>
                    <div class="tarif-duration">À l'unité</div>
                    <ul class="tarif-features">
                        <li>Heure de conduite</li>
                        <li>Moniteur dédié</li>
                        <li>Horaires flexibles</li>
                        <li>Véhicule récent</li>
                    </ul>
                    <a href="#contact" class="btn-secondary" style="display: block; text-align: center; width: 100%;">Réserver</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="section-header">
                <div class="label">Contactez-nous</div>
                <h3>Prêt à commencer votre formation ?</h3>
                <p>Notre équipe est là pour répondre à toutes vos questions</p>
            </div>

            <div class="contact-container">
                <div class="contact-info">
                    <h4>Parlons de votre projet</h4>
                    <p>N'hésitez pas à nous contacter par téléphone, email ou directement via notre formulaire. Nous vous répondrons dans les plus brefs délais.</p>

                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="contact-icon">📞</div>
                            <div class="contact-method-text">
                                <h5>Téléphone</h5>
                                <p>01 23 45 67 89</p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">✉️</div>
                            <div class="contact-method-text">
                                <h5>Email</h5>
                                <p>contact@easypermis.fr</p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">📍</div>
                            <div class="contact-method-text">
                                <h5>Adresse</h5>
                                <p>IRIS<br>75017 Paris</p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">🕐</div>
                            <div class="contact-method-text">
                                <h5>Horaires</h5>
                                <p>Lun - Sam: 9h - 19h<br>Dimanche: Fermé</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label for="nom">Nom complet</label>
                            <input type="text" id="nom" name="nom" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%;">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h5>EasyPermis Auto-École</h5>
                <p style="color: rgba(255, 255, 255, 0.7); line-height: 1.7;">
                    Votre partenaire de confiance pour obtenir votre permis de conduire dans les meilleures conditions.
                </p>
            </div>

            <div class="footer-section">
                <h5>Liens rapides</h5>
                <ul>
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#formations">Formations</a></li>
                    <li><a href="#apropos">À propos</a></li>
                    <li><a href="#tarifs">Tarifs</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h5>Formations</h5>
                <ul>
                    <li><a href="#formations">Permis B</a></li>
                    <li><a href="#formations">Permis Accéléré</a></li>
                    <li><a href="#formations">Conduite Accompagnée</a></li>
                    <li><a href="#formations">Code en ligne</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h5>Contact</h5>
                <ul>
                    <li><a href="tel:0759655833">01 23 45 67 89 </a></li>
                    <li><a href="mailto:youmadrame301@gmail.com">contact@easypermis.fr</a></li>
                    <li>Paris<br>75017 Paris</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 EasyPermis Auto-École. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Active navigation
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-links a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });

            // Header shadow
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.08)';
            } else {
                header.style.boxShadow = 'none';
            }
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Merci pour votre message ! Nous vous répondrons dans les plus brefs délais.');
            e.target.reset();
        });
    </script>
</body>
</html>