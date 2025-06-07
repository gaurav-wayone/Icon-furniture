<?php
require '../../inc/db.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the subcategory exists
    $stmt = $pdo->prepare("SELECT * FROM subcategory WHERE id = ?");
    $stmt->execute([$id]);
    $subcategory = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($subcategory) {
        // Delete the subcategory from the database
        $deleteStmt = $pdo->prepare("DELETE FROM subcategory WHERE id = ?");
        $deleteStmt->execute([$id]);

        header("Location: ../sub-category.php?message=Subcategory deleted successfully!");
        exit();
    } else {
        header("Location: ../sub-category.php?error=Subcategory not found!");
        exit();
    }
} else {
    header("Location: ../sub-category.php?error=Invalid request!");
    exit();
}
?>