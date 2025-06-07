<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>
<?php
require_once '../inc/db.php';

// Fetch existing contact details (if any)
$stmt = $pdo->query("SELECT * FROM contact_details LIMIT 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $opening_time = $_POST['opening_time'] ?? '';
    $phone = $_POST['phone'] ?? '';

    try {
        if ($contact) {
            // Update existing contact details
            $updateStmt = $pdo->prepare("UPDATE contact_details SET email = :email, address = :address, opening_time = :opening_time, phone = :phone, updated_at = NOW() WHERE id = :id");
            $updateStmt->execute([
                ':email' => $email,
                ':address' => $address,
                ':opening_time' => $opening_time,
                ':phone' => $phone,
                ':id' => $contact['id']
            ]);
            header('Location: contact-details.php');
        } else {
            // Insert new contact details
            $insertStmt = $pdo->prepare("INSERT INTO contact_details (email, address, opening_time, phone) VALUES (:email, :address, :opening_time, :phone)");
            $insertStmt->execute([
                ':email' => $email,
                ':address' => $address,
                ':opening_time' => $opening_time,
                ':phone' => $phone
            ]);
            header('Location: contact-details.php');
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Icon furniture</title>
  <meta content="" name="description">
  <meta content="" name="keywords">



  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    


  <div class="container" style="max-width: 600px; margin: auto;">
    <h2>Manage Contact Details</h2>

   

    <form  method="POST" style="margin-top: 20px;">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" 
                value="<?= htmlspecialchars($contact['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" class="form-control" 
                value="<?= htmlspecialchars($contact['address'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Opening Time (e.g., Mon - Sat 10AM - 05PM):</label>
            <input type="text" name="opening_time" class="form-control" 
                value="<?= htmlspecialchars($contact['opening_time'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control" 
                value="<?= htmlspecialchars($contact['phone'] ?? '') ?>" required>
        </div>

        <button type="submit" class="theme-btn">Save Details</button>
    </form>
</div>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Icon Furniture</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
     
      Designed by <a href="https://volvrit.com/">Volvrit</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>