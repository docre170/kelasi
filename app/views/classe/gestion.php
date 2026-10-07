<div class="gestion-classes-container">
    <div class="page-header">
        <div>
            <h1><i class="fas fa-school"></i> Gestion des Classes</h1>
            <p>Ajoutez, modifiez ou supprimez les niveaux et cycles scolaires.</p>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="layout-2col">
        <!-- Formulaire d'ajout -->
        <div class="card">
            <h2 class="section-title">Ajouter une Classe</h2>
            <form action="<?= url('classe/gestion') ?>" method="POST">
                <div class="form-group">
                    <label for="cycle">Cycle *</label>
                    <select id="cycle" name="cycle" required>
                        <option value="maternelle">Maternelle</option>
                        <option value="primaire">Primaire</option>
                        <option value="eb">Éducation de Base (EB)</option>
                        <option value="humanite">Humanité</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="niveau">Niveau (ex: 1ère primaire) *</label>
                    <input type="text" id="niveau" name="niveau" required>
                </div>
                <div class="form-group">
                    <label for="ordre">Ordre d'affichage</label>
                    <input type="number" id="ordre" name="ordre" value="10" required>
                </div>
                <button type="submit" class="btn-block"><i class="fas fa-plus"></i> Ajouter la classe</button>
            </form>
        </div>

        <!-- Liste des classes -->
        <div class="card">
            <h2 class="section-title">Classes Existantes</h2>
            <?php if (!empty($classes)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ordre</th>
                                <th>Cycle</th>
                                <th>Niveau</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as $cls): ?>
                                <tr>
                                    <td><?= $cls['ordre'] ?></td>
                                    <td><strong><?= htmlspecialchars(ucfirst($cls['cycle'])) ?></strong></td>
                                    <td><?= htmlspecialchars($cls['niveau']) ?></td>
                                    <td style="text-align: center;">
                                        <a href="<?= url('classe/supprimer?id=' . $cls['id']) ?>" class="btn-icon" style="background: #dc3545;" title="Supprimer" onclick="return confirm('Supprimer cette classe ?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="empty-state">Aucune classe enregistrée.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
