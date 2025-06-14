<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>
<?php
require('../inc/db.php');

// Fetch enquiry data along with the associated product name
$stmt = $pdo->prepare("SELECT e.id, e.name, e.email, e.phone,  e.message, p.product_name, e.created_at, p.product_image 
                       FROM enquiry e
                       JOIN product p ON e.product_id = p.id
                       ORDER BY e.id DESC");
$stmt->execute();
$enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

  <style>
    td{
      font-size: 12px;
    }
    th{
      font-size: 12px;
    }
  </style>
  


</head>

<body>

  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">orders</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    
   
   
    <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Enquiries</h5>
                    <table class="table datatable">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Date&Time</th>
                            
                        </tr>

                        <?php if ($enquiries): ?>
                            <?php foreach ($enquiries as $enquiry): ?>
                                <tr>
                                    <td><?= htmlspecialchars($enquiry['id']); ?></td>
                                    <td><?= htmlspecialchars($enquiry['product_name']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?= htmlspecialchars($enquiry['product_image']); ?>" alt="Product Image">
                                    </td>
                                    <td><?= htmlspecialchars($enquiry['name']); ?></td>
                                    <td><?= htmlspecialchars($enquiry['email']); ?></td>
                                    <td><?= htmlspecialchars($enquiry['phone']); ?></td>
                                    <td><?= htmlspecialchars($enquiry['message']); ?></td>
                                    <td><?= htmlspecialchars($enquiry['created_at']); ?></td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="13">No enquiries found.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


    





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