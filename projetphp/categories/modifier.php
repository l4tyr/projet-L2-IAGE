<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../classes/Category.php';

if (!isset($_GET['id'])) {
    header('Location: liste.php');
    exit;
}

$id = (int)$_GET['id'];
$cat = getCategoryById($pdo, $id);

if (!$cat) {
    header('Location: liste.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (updateCategory($pdo, $id, $name, $description)) {
        header('Location: liste.php?updated=1');
        exit;
    } else {
        $error = "Erreur lors de la modification de la catégorie";
    }
}
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Modifier la Catégorie</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($cat['description']); ?></textarea>
        </div>
        <button type="submit">Modifier</button>
    </form>
</div>
<?php
require_once '../footer.php';
