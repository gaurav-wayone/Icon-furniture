<?php
require '../../inc/db.php';

// Fetch subcategory data
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM subcategory WHERE id = ?");
    $stmt->execute([$id]);
    $subcategory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$subcategory) {
        die("Subcategory not found!");
    }
}

// Fetch categories
try {
    $stmt = $pdo->prepare("SELECT * FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $category_id = $_POST['category_id'];
    $subcategory_name = trim($_POST['subcategory_name']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $meta_keywords = trim($_POST['meta_keywords']);
    $imageName = $subcategory['subcategory_image']; // keep current image if not changed

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = 'subcategory_' . time() . '.' . $ext;
        $uploadPath = '../../uploads/subcategory/' . $newFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Delete old image if exists
            if (!empty($subcategory['subcategory_image']) && file_exists('../../' . $subcategory['subcategory_image'])) {
                unlink('../../' . $subcategory['subcategory_image']);
            }
            $imageName = 'uploads/subcategory/' . $newFileName;
        }
    }

    if (!empty($subcategory_name)) {
        $stmt = $pdo->prepare("UPDATE subcategory SET 
            category_id = :category_id,
            subcategory_name = :name,
            subcategory_image = :image,
            meta_title = :meta_title,
            meta_description = :meta_description,
            meta_keywords = :meta_keywords
            WHERE id = :id
        ");
        $stmt->execute([
          ':category_id' => $category_id,
          ':name' => $subcategory_name,
          ':image' => $imageName,
          ':meta_title' => $meta_title,
          ':meta_description' => $meta_description,
          ':meta_keywords' => $meta_keywords,
          ':id' => $id
      ]);
      

        header("Location: ../sub-category.php?message=Subcategory updated successfully!");
        exit();
    } else {
        $error = "Subcategory name cannot be empty!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link rel="stylesheet" href="../../icon/assets/css/style.css">
    <style>
      .container {
        max-width: 500px;
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
      input[type="file"] {
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
  <body>
    <div class="container">
      <h2>Edit Subcategory</h2> <?php if (isset($error)) : ?> <p class="error text-danger"> <?php echo htmlspecialchars($error); ?> </p> <?php endif; ?> <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="
								<?php echo htmlspecialchars($subcategory['id'] ?? ''); ?>">
        <label for="category_id">Select Category:</label>
        <select class="form-control" name="category_id" id="category_id" required>
          <option value="">Select Category</option> <?php foreach ($categories as $category): ?> <option value="
										<?php echo $category['id']; ?>" <?php echo ($subcategory['category_id'] ?? '') == $category['id'] ? 'selected' : ''; ?>> <?php echo htmlspecialchars($category['category_name']); ?> </option> <?php endforeach; ?>
        </select>
        <label for="subcategory_name">Subcategory Name:</label>
        <input type="text" id="subcategory_name" name="subcategory_name" value="
									<?php echo htmlspecialchars($subcategory['subcategory_name'] ?? ''); ?>" required>
                  <label for="meta_title">Meta Title:</label>
<input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($subcategory['meta_title'] ?? ''); ?>">

<label for="meta_description">Meta Description:</label>
<input type="text" id="meta_description" name="meta_description" value="<?php echo htmlspecialchars($subcategory['meta_description'] ?? ''); ?>">

<label for="meta_keywords">Meta Keywords:</label>
<input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($subcategory['meta_keywords'] ?? ''); ?>">


        <label for="image">Subcategory Image:</label>
        <input type="file" id="image" name="image"> <?php if (!empty($subcategory['subcategory_image'])) : ?> <img src="../../
											<?php echo htmlspecialchars($subcategory['subcategory_image']); ?>" alt=""> <?php endif; ?> <button type="submit" name="update">Update Subcategory</button>
      </form>
    </div>
  </body>
</html>