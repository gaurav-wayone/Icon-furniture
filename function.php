<?php
session_start();
include ('inc/db.php');


// Slugify function
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text ?: 'n-a';
}



include 'function.php'; // If slugify is in a separate file

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $correctSlug = slugify($product['product_name']);
        if ($_GET['name'] !== $correctSlug) {
            header("Location: sub-category.php?id={$product['id']}&name={$correctSlug}");
            exit;
        }
    }
}
?>
