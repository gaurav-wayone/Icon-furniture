<?php
require '../../inc/db.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the category to get the image path
    $stmt = $pdo->prepare("SELECT category_image FROM category WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Delete the image from the server
        $imagePath = "../../" . $category['category_image'];
        if (!empty($category['category_image']) && file_exists($imagePath)) {
            unlink($imagePath); // Remove the image file
        }

        // Delete the category from the database
        $deleteStmt = $pdo->prepare("DELETE FROM category WHERE id = ?");
        $deleteStmt->execute([$id]);

        header("Location: ../category.php?message=Category deleted successfully!");
        exit();
    } else {
        header("Location: ../category.php?error=Category not found!");
        exit();
    }
} else {
    header("Location: ../category.php?error=Invalid request!");
    exit();
}
?>
