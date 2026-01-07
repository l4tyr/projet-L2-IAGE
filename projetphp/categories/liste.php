<?php
session_start();
require_once '../db.php';
require_once '../classes/Category.php';

$categories = getAllCategories($pdo);
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Liste des Catégories</h2>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="ajouter.php" class="button">Ajouter une catégorie</a><br><br>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Nombre de produits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cat['id']); ?></td>
                    <td><?php echo htmlspecialchars($cat['name']); ?></td>
                    <td><?php echo htmlspecialchars($cat['description']); ?></td>
                    <td><?php echo htmlspecialchars($cat['product_count']); ?></td>
                    <td>
                        <a href="../produits/liste.php?categorie_id=<?php echo $cat['id']; ?>" class="button">Voir produits</a><br><br>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="modifier.php?id=<?php echo $cat['id']; ?>" class="button">Modifier</a><br><br>
                            <a href="supprimer.php?id=<?php echo $cat['id']; ?>" class="button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">Supprimer</a> <br>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
require_once '../footer.php';
