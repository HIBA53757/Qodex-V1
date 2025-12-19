<?php
require_once '../config/database.php';
session_start();

// SECURITY CHECK
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'enseignant') {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

// --- 1. ACTION: ADD CATEGORY ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = htmlspecialchars($_POST['name']);
    $desc = htmlspecialchars($_POST['description']);
    
    $stmt = mysqli_prepare($conn, "INSERT INTO CATEGORY (nom_category, description_category, created_by, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $desc, $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: manage_categories.php"); 
    exit();
}

// --- 2. ACTION: DELETE CATEGORY ---
if (isset($_GET['delete_cat_id'])) {
    $id_to_delete = (int)$_GET['delete_cat_id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM CATEGORY WHERE id_category = ? AND created_by = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id_to_delete, $user_id);
    mysqli_stmt_execute($stmt);
    header("Location: manage_categories.php");
    exit();
}

// --- 3. DATA FETCHING ---
$categories_query = mysqli_query($conn, "SELECT * FROM CATEGORY");

$page_title = 'Gestion des Catégories';
include '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>Gestion des Catégories</h1>
        <p>Organisez vos quiz par catégories</p>
    </div>
    <button class="btn-primary" id="openModalBtn">
        <i class="fa-solid fa-plus"></i> Nouvelle Catégorie
    </button>
</div>

<section class="category-grid">
    <?php while($cat = mysqli_fetch_assoc($categories_query)): ?>
    <div class="category-card">
        <div class="card-header">
            <span class="category-title"><?php echo htmlspecialchars($cat['nom_category']); ?></span>
            <div class="card-actions">
                <a href="?delete_cat_id=<?php echo $cat['id_category']; ?>" 
                   class="icon-btn delete-btn" 
                   onclick="return confirm('Supprimer cette catégorie ?');">
                    <i class="fa-solid fa-trash-can"></i>
                </a>
            </div>
        </div>
        <p class="category-description"><?php echo htmlspecialchars($cat['description_category']); ?></p>
        <div class="category-stats">
            <span><i class="fa-solid fa-clock"></i> Créé le <?php echo date('d/m/Y', strtotime($cat['created_at'])); ?></span>
        </div>
    </div>
    <?php endwhile; ?>
</section>

<div id="categoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nouvelle Catégorie</h2>
            <span class="close-modal">&times;</span>
        </div>
        <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="cat_name">Nom de la catégorie</label>
                    <input type="text" id="cat_name" name="name" placeholder="Ex: PHP & MySQL" required>
                </div>
                <div class="form-group">
                    <label for="cat_desc">Description</label>
                    <textarea id="cat_desc" name="description" rows="3" placeholder="Brève description..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelBtn">Annuler</button>
                <button type="submit" name="add_category" class="btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
// Le script JS reste identique
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("categoryModal");
    const openBtn = document.getElementById("openModalBtn"); 
    const closeBtn = document.querySelector(".close-modal");
    const cancelBtn = document.getElementById("cancelBtn");

    if (openBtn && modal) {
        openBtn.onclick = () => modal.style.display = "block";
        const closeModal = () => modal.style.display = "none";
        if (closeBtn) closeBtn.onclick = closeModal;
        if (cancelBtn) cancelBtn.onclick = closeModal;
        window.onclick = (event) => { if (event.target == modal) closeModal(); }
    }
});
</script>