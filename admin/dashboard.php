<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin('../login.php');

$users    = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$messages = $pdo->query('SELECT id, name, email, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC')->fetchAll();

$assetPath  = '../';
$pageTitle  = 'Admin Dashboard';
$activePage = 'admin';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">Admin</span>
    <h1>Dashboard</h1>
    <p>Signed in as <?= htmlspecialchars(currentUsername()) ?></p>
</section>

<section>
    <div class="container">
        <div class="section-title" style="text-align:left; margin-bottom:24px;">
            <h2 style="font-size:24px;">Registered Users (<?= count($users) ?>)</h2>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Joined</th></tr>
                </thead>
                <tbody>
                <?php if (!$users): ?>
                    <tr><td colspan="5">No users yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int) $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="role-badge role-<?= htmlspecialchars($u['role']) ?>"><?= htmlspecialchars($u['role']) ?></span></td>
                        <td><?= htmlspecialchars($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="feature-strip">
    <div class="container">
        <div class="section-title" style="text-align:left; margin-bottom:24px;">
            <h2 style="font-size:24px;">Contact Messages (<?= count($messages) ?>)</h2>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Message</th><th>Sent</th></tr>
                </thead>
                <tbody>
                <?php if (!$messages): ?>
                    <tr><td colspan="4">No messages yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($messages as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                        <td><?= htmlspecialchars($m['submitted_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
