<!-- connection -->
<?php
require_once '../config/database.php';
?>


<?php

$page_title = $page_title ?? 'Tableau de bord';

$active_tab = $active_tab ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizMaster - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <?php if (!isset($auth_page) || $auth_page !== true): ?>

        <header class="navbar">
            <div class="navbar-left">
                <a href="dashboard.php" class="logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                    QuizMaster
                </a>
                <span class="user-role">Enseignant</span>
            </div>
            <nav class="navbar-center">
                <ul>
                    <li><a href="dashboard.php">
                            <i class="fa-solid fa-table-columns"></i> Tableau de bord
                        </a></li>

                    <li><a href="manage_categories.php"
                           >
                            <i class="fa-solid fa-folder-open"></i> Catégories
                        </a></li>

                    <li><a href="manage_quiz.php?view=quizzes"
                            >
                            <i class="fa-solid fa-clipboard-question"></i> Mes Quiz
                        </a></li>

                    <li><a href="view_results.php" >
                            <i class="fa-solid fa-square-poll-vertical"></i> Résultats
                        </a></li>
                </ul>
            </nav>

       <div class="navbar-right">
    <a href="../logout.php" class="btn-logout">
        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
    </a>
</div>
        </header>

        <main class="content-wrapper">
        <?php endif; ?>