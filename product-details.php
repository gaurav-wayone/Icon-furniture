<?php
session_start();
?>

<?php
require 'inc/db.php'; // Database connection




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
    <link rel="stylesheet" href="/icon/assets/css/flex-slider.min.css">
    <link rel="stylesheet" href="/icon/assets/css/style.css">

</head>
<style>
  /* General Product Info Section */
.shop-single-info {
    padding: 15px;
    border-radius: 8px;
    margin-left: 30px;
}



.shop-single-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
    text-transform: capitalize;
}

.product-short-description {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.6;
}

/* Product Details */
.shop-single-sortinfo ul.product-details {
    list-style: none;
    padding: 0;
    margin: 0;
}

.shop-single-sortinfo ul.product-details li {
    margin-bottom: 12px;
    font-size: 16px;
    line-height: 1.6;
    color: #555;
    display: flex;
    align-items: center;
}

.shop-single-sortinfo ul.product-details li strong {
    font-weight: 600;
    color: #333;
    width: 120px;
    text-transform: capitalize;
}

.shop-single-sortinfo ul.product-details li span {
    color: #777;
    font-weight: 400;
}

.shop-single-sortinfo ul.product-details li a {
    color: #007bff;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
}

.shop-single-sortinfo ul.product-details li a:hover {
    color: #0056b3;
}

/* Badges for Category, Subcategory, and Type */
.shop-single-sortinfo ul.product-details .badge {
    display: inline-block;
    padding: 8px 14px;
    margin-top: 5px;
    font-size: 14px;
    border-radius: 12px;
    text-transform: capitalize;
}

.shop-single-sortinfo ul.product-details .badge-category {
    background-color: #3498db;
    color: #fff;
}

.shop-single-sortinfo ul.product-details .badge-subcategory {
    background-color: #2ecc71;
    color: #fff;
}

.shop-single-sortinfo ul.product-details .badge-type {
    background-color: #f39c12;
    color: #fff;
}

/* Enquire Button */
.shop-single-btn {
    margin-top: 20px;
}

.theme-btn {
    background-color: #e67e22;
    color: #fff;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.theme-btn:hover {
    background-color: #d35400;
    transform: scale(1.05);
}

.shop-single-gallery ul li img {
    width: 100%;
    max-width: 600px;  /* fixed width */
    height: 480px;     /* fixed height */
    object-fit: cover; /* prevent stretching, crop instead */
    display: block;
    margin: 0 auto;    /* optional: center image */
}


@media (max-width: 767px) {
    .shop-single-info {
        padding: 20px;
    }

    .shop-single-title {
        font-size: 24px;
    }

    .shop-single-sortinfo ul.product-details li {
        font-size: 14px;
    }

    .theme-btn {
        padding: 10px 25px;
        font-size: 14px;
    }
}




</style>

<body>

   <?php include('inc/header.php'); ?>
   
    <?php
require('inc/db.php');

// Get slug from URL
$product_slug = $_GET['slug'] ?? '';

if (empty($product_slug)) {
    echo "<div class='alert alert-danger'>Invalid product slug.</div>";
    exit;
}

