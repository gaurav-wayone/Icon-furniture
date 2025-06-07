<?php
session_start();
require_once 'db.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $payment_method = $_POST['payment_method'] ?? '';
    $payment_details = json_encode($_POST); // Save additional payment details as JSON

    if (empty($payment_method)) {
        echo json_encode(['status' => 'error', 'message' => 'Payment method is required.']);
        exit;
    }

    try {
        // Check if any payment method already exists for the user
        $stmt = $pdo->prepare("SELECT * FROM payment_method WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $existingPayment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingPayment) {
            // Update the existing payment method and details
            $updateStmt = $pdo->prepare("UPDATE payment_method SET method_name = :method_name, payment_details = :payment_details, updated_at = NOW() WHERE user_id = :user_id");
            $updateStmt->execute([
                ':method_name' => $payment_method,
                ':payment_details' => $payment_details,
                ':user_id' => $user_id
            ]);
            echo json_encode(['status' => 'success']);
        } else {
            // Insert new payment method if none exists
            $insertStmt = $pdo->prepare("INSERT INTO payment_method (user_id, method_name, payment_details, created_at) VALUES (:user_id, :method_name, :payment_details, NOW())");
            $insertStmt->execute([
                ':user_id' => $user_id,
                ':method_name' => $payment_method,
                ':payment_details' => $payment_details
            ]);
            echo json_encode(['status' => 'success']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
