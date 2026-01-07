<?php
session_start();
require_once '../db.php';
require_once '../classes/Product.php';
require_once '../classes/Category.php';

$filter_category = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : null;
$products = $filter_category ? getProductsByCategory($pdo, $filter_category) : getAllProducts($pdo);
$categories = getAllCategories($pdo);
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Liste des Produits</h2>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="ajouter.php" class="button">Ajouter un produit</a>
    <?php endif; ?>

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

    <?php if (isset($_GET['added'])): ?>
        <p style="color: green;">Produit ajouté avec succès!</p>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
        <p style="color: green;">Produit modifié avec succès!</p>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <p style="color: green;">Produit supprimé avec succès!</p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Une erreur s'est produite.</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $prod): ?>
                <tr>
                    <td><?php echo htmlspecialchars($prod['id']); ?></td>
                    <td><?php echo htmlspecialchars($prod['name']); ?></td>
                    <td><?php echo htmlspecialchars($prod['description']); ?></td>
                    <td><?php echo htmlspecialchars($prod['prix']); ?> FCFA</td>
                    <td><?php echo htmlspecialchars($prod['quantite']); ?></td>
                    <td><?php echo htmlspecialchars($prod['categorie_name']); ?></td>
                    <td>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="modifier.php?id=<?php echo $prod['id']; ?>" class="button">Modifier</a> <br><br>
                            <a href="supprimer.php?id=<?php echo $prod['id']; ?>" class="button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?')">Supprimer</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
require_once '../footer.php';
