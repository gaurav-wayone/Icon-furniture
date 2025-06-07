<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>


<?php
include ('../inc/db.php');
try {
    $stmt = $pdo->prepare("SELECT * FROM slider");
    $stmt->execute();
    $sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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

 
</head>

<body>

  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    
  <section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Slider</h5>

      <form action="inc/add_slider.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <!-- Title -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="title" class="col-sm-4 col-form-label">Title</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="title" id="title" >
              </div>
            </div>
          </div>

          <!-- Subtitle -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="subtitle" class="col-sm-4 col-form-label">Subtitle</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="subtitle" id="subtitle" >
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- Description -->
          <div class="col-lg-12">
            <div class="mb-3 row">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" rows="4" ></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- Slider Image -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="image" class="col-sm-4 col-form-label">Slider Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="image" id="image" accept="image/*" recuired>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Slider</button>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Slider Management</h5>
                    <table class="table datatable">
                        <tr>
                            <th>ID</th>
                            <th>Slider Title</th>
                            <th>Slider Sub Title</th>
                            <th>Slider Image</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($sliders): ?>
                            <?php foreach ($sliders as $slider): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($slider['id']); ?></td>
                                    <td><?php echo htmlspecialchars($slider['title']); ?></td>
                                    <td><?php echo htmlspecialchars($slider['subtitle']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($slider['image']); ?>" alt="Slider Image">
                                    </td>
                                    <td class="action-icons">
                                        <i style="color: #3B71CA;" class="bx bx-edit icon-tooltip" title="Edit" onclick="window.location.href='inc/edit_slider.php?id=<?php echo $slider['id']; ?>'"></i>

                                        <i style="color: #F44336;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteSlider(<?php echo $slider['id']; ?>)"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No sliders found.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function deleteSlider(id) {
    if (confirm("Are you sure you want to delete this slider?")) {
        window.location.href = 'inc/delete_slider.php?id=' + id;
    }
}
</script>


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