<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../procedural/category.php'; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name) || empty($description)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            if (createCategory($pdo, $name, $description)) { 
                header('Location: liste.php?created=1');
                exit;
            } else {
                $errorInfo = $pdo->errorInfo();
                $error = "Erreur SQL : " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            $error = "Exception : " . $e->getMessage();
        }
    }
}
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Ajouter une Catégorie</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
<?php require_once '../footer.php'; ?>
