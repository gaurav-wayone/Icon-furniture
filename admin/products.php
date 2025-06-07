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
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
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
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <?php
require '../inc/db.php';

// Fetch categories for the dropdown
$stmt = $pdo->query("SELECT id, category_name FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['add_product'])) {
    $name = trim($_POST['product_name']);
    $type = $_POST['type'];
    $category_id = $_POST['category_id'];
    $subcategory_name = $_POST['subcategory_name'];
    $description = $_POST['description'];
    $additional_info = $_POST['additional_info'];
    $short_description = $_POST['short_description'];
    $image = $_FILES['product_image'];

    if ($name && $category_id && $subcategory_name && $description) {
        // 📌 Step 1: Fetch subcategory_slug from subcategory table
        $slug_stmt = $pdo->prepare("SELECT slug FROM subcategory WHERE subcategory_name = :name");
        $slug_stmt->execute([':name' => $subcategory_name]);
        $subcategory = $slug_stmt->fetch(PDO::FETCH_ASSOC);

        if (!$subcategory) {
            $error = "Subcategory slug not found!";
        } else {
            $subcategory_slug = $subcategory['slug'];

            $targetDir = "../uploads/products/";
            $imageName = time() . '_' . basename($image["name"]);
            $targetFile = $targetDir . $imageName;

            // You can still generate product slug based on name
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                $stmt = $pdo->prepare("INSERT INTO product (
                    product_name, type, description, additional_info, short_description, 
                    product_image, category_id, subcategory_name, slug, subcategory_slug
                ) VALUES (
                    :name, :type, :description, :additional_info, :short_description, 
                    :image, :category_id, :subcategory_name, :slug, :subcategory_slug
                )");

                $stmt->execute([
                    ':name' => $name,
                    ':type' => $type,
                    ':description' => $description,
                    ':additional_info' => $additional_info,
                    ':short_description' => $short_description,
                    ':image' => "uploads/products/" . $imageName,
                    ':category_id' => $category_id,
                    ':subcategory_name' => $subcategory_name,
                    ':slug' => $slug,
                    ':subcategory_slug' => $subcategory_slug
                ]);

                echo "Product Added Successfully";
            } else {
                $error = "Failed to upload image.";
            }
        }
    } else {
        $error = "All fields are required!";
    }
}

