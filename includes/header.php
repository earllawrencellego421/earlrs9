<?php
require_once __DIR__ . '/auth.php';

$assetPath  = $assetPath  ?? '';   
$pageTitle  = $pageTitle  ?? 'RS8 Racing';
$activePage = $activePage ?? '';

function navClass(string $page, string $active): string
{
    return $page === $active ? ' class="active"' : '';
}

$cartCount = 0;
if (isset($_SESSION['cart'])) {
    $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?> | RS8 Racing</title>
<link rel="icon" type="image/webp" href="<?= $assetPath ?>images/rs8icon.webp">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $assetPath ?>css/style.css">
</head>
<body>

<header class="site-header">
    <a href="<?= $assetPath ?>index.php" class="logo"><img src="<?= $assetPath ?>images/rs8logo.webp" alt="RS8 Racing Logo"></a>
    <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
    <nav>
        <ul>
            <li><a href="<?= $assetPath ?>index.php"<?= navClass('home', $activePage) ?>>Home</a></li>
            <li><a href="<?= $assetPath ?>about.php"<?= navClass('about', $activePage) ?>>About Us</a></li>
            <li><a href="<?= $assetPath ?>contact.php"<?= navClass('contact', $activePage) ?>>Contact</a></li>
            <li><a href="<?= $assetPath ?>cart.php"<?= navClass('cart', $activePage) ?>>Cart (<span id="cart-counter"><?= $cartCount ?></span>)</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="<?= $assetPath ?>dashboard.php"<?= navClass('dashboard', $activePage) ?>><?= htmlspecialchars(currentUsername()) ?></a></li>
                <?php if (isAdmin()): ?>
                    <li><a href="<?= $assetPath ?>admin/dashboard.php"<?= navClass('admin', $activePage) ?>>Admin</a></li>
                <?php endif; ?>
                <li><a href="<?= $assetPath ?>logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= $assetPath ?>login.php"<?= navClass('login', $activePage) ?>>Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="hazard-rule"></div>
<main>