<?php
require '../../inc/db.php'; // Database connection

// Fetch product data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found!");
    }
} else {
    die("Invalid request!");
}

// Fetch all categories
$categories = $pdo->query("SELECT id, category_name FROM category")->fetchAll(PDO::FETCH_ASSOC);
$subcategories = $pdo->query("SELECT id, subcategory_name, slug, category_id FROM subcategory")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);
    $additional_info = trim($_POST['additional_info']);
    $short_description = trim($_POST['short_description']);
    $category_id = $_POST['category_id'];
    $subcategory_name = $_POST['subcategory_name'];
    $slug = trim($_POST['slug']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $meta_keywords = trim($_POST['meta_keywords']);
    $image = $_FILES['image'];

    // Preserve the original subcategory_slug
    $subcategory_slug = $product['subcategory_slug'];

    if (!empty($name) && !empty($type) && !empty($category_id)) {
        if (!empty($image['name'])) {
            $uploadDir = "../../uploads/product/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = time() . '_' . basename($image["name"]);
            $targetFile = $uploadDir . $imageName;
            $dbImagePath = "uploads/product/" . $imageName;

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                // Delete old image
                $oldImagePath = "../../" . $product['product_image'];
                if (!empty($product['product_image']) && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $stmt = $pdo->prepare("UPDATE product SET product_name = :name, type = :type, description = :description, additional_info = :additional_info, short_description = :short_description, product_image = :image, category_id = :category_id, subcategory_name = :subcategory_name, subcategory_slug = :subcategory_slug, slug = :slug, meta_title = :meta_title, meta_description = :meta_description, meta_keywords = :meta_keywords WHERE id = :id");
                $stmt->execute([
                    ':name' => $name,
                    ':type' => $type,
                    ':description' => $description,
                    ':additional_info' => $additional_info,
                    ':short_description' => $short_description,
                    ':image' => $dbImagePath,
                    ':category_id' => $category_id,
                    ':subcategory_name' => $subcategory_name,
                    ':subcategory_slug' => $subcategory_slug,
                    ':slug' => $slug,
                    ':meta_title' => $meta_title,
                    ':meta_description' => $meta_description,
                    ':meta_keywords' => $meta_keywords,
                    ':id' => $id
                ]);
            } else {
                die("Failed to upload image.");
            }
        } else {
            $stmt = $pdo->prepare("UPDATE product SET product_name = :name, type = :type, description = :description, additional_info = :additional_info, short_description = :short_description, category_id = :category_id, subcategory_name = :subcategory_name, subcategory_slug = :subcategory_slug, slug = :slug, meta_title = :meta_title, meta_description = :meta_description, meta_keywords = :meta_keywords WHERE id = :id");
            $stmt->execute([
                ':name' => $name,
                ':type' => $type,
                ':description' => $description,
                ':additional_info' => $additional_info,
                ':short_description' => $short_description,
                ':category_id' => $category_id,
                ':subcategory_name' => $subcategory_name,
                ':subcategory_slug' => $subcategory_slug,
                ':slug' => $slug,
                ':meta_title' => $meta_title,
                ':meta_description' => $meta_description,
                ':meta_keywords' => $meta_keywords,
                ':id' => $id
            ]);
        }

        header("Location: ../products.php?message=Product updated successfully!");
        exit();
    } else {
        $error = "All required fields must be filled!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../icon/assets/vendor/bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <style>
        .container {
            max-width: 100%;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #3B71CA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #2A5A9A;
        }

        img {
            display: block;
            max-width: 150px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
        <h2>Edit Product</h2>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

            <div class="row">
                <div class="col-lg-6">

                    <label>Product Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

                    <label>Slug:</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="<?php echo htmlspecialchars($product['slug']); ?>" required readonly>

                    <label>Type:</label>
                    <select name="type" class="form-control" required>
                        <option selected><?php echo htmlspecialchars($product['type']); ?></option>
                        <option value="hot">Hot</option>
                        <option value="oss">Out of Stock</option>
                        <option value="new">New</option>
                        <option value="trending">Trending</option>
                        <option value="featured">Featured</option>
                        <option value="popular">Popular</option>
                        <option value="best_sale">Best Sale</option>
                    </select>

                    <label>Short Description:</label>
                    <textarea name="short_description" class="form-control"><?php echo htmlspecialchars($product['short_description']); ?></textarea>

                    <label>Additional Info:</label>
                    <textarea name="additional_info" id="additional_info" class="form-control"><?php echo htmlspecialchars($product['additional_info']); ?></textarea>

                    <label>Product Image:</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (!empty($product['product_image'])) : ?>
                        <img src="../../<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="img-fluid mt-2" style="max-width:150px;">
                    <?php endif; ?>

                </div>

                <div class="col-lg-6">

                    <label>Description:</label>
                    <textarea name="description" id="description" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>

                    <label>Category:</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo ($product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label>Subcategory Name:</label>
                    <select name="subcategory_name" id="subcategory_name" class="form-control">
                        <option value="">Select Subcategory</option>
                        <?php foreach ($subcategories as $subcategory) : ?>
                            <option value="<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>" <?php echo ($product['subcategory_name'] == $subcategory['subcategory_name']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($subcategory['subcategory_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    

                    <label>Meta Title:</label>
                    <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($product['meta_title']); ?>">

                    <label>Meta Description:</label>
                    <textarea name="meta_description" class="form-control"><?php echo htmlspecialchars($product['meta_description']); ?></textarea>

                    <label>Meta Keywords:</label>
                    <input type="text" name="meta_keywords" class="form-control" value="<?php echo htmlspecialchars($product['meta_keywords']); ?>">

                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" name="update" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>

    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('additional_info');

        // Auto-generate slug from product name
        document.getElementById('name').addEventListener('input', function() {
            let name = this.value;
            let slug = name.toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
</body>
</html>