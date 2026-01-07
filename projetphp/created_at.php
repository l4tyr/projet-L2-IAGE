<?php
require_once 'db.php';

try {
    $stmt = $pdo->prepare("UPDATE utilisateur SET created_at = CURRENT_TIMESTAMP WHERE created_at IS NULL");
    $stmt->execute();

    echo "Mise à jour terminée : les utilisateurs existants ont maintenant une date d'inscription.";
} catch (PDOException $e) {
    echo "Erreur lors de la mise à jour : " . htmlspecialchars($e->getMessage());
}
