<?php
require '../../inc/db.php';

if (isset($_GET['category_id'])) {
    $stmt = $pdo->prepare("SELECT subcategory_name, slug FROM subcategory WHERE category_id = ?");
    $stmt->execute([$_GET['category_id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
