<?php
require_once '../db.php';
$pdo = getPDO();
require_once '../classes/User.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (loginUser($pdo, $username, $password)) { 
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Connexion</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">S'inscrire</a></p>
</div>
<?php require_once '../footer.php'; ?>
