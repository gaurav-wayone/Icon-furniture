<?php
session_start();
include 'db.php';

// Function to generate unique Order ID
function generateOrderId($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return '#' . rand(10, 99) . $randomString; // Example: #28VR5K59
}

if (isset($_POST['checkout'])) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['cart'])) {
        $user_id = $_SESSION['user_id'];
        $cart = $_SESSION['cart'];

        $total_amount = 0;
        $products = [];

        foreach ($cart as $item) {
            $product_name = $item['product_name'];
            $product_quantity = $item['quantity'];
            $product_price = $item['price'];
            $product_subtotal = $product_price * $product_quantity;

            $total_amount += $product_subtotal;

            $products[] = [
                'product_name' => $product_name,
                'quantity' => $product_quantity,
                'price' => $product_price,
                'subtotal' => $product_subtotal
            ];
        }

        // Generate Order ID
        $order_id = generateOrderId();

        // Convert products array to JSON
        $products_json = json_encode($products);

        // Insert the order into the database
        $stmt = $pdo->prepare("INSERT INTO orders (order_id, user_id, products, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $user_id, $products_json, $total_amount]);

        // Clear cart after checkout
        unset($_SESSION['cart']);
        $_SESSION['message'] = "Checkout successful! Your Order ID is: $order_id";
        header("Location: ../checkout.php");
        exit();
    } else {
        $_SESSION['message'] = "No items in the cart or user not logged in.";
        header("Location: cart.php");
        exit();
    }
}
?>
