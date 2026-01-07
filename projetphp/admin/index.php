<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../classes/User.php';
require_once '../classes/Category.php';
require_once '../classes/Product.php';

$stats = getProductStats($pdo);
$total_users = count(getAllUsers($pdo));
$total_categories = count(getAllCategories($pdo));
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Tableau de Bord Administrateur</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $stats['total_products'] ?? 0; ?></h3>
            <p>Produits</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total_categories; ?></h3>
            <p>Catégories</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total_users; ?></h3>
            <p>Utilisateurs</p>
        </div>
        <div class="stat-card">
            <h3><?php echo number_format($stats['avg_price'] ?? 0, 2); ?> FCFA</h3>
            <p>Prix moyen</p>
        </div>
    </div>

    <div class="admin-actions">
        <h3>Vous pouvez: </h3>
        <div class="action-buttons">
            <a href="../categories/liste.php" class="button">Gérer les catégories</a>
            <a href="../produits/liste.php" class="button">Gérer les produits</a>
            <a href="users.php" class="button">Gérer les utilisateurs</a>
            <a href="../produits/public.php" class="button">Voir le catalogue public</a>
        </div>
    </div>
</div>
<?php
require_once '../footer.php';
