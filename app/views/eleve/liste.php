<div class="liste-container">
    <div class="page-header">
        <div>
            <h1><i class="fas fa-list"></i> Liste des Inscriptions et Élèves</h1>
            <p>Consultez et gérez l'ensemble des dossiers d'inscription enregistrés.</p>
        </div>
        <div>
            <a href="<?= url('eleve/inscrire') ?>" class="btn btn-primary"><i class="fas fa-user-plus"></i> Nouvelle Inscription</a>
        </div>
    </div>

    <!-- Filtres rapides JS -->
    <div class="filter-bar">
        <label for="searchInput"><i class="fas fa-search"></i> Filtrer :</label>
        <input type="text" id="searchInput" placeholder="Rechercher par nom, dossier ou classe..." onkeyup="filterTable()">
    </div>

    <div class="card">
        <?php if (!empty($inscriptions)): ?>
            <div class="table-responsive">
                <table id="inscriptionsTable" class="table">
                    <thead>
                        <tr>
                            <th>Dossier</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Parent / Tél</th>
                            <th>Statut</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscriptions as $inc): ?>
                            <tr>
                                <td><span class="dossier-num"><?= htmlspecialchars($inc['numero_dossier']) ?></span></td>
                                <td><?= htmlspecialchars($inc['eleve_prenom'] . ' ' . $inc['eleve_nom']) ?></td>
                                <td><?= htmlspecialchars($inc['classe_niveau'] ?? '-') ?></td>
                                <td>
                                    <?= htmlspecialchars($inc['parent_nom'] ?? '-') ?><br>
                                    <span class="muted"><?= htmlspecialchars($inc['telephone'] ?? '') ?></span>
                                </td>
                                <td>
                                    <?php
                                        $badgeClass = 'badge-warning';
                                        if ($inc['statut'] === 'validee') $badgeClass = 'badge-success';
                                        elseif ($inc['statut'] === 'rejetee') $badgeClass = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($inc['statut']) ?></span>
                                </td>
                                <td style="text-align: center;">
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <div class="action-buttons">
                                            <form action="<?= url('eleve/traiter') ?>" method="POST" style="display:inline;">
                                                <input type="hidden" name="inscription_id" value="<?= $inc['id'] ?>">
                                                <input type="hidden" name="statut" value="validee">
                                                <button type="submit" class="btn-icon" style="background: #28a745;" title="Valider"><i class="fas fa-check"></i></button>
                                            </form>
                                            <form action="<?= url('eleve/traiter') ?>" method="POST" style="display:inline;">
                                                <input type="hidden" name="inscription_id" value="<?= $inc['id'] ?>">
                                                <input type="hidden" name="statut" value="rejetee">
                                                <button type="submit" class="btn-icon" style="background: #dc3545;" title="Rejeter"><i class="fas fa-times"></i></button>
                                            </form>
                                            <a href="<?= url('eleve/supprimer?id=' . $inc['id']) ?>" class="btn-icon" style="background: #6c757d;" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?');"><i class="fas fa-trash"></i></a>
                                        </div>
                                    <?php else: ?>
                                        <span class="muted" style="font-style: italic;">Aucune action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty-state">Aucune inscription trouvée.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("inscriptionsTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdDossier = tr[i].getElementsByTagName("td")[0];
        let tdEleve = tr[i].getElementsByTagName("td")[1];
        let tdClasse = tr[i].getElementsByTagName("td")[2];
        if (tdDossier || tdEleve || tdClasse) {
            let txtDossier = tdDossier.textContent || tdDossier.innerText;
            let txtEleve = tdEleve.textContent || tdEleve.innerText;
            let txtClasse = tdClasse.textContent || tdClasse.innerText;
            if (txtDossier.toLowerCase().indexOf(filter) > -1 || txtEleve.toLowerCase().indexOf(filter) > -1 || txtClasse.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
