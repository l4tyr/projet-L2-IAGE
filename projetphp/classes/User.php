<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function registerUser($pdo, $username, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO utilisateur (username, email, password, created_at) 
        VALUES (?, ?, ?, CURRENT_TIMESTAMP)
    ");
    return $stmt->execute([$username, $email, $hashedPassword]);
}

function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

function getAllUsers($pdo) {
    $stmt = $pdo->query("
        SELECT id, username, email, role, created_at 
        FROM utilisateur 
        ORDER BY created_at DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT id, username, email, role, created_at 
        FROM utilisateur 
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserRole($pdo, $id, $role) {
    $stmt = $pdo->prepare("UPDATE utilisateur SET role = ? WHERE id = ?");
    return $stmt->execute([$role, $id]);
}
