<?php

$total_quiz = 0;
$q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM QUIZ");
if ($q) {
    $row = mysqli_fetch_assoc($q);
    $total_quiz = (int) ($row['total'] ?? 0);
}

$total_categories = 0;
$q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM CATEGORY");
if ($q) {
    $row = mysqli_fetch_assoc($q);
    $total_categories = (int) ($row['total'] ?? 0);
}

$total_students = 0;
$q = mysqli_query(
    $conn,
    "SELECT COUNT(DISTINCT id_etudiant) AS total FROM RESULT"
);
if ($q) {
    $row = mysqli_fetch_assoc($q);
    $total_students = (int) ($row['total'] ?? 0);
}
$success_rate = 0;

$q = mysqli_query(
    $conn,
    "SELECT 
        COUNT(*) AS total_attempts,
        SUM(
            CASE 
                WHEN score >= (total_questions / 2) THEN 1 
                ELSE 0 
            END
        ) AS success_attempts
     FROM RESULT"
);
if ($q) {
    $row = mysqli_fetch_assoc($q);

    $total_attempts  = (int) ($row['total_attempts'] ?? 0);
    $success_attempts = (int) ($row['success_attempts'] ?? 0);

    if ($total_attempts > 0) {
        $success_rate = (int) round(
            ($success_attempts / $total_attempts) * 100
        );
    }
}
?>
<div class="dashboard-stats-grid">

    <div class="stat-card">
        <div class="stat-content">
            <span class="stat-label">Total Quiz</span>
            <span class="stat-value"><?php echo $total_quiz; ?></span>
        </div>
        <div class="stat-icon icon-blue">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <span class="stat-label">Catégories</span>
            <span class="stat-value"><?php echo $total_categories; ?></span>
        </div>
        <div class="stat-icon icon-purple">
            <i class="fa-solid fa-folder"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <span class="stat-label">Étudiants Actifs</span>
            <span class="stat-value"><?php echo $total_students; ?></span>
        </div>
        <div class="stat-icon icon-green">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <span class="stat-label">Taux de Réussite</span>
            <span class="stat-value"><?php echo $success_rate; ?>%</span>
        </div>
        <div class="stat-icon icon-yellow">
            <i class="fa-solid fa-chart-line"></i>
        </div>
    </div>

</div>