try {
    // Fetch product with category name by slug
    $stmt = $pdo->prepare("
        SELECT 
            p.id, 
            p.product_name, 
            p.product_image,
            p.type,
            p.description, 
            p.additional_info, 
            p.short_description, 
            p.subcategory_name,
            p.slug,
            c.category_name
        FROM product AS p
        INNER JOIN category AS c ON p.category_id = c.id
        WHERE p.slug = :product_slug
    ");

    $stmt->execute(['product_slug' => $product_slug]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<div class='alert alert-danger'>Product not found.</div>";
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>


    <main class="main">

        <!-- breadcrumb -->
        
        
        <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
           <h4 class="breadcrumb-title"><?= htmlspecialchars($product['product_name']) ?></h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
               <li class="active"><?= htmlspecialchars($product['product_name']) ?></li>
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

       


<!-- shop single -->
<div class="shop-single pt-30 pb-30">
    <div class="container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-9 col-lg-6 col-xxl-5">
                <div class="shop-single-gallery">
                    <ul>
                        <li data-thumb="<?= htmlspecialchars($product['product_image']) ?>">
                            <img src="/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" />
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Product Info -->
          <!-- Product Info -->
<div class="col-md-12 col-lg-6 col-xxl-6">
    <div class="shop-single-info">
        <h4 class="shop-single-title"><?= htmlspecialchars($product['product_name']) ?></h4>

        <p class="mb-3 product-short-description">
            <?= htmlspecialchars($product['short_description']) ?>
        </p>

        <div class="shop-single-sortinfo">
            <ul class="product-details">
                <li><strong>Category:</strong> <span class="badge badge-category"><?= htmlspecialchars($product['category_name']) ?></span></li>
                <li><strong>Subcategory:</strong> <span class="badge badge-subcategory"><?= htmlspecialchars($product['subcategory_name']) ?></span></li>
                <li><strong>Type:</strong> <span class="badge badge-type"><?= htmlspecialchars($product['type']) ?></span></li>
                <li><strong>Brand:</strong> <a href="#" class="brand-link">Icon Furniture</a></li>
            </ul>
        </div>

        <div class="shop-single-action">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-12 col-xl-6">
                    <div class="shop-single-btn">
                        <a href="#" class="theme-btn" title="Enquire Now" onclick="openEnquiryForm(<?= $product['id'] ?>)">Enquire Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        </div>
    </div>
</div>


<style>
    .shop-single-details{
        margin-top: 1px;
    }
</style>

                <!-- shop single details -->
                <div class="shop-single-details">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-tab1" data-bs-toggle="tab" data-bs-target="#tab1"
                                type="button" role="tab" aria-controls="tab1" aria-selected="true">Description</button>
                            <button class="nav-link" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#tab2"
                                type="button" role="tab" aria-controls="tab2" aria-selected="false">Additional
                                Info</button>
                            
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="nav-tab1">
                            <div class="shop-single-desc">
                          <?php echo html_entity_decode($product['description']); ?>

                               
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="nav-tab2">
                            <div class="shop-single-additional">
                                
                                <?php echo html_entity_decode($product['additional_info']); ?>

                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- shop single details end -->
            </div>
        </div>
        <!-- shop single end -->
        
        <style>
            .shop-single-desc{
                margin: 20px ;
            }
            
            .shop-single-desc{
                padding-top: 0px !important;
            } 
            .shop-single-additional{
                padding-top: 0px !important;
            }
            
             .shop-single-additional{
                margin: 20px ;
            }
        </style>

    </main>

<!-- Enquiry Form Modal -->
<div id="enquiryModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEnquiryForm()">&times;</span>
    <h2>Enquire Now</h2>
    <form action="https://iconfurniture.in/enquiry.php" method="POST">
      <input type="hidden" name="product_id" id="product_id">
      <div class="col-lg-12 mt-2">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder=" Name" required>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="form-group">
                    <textarea name="message" cols="30" rows="4" class="form-control" placeholder="Your Message"></textarea>
                </div>
            </div>
      <button type="submit" class="theme-btn mt-3 text-center">Submit Enquiry</button>
    </form>
  </div>
</div>

<!-- CSS for Modal Styling -->
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
  }

  .modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

   
  .modal-content h2{
      margin-bottom: 15px;
  }

  .close {
    float: right;
    font-size: 24px;
    cursor: pointer;
  }
  
  .form-control{
      border-radius: 20px;
      border: 1px solid #333;
      margin-bottom: 10px;
  }
  
</style>

<!-- JavaScript for Modal Functionality -->
<script>
  function openEnquiryForm(productId) {
    document.getElementById('enquiryModal').style.display = 'block';
    document.getElementById('product_id').value = productId;
  }

  function closeEnquiryForm() {
    document.getElementById('enquiryModal').style.display = 'none';
  }

  window.onclick = function(event) {
    const modal = document.getElementById('enquiryModal');
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  }
</script>

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
    <script src="/icon/assets/js/flex-slider.js"></script>
    <script src="/icon/assets/js/main.js"></script>

</body>

</html>