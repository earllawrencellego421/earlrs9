<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin('../login.php');

$message_alert = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_order') {
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$_POST['status'], (int)$_POST['order_id']]);
        $message_alert = 'Order #' . (int)$_POST['order_id'] . ' status updated!';
    } elseif ($action === 'delete_order') {
        $stmt = $pdo->prepare('DELETE FROM orders WHERE id = ?');
        $stmt->execute([(int)$_POST['order_id']]);
        $message_alert = 'Order deleted permanently.';
    } elseif ($action === 'delete_user') {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ? AND role != "admin"');
        $stmt->execute([(int)$_POST['user_id']]);
        $message_alert = 'Customer account deleted.';
    } elseif ($action === 'delete_message') {
        $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = ?');
        $stmt->execute([(int)$_POST['message_id']]);
        $message_alert = 'Contact message deleted.';
    }
}

$orders   = $pdo->query('SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC')->fetchAll();
$users    = $pdo->query('SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$messages = $pdo->query('SELECT id, name, email, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC')->fetchAll();

$stmtItems = $pdo->query('SELECT order_id, product_name, quantity FROM order_items');
$itemsByOrder = [];
while ($row = $stmtItems->fetch()) {
    $itemsByOrder[$row['order_id']][] = $row;
}

$assetPath  = '../';
$pageTitle  = 'Admin Dashboard';
$activePage = 'admin';
include __DIR__ . '/../includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">Admin</span>
    <h1>Dashboard</h1>
    <p>Signed in as <?= htmlspecialchars(currentUsername()) ?>. You have full control over customer data.</p>
</section>

<?php if ($message_alert): ?>
    <div class="container" style="margin-top: 20px;">
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; border: 1px solid #c3e6cb;">
            <strong>Success:</strong> <?= htmlspecialchars($message_alert) ?>
        </div>
    </div>
<?php endif; ?>

<section>
    <div class="container">
        <div class="section-title" style="text-align:left; margin-bottom:24px; margin-top:20px;">
            <h2 style="font-size:24px;">Store Orders (<?= count($orders) ?>)</h2>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>Order Info</th><th>Delivery Details</th><th>Items Ordered</th><th>Total / Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if (!$orders): ?>
                    <tr><td colspan="5">No orders yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td style="font-size: 0.9rem;">
                            <strong>#<?= (int) $o['id'] ?></strong><br>
                            <?= htmlspecialchars($o['username']) ?><br>
                            <span style="color: #666; font-size: 0.8rem;"><?= htmlspecialchars($o['created_at']) ?></span>
                        </td>
                        <td style="font-size: 0.9rem;">
                            <strong>Tel:</strong> <?= htmlspecialchars($o['contact_number']) ?><br>
                            <strong>To:</strong> <?= htmlspecialchars($o['shipping_address']) ?>
                        </td>
                        <td>
                            <ul style="margin: 0; padding-left: 15px; font-size: 0.85rem;">
                                <?php if(isset($itemsByOrder[$o['id']])): ?>
                                    <?php foreach($itemsByOrder[$o['id']] as $item): ?>
                                        <li><?= $item['quantity'] ?>x <?= htmlspecialchars($item['product_name']) ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td>
                            <span style="font-weight: bold; color: #ff3333;">₱<?= number_format($o['total_amount'], 2) ?></span><br>
                            <span style="font-size: 0.85rem; text-transform: uppercase;"><?= htmlspecialchars($o['status']) ?></span>
                        </td>
                        <td>
                            <form method="POST" style="display:flex; flex-direction: column; gap:5px;">
                                <input type="hidden" name="action" value="update_order">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <select name="status" style="padding: 2px;">
                                    <option value="pending" <?= $o['status'] === 'pending' ? 'selected' : '' ?>>Pending (Placed)</option>
                                    <option value="processing" <?= $o['status'] === 'processing' ? 'selected' : '' ?>>Processing (Preparing)</option>
                                    <option value="shipped" <?= $o['status'] === 'shipped' ? 'selected' : '' ?>>Shipped (In Transit)</option>
                                    <option value="completed" <?= $o['status'] === 'completed' ? 'selected' : '' ?>>Completed (Delivered)</option>
                                    <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn" style="padding: 2px 5px; font-size: 12px;">Save Status</button>
                            </form>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this order entirely?');" style="margin-top: 5px;">
                                <input type="hidden" name="action" value="delete_order">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <button type="submit" class="btn" style="background: #dc3545; width: 100%; padding: 2px 5px; font-size: 12px;">Delete</button>
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
            <h2 style="font-size:24px;">Registered Customers (<?= count($users) ?>)</h2>
        </div>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Joined</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if (!$users): ?>
                    <tr><td colspan="6">No users yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int) $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="role-badge role-<?= htmlspecialchars($u['role']) ?>"><?= htmlspecialchars($u['role']) ?></span></td>
                        <td><?= htmlspecialchars($u['created_at']) ?></td>
                        <td>
                            <?php if ($u['role'] !== 'admin'): ?>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                <button type="submit" class="btn" style="background: #dc3545; padding: 2px 8px; font-size: 12px;">Delete</button>
                            </form>
                            <?php else: ?>
                                <span style="font-size: 12px; color: #888;">Admin (Locked)</span>
                            <?php endif; ?>
                        </td>
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
                    <tr><th>Name</th><th>Email</th><th>Message</th><th>Sent</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php if (!$messages): ?>
                    <tr><td colspan="5">No messages yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($messages as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                        <td><?= htmlspecialchars($m['submitted_at']) ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Delete this message?');">
                                <input type="hidden" name="action" value="delete_message">
                                <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn" style="background: #6c757d; padding: 2px 8px; font-size: 12px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>