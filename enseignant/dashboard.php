<?php
require_once '../config/database.php';

$page_title = 'Tableau de bord Enseignant';
$active_tab = 'dashboard';

include '../includes/header.php';
?>

<section class="dashboard-hero-section">
    <div class="dashboard-hero-content">
        <h1>Tableau de bord Enseignant</h1>
        <p>Gérez vos quiz et suivez les performances de vos étudiants</p>
        <div class="dashboard-actions">
            <a href="manage_categories.php" class="btn-primary">
                <i class="fa-solid fa-plus"></i>
                Nouvelle Catégorie
            </a>
            <a href="manage_quiz.php?action=add" class="btn-primary create-quiz-btn">
                <i class="fa-solid fa-pen-to-square"></i>
                Créer un Quiz
            </a>
        </div>
    </div>
</section>

<section class="dashboard-statistics">
    <?php include 'statistics.php'; ?>
</section>

<?php include '../includes/footer.php'; ?>
