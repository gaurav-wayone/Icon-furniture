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
  $stmt = $pdo->prepare("SELECT * FROM testimonial");
  $stmt->execute();
  $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

  <section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Testimonial</h5>

      <form action="inc/add_testimonial.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <!-- Author Name -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="author_name" class="col-sm-4 col-form-label">Author Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="author_name" id="author_name" required>
              </div>
            </div>
          </div>

          <!-- Author Role -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="author_role" class="col-sm-4 col-form-label">Author Role</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="author_role" id="author_role" required>
              </div>
            </div>
          </div>

          <!-- Testimonial Text -->
          <div class="col-lg-12">
            <div class="mb-3 row">
              <label for="testimonial_text" class="col-sm-2 col-form-label">Testimonial</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="testimonial_text" id="testimonial_text" rows="4" required></textarea>
              </div>
            </div>
          </div>

          <!-- Rating -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="rating" class="col-sm-4 col-form-label">Rating (1-5)</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="rating" id="rating" min="1" max="5" required>
              </div>
            </div>
          </div>

          <!-- Author Image -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="author_image" class="col-sm-4 col-form-label">Author Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="author_image" id="author_image" accept="image/*" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Testimonial</button>
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
                    <h5 class="card-title">Testimonials</h5>
                    <table class="table datatable">
                        <tr>
                            <th>ID</th>
                            <th>Author Name</th>
                            <th>Position</th>
                            <th>Testimonial</th>
                            <th>Author Image</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($testimonials): ?>
                            <?php foreach ($testimonials as $testimonial): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($testimonial['id']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['author_name']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['author_role']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['rating']); ?></td>
                                    <td><?php echo htmlspecialchars($testimonial['testimonial_text']); ?></td>
                                    <td>
                                        <img style="width:50px; height:50px; border-radius:50%; object-fit:cover;" src="../<?php echo htmlspecialchars($testimonial['author_image']); ?>" alt="Author Image">
                                    </td>
                                    <td class="action-icons">
                                        <i style="color: #3B71CA; cursor: pointer;" class="bx bx-edit icon-tooltip" title="Edit" onclick="window.location.href='inc/edit_testimonial.php?id=<?php echo $testimonial['id']; ?>'"></i>
                                        <i style="color: #F44336; cursor: pointer;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteTestimonial(<?php echo $testimonial['id']; ?>)"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No testimonials found.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function deleteTestimonial(id) {
    if (confirm("Are you sure you want to delete this testimonial?")) {
        window.location.href = 'inc/delete_testimonial.php?id=' + id;
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