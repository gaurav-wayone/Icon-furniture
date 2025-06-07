<?php
session_start();
include ('inc/db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

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

.product-item .type.trending{
    background: #ffb703;
}

.product-item .type.featured{
    background: #2a9d8f;
}

.product-item .type.best-sale{
    background: #800080;
}


    </style>

</head>

<body>

<?php include('inc/header.php'); ?>


    <main class="main">

        <!-- breadcrumb -->
        <!-- breadcrumb -->
        <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Products</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Products</li>
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


    <?php
require 'inc/db.php';

// First check if search-field is provided
$searchQuery = $_GET['search-field'] ?? null;

if (!empty($searchQuery)) {
    // -------------- SEARCH LOGIC -----------------
    try {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE product_name LIKE ?");
        $stmt->execute(['%' . $searchQuery . '%']);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

        echo "<div class='container py-5'>";
        echo "<h2 class='mb-4'>Search Results for <strong>" . htmlspecialchars($searchQuery) . "</strong></h2>";

        if ($products) {
            echo "<div class='row'>";
            foreach ($products as $product) {
                echo "<div class='col-md-6 col-lg-3 mt-4'>
                        <div class='product-item'>
                            <div class='product-img'>
                                <a href='/product-details/" . htmlspecialchars($product['slug']) . "'>
                                    <img src='/" . htmlspecialchars($product['product_image']) . "' alt='" . htmlspecialchars($product['product_name']) . "'>
                                </a>
                            </div>
                            <div class='product-content'>
                                <h3 class='product-title'>
                                    <a href='/product-details/" . htmlspecialchars($product['slug']) . "'>
                                        " . htmlspecialchars($product['product_name']) . "
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>";
            }
            echo "</div>";
        } else {
            echo "<p class='text-muted'>No products found for your search.</p>";
        }

        echo "</div>"; // Close container
    } catch (PDOException $e) {
        echo "<div class='container py-5'><p class='text-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</p></div>";
    }
} 
// If no search query, use category and subcategory slugs
else {
    // Extract category and subcategory slugs from the URL
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uriParts = explode('/', $uri);

    // Expected URL: /product/{categorySlug}/{subcategorySlug}
    $categorySlug = $uriParts[1] ?? null;
    $subcategorySlug = $uriParts[2] ?? null;

    if ($categorySlug && $subcategorySlug) {
        try {
            // Fetch category ID
            $stmt = $pdo->prepare("SELECT id FROM category WHERE slug = ?");
            $stmt->execute([$categorySlug]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$category) {
                echo "<div class='container py-5'><p class='text-danger'>Category not found.</p></div>";
                exit;
            }

            $categoryId = $category['id'];

            // Fetch subcategory
            $stmt = $pdo->prepare("SELECT slug, subcategory_name FROM subcategory WHERE slug = ? AND category_id = ?");
            $stmt->execute([$subcategorySlug, $categoryId]);
            $subcategory = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$subcategory) {
                echo "<div class='container py-5'><p class='text-danger'>Subcategory not found.</p></div>";
                exit;
            }

            // Fetch products
            $stmt = $pdo->prepare("SELECT * FROM product WHERE category_id = ? AND subcategory_slug = ?");
            $stmt->execute([$categoryId, $subcategory['slug']]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<div class='container py-5'>";
            echo "<h2 class='mb-4'>Products in <strong>" . htmlspecialchars($subcategory['subcategory_name']) . "</strong></h2>";

            if ($products) {
                echo "<div class='row'>";
                foreach ($products as $product) {
                    $type = strtolower($product['type']);
$badgeMap = [
       'hot' => ['class' => 'hot', 'text' => 'Hot'],
    'oss' => ['class' => 'oss', 'text' => 'Out of Stock'],
    'new' => ['class' => 'new', 'text' => 'New'],
    'trending' => ['class' => 'trending', 'text' => 'Trending'],
    'featured' => ['class' => 'featured', 'text' => 'Featured'],
    'popular' => ['class' => 'popular', 'text' => 'Popular'],
    'best_sale' => ['class' => 'best-sale', 'text' => 'Best Sale'],
    // Add more types as needed
];

$badgeClass = $badgeMap[$type]['class'] ?? '';
$badgeText = $badgeMap[$type]['text'] ?? '';

                    echo "<div class='col-md-6 col-lg-3 mt-4'>
                            <div class='product-item'>
                                <div class='product-img'>";

                    if ($badgeClass && $badgeText) {
    echo "<span class='type " . htmlspecialchars($badgeClass) . "'>" . htmlspecialchars($badgeText) . "</span>";
}

                    echo "              <a href='/product-details/" . htmlspecialchars($product['slug']) . "'>
                                            <img src='/" . htmlspecialchars($product['product_image']) . "' alt='" . htmlspecialchars($product['product_name']) . "'>
                                        </a>
                                    </div>
                                    <div class='product-content'>
                                        <h3 class='product-title'>
                                            <a href='/product-details/" . htmlspecialchars($product['slug']) . "'>
                                                " . htmlspecialchars($product['product_name']) . "
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>";
                }
                echo "</div>";
            } else {
                echo "<p class='text-muted'>No products found in this subcategory.</p>";
            }

            echo "</div>"; // Close container
        } catch (PDOException $e) {
            echo "<div class='container py-5'><p class='text-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</p></div>";
        }
    } else {
        echo "<div class='container py-5'><p class='text-danger'>Invalid URL structure. Please use <code>/product/{categorySlug}/{subcategorySlug}</code></p></div>";
    }
}
?>

















                                
                            </div>
                        </div>
                        <!-- pagination -->
                        <!-- Pagination -->

                        
                        <!-- pagination end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- shop-area end -->

    </main>


    <!-- footer area -->
    <?php include('inc/footer.php'); ?>


  


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