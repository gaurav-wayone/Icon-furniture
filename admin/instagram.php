<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
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

  <?php
require_once '../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instagram_link = $_POST['link'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = '../uploads/insta/';  // Upload directory
        $db_image_path = 'uploads/insta/' . $image_name; // Path to store in DB

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $full_upload_path = $upload_dir . $image_name;

        // Move uploaded file to the directory
        if (move_uploaded_file($image_tmp, $full_upload_path)) {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO instagram (image_path, instagram_link) VALUES (:image_path, :instagram_link)");
            $stmt->execute([
                ':image_path' => $db_image_path,
                ':instagram_link' => $instagram_link
            ]);

            echo "✅ Instagram post added successfully!";
        } else {
            echo "❌ Failed to upload the image.";
        }
    } else {
        echo "⚠️ Please select an image to upload.";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM instagram");
    $stmt->execute();
    $instagrams = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

    
  <section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Instagram Post</h5>

      <form action="instagram.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <!-- Category Name -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="link" class="col-sm-4 col-form-label">Post link</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="link" id="link" required>
              </div>
            </div>
          </div>

          <!-- Category Image -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="image" class="col-sm-4 col-form-label" >Post Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Instagram Post</button>
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
                    <h5 class="card-title">Datatables</h5>
                    <table class="table datatable">
                        <tr>
                            <th>ID</th>
                            <th>Post Link</th>
                            <th>Post Image</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($instagrams): ?>
                            <?php foreach ($instagrams as $instagram): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($instagram['id']); ?></td>
                                    <td><?php echo htmlspecialchars($instagram['instagram_link']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($instagram['image_path']); ?>" alt="instagram Image">
                                    </td>
                                    <td class="action-icons">
                                    <i style="color: #3B71CA;" class="bx bx-edit icon-tooltip" title="Edit" onclick="window.location.href='inc/edit_instagram.php?id=<?php echo $instagram['id']; ?>'"></i>

<i style="color: #F44336;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteinsta(<?php echo $instagram['id']; ?>)"></i>


                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No categories found.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

function deleteinsta(id) {
    if (confirm("Are you sure you want to delete this category?")) {
        window.location.href = 'inc/delete_instagram.php?id=' + id;
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