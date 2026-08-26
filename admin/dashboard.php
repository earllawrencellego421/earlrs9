<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin('../login.php');

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$_POST['status'], (int)$_POST['order_id']]);
}

$orders   = $pdo->query('SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC')->fetchAll();
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

<!-- ORDERS TABLE -->
<section>
    <div class="container">
        <div class="section-title" style="text-align:left; margin-bottom:24px;">
            <h2 style="font-size:24px;">Store Orders (<?= count($orders) ?>)</h2>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if (!$orders): ?>
                    <tr><td colspan="6">No orders yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>#<?= (int) $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['username']) ?></td>
                        <td>₱<?= number_format($o['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($o['status']) ?></td>
                        <td><?= htmlspecialchars($o['created_at']) ?></td>
                        <td>
                            <form method="POST" style="display:flex; gap:5px;">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <select name="status">
                                    <option value="pending" <?= $o['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="completed" <?= $o['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn" style="padding: 2px 5px; font-size: 12px;">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- REGISTERED USERS TABLE -->
<section class="feature-strip">
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

<!-- CONTACT MESSAGES TABLE -->
<section>
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