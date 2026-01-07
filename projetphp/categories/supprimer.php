<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

require_once '../db.php';
require_once '../classes/Category.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (deleteCategory($pdo, $id)) {
        header('Location: liste.php?deleted=1');
        exit;
    } else {
        header('Location: liste.php?error=1');
        exit;
    }
} else {
    header('Location: liste.php');
    exit;
}
