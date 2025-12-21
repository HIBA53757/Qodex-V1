<?php
 //connection
require_once '../config/database.php';
session_start(); 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    

  
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

   
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
       
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "Email déjà enregistré. Veuillez vous connecter.";
        } else {
          
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nom_user, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPassword, $role);


            if (mysqli_stmt_execute($stmt)) {
              
                header("Location: login.php");
                exit();
            } else {
                $message = "Erreur lors de l'inscription. Veuillez réessayer.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<?php
$page_title = 'Inscription';
$auth_page = true;
include '../includes/header.php';
?>

<div class="auth-container">
    <h2>Inscription</h2>

    <?php if(isset($message)) : ?>
        <p style="color:red; text-align:center; margin-bottom:15px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name"><i class="fa-solid fa-user"></i> Nom & Prénom</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Votre nom complet" required>
        </div>
        <div class="form-group">
            <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fa-solid fa-lock"></i> Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control"
                placeholder="Choisissez un mot de passe" required>
        </div>
        <div class="form-group">
            <label for="role"><i class="fa-solid fa-briefcase"></i> Rôle</label>
            <select id="role" name="role" class="form-select" required>
                <option value="">Sélectionner votre rôle</option>
                <option value="enseignant">Enseignant</option>
                <option value="etudiant">Étudiant</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">S'inscrire</button>
        </div>
    </form>
    <p class="link-text">Déjà un compte ? <a href="login.php">Connectez-vous</a></p>
</div>

<?php include '../includes/footer.php'; ?>
