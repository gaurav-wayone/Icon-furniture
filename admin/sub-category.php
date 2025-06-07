<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - Icon Furniture</title>

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include('inc/admin_header.php'); ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subcategory</li>
      </ol>
    </nav>
  </div>
  
  
  <?php
require '../inc/db.php';
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['subcategory_name'], $_POST['category_id'], $_FILES['subcategory_image']) &&
        $_FILES['subcategory_image']['error'] === 0
    ) {
        $subcategory_name = trim($_POST['subcategory_name']);
        $category_id = $_POST['category_id'];
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $meta_keywords = trim($_POST['meta_keywords'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $image = $_FILES['subcategory_image'];

        $upload_dir = "../uploads/subcategory/";
        $db_path = "uploads/subcategory/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = time() . '_' . basename($image['name']);
        $target_file = $upload_dir . $file_name;
        $db_file = $db_path . $file_name;

        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            $message = "File is not a valid image.";
            $message_type = "danger";
        } elseif (move_uploaded_file($image["tmp_name"], $target_file)) {
            try {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM subcategory WHERE subcategory_name = :name AND category_id = :category_id");
                $stmt->execute([
                    ':name' => $subcategory_name,
                    ':category_id' => $category_id
                ]);
                $exists = $stmt->fetchColumn();

                if ($exists > 0) {
                    $message = "Subcategory already exists in this category.";
                    $message_type = "warning";
                } else {
                    $stmt = $pdo->prepare("
                        INSERT INTO subcategory 
                        (subcategory_name, subcategory_image, category_id, meta_title, meta_description, meta_keywords, slug) 
                        VALUES 
                        (:name, :image, :category_id, :meta_title, :meta_description, :meta_keywords, :slug)
                    ");
                    $stmt->execute([
                        ':name' => $subcategory_name,
                        ':image' => $db_file,
                        ':category_id' => $category_id,
                        ':meta_title' => $meta_title,
                        ':meta_description' => $meta_description,
                        ':meta_keywords' => $meta_keywords,
                        ':slug' => $slug
                    ]);
                    $message = "Subcategory added successfully!";
                    $message_type = "success";
                }

            } catch (PDOException $e) {
                $message = "Database error: " . $e->getMessage();
                $message_type = "danger";
            }
        } else {
            $message = "Error uploading the image.";
            $message_type = "danger";
        }
    } else {
        $message = "Please fill in all fields and upload a valid image.";
        $message_type = "warning";
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT subcategory.id, subcategory.subcategory_name, subcategory.meta_title, subcategory.meta_description, subcategory.meta_keywords, subcategory.slug, subcategory.subcategory_image, category.category_name 
                           FROM subcategory 
                           INNER JOIN category ON subcategory.category_id = category.id");
    $stmt->execute();
    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
    $message_type = "danger";
}
?>

<?php if (!empty($message)): ?>
    <div class="alert alert-<?= $message_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Subcategory</h5>
      <form method="POST" enctype="multipart/form-data">
        <div class="row">
          <!-- Select Category -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Select Category</label>
            <select class="form-control" name="category_id" required>
              <option value="">Select Category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Subcategory Name -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" name="subcategory_name" id="subcategory_name" required>
          </div>

          <!-- Subcategory Image -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Subcategory Image</label>
            <input type="file" class="form-control" name="subcategory_image" accept="image/*" required>
          </div>

          <!-- Meta Title -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" class="form-control" name="meta_title">
          </div>

          <!-- Meta Description -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Meta Description</label>
            <input type="text" class="form-control" name="meta_description">
          </div>

          <!-- Meta Keywords -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Meta Keywords</label>
            <input type="text" class="form-control" name="meta_keywords">
          </div>

          <!-- Slug (Auto-filled) -->
          <div class="col-lg-6 mb-3">
            <label class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" readonly required>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Add Subcategory</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Auto Slug Generation Script -->
<script>
document.getElementById('subcategory_name').addEventListener('input', function() {
    let name = this.value;
    let slug = name.toLowerCase()
                  .trim()
                  .replace(/[^a-z0-9\s-]/g, '')    // Remove special chars
                  .replace(/\s+/g, '-')             // Replace spaces with -
                  .replace(/-+/g, '-');              // Collapse multiple hyphens
    document.getElementById('slug').value = slug;
});
</script>



  <section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Subcategory List</h5>

          <!-- DataTable -->
          <table class="table datatable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Subcategory Name</th>
                <th>Image</th>
                <th>Meta_title</th>
                <th>Meta_Descrition</th>
                <th>Meta_Keywords</th>
                <th>Slug</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($subcategories as $subcategory): ?>
                <tr>
                  <td><?php echo $subcategory['id']; ?></td>
                  <td><?php echo htmlspecialchars($subcategory['category_name']); ?></td>
                  <td><?php echo htmlspecialchars($subcategory['subcategory_name']); ?></td>
                  <td>
                    <a href="../<?php echo htmlspecialchars($subcategory['subcategory_image']); ?>" target="_blank">
                      <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($subcategory['subcategory_image']); ?>" alt="">
                    </a>
                  </td>
                  <td><?php echo htmlspecialchars($subcategory['meta_title']); ?></td>
                  <td><?php echo htmlspecialchars($subcategory['meta_description']); ?></td>
                  <td><?php echo htmlspecialchars($subcategory['meta_keywords']); ?></td>
                  <td><?php echo htmlspecialchars($subcategory['slug']); ?></td>
                  <td>
                    <i class="bx bx-edit icon-tooltip text-primary" title="Edit" onclick="window.location.href='inc/edit_subcategory.php?id=<?php echo $subcategory['id']; ?>'"></i>
                    <i class="bx bx-trash-alt icon-tooltip text-danger" title="Delete" onclick="deleteSubcategory(<?php echo $subcategory['id']; ?>)"></i>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</section>
>
</main>

<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>Icon Furniture</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Designed by <a href="https://volvrit.com/">Volvrit</a>
  </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<script>
function deleteSubcategory(id) {
  if (confirm("Are you sure you want to delete this subcategory?")) {
    window.location.href = 'inc/delete_subcategory.php?id=' + id;
  }
}
</script>

<style>
.icon-tooltip {
  font-size: 24px;
  cursor: pointer;
  margin: 0 8px;
  transition: transform 0.2s;
  position: relative;
}
.icon-tooltip:hover {
  transform: scale(1.2);
}
.icon-tooltip::after {
  content: attr(title);
  position: absolute;
  bottom: 120%;
  left: 50%;
  transform: translateX(-50%);
  background-color: #333;
  color: white;
  padding: 6px 10px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: 0.3s;
  z-index: 1;
}
.icon-tooltip:hover::after {
  opacity: 1;
  visibility: visible;
  transform: translate(-50%, -5px);
}
</style>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/main.js"></script>
<script>
  // Initialize DataTable after DOM is loaded
  document.addEventListener('DOMContentLoaded', function () {
    const datatable = new simpleDatatables.DataTable(".datatable", {
      searchable: true,
      fixedHeight: true,
      perPageSelect: [5, 10, 15, 25, 50],
      perPage: 10
    });
  });
</script>

</body>
</html>
