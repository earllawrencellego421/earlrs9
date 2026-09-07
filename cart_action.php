<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        if (!isLoggedIn()) {
            echo json_encode(['status' => 'unauthorized']);
            exit;
        }

        $id       = $_POST['id'] ?? '';
        $name     = $_POST['name'] ?? '';
        $price    = (float)($_POST['price'] ?? 0);
        $image    = $_POST['image'] ?? '';
        
        // Safely capture the quantity sent from the Javascript popup
        $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'name'     => $name, 
                'price'    => $price, 
                'image'    => $image, 
                'quantity' => $quantity
            ];
        }
        
        $totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
        echo json_encode(['status' => 'success', 'totalItems' => $totalItems]);
        exit;
    }
    
    if ($action === 'remove') {
        $id = $_POST['id'] ?? '';
        if (isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
        header("Location: cart.php");
        exit;
    }
}
echo json_encode(['status' => 'error']);