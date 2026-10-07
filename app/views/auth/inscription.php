<div class="auth-form">
    <h2>Inscription</h2>
    <p class="subtitle">Créez votre compte parent Kelasi</p>

    <?php if (isset($error)): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= url('auth/inscription') ?>" method="POST">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" required placeholder="ex: Jean Dupont">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="votre@email.com">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required placeholder="********">
        </div>
        <button type="submit" class="btn-block"><i class="fas fa-user-plus"></i> S'inscrire</button>
    </form>

    <p class="auth-switch">
        Déjà un compte ? <a href="<?= url('auth/connexion') ?>">Se connecter</a>
    </p>
</div>
