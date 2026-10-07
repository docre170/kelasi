<div class="auth-form">
    <h2>Connexion</h2>
    <p class="subtitle">Accédez à votre espace Kelasi</p>

    <?php if (isset($error)): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= url('auth/connexion') ?>" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="votre@email.com">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required placeholder="********">
        </div>
        <button type="submit" class="btn-block"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
    </form>

    <p class="auth-switch">
        Pas encore de compte ? <a href="<?= url('auth/inscription') ?>">Créer un compte</a>
    </p>
</div>
