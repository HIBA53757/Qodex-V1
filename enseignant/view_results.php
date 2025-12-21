<!-- connection -->
<?php
require_once '../config/database.php';

?>



<?php $page_title = 'Résultats des Étudiants';
include '../includes/header.php'; ?>

<div class="page-header">
    <h1>Résultats des Étudiants</h1>
    <p>Historique des scores pour tous les quiz</p>
</div>

<section class="results-table-container card">
    <table class="results-table">
        <thead>
            <tr>
                <th>ÉTUDIANT</th>
                <th>QUIZ</th>
                <th>SCORE</th>
                <th>DATE</th>
                <th>STATUT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="student-info-cell">
                    <span class="student-avatar-sm">.</span>
                    <span>.</span>
                </td>
                <td>Les Bases de HTML5</td>
                <td class="score-cell"><span class="score-value success-score">18/20</span></td>
                <td>.</td>
                <td><span class="status-tag success-tag">Réussi</span></td>
            </tr>

        </tbody>
    </table>
</section>

<?php include '../includes/footer.php'; ?>