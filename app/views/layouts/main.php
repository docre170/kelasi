<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelasi - Plateforme d'Inscription Scolaire</title>
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-school"></i> Kelasi
        </div>
        <ul class="nav-links">
            <li><a href="<?= url('') ?>"><i class="fas fa-home"></i> Accueil</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?= url('dashboard') ?>"><i class="fas fa-chart-pie"></i> Tableau de bord</a></li>
                <li><a href="<?= url('eleve/inscrire') ?>"><i class="fas fa-user-plus"></i> Inscrire</a></li>
                <li><a href="<?= url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Déconnexion (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
            <?php else: ?>
                <li><a href="<?= url('auth/connexion') ?>"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                <li><a href="<?= url('auth/inscription') ?>" class="btn-nav"><i class="fas fa-user-plus"></i> S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="container">
        <?= $content ?>
    </main>

    <footer>
        <p><i class="fas fa-copyright"></i> <?= date('Y') ?> Projet Kelasi - Tous droits réservés.</p>
    </footer>

    <script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
