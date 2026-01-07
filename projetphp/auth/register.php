<?php
session_start();
require_once '../db.php';
require_once '../classes/User.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } elseif (registerUser($pdo, $username, $email, $password)) {
        header('Location: login.php?success=1');
        exit;
    } else {
        $error = "Erreur lors de l'inscription";
    }
}
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Inscription</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Inscription réussie! Vous pouvez maintenant vous connecter.</p>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <div>
            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit? <a href="login.php">Se connecter</a></p>
</div>
<?php
require_once '../footer.php';
