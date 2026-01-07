
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet PHP </title>
    <link rel="stylesheet" href="/devweb/projetphp/style-basique.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1>Projet PHP</h1>
        <nav>
            <a href="/devweb/projetphp/index.php">Accueil</a>
            <a href="/devweb/projetphp/categories/liste.php">Catégories</a>
            <a href="/devweb/projetphp/produits/public.php">Produits</a>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/devweb/projetphp/admin/index.php">Tableau de bord</a>
            <?php endif; ?>
        </nav>
        <br>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="welcome-msg">Bonjour, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                <a href="/devweb/projetphp/auth/logout.php" class="button connexion-btn">Déconnexion</a>
            <?php else: ?>
                <a href="/devweb/projetphp/auth/login.php" class="button connexion-btn">Connexion</a>
                <a href="/devweb/projetphp/auth/register.php" class="button inscription-btn">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main class="container">
 