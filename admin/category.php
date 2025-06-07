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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    try {
        $category_name     = trim($_POST['category_name'] ?? '');
        $meta_title        = trim($_POST['meta_title'] ?? '');
        $meta_description  = trim($_POST['meta_description'] ?? '');
        $meta_keywords     = trim($_POST['meta_keywords'] ?? '');
        $slug              = trim($_POST['slug'] ?? '');
        $image             = $_FILES['category_image'] ?? null;

        if (empty($category_name) || !$image || $image['error'] !== 0) {
            throw new Exception("Category name and image are required.");
        }

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_types)) {
            throw new Exception("Invalid image format. Allowed formats: jpg, jpeg, png, gif, webp.");
        }

        $check = getimagesize($image['tmp_name']);
        if ($check === false) {
            throw new Exception("Uploaded file is not a valid image.");
        }

        $upload_dir = "../uploads/category/";
        $db_path    = "uploads/category/";
        $unique_name = uniqid('cat_', true) . "." . $file_ext;
        $target_file = $upload_dir . $unique_name;
        $db_file     = $db_path . $unique_name;

        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
            throw new Exception("Failed to upload the image.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO category 
            (category_name, category_image, meta_title, meta_description, meta_keywords, slug)
            VALUES 
            (:name, :image, :meta_title, :meta_description, :meta_keywords, :slug)
        ");
        $stmt->execute([
            ':name'             => $category_name,
            ':image'            => $db_file,
            ':meta_title'       => $meta_title,
            ':meta_description' => $meta_description,
            ':meta_keywords'    => $meta_keywords,
            ':slug'             => $slug,
        ]);

        echo "<div style='color: green;'>✅ Category added successfully!</div>";

    } catch (Exception $e) {
        echo "<div style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Category</h5>

      <form action="category.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <!-- Category Name -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="category_name" class="col-sm-4 col-form-label">Category Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="category_name" id="category_name" required>
              </div>
            </div>
          </div>

          <!-- Category Image -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="category_image" class="col-sm-4 col-form-label">Category Image</label>
              <div class="col-sm-8">
                <input type="file" class="form-control" name="category_image" id="category_image" accept="image/*" required>
              </div>
            </div>
          </div>

          <!-- Meta Title -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="meta_title" class="col-sm-4 col-form-label">Meta Title</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="meta_title" id="meta_title" required>
              </div>
            </div>
          </div>

          <!-- Meta Description -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="meta_description" class="col-sm-4 col-form-label">Meta Description</label>
              <div class="col-sm-8">
                <textarea class="form-control" name="meta_description" id="meta_description" rows="4" required></textarea>
              </div>
            </div>
          </div>

          <!-- Slug -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="slug" class="col-sm-4 col-form-label">Slug</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="slug" id="slug" readonly required>
              </div>
            </div>
          </div>

          <!-- Meta Keywords -->
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="meta_keywords" class="col-sm-4 col-form-label">Meta Keywords</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" required>
              </div>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Auto-slug script -->
<script>
document.getElementById('category_name').addEventListener('input', function() {
    let name = this.value;
    let slug = name.toLowerCase()
                  .trim()
                  .replace(/[^a-z0-9\s-]/g, '')    // Remove special chars
                  .replace(/\s+/g, '-')             // Replace spaces with -
                  .replace(/-+/g, '-');              // Collapse multiple -
    document.getElementById('slug').value = slug;
});
</script>



<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Datatables</h5>
                    <table class="table datatable">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            
                            <th>Meta Title</th>
                            <th>Meta Description</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($categories): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                                    <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($category['category_image']); ?>" alt="Category Image">
                                    </td>
                                    
                                    <td><?php echo htmlspecialchars($category['meta_title']); ?></td>
                                    <td><?php echo htmlspecialchars($category['meta_description']); ?></td>
                                    <td><?php echo htmlspecialchars($category['slug']); ?></td>
                                    <td class="action-icons">
                                    <i style="color: #3B71CA;" class="bx bx-edit icon-tooltip" title="Edit" onclick="window.location.href='inc/edit_category.php?id=<?php echo $category['id']; ?>'"></i>

<i style="color: #F44336;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteCategory(<?php echo $category['id']; ?>)"></i>


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

function deleteCategory(id) {
    if (confirm("Are you sure you want to delete this category?")) {
        window.location.href = 'inc/delete_category.php?id=' + id;
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