// Fetch products for listing (optional display use)
$stmt = $pdo->query("
    SELECT p.*, c.category_name 
    FROM product p
    JOIN category c ON p.category_id = c.id
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Add Products</h5>

      <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="product_name" class="col-sm-4 col-form-label">Product Name:</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="product_name" name="product_name" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="type" class="col-sm-4 col-form-label">Product label:</label>
              <div class="col-sm-8">
                <select class="form-control" id="type" name="type" required>
                  <option value="hot">Hot</option>
                  <option value="oss">Out of Stock</option>
                  <option value="new">New</option>
                  <option value="trending">Trending</option>
                  <option value="featured">Featured</option>
                  <option value="popular">Popular</option>
                  <option value="best_sale">Best Sale</option>
                </select>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="meta_title" class="col-sm-4 col-form-label">Meta Title:</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="meta_title" name="meta_title">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="meta_keywords" class="col-sm-4 col-form-label">Meta Keywords:</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="meta_keywords" name="meta_keywords">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="slug" class="col-sm-4 col-form-label">Slug:</label>
              <div class="col-sm-8">
                <input class="form-control" type="text" id="slug" name="slug">
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3 row">
              <label for="category_id" class="col-sm-4 col-form-label">Category:</label>
              <div class="col-sm-8">
                <select class="form-control" id="category_id" name="category_id" required>
                  <option value="">Select Category</option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                      <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="subcategory_name" class="col-sm-4 col-form-label">Subcategory:</label>
              <div class="col-sm-8">
                <select class="form-control" id="subcategory_name" name="subcategory_name" required>
                  <option value="">Select Subcategory</option>
                </select>
                <input type="hidden" name="subcategory_slug" id="subcategory_slug">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="product_image" class="col-sm-4 col-form-label">Product Image:</label>
              <div class="col-sm-8">
                <input class="form-control" type="file" id="product_image" name="product_image" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="short_description" class="col-sm-4 col-form-label">Short Description:</label>
              <div class="col-sm-8">
                <textarea class="form-control" id="short_description" name="short_description" rows="4" required></textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="meta_description" class="col-sm-4 col-form-label">Meta Description:</label>
              <div class="col-sm-8">
                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>

        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="6" required></textarea>

        <label for="additional_info">Additional Info:</label>
        <textarea class="form-control" id="additional_info" name="additional_info" rows="6"></textarea>

        <div class="text-center">
          <button type="submit" name="add_product" class="btn btn-primary">Add Products</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
document.getElementById('product_name').addEventListener('input', function() {
    let name = this.value;
    let slug = name.toLowerCase()
                  .trim()
                  .replace(/[^a-z0-9\s-]/g, '')    // Remove special chars
                  .replace(/\s+/g, '-')             // Replace spaces with -
                  .replace(/-+/g, '-');              // Collapse multiple -
    document.getElementById('slug').value = slug;
});
</script>

<script>
  document.getElementById('category_id').addEventListener('change', function () {
    var categoryId = this.value;
    var subcategoryDropdown = document.getElementById('subcategory_name');
    subcategoryDropdown.innerHTML = '<option value="">Select Subcategory</option>';
    document.getElementById('subcategory_slug').value = ''; // Clear subcategory_slug field

    if (categoryId) {
      // Fetch subcategories based on selected category
      fetch('inc/fetch_subcategory.php?category_id=' + categoryId)
        .then(response => response.json())
        .then(data => {
          // Populate subcategory dropdown
          data.forEach(subcat => {
            let option = document.createElement('option');
            option.value = subcat.subcategory_name;
            option.textContent = subcat.subcategory_name;
            option.dataset.slug = subcat.slug;  // Store slug as data attribute
            subcategoryDropdown.appendChild(option);
          });
        });
    }
  });

  document.getElementById('subcategory_name').addEventListener('change', function () {
    const selected = this.selectedOptions[0];
    if (selected) {
      // Set the subcategory_slug input field when a subcategory is selected
      document.getElementById('subcategory_slug').value = selected.dataset.slug || '';
    }
  });
</script>



<script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('additional_info');
        CKEDITOR.disableAutoInline = true;
      CKEDITOR.config.versionCheck = false;
    </script>


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card table-responsive">
                
                <div class="card-body">
                <div class="text-right">
    <!--<button class="btn add-product-btn"></button>-->
</div>

                    <h5 class="card-title">Datatables</h5>
                    <table class="table datatable ">
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Type</th>
                            <th>Short Description</th>
                            <th>Description</th>
                            <th>Additional Info</th>
                            <th>Created At</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Actions</th>
                        </tr>
                        <?php if ($products): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                    <td>
                                        <img style="width:50px; border-radius: 50px;" src="../<?php echo htmlspecialchars($product['product_image']); ?>" alt="product Image">
                                    </td>
                                    <td><?php echo htmlspecialchars($product['type']); ?></td>
                                    <td><?php
echo nl2br(strip_tags(html_entity_decode(implode(' ', array_slice(explode(' ', $product['short_description']), 0, 10))))) . (str_word_count(strip_tags(html_entity_decode($product['short_description']))) > 10 ? '...' : '');
?>
</td>
                                    <td><?php
echo nl2br(strip_tags(html_entity_decode(implode(' ', array_slice(explode(' ', $product['description']), 0, 10))))) . (str_word_count(strip_tags(html_entity_decode($product['description']))) > 10 ? '...' : '');
?>
</td>
<td><?php
echo nl2br(strip_tags(html_entity_decode(implode(' ', array_slice(explode(' ', $product['additional_info']), 0, 10))))) . (str_word_count(strip_tags(html_entity_decode($product['additional_info']))) > 10 ? '...' : '');
?>
</td>
                                    <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['subcategory_name']); ?></td>
                                    <td class="action-icons">
                                    <i style="color: #3B71CA;" class="bx bx-edit icon-tooltip" title="Edit" onclick="window.location.href='inc/edit_product.php?id=<?php echo $product['id']; ?>'"></i>

<i style="color: #F44336;" class="bx bx-trash-alt icon-tooltip" title="Delete" onclick="deleteCategory(<?php echo $product['id']; ?>)"></i>


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
        window.location.href = 'inc/delete_product.php?id=' + id;
    }
}

</script>
<style>
 .icon-tooltip {
    position: relative;
    display: inline-block;
    font-size: 20px; /* Icon size */
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

.add-product-btn {
    background-color: #3B71CA;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    float: right; /* Align to the right */
    margin-bottom: 15px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 70px;
    margin-left: 20px;
}

.add-product-btn:hover {
    background-color: #2851a3;
    transform: translateY(-2px);
}

.add-product-btn:active {
    transform: translateY(0);
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
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


</body>

</html>