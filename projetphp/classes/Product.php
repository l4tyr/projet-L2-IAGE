<?php

function createProduct($pdo, $name, $description, $prix, $quantite, $categorie_id)
{
    $stmt = $pdo->prepare("INSERT INTO produits (name, description, prix, quantite, categorie_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$name, $description, $prix, $quantite, $categorie_id]);
}

function getAllProducts($pdo)
{
    $stmt = $pdo->query("
        SELECT p.*, c.name AS categorie_name
        FROM produits p
        LEFT JOIN categories c ON p.categorie_id = c.id
        ORDER BY p.name
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($pdo, $id)
{
    $stmt = $pdo->prepare("
        SELECT p.*, c.name AS categorie_name
        FROM produits p
        LEFT JOIN categories c ON p.categorie_id = c.id
        WHERE p.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getProductsByCategory($pdo, $categorie_id)
{
    $stmt = $pdo->prepare("
        SELECT p.*, c.name AS categorie_name
        FROM produits p
        LEFT JOIN categories c ON p.categorie_id = c.id
        WHERE p.categorie_id = ?
        ORDER BY p.name
    ");
    $stmt->execute([$categorie_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateProduct($pdo, $id, $name, $description, $prix, $quantite, $categorie_id)
{
    $stmt = $pdo->prepare("
        UPDATE produits 
        SET name = ?, description = ?, prix = ?, quantite = ?, categorie_id = ?, updated_at = CURRENT_TIMESTAMP 
        WHERE id = ?
    ");
    return $stmt->execute([$name, $description, $prix, $quantite, $categorie_id, $id]);
}

function deleteProduct($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    return $stmt->execute([$id]);
}

function getProductStats($pdo)
{
    $stmt = $pdo->query("
        SELECT COUNT(*) AS total_products, SUM(quantite) AS total_quantity, AVG(prix) AS avg_price 
        FROM produits
    ");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
