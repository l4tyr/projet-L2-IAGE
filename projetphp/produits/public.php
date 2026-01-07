<?php
require_once '../db.php';
require_once '../classes/Product.php';
require_once '../classes/Category.php';

$filter_category = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : null;
$products = $filter_category ? getProductsByCategory($pdo, $filter_category) : getAllProducts($pdo);
$categories = getAllCategories($pdo);
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Catalogue des Produits</h2>

    <div style="margin: 20px 0;">
        <form method="get" style="display: inline;">
            <label for="categorie_id">Filtrer par catégorie:</label>
            <select id="categorie_id" name="categorie_id" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $filter_category == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="products-grid">
        <?php foreach ($products as $prod): ?>
            <div class="product-card">
                <h3><?php echo htmlspecialchars($prod['name']); ?></h3>
                <p class="description"><?php echo htmlspecialchars($prod['description']); ?></p>
                <p class="price"><?php echo htmlspecialchars($prod['prix']); ?> FCFA</p>
                <p class="quantity">Quantité disponible: <?php echo htmlspecialchars($prod['quantite']); ?></p>
                <p class="category">Catégorie: <?php echo htmlspecialchars($prod['categorie_name']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
require_once '../footer.php';
