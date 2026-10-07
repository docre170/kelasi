<div class="form-container" style="max-width: 760px; margin: 0 auto;">
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> Inscription d'un Élève</h1>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
        <form action="<?= url('eleve/inscrire') ?>" method="POST">
            <fieldset>
                <legend><i class="fas fa-user"></i> Informations de l'Élève</legend>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="postnom">Post-nom</label>
                        <input type="text" id="postnom" name="postnom">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="sexe">Sexe *</label>
                        <select id="sexe" name="sexe" required>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="lieu_naissance">Lieu de naissance</label>
                        <input type="text" id="lieu_naissance" name="lieu_naissance">
                    </div>
                </div>

                <div class="form-group">
                    <label for="adresse">Adresse résidentielle</label>
                    <textarea id="adresse" name="adresse" rows="2"></textarea>
                </div>
            </fieldset>

            <fieldset>
                <legend><i class="fas fa-users"></i> Informations du Parent / Tuteur</legend>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="parent_nom">Nom complet du parent *</label>
                        <input type="text" id="parent_nom" name="parent_nom" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone *</label>
                        <input type="text" id="telephone" name="telephone" placeholder="+243 ..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="parent_email">Email du parent</label>
                    <input type="email" id="parent_email" name="parent_email">
                </div>
            </fieldset>

            <fieldset>
                <legend><i class="fas fa-graduation-cap"></i> Scolarité (Année en cours : <?= htmlspecialchars($anneeActive['libelle'] ?? '2026-2027') ?>)</legend>

                <div class="form-group">
                    <label for="classe_id">Classe souhaitée *</label>
                    <select id="classe_id" name="classe_id" required>
                        <option value="">-- Sélectionnez une classe --</option>
                        <?php foreach ($classes as $classe): ?>
                            <option value="<?= $classe['id'] ?>"><?= htmlspecialchars(ucfirst($classe['cycle']) . ' - ' . $classe['niveau']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observations">Observations / Remarques</label>
                    <textarea id="observations" name="observations" rows="2"></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn-block"><i class="fas fa-paper-plane"></i> Soumettre l'inscription</button>
        </form>
    </div>
</div>
