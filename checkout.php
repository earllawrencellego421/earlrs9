<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

// Force login to checkout
requireLogin('login.php');

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Insert into orders table
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, "pending")');
        $stmt->execute([$_SESSION['user_id'], $total]);
        $orderId = $pdo->lastInsertId();

        // 2. Insert into order_items table
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)');
        foreach ($cart as $id => $item) {
            $stmt->execute([$orderId, $id, $item['name'], $item['price'], $item['quantity']]);
        }

        $pdo->commit();
        unset($_SESSION['cart']); 
        $success = true;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Something went wrong processing your order.";
    }
}

$pageTitle  = 'Checkout';
$activePage = 'checkout';
include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <span class="eyebrow">Checkout</span>
    <h1>Finalize Order</h1>
</section>

<section>
    <div class="container">
        <?php if ($success): ?>
            <div class="auth-card" style="text-align: center; max-width: 600px; margin: 0 auto;">
                <h2>Order Placed Successfully!</h2>
                <p>Thank you for shopping with RS8. Your parts are being prepared.</p>
                <a href="dashboard.php" class="btn" style="margin-top: 20px;">Go to Dashboard</a>
            </div>
        <?php else: ?>
            <div class="auth-card" style="max-width: 600px; margin: 0 auto;">
                <h3>Confirm your details</h3>
                <?php if ($error): ?>
                    <p class="form-message form-error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                
                <p>Billing Account: <strong><?= htmlspecialchars(currentUsername()) ?></strong></p>
                
                <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
                
                <form method="POST">
                    <button type="submit" class="btn" style="width: 100%;">Place Order (Cash on Delivery)</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>