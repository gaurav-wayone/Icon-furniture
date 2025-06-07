<?php
require '../../inc/db.php'; // Database connection

// Fetch category data based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM category WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        die("Category not found!");
    }
} else {
    die("Invalid request!");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $meta_keywords = trim($_POST['meta_keywords']);
    $image = $_FILES['image'];

    if (!empty($name)) {
        // Prepare image upload if needed
        if (!empty($image['name'])) {
            $uploadDir = "../../uploads/category/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = time() . '_' . basename($image["name"]);
            $targetFile = $uploadDir . $imageName;
            $dbImagePath = "uploads/category/" . $imageName;

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                $oldImagePath = "../../" . $category['category_image'];
                if (!empty($category['category_image']) && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $stmt = $pdo->prepare("UPDATE category SET 
                    category_name = :name,
                    category_image = :image,
                    meta_title = :meta_title,
                    meta_description = :meta_description,
                    meta_keywords = :meta_keywords
                    WHERE id = :id
                ");
                $stmt->execute([
                    ':name' => $name,
                    ':image' => $dbImagePath,
                    ':meta_title' => $meta_title,
                    ':meta_description' => $meta_description,
                    ':meta_keywords' => $meta_keywords,
                    ':id' => $id
                ]);
            } else {
                die("Failed to upload image.");
            }
        } else {
            // Update without image
            $stmt = $pdo->prepare("UPDATE category SET 
                category_name = :name,
                meta_title = :meta_title,
                meta_description = :meta_description,
                meta_keywords = :meta_keywords
                WHERE id = :id
            ");
            $stmt->execute([
                ':name' => $name,
                ':meta_title' => $meta_title,
                ':meta_description' => $meta_description,
                ':meta_keywords' => $meta_keywords,
                ':id' => $id
            ]);
        }

        header("Location: ../category.php?message=Category updated successfully!");
        exit();
    } else {
        $error = "Category name cannot be empty!";
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
            max-width: 600px;
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
</head>
<body>
<div class="container">
    <h2>Edit Category</h2>

    <?php if (isset($error)) : ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">

        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>

        <label for="meta_title">Meta Title:</label>
        <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($category['meta_title'] ?? ''); ?>">

        <label for="meta_description">Meta Description:</label>
        <input type="text" id="meta_description" name="meta_description" value="<?php echo htmlspecialchars($category['meta_description'] ?? ''); ?>">

        <label for="meta_keywords">Meta Keywords:</label>
        <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo htmlspecialchars($category['meta_keywords'] ?? ''); ?>">


        <label for="image">Category Image:</label>
        <input type="file" id="image" name="image">

        <?php if (!empty($category['category_image'])) : ?>
            <img src="../../<?php echo htmlspecialchars($category['category_image']); ?>" alt="Current Image">
        <?php endif; ?>

        <button type="submit" name="update">Update Category</button>
    </form>
</div>
</body>
</html>
