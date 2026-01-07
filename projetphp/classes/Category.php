<?php

function createCategory($pdo, $name, $description) {
    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    return $stmt->execute([$name, $description]);
}

function getAllCategories($pdo) {
    $stmt = $pdo->query("
        SELECT c.*, COUNT(p.id) AS product_count
        FROM categories c
        LEFT JOIN produits p ON c.id = p.categorie_id
        GROUP BY c.id
        ORDER BY c.name
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateCategory($pdo, $id, $name, $description) {
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, description = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $stmt->execute([$name, $description, $id]);
}

function deleteCategory($pdo, $id) {
    // Vérifie s'il existe des produits liés
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produits WHERE categorie_id = ?");
    $stmt->execute([$id]);
    if ($stmt->fetchColumn() > 0) {
        return false; // impossible de supprimer
    }
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}
