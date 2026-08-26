<?php
$pageTitle  = 'My Cart';
$activePage = 'cart';
include __DIR__ . '/includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<section class="page-hero">
    <span class="eyebrow">Shopping Cart</span>
    <h1>Your Items</h1>
</section>

<section>
    <div class="container">
        <?php if (empty($cart)): ?>
            <div class="auth-card" style="text-align: center; max-width: 500px; margin: 0 auto;">
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any parts to your build yet.</p>
                <a href="index.php#featured" class="btn" style="margin-top: 15px;">Shop Now</a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-wrap: wrap; gap: 30px;">
                <!-- Cart Items -->
                <div style="flex: 2; min-width: 300px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <tr style="border-bottom: 2px solid #333; text-align: left;">
                            <th style="padding: 10px;">Product</th>
                            <th style="padding: 10px;">Price</th>
                            <th style="padding: 10px;">Qty</th>
                            <th style="padding: 10px;">Subtotal</th>
                            <th style="padding: 10px;"></th>
                        </tr>
                        <?php foreach ($cart as $id => $item): ?>
                            <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="" style="width: 60px; border-radius: 4px;">
                                    <strong><?= htmlspecialchars($item['name']) ?></strong>
                                </td>
                                <td style="padding: 15px;">₱<?= number_format($item['price'], 2) ?></td>
                                <td style="padding: 15px;"><?= $item['quantity'] ?></td>
                                <td style="padding: 15px; color: #ff3333; font-weight: bold;">₱<?= number_format($subtotal, 2) ?></td>
                                <td style="padding: 15px;">
                                    <form action="cart_action.php" method="POST">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                                        <button type="submit" style="background: none; border: none; color: #666; text-decoration: underline; cursor: pointer;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <!-- Checkout Summary -->
                <div style="flex: 1; min-width: 250px; background: #f9f9f9; padding: 25px; border-radius: 8px; height: fit-content; border: 1px solid #ddd;">
                    <h3>Order Summary</h3>
                    <div style="display: flex; justify-content: space-between; margin: 15px 0; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                        <span>Total:</span>
                        <span style="font-size: 1.5rem; color: #ff3333; font-weight: bold;">₱<?= number_format($total, 2) ?></span>
                    </div>
                    <a href="checkout.php" class="btn" style="display: block; width: 100%; text-align: center;">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>