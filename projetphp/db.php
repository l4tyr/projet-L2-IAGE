<?php
function getPDO() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=localhost;dbname=projetphp;charset=utf8mb4';
        $dbUser = 'root';
        $dbPass = '';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données: ' . htmlspecialchars($e->getMessage()));
        }
    }
    return $pdo;
}

$pdo = getPDO();
