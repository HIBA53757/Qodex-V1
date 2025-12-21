<?php
 //connection
require_once '../config/database.php';


session_start(); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
     
        $stmt = mysqli_prepare($conn, "SELECT id_user, nom_user, password_hash, role FROM USERS WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id_user, $nom_user, $hashedPassword, $role);
            mysqli_stmt_fetch($stmt);

           
            if (password_verify($password, $hashedPassword)) {
                   $_SESSION['id_user'] = $id_user;
                $_SESSION['nom_user'] = $nom_user;
                $_SESSION['role'] = $role;
                header("Location:  http://localhost/Qodex_v1/enseignant/dashboard.php");
                exit();
            } else {
                $message = "Mot de passe incorrect.";
            }
        } else {
            $message = "Email non enregistré.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<?php
$page_title = 'Connexion';
$auth_page = true; 
include '../includes/header.php';
?>

<div class="auth-container">
    <h2>Connexion</h2>

    <?php if(isset($message)) : ?>
        <p style="color:red; text-align:center; margin-bottom:15px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fa-solid fa-lock"></i> Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Se Connecter</button>
        </div>
    </form>
    <p class="link-text">Pas encore de compte ? <a href="register.php">S'inscrire ici</a></p>
</div>

<?php include '../includes/footer.php'; ?>
