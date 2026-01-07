<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../procedural/product.php';  
require_once '../procedural/category.php';  

$error = '';

$categories = getAllCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $prix = (float)$_POST['prix'];
    $quantite = (int)$_POST['quantite'];
    $categorie_id = (int)$_POST['categorie_id'];

    if (empty($name) || empty($description) || $prix <= 0 || $quantite < 0 || $categorie_id <= 0) {
        $error = "Veuillez remplir tous les champs correctement.";
    } else {
        try {
            if (createProduct($pdo, $name, $description, $prix, $quantite, $categorie_id)) {
                header('Location: liste.php?added=1');
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
    <h2>Ajouter un Produit</h2>
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
        <div>
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" step="0.01" required>
        </div>
        <div>
            <label for="quantite">Quantité :</label>
            <input type="number" id="quantite" name="quantite" required>
        </div>
        <div>
            <label for="categorie_id">Catégorie :</label>
            <select id="categorie_id" name="categorie_id" required>
                <option value="">Sélectionner une catégorie</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
<?php require_once '../footer.php'; ?>
