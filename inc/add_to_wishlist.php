<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id']) && isset($_GET['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];

    // Check if the product is already in the wishlist
    $checkStmt = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $checkStmt->execute([$user_id, $product_id]);

    if ($checkStmt->rowCount() == 0) {
        // Add to wishlist
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        if ($stmt->execute([$user_id, $product_id])) {
            $_SESSION['message'] = "Product added to wishlist!";
        } else {
            $_SESSION['message'] = "Failed to add to wishlist.";
        }
    } else {
        $_SESSION['message'] = "Product already in wishlist!";
    }
} else {
    $_SESSION['message'] = "Please log in to add products to your wishlist.";
}

header("Location: ../user-panel/wishlist.php"); // Redirect back to the products page
exit();
?>
