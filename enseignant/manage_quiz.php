<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

$sql = "SELECT q.*, c.nom_category 
        FROM QUIZ q 
        LEFT JOIN CATEGORY c ON q.id_category = c.id_category 
        WHERE q.id_enseignant = '$user_id' 
        ORDER BY q.created_at DESC";
$quizzes_query = mysqli_query($conn, $sql);

$categories_query = mysqli_query($conn, "SELECT * FROM CATEGORY");

$page_title = 'Mes Quiz';
include '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>Mes Quiz</h1>
        <p>Gérez vos quiz et questions en un seul endroit</p>
    </div>
    <button class="btn-primary" id="openQuizModal">
        <i class="fa-solid fa-plus"></i> Créer un Quiz
    </button>
</div>

<div class="quiz-grid">
    <?php while($quiz = mysqli_fetch_assoc($quizzes_query)): ?>
    <div class="card quiz-card">
        <div class="quiz-header">
            <span class="quiz-category-tag"><?= htmlspecialchars($quiz['nom_category'] ?? 'Général'); ?></span>
        </div>
        <h3 class="quiz-title"><?= htmlspecialchars($quiz['titre_quiz']); ?></h3>
        <p><?= htmlspecialchars($quiz['description_quiz']); ?></p>
   
    </div>
    <?php endwhile; ?>
</div>

<div id="quizModal" class="modal">
    <div class="modal-content" style="max-width: 900px; width: 95%;">
        <div class="modal-header">
            <h2>Créer un Nouveau Quiz</h2>
            <span class="close-modal">&times;</span>
        </div>
        <form action="add_quiz.php" method="POST">
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Titre du quiz *</label>
                        <input type="text" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label>Catégorie *</label>
                        <select name="id_category" required>
                            <?php mysqli_data_seek($categories_query, 0); 
                                  while($c = mysqli_fetch_assoc($categories_query)): ?>
                                <option value="<?= $c['id_category'] ?>"><?= $c['nom_category'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2"></textarea>
                </div>

                <hr>
                <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                    <h3>Questions</h3>
                    <button type="button" id="addQuestionBtn" class="btn-primary" style="background: #28a745;">+ Ajouter</button>
                </div>
                <div id="questionsContainer"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="save_all" class="btn-primary">Enregistrer tout le Quiz</button>
            </div>
        </form>
    </div>
</div>

<script>
let qCount = 0;
document.getElementById('addQuestionBtn').onclick = function() {
    qCount++;
    const html = `
    <div class="question-block" id="q_block_${qCount}" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 8px;">
        <div style="display:flex; justify-content:space-between">
            <label>Question ${qCount}</label>
            <button type="button" onclick="this.parentElement.parentElement.remove()" style="color:red; border:none; background:none; cursor:pointer">Supprimer</button>
        </div>
        <input type="text" name="q_text[]" required style="width:100%; margin-bottom:10px;">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <input type="text" name="q_o1[]" placeholder="Option 1" required>
            <input type="text" name="q_o2[]" placeholder="Option 2" required>
            <input type="text" name="q_o3[]" placeholder="Option 3" required>
            <input type="text" name="q_o4[]" placeholder="Option 4" required>
        </div>
        <label>Réponse correcte (1-4) :</label>
        <input type="number" name="q_correct[]" min="1" max="4" value="1" style="width:50px">
    </div>`;
    document.getElementById('questionsContainer').insertAdjacentHTML('beforeend', html);
};

const modal = document.getElementById("quizModal");
document.getElementById("openQuizModal").onclick = () => modal.style.display = "block";
document.querySelector(".close-modal").onclick = () => modal.style.display = "none";
</script>
<?php include '../includes/footer.php'; ?>