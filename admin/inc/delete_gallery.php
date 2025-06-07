<?php
require '../../inc/db.php'; // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the category to get the image path
    $stmt = $pdo->prepare("SELECT gallery_image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Delete the image from the server
        $imagePath = "../../" . $category['gallery_image'];
        if (!empty($category['gallery_image']) && file_exists($imagePath)) {
            unlink($imagePath); // Remove the image file
        }

        // Delete the category from the database
        $deleteStmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $deleteStmt->execute([$id]);

        header("Location: ../gallery.php?message=gallery deleted successfully!");
        exit();
    } else {
        header("Location: ../gallery.php?error=gallery not found!");
        exit();
    }
} else {
    header("Location: ../gallery.php?error=Invalid request!");
    exit();
}
?>
