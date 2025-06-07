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
    <meta name="title" content="">
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
    </style>

</head>

<body>

<?php 
include('inc/header.php'); 

?>



    <main class="main">
    <!-- breadcrumb -->
    <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Category</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Category</li>
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
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Category</span>
                            <h2 class="site-title">Our Popular <span>Category</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                <?php
include 'inc/db.php';

// Better slugify function
function slugify($text) {
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}


try {
    $stmt = $pdo->prepare("SELECT id, category_name, category_image, slug FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        
        echo '<div class="col-lg-3 col-md-6">
                <div class="category-item">
                    <!-- Updated link to use clean URLs -->
                    <a href="subcategory/' . urlencode($category['slug']) . '">
                        <div class="category-info">
                            <div class="icon">
                                <img src="/' . htmlspecialchars($category['category_image']) . '" alt="">
                            </div>
                            <div class="content">
                                <h4>' . htmlspecialchars($category['category_name']) . '</h4>
                                <p>30 Items</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>';
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