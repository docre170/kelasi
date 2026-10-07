<div class="dashboard-container">
    <div class="page-header">
        <div>
            <h1><i class="fas fa-chart-pie"></i> Tableau de bord</h1>
            <p>Bienvenue, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (Rôle : <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>)</p>
        </div>
        <div>
            <span class="badge badge-primary">
                <i class="fas fa-calendar-alt"></i> Année scolaire : <?= htmlspecialchars($anneeActive['libelle'] ?? '2026-2027') ?>
            </span>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card stat-blue">
            <h3>Total Élèves</h3>
            <p class="stat-value"><?= $stats['total_eleves'] ?></p>
        </div>
        <div class="stat-card stat-info">
            <h3>Classes</h3>
            <p class="stat-value"><?= $stats['total_classes'] ?></p>
        </div>
        <div class="stat-card stat-warning">
            <h3>En attente</h3>
            <p class="stat-value"><?= $stats['inscriptions_attente'] ?></p>
        </div>
        <div class="stat-card stat-success">
            <h3>Validées</h3>
            <p class="stat-value"><?= $stats['inscriptions_validees'] ?></p>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="quick-actions">
        <h2 class="section-title">Actions Rapides</h2>
        <div class="action-row">
            <a href="<?= url('eleve/inscrire') ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Inscrire un élève</a>
            <a href="<?= url('eleve/liste') ?>" class="btn btn-info"><i class="fas fa-list"></i> Consulter les inscriptions</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?= url('classe/gestion') ?>" class="btn btn-secondary"><i class="fas fa-school"></i> Gérer les classes</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Inscriptions Récentes -->
    <div class="card">
        <h2 class="section-title">Inscriptions Récentes</h2>
        <?php if (!empty($inscriptionsRecentes)): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Dossier</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscriptionsRecentes as $inc): ?>
                            <tr>
                                <td><span class="dossier-num"><?= htmlspecialchars($inc['numero_dossier']) ?></span></td>
                                <td><?= htmlspecialchars($inc['eleve_prenom'] . ' ' . $inc['eleve_nom']) ?></td>
                                <td><?= htmlspecialchars($inc['classe_niveau']) ?></td>
                                <td>
                                    <?php
                                        $badgeClass = 'badge-warning';
                                        if ($inc['statut'] === 'validee') $badgeClass = 'badge-success';
                                        elseif ($inc['statut'] === 'rejetee') $badgeClass = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($inc['statut']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($inc['date_soumission']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="muted">Aucune inscription récente.</p>
        <?php endif; ?>
    </div>
</div>
