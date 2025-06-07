<?php
require 'inc/db.php'; // Database connection
require 'vendor/autoload.php'; // PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $name       = $_POST['name'] ?? '';
    $email      = $_POST['email'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $message    = $_POST['message'] ?? '';

    if ($name && $email && $phone && $message) {
        try {
            // Fetch product name correctly
            $product_name = 'Unknown';
            if (!empty($product_id)) {
                $product_stmt = $pdo->prepare("SELECT product_name FROM product WHERE id = ?");
                $product_stmt->execute([$product_id]);
                $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
                if ($product) {
                    $product_name = $product['product_name']; // <-- corrected here
                }
            }

            // Insert enquiry into database
            $stmt = $pdo->prepare("INSERT INTO enquiry (product_id, name, email, phone, message, created_at) 
                                   VALUES (:product_id, :name, :email, :phone, :message, NOW())");
            $stmt->execute([
                ':product_id' => $product_id,
                ':name'       => $name,
                ':email'      => $email,
                ':phone'      => $phone,
                ':message'    => $message
            ]);

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'iconoutdoor13@gmail.com'; // Your Gmail
            $mail->Password   = 'boom hzhi hrhi zihv';     // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('iconoutdoor13@gmail.com', 'Website Enquiry');
            $mail->addAddress('iconoutdoor13@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'New Product Enquiry Received';
            $mail->Body    = "
                <h3>New Enquiry Details</h3>
                <p><strong>Product ID:</strong> $product_id</p>
                <p><strong>Product Name:</strong> $product_name</p>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Message:</strong><br>$message</p>
            ";

            $mail->send();

            echo "<script>alert('Enquiry submitted and emailed successfully!'); window.location.href='index.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Database Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields.'); window.history.back();</script>";
    }
} else {
    header('Location: thank_you.php');
    exit;
}
