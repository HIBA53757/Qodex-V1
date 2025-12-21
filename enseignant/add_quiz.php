<?php
require_once '../config/database.php';
session_start();

if (isset($_POST['save_all'])) {
    $titre = htmlspecialchars($_POST['titre']);
    $desc = htmlspecialchars($_POST['description']);
    $id_cat = (int)$_POST['id_category'];
    $user_id = $_SESSION['id_user'];

    mysqli_begin_transaction($conn);

    try {
        // Insertion du Quiz
        $stmt = mysqli_prepare($conn, "INSERT INTO QUIZ (titre_quiz, description_quiz, duree_minutes, id_category, id_enseignant, created_at, updated_at) VALUES (?, ?, 20, ?, ?, NOW(), NOW())");
        mysqli_stmt_bind_param($stmt, "ssii", $titre, $desc, $id_cat, $user_id);
        mysqli_stmt_execute($stmt);
        $quiz_id = mysqli_insert_id($conn);

        // Insertion des Questions
        if (!empty($_POST['q_text'])) {
            $stmtQ = mysqli_prepare($conn, "INSERT INTO QUESTION (question, correct_option, option1, option2, option3, option4, id_quiz, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            
            foreach ($_POST['q_text'] as $i => $text) {
                mysqli_stmt_bind_param($stmtQ, "sissssi", $text, $_POST['q_correct'][$i], $_POST['q_o1'][$i], $_POST['q_o2'][$i], $_POST['q_o3'][$i], $_POST['q_o4'][$i], $quiz_id);
                mysqli_stmt_execute($stmtQ);
            }
        }

        mysqli_commit($conn);
        header("Location: manage_quiz.php?msg=success");
    } catch (Exception $e) {
        mysqli_rollback($conn);
        die("Erreur : " . $e->getMessage());
    }
}