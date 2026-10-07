<div class="home">
    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg">
            <span class="hero-blob hero-blob-1"></span>
            <span class="hero-blob hero-blob-2"></span>
            <span class="hero-grid"></span>
        </div>

        <div class="hero-inner">
            <span class="hero-badge"><i class="fas fa-school"></i> Plateforme scolaire RDC</span>
            <h1>L'inscription scolaire, <span class="grad-text">100% en ligne</span></h1>
            <p class="hero-subtitle">
                Kelasi simplifie l'inscription de votre enfant : créez son dossier,
                suivez sa validation et obtenez sa place sans faire la queue.
            </p>
            <div class="hero-actions">
                <a href="<?= url('auth/inscription') ?>" class="btn btn-primary btn-lg"><i class="fas fa-user-plus"></i> Créer un compte</a>
                <a href="<?= url('auth/connexion') ?>" class="btn btn-outline btn-lg"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
            </div>
        </div>
    </section>

    <!-- FONCTIONNALITÉS -->
    <section class="section-block features">
        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fas fa-file-signature"></i></div>
                <h3>Inscription en ligne</h3>
                <p>Créez le dossier de votre enfant depuis chez vous, en quelques minutes.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fas fa-tasks"></i></div>
                <h3>Suivi du dossier</h3>
                <p>En attente, validée ou rejetée : suivez chaque étape en temps réel.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                <h3>Données sécurisées</h3>
                <p>Vos informations sont protégées et restent strictement confidentielles.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Cycles scolaires RDC</h3>
                <p>De la maternelle à l'humanité, tous les niveaux du système éducatif congolais.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-banner reveal">
        <div>
            <h2><i class="fas fa-rocket"></i> Prêt pour la rentrée ?</h2>
            <p>Rejoignez Kelasi et simplifiez l'inscription de votre enfant dès aujourd'hui.</p>
        </div>
        <a href="<?= url('auth/inscription') ?>" class="btn btn-white btn-lg">Commencer maintenant <i class="fas fa-arrow-right"></i></a>
    </section>
</div>
