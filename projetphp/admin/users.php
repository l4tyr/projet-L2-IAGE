<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../classes/User.php';

$users = getAllUsers($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['role'])) {
    $user_id = (int)$_POST['user_id'];
    $role = $_POST['role'];
    if (updateUserRole($pdo, $user_id, $role)) {
        header('Location: users.php?updated=1');
        exit;
    } else {
        $error = "Erreur lors de la mise à jour du rôle";
    }
}
?>

<?php require_once '../header.php'; ?>
<div class="card">
    <h2>Gestion des Utilisateurs</h2>
    <a href="index.php" class="button">Retour au tableau de bord</a><br><br>
    <?php if (isset($_GET['updated'])): ?>
        <p style="color: green;">Rôle mis à jour avec succès!</p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['id']); ?></td>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['role']); ?></td>
                    <td><?php echo htmlspecialchars($u['created_at']); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                            <select name="role" onchange="this.form.submit()">
                                <option value="user" <?php echo $u['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                                <option value="admin" <?php echo $u['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
require_once '../footer.php';
