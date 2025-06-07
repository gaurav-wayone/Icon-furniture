<?php
session_start();
include ('inc/db.php');


?>
<?php

// Function to create slugs
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}

// Get category slug from URL
$uriParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$categorySlug = end($uriParts);

// Initialize variables
$categoryId = null;
$categoryName = '';
$categoryImage = '';
$subcategories = [];

try {
    // Step 1: Fetch category by slug
    $stmt = $pdo->prepare("SELECT id, category_name, category_image, meta_title, meta_description, meta_keywords FROM category WHERE slug = ?");
    $stmt->execute([$categorySlug]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $categoryId = $category['id'];
        $categoryName = $category['category_name'];
        $categoryImage = $category['category_image'];

        // Step 2: Fetch subcategories for this category
        $stmt = $pdo->prepare("SELECT id, subcategory_name, subcategory_image FROM subcategory WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error = "Category not found.";
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (!empty($category)): ?>
        <meta name="title" content="<?= htmlspecialchars($category['meta_title'] ?? $categoryName) ?>">
        <meta name="description" content="<?= htmlspecialchars($category['meta_description'] ?? 'Explore subcategories under ' . $categoryName) ?>">
        <meta name="keywords" content="<?= htmlspecialchars($category['meta_keywords'] ?? $categoryName) ?>">
        <title><?= htmlspecialchars($category['meta_title'] ?? $categoryName) ?> | Our Categories</title>
    <?php else: ?>
        <meta name="title" content="Category Not Found">
        <meta name="description" content="The category you are looking for could not be found.">
        <meta name="keywords" content="categories, error, not found">
        <title>Category Not Found</title>
    <?php endif; ?>

    <!-- title -->
    <title>Icon Furniture</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="/icon/assets/img/logo/favicon.png">

<!-- css -->
<link rel="stylesheet" href="/icon/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="/icon/assets/css/all-fontawesome.min.css">
<link rel="stylesheet" href="/icon/assets/css/animate.min.css">
<link rel="stylesheet" href="/icon/assets/css/magnific-popup.min.css">
<link rel="stylesheet" href="/icon/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="/icon/assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="/icon/assets/css/nice-select.min.css">
<link rel="stylesheet" href="/icon/assets/css/style.css">
    <style>
      .product-img  img {
    width: 500px;
    height: 200px;
    object-fit: cover; /* Ensures images maintain their aspect ratio while filling the container */
    border-radius: 8px;
}
    </style>

</head>

<body>

<?php 
include('inc/header.php'); 

?>



    <main class="main">
    <!-- breadcrumb -->
   <!-- breadcrumb -->
      <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Sub Category</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Sub Category</li>
            </ul>
          </div>
        </div>
      </div>
          <script>

        
let randomNumber = Math.floor(Math.random() * 5) + 1;

console.log(randomNumber); 

document.getElementById("dynamic-div").style.background = `url(/icon/assets/img/breadcrumb/0${randomNumber}.jpg)`

    </script>
        <!-- breadcrumb end -->



        <!-- category area -->
        <div class="category-area3 py-120">
            <div class="container">
                
                <div class="row">
                    
                <?php
include 'inc/db.php';

if (!function_exists('slugify')) {
    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }
}


// Get the category slug from the URL
$uriParts = explode('/', $_SERVER['REQUEST_URI']);
$categorySlug = end($uriParts); // Get the last part of the URL

try {
    // Step 1: Get the category by slug
    $stmt = $pdo->prepare("SELECT id, category_name, category_image FROM category WHERE slug = ?");
    $stmt->execute([$categorySlug]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $categoryId = $category['id'];
        $categoryName = $category['category_name'];
        $categoryImage = $category['category_image'];

        // Step 2: Get subcategories under the category
        $stmt = $pdo->prepare("SELECT id, subcategory_name, subcategory_image FROM subcategory WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the category info and subcategories
        echo "<div class='container py-5'>";
        echo "<h2 class='text-center mb-4'>Subcategories in <strong>" . htmlspecialchars($categoryName) . "</strong></h2>";
        echo "<div class='row'>";

        // Loop through subcategories and display them
        if ($subcategories) {
            foreach ($subcategories as $sub) {
                $subSlug = slugify($sub['subcategory_name']);
                $subImage = $sub['subcategory_image'];

                echo '<div class="col-lg-3 col-md-6 mb-4">';
                echo '<div class="category-item">';
                // Update this URL generation
echo '<a href="/product/' . urlencode($categorySlug) . '/' . urlencode($subSlug) . '">';

                echo '<div class="category-info">';
                echo '<div class="icon">';
                
                // Check if subcategory image exists
                if (!empty($subImage)) {
                    echo '<img src="/' . htmlspecialchars($subImage) . '" alt="' . htmlspecialchars($sub['subcategory_name']) . '" class="img-fluid">';
                } else {
                    echo '<img src="/' . htmlspecialchars($categoryImage) . '" alt="' . htmlspecialchars($sub['subcategory_name']) . '" class="img-fluid">';
                }
                
                echo '</div>';
                echo '<div class="content text-center">';
                echo '<h4>' . htmlspecialchars($sub['subcategory_name']) . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p class='text-muted'>No subcategories found under this category.</p>";
        }

        echo "</div></div>"; // Close row + container
    } else {
        echo "<p class='text-danger'>Category not found.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>






             
                    
                </div>
            </div>
        </div>
        <!-- category area end-->

                           

    </main>


    <!-- footer area -->
    <?php include "inc/footer.php"; ?> 


  


    <!-- js -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="/icon/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/icon/assets/js/modernizr.min.js"></script>
    <script src="/icon/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/icon/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="/icon/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/icon/assets/js/isotope.pkgd.min.js"></script>
    <script src="/icon/assets/js/jquery.appear.min.js"></script>
    <script src="/icon/assets/js/jquery.easing.min.js"></script>
    <script src="/icon/assets/js/owl.carousel.min.js"></script>
    <script src="/icon/assets/js/counter-up.js"></script>
    <script src="/icon/assets/js/jquery-ui.min.js"></script>
    <script src="/icon/assets/js/jquery.nice-select.min.js"></script>
    <script src="/icon/assets/js/countdown.min.js"></script>
    <script src="/icon/assets/js/wow.min.js"></script>
    <script src="/icon/assets/js/main.js"></script>

</body>

</html>