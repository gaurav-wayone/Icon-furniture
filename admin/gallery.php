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

</head>

<body>




  <?php include('inc/admin_header.php'); ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Categroy</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <?php
require '../inc/db.php';

if (isset($_POST['submit'])) {
    $image = $_FILES['gallery_image'];

    $upload_dir = "../uploads/gallery/"; // Directory where the file will be stored
    $db_path = "uploads/gallery/";       // Path to be stored in the database (without '../')
    $target_file = $upload_dir . basename($image['name']);
    $db_file = $db_path . basename($image['name']); // Relative path for the database

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Move uploaded file to the target directory
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery (gallery_image) VALUES ( :gallery_image)");
            $stmt->execute([
                ':gallery_image' => $db_file // Store the relative path in the database
            ]);
            echo "gallery Image added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


try {
    $stmt = $pdo->prepare("SELECT * FROM gallery");
    $stmt->execute();
    $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Gallery</h5>

      <form action="gallery.php" method="POST" enctype="multipart/form-data">
        
          

          <!-- Category Image -->
          <div class="col-lg-12">
            <div class="mb-3 row">
              <label for="gallery_image" class="col-sm-4 col-form-label" >gallery Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="gallery_image" id="gallery_image" accept="image/*" required>
              </div>
            </div>
          </div>
        

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Gallery Image</button>
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
                            <th>Gallery Image</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($galleries): ?>
                            <?php foreach ($galleries as $gallery): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($gallery['id']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($gallery['gallery_image']); ?>" alt="gallery Image">
                                    </td>
                                    <td class="action-icons">

<i style="color: #F44336;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteGallery(<?php echo $gallery['id']; ?>)"></i>
 

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

function deleteGallery(id) {
    if (confirm("Are you sure you want to delete this gallery?")) {
        window.location.href = 'inc/delete_gallery.php?id=' + id;
    }
}

</script>
<style>
 .icon-tooltip {
    position: relative;
    display: inline-block;
    font-size: 28px; /* Icon size */
    cursor: pointer;
    margin: 0 8px; /* Spacing between icons */
    transition: transform 0.2s, color 0.2s; /* Hover effects */
}

.icon-tooltip:hover {
    transform: scale(1.2); /* Zoom effect on hover */
    opacity: 0.9;
}

/* Tooltip styling */
.icon-tooltip::after {
    content: attr(title); /* Get tooltip text from the title attribute */
    position: absolute;
    bottom: 120%; /* Position above the icon */
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 12px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, transform 0.3s;
    z-index: 10;
}

/* Show tooltip on hover */
.icon-tooltip:hover::after {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -5px); /* Slight upward movement */
}


</style>

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