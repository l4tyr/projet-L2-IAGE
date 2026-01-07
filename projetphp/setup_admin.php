<?php
require_once 'db.php';
require_once 'procedural/user.php'; 


$stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE username = ?");
$stmt->execute(['admin']);
$existingAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingAdmin) {
    echo "<h2>Compte Admin Déjà existant</h2>";
    echo "<p>Un compte administrateur existe déjà avec le nom d'utilisateur 'admin'.</p>";
    echo "<p><a href='auth/login.php'>Se connecter</a></p>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_admin'])) {
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE username = ?");
        $stmt->execute(['admin']);
        echo "<h2>Compte Admin Supprimé avec Succès !</h2>";
        echo "<p>Le compte administrateur a été supprimé. Vous pouvez maintenant le recréer si nécessaire.</p>";
        echo "<p><a href='setup_admin.php'>Recharger la page</a></p>";
        exit;
    }

    echo "<h3>Supprimer le Compte Admin</h3>";
    echo "<form method='POST' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer le compte admin ?\");'>";
    echo "<button type='submit' name='delete_admin' style='background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>Supprimer le Compte Admin</button>";
    echo "</form>";

} else {
    $result = registerUser($pdo, 'admin', 'admin@gmail.com', 'admin123');

    if ($result) {
        $stmt = $pdo->prepare("UPDATE utilisateur SET role = 'admin' WHERE username = 'admin'");
        $stmt->execute();

        echo "<h2>Compte Admin Créé avec Succès !</h2>";
        echo "<div style='background: #e8f5e8; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>Identifiants de Connexion :</h3>";
        echo "<p><strong>Nom d'utilisateur :</strong> admin</p>";
        echo "<p><strong>Mot de passe :</strong> admin123</p>";
        echo "<p><strong>Email :</strong> admin@gmail.com</p>";
        echo "</div>";
        echo "<p><a href='auth/login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Se Connecter en Admin</a></p>";
    } else {
        echo "<h2>Erreur lors de la Création du Compte</h2>";
        echo "<p>Une erreur s'est produite. Vérifiez la configuration de la base de données.</p>";
    }
}
