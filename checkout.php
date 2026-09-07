<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin('login.php');

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact  = trim($_POST['contact_number'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $city     = trim($_POST['city'] ?? '');
    $barangay = trim($_POST['barangay'] ?? '');
    $postal   = trim($_POST['postal'] ?? '');
    $street   = trim($_POST['street'] ?? '');

    // Validate Philippine phone number (11 digits, starts with 09)
    if (!preg_match('/^09[0-9]{9}$/', $contact)) {
        $error = "Please enter a valid 11-digit Philippine mobile number starting with 09 (e.g., 09123456789).";
    } 
    elseif (empty($province) || empty($city) || empty($barangay) || empty($street)) {
        $error = "Please fill in all required address fields.";
    } 
    else {
        // Combine into a single Shopee-style address string for the database
        $fullAddress = $street . ', Brgy. ' . $barangay . ', ' . $city . ', ' . $province . ' ' . $postal;
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_amount, shipping_address, contact_number, status) VALUES (?, ?, ?, ?, "pending")');
        $stmt->execute([$_SESSION['user_id'], $total, $fullAddress, $contact]);
        $orderId = $pdo->lastInsertId();

        $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)');
        foreach ($cart as $id => $item) {
            $itemStmt->execute([$orderId, $id, $item['name'], $item['price'], $item['quantity']]);
        }

        unset($_SESSION['cart']); 
        $success = true;
    }
}

$pageTitle = 'Checkout';
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
                <p>Thank you for shopping with RS8. Your items will be delivered soon.</p>
                <a href="dashboard.php" class="btn" style="margin-top: 20px;">Track Order in Dashboard</a>
            </div>
        <?php else: ?>
            <div class="auth-card" style="max-width: 600px; margin: 0 auto;">
                <h3>Delivery Details</h3>
                <?php if ($error): ?>
                    <p class="form-message form-error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <form method="POST">
                    
                    <div class="field">
                        <label>Phone Number</label>
                        <input type="text" name="contact_number" required pattern="09[0-9]{9}" inputmode="numeric" maxlength="11" placeholder="09XXXXXXXXX (11 digits)" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="field" style="flex: 1;">
                            <label>Province</label>
                            <input type="text" name="province" required placeholder="e.g., Metro Manila">
                        </div>
                        <div class="field" style="flex: 1;">
                            <label>City / Municipality</label>
                            <input type="text" name="city" required placeholder="e.g., Quezon City">
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="field" style="flex: 1;">
                            <label>Barangay</label>
                            <input type="text" name="barangay" required placeholder="e.g., Brgy. San Antonio">
                        </div>
                        <div class="field" style="flex: 1;">
                            <label>Postal Code</label>
                            <input type="text" name="postal" inputmode="numeric" maxlength="4" placeholder="e.g., 1105" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>

                    <div class="field">
                        <label>Street Name, Building, House No.</label>
                        <textarea name="street" required placeholder="Street Name, Building, House No." style="height: 80px;"></textarea>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Confirm & Place Order (COD)</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>