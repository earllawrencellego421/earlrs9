<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin('login.php');

// Admins land here too if they navigate to it directly — send them to their own panel.
if (isAdmin()) {
    header('Location: admin/dashboard.php');
    exit;
}

$pageTitle  = 'My Account';
$activePage = 'dashboard';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">My Account</span>
    <h1>Welcome, <?= htmlspecialchars(currentUsername()) ?></h1>
    <p>This is your RS8 account dashboard.</p>
</section>

<section>
    <div class="container">
        <div class="value-card" style="max-width:480px;">
            <span class="num">Status</span>
            <h3>Account active</h3>
            <p>Order history and saved builds will show up here as we add store features.</p>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
