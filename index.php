<?php
include "inc/db.php"; ?>
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
  <title>Icon Furniture </title>
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
    .view-more-container {
      text-align: right;
      margin-top: 10px;
    }
    
    .hs-3 .hero-single-bg{
            position: absolute;
    width: 100%;
    height: 86% !important;
    left: 0;
    top: 0;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    }

    .view-more-button {
      display: inline-block;
      text-decoration: none;
      color: rgb(15, 21, 29);

      border: 1px solid #5C86B8;
      padding: 6px 14px;
      font-size: 14px;
      font-weight: 600;

      cursor: pointer;
      animation: colorShift 5s infinite ease-in-out;
      transition: background-color 0.3s ease, color 0.3s ease;
    }



    /* === New Styles for Hero Section & Read More === */
    .hero-single {
      position: relative;
      overflow: hidden;
    }

    .testimonial-text {
      transition: max-height 0.3s ease-in-out;
    }

    .full {
      display: none;
      /* Hide full text initially */
    }

    .read-more-btn {

      border: none;
      color: #007bff;
      cursor: pointer;
      padding: 0;
      font-size: 14px;
      margin-top: 5px;
    }

    .hero-single-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
    }

    .hero-single::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 86%;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5));
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      color: white;
    }
    
    .hero-single-bg {
    height: 50vh; /* 80% of the viewport height */
    background-size: cover; /* Cover the entire container */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* No tiling */
}


    @media only screen and (max-width: 768px) {
      .home-3 .hero-single .hero-content .hero-title {
        font-size: 20px;
      }

      .hero-single .hero-content p {
        color: var(--color-white);
        line-height: 30px;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 25px;
      }
    }
    
    

    .view-more-container {
      text-align: right;
      /* Center-align the content */
      margin-top: 10px;
    }
  </style>
</head>

<body class="home-3">
  <?php include "inc/header.php"; ?>
  <!-- header area end -->
  <?php
    require "inc/db.php";

    $stmt = $pdo->query("SELECT * FROM slider ORDER BY id DESC");
    $sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
  <main class="main">
    <!-- hero slider -->
    <div class="hero-section hs-3">
      <div class="container-fluid px-0">
        <div class="hero-slider owl-carousel owl-theme">
          <?php foreach (
              $sliders
              as $slider
          ): ?>
          <div class="hero-single">
<div class="hero-single-bg" style="background-image: url('<?php echo htmlspecialchars($slider["image"]); ?>');" >

            </div>
            <div class="container">
              <div class="row align-items-center">
                <div class="col-md-12 col-lg-8 col-xl-6">
                  <div class="hero-content">
                    <h6 class="hero-sub-title">
                      <?php echo htmlspecialchars(
                          $slider["subtitle"]
                      ); ?>
                    </h6>
                    <h1 class="hero-title">
                      <?php echo htmlspecialchars(
                          $slider["title"]
                      ); ?>
                    </h1>
                    <p>
                      <?php echo htmlspecialchars(
                          $slider["description"]
                      ); ?>
                    </p>
                    <div class="hero-btn">
                      <a href="about.php" class="theme-btn theme-btn2">Learn More <i class="fas fa-arrow-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- hero slider end -->
    <?php
      // Fetch categories from the database
      $stmt = $pdo->query("SELECT * FROM category");
      $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
    <div class="product-area pb-30">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="site-heading-inline">
              <h2 class="site-title"></h2>
              <a href="category.php">View More <i class="fas fa-angle-double-right"></i>
              </a>
            </div>
          </div>
        </div>



        <!-- Category Area -->
        <div class="category-area3">
          <div class="container-fluid wow">
            <div class="category-slider owl-carousel owl-theme 
								<?php echo count($categories) === 1 ? " single-category": "" ; ?>">
              <?php foreach ( $categories as $category): ?>
              <div class="category-item">
                <a href="/icon/subcategory/<?php echo (urlencode($category['slug'])); ?>">
                  <div class="category-info">
                    <div class="icon">
                      <img src="/<?php echo htmlspecialchars($category["category_image"]); ?>" alt="<?php echo htmlspecialchars( $category["category_name"]); ?>"
                       style="width: 100px; height: 100px;
                      object-fit: cover; border-radius: 10px;">
                    </div>
                    <div class="content">
                      <h4>
                        <?php echo htmlspecialchars(
                        $category["category_name"]
                    ); ?>
                      </h4>
                    </div>
                  </div>
                </a>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <!-- category area end-->
        <!-- feature area -->
        <div class="feature-area2 pt-70 pb-90">
          <div class="container">
            <div class="feature-wrap">
              <div class="row g-0">
                <div class="col-12 col-md-6 col-lg-3">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="fal fa-truck"></i>
                    </div>
                    <div class="feature-content">
                      <h4>World Wide</h4>
                      <p>Delivery</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="fal fa-sync"></i>
                    </div>
                    <div class="feature-content">
                      <h4>Get Refund</h4>
                      <p>Within 30 Days Returns</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="fal fa-wallet"></i>
                    </div>
                    <div class="feature-content">
                      <h4>Safe Payment</h4>
                      <p>100% Secure Payment</p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                  <div class="feature-item">
                    <div class="feature-icon">
                      <i class="fal fa-headset"></i>
                    </div>
                    <div class="feature-content">
                      <h4>24/7 Support</h4>
                      <p>Feel Free To Call Us</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- feature area end -->
        <!-- trending item -->
        <div class="product-area pb-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="site-heading-inline">
          <h2 class="site-title">Hot Items</h2>
        </div>
      </div>
    </div>

    <div class="product-wrap item-2">
      <div class="product-slider owl-carousel owl-theme">
        <?php
        require "inc/db.php";

        // Fetch Hot Products
        $stmtHot = $pdo->prepare("SELECT * FROM product WHERE type = 'hot'");
        $stmtHot->execute();
        $hotProducts = $stmtHot->fetchAll(PDO::FETCH_ASSOC);

        // Function to get dynamic class and text based on product type
        function getProductTypeBadge($type) {
          switch (strtolower($type)) {
            case "hot": return ["hot", "🔥 HOT"];
            case "oss": return ["oss", "OUT OF STOCK"];
            case "new": return ["new", "⭐ NEW"];
            case "featured": return ["featured", "🌟 FEATURED"];
            default: return ["", ""];
          }
        }
        ?>

        <?php foreach ($hotProducts as $product): 
          list($badgeClass, $badgeText) = getProductTypeBadge($product["type"]); 
        ?>
        <div class="product-item">
          <div class="product-img">
            <?php if ($badgeText): ?>
              <span class="type <?php echo $badgeClass; ?>">
                <?php echo $badgeText; ?>
              </span>
            <?php endif; ?>

            <a href="/product-details/<?php echo htmlspecialchars($product["slug"]); ?>">
              <img 
                src="<?php echo htmlspecialchars($product["product_image"]); ?>" 
                alt="<?php echo htmlspecialchars($product["product_name"]); ?>" 
                style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px;"
              >
            </a>
          </div>

          <div class="product-content">
            <h3 class="product-title">
              <a href="/product-details/<?php echo htmlspecialchars($product["slug"]); ?>">
                <?php echo htmlspecialchars($product["product_name"]); ?>
              </a>
            </h3>

            <div class="product-bottom">
              <!-- You can add price, ratings, cart button here if needed -->
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>

        <!-- trending item end -->
        <!-- big banner -->
        <div class="big-banner">
          <div class="container">
            <div class="banner-wrap" style="background-image: url(/icon/assets/img/banner/big-banner.jpg);">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="banner-content">
                    <div class="banner-info">
                      <h6>Mega Collections</h6>
                      <h2>Huge Sale Up To <span>40%</span> Off </h2>
                      <p>at our outlet stores</p>
                    </div>
                    <a href="shop" class="theme-btn">View Products <i class="fas fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- big banner end -->
        <!-- featured item -->
      <!-- trending item -->
        <div class="product-area pt-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="site-heading-inline">
          <h2 class="site-title">Featured Items</h2>
        </div>
      </div>
    </div>
              
              </div>
            </div>
            
            
        
        <div class="product-wrap item-2">
      <div class="product-slider owl-carousel owl-theme">
        <?php
        require "inc/db.php";

        // Fetch Hot Products
        $stmtHot = $pdo->prepare("SELECT * FROM product WHERE type = 'featured'");
        $stmtHot->execute();
        $hotProducts = $stmtHot->fetchAll(PDO::FETCH_ASSOC);

        // Function to get dynamic class and text based on product type
      
        ?>

        <?php foreach ($hotProducts as $product): 
          list($badgeClass, $badgeText) = getProductTypeBadge($product["type"]); 
        ?>
        <div class="product-item">
          <div class="product-img">
            <?php if ($badgeText): ?>
              <span class="type <?php echo $badgeClass; ?>">
                <?php echo $badgeText; ?>
              </span>
            <?php endif; ?>

            <a href="/product-details/<?php echo htmlspecialchars($product["slug"]); ?>">
              <img 
                src="<?php echo htmlspecialchars($product["product_image"]); ?>" 
                alt="<?php echo htmlspecialchars($product["product_name"]); ?>" 
                style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px;"
              >
            </a>
          </div>

          <div class="product-content">
            <h3 class="product-title">
              <a href="/product-details/<?php echo htmlspecialchars($product["slug"]); ?>">
                <?php echo htmlspecialchars($product["product_name"]); ?>
              </a>
            </h3>

            <div class="product-bottom">
              <!-- You can add price, ratings, cart button here if needed -->
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>



  
        <!-- choose-area -->
        <div class="choose-area pt-100 pb-100">
          <div class="container">
            <div class="row g-4 align-items-center">
              <div class="col-lg-4">
                <span class="site-title-tagline">Why Choose Us</span>
                <h2 class="site-title">Why We're the Best Choice</h2>
              </div>
              <div class="col-lg-4">
                <p>We are committed to give you the best furniture options that are long-lasting, fashion-forward, and
                  budget-friendly. We strive to make your home shine with furniture that not just looks fantastic, but
                  is fantastic value as well.</p>
              </div>
              <div class="col-lg-4">
                <div class="choose-img">
                  <img src="/icon/assets/img/choose/01.jpg" alt="">
                </div>
              </div>
            </div>
            <div class="choose-content">
              <div class="row g-4">
                <div class="col-lg-4">
                  <div class="choose-item">
                    <div class="choose-icon">
                      <img src="/icon/assets/img/icon/warranty.svg" alt="">
                    </div>
                    <div class="choose-info">
                      <h4>5 Years Warranty</h4>
                      <p>We have confidence in the quality of our furniture and are backing it up with an extended
                        3-year warranty. That provides you with assurance, as you know that your purchase will be
                        protected over the long term.</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="choose-item">
                    <div class="choose-icon">
                      <img src="/icon/assets/img/icon/price.svg" alt="">
                    </div>
                    <div class="choose-info">
                      <h4>Affordable Price</h4>
                      <p>Good furniture need not be expensive. We offer trendy and durable pieces at prices that are
                        economical without compromising quality.</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="choose-item">
                    <div class="choose-icon">
                      <img src="/icon/assets/img/icon/delivery.svg" alt="">
                    </div>
                    <div class="choose-info">
                      <h4>Free Shipping</h4>
                      <p>Enjoy free shipping on all orders. No charges, and no extras—just rapid and secure shipping
                        straight to your doorstep.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- choose-area end-->
        <!-- brand area -->
        <!-- <div class="brand-area bg pt-50 pb-20"><div class="container wow fadeInUp" data-wow-delay=".25s"><div class="row"><div class="col-12"><div class="text-center"><h2 class="site-title">Trusted by over <span>3.2k+</span> companies</h2></div></div></div><div class="brand-slider owl-carousel owl-theme"><div class="brand-item"><img src="/icon/assets/img/brand/01.png" alt=""></div><div class="brand-item"><img src="/icon/assets/img/brand/02.png" alt=""></div><div class="brand-item"><img src="/icon/assets/img/brand/03.png" alt=""></div><div class="brand-item"><img src="/icon/assets/img/brand/04.png" alt=""></div><div class="brand-item"><img src="/icon/assets/img/brand/05.png" alt=""></div><div class="brand-item"><img src="/icon/assets/img/brand/06.png" alt=""></div></div></div></div> -->
        <!-- brand area end -->
        <!-- Features 2 Section -->
        <section id="features-2" class="features-2 section">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-4">
                <div class="feature-item text-end mb-5">
                  <div class="d-flex align-items-center justify-content-end gap-4">
                    <div class="feature-content">
                      <h3>Antistatic</h3>
                      <p>Icon furniture is a leading manufacturer of Outdoor furniture & accessories that boasts
                        longevity and low maintenance.</p>
                    </div>
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/antistatic.png" alt="">
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item text-end mb-5">
                  <div class="d-flex align-items-center justify-content-end gap-4">
                    <div class="feature-content">
                      <h3>Durable</h3>
                      <p>We are specializes in crafting durable furniture and accessories, built for lasting strength,
                        resilience, and minimal maintenance.</p>
                    </div>
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/link.png" alt="">
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item text-end mb-5">
                  <div class="d-flex align-items-center justify-content-end gap-4">
                    <div class="feature-content">
                      <h3>Disinfactable</h3>
                      <p>Icon Furniture designs furniture and accessories with easy-to-clean surfaces, ensuring optimal
                        hygiene and effortless disinfection.</p>
                    </div>
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/alcohol.png" alt="">
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item text-end mb-5">
                  <div class="d-flex align-items-center justify-content-end gap-4">
                    <div class="feature-content">
                      <h3>Breathable</h3>
                      <p>Icon Furniture crafts furniture with breathable materials, ensuring enhanced airflow and
                        lasting comfort.</p>
                    </div>
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/layers.png" alt="">
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item text-end">
                  <div class="d-flex align-items-center justify-content-end gap-4">
                    <div class="feature-content">
                      <h3>Recyclable</h3>
                      <p>Icon Furniture designs eco-friendly furniture using recyclable materials, promoting
                        sustainability without compromising quality.</p>
                    </div>
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/recycle-symbol.png" alt="">
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
              </div>
              <div class="col-lg-4">
                <div class="phone-mockup text-center">
                  <img src="/icon/assets/img/bs.png" alt="Phone Mockup" class="img-fluid">
                </div>
              </div>
              <!-- End Phone Mockup -->
              <div class="col-lg-4">
                <div class="feature-item mb-5">
                  <div class="d-flex align-items-center gap-4">
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/exchanche.png" alt="">
                    </div>
                    <div class="feature-content">
                      <h3>Fade Resistant</h3>
                      <p>We crafts fade-resistant furniture, ensuring long-lasting color vibrancy and durability even in
                        harsh sunlight.</p>
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item mb-5">
                  <div class="d-flex align-items-center gap-4">
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/water-resistance.png" alt="">
                    </div>
                    <div class="feature-content">
                      <h3>Stain Resistant</h3>
                      <p>Icon Furniture designs stain-resistant furniture, making cleaning effortless while maintaining
                        a pristine look for years.</p>
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item mb-5">
                  <div class="d-flex align-items-center gap-4">
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/mould.png" alt="">
                    </div>
                    <div class="feature-content">
                      <h3>Mould Resistant </h3>
                      <p>Icon Furniture crafts mold-resistant pieces, ensuring a hygienic and long-lasting addition to
                        any space.</p>
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item mb-5">
                  <div class="d-flex align-items-center gap-4">
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/clean-up.png" alt="">
                    </div>
                    <div class="feature-content">
                      <h3>Easy to Clean </h3>
                      <p>We crafts easy-to-clean furniture with surfaces that resist spills and dust, allowing for
                        effortless maintenance and a pristine look with minimal effort. </p>
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
                <div class="feature-item">
                  <div class="d-flex align-items-center gap-4">
                    <div class="feature-icon flex-shrink-0">
                      <img src="/icon/assets/img/protection.png" alt="">
                    </div>
                    <div class="feature-content">
                      <h3>UV Protection </h3>
                      <p>Icon Furniture designs UV-protected furniture that withstands prolonged sun exposure,
                        preventing fading and degradation while maintaining its vibrant appearance for years to come.
                      </p>
                    </div>
                  </div>
                </div>
                <!-- End .feature-item -->
              </div>
            </div>
          </div>
        </section>
        <!-- /Features 2 Section -->
        <style>
          /*--------------------------------------------------------------
# Features 2 Section
--------------------------------------------------------------*/
          .features-2 .feature-item .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: color-mix(in srgb, var(--accent-color), transparent 92%);
          }

          .features-2 .feature-item .feature-icon i {
            font-size: 24px;
            color: var(--accent-color);
          }

          .features-2 .feature-item .feature-content h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
          }

          .features-2 .feature-item .feature-content p {
            color: color-mix(in srgb, var(--default-color), transparent 25%);
            font-size: 15px;
            margin-bottom: 0;
          }

          .features-2 .phone-mockup {
            position: relative;
            padding: 30px 0;
          }

          .features-2 .phone-mockup img {
            max-width: 300px;
            height: auto;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            border-radius: 20px;
          }

          @media (max-width: 991.98px) {
            .features-2 .feature-item {
              text-align: center !important;
              margin-bottom: 2rem;
            }

            .features-2 .feature-item .d-flex {
              flex-direction: column;
              text-align: center;
              justify-content: center !important;
            }

            .features-2 .phone-mockup {
              margin: 3rem 0;
            }
          }
        </style>
        <?php
      require "inc/db.php"; // Ensure this file correctly initializes $pdo

      try {
          $stmt = $pdo->prepare("SELECT gallery_image FROM gallery");
          $stmt->execute();
          $galleries = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
      }
      ?>
        <!-- gallery-area -->
        <div class="gallery-area py-100">
          <div class="container">
            <div class="row">
              <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center">
                  <span class="site-title-tagline">Our Gallery</span>
                  <h2 class="site-title">Let's Check Our Photo <span>Gallery</span>
                  </h2>
                </div>
              </div>
            </div>
          <div class="row g-4 popup-gallery"> <?php foreach ($galleries as $gallery): ?> <div class="col-md-4 col-lg-3">
              <div class="gallery-item wow fadeInDown" data-wow-delay=".25s">
                <div class="gallery-img">
                  <img src="
																								<?= htmlspecialchars($gallery['gallery_image']) ?>" alt="Gallery Image">
                  <a class="popup-img gallery-link" href="
																									<?= htmlspecialchars($gallery['gallery_image']) ?>">
                    <i class="fal fa-plus"></i>
                  </a>
                </div>
              </div>
            </div> <?php endforeach; ?> </div>
        </div>
          </div>
        </div>
        <!-- gallery-area end -->
        <!-- gallery-area end -->
     <?php
// Fetch testimonials
$stmt = $pdo->query("SELECT * FROM testimonial ORDER BY id DESC");
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- testimonial area -->
<div class="testimonial-area bg ts-bg py-90">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="site-heading text-center">
          <span class="site-title-tagline">Testimonials</span>
          <h2 class="site-title">What Our Client <span>Say's</span></h2>
        </div>
      </div>
    </div>

    <div class="testimonial-slider owl-carousel owl-theme">
      <?php if ($testimonials): ?>
        <?php foreach ($testimonials as $testimonial): ?>
          <div class="testimonial-item">
            <div class="testimonial-author">
              <div class="testimonial-author-img">
                <img src="<?php echo htmlspecialchars($testimonial["author_image"]); ?>" alt="<?php echo htmlspecialchars($testimonial["author_name"]); ?>">
              </div>
              <div class="testimonial-author-info">
                <h4><?php echo htmlspecialchars($testimonial["author_name"]); ?></h4>
                <p><?php echo htmlspecialchars($testimonial["author_role"]); ?></p>
              </div>
            </div>

            <div class="testimonial-quote">
              <?php
              $fullText = htmlspecialchars($testimonial["testimonial_text"]);
              $shortText = mb_substr($fullText, 0, 100); // better for utf-8 text
              ?>
              <p class="testimonial-text short">
                <?php echo $shortText; ?>...
              </p>
              <p class="testimonial-text full" style="display: none;">
                <?php echo $fullText; ?>
              </p>
              <?php if (mb_strlen($fullText) > 100): ?>
                <button class="read-more-btn">Read More</button>
              <?php endif; ?>
            </div>

            <div class="testimonial-rate">
              <?php for ($i = 0; $i < $testimonial["rating"]; $i++): ?>
                <i class="fas fa-star"></i>
              <?php endfor; ?>
              <?php for ($i = $testimonial["rating"]; $i < 5; $i++): ?>
                <i class="far fa-star"></i>
              <?php endfor; ?>
            </div>

            <div class="testimonial-quote-icon">
              <img src="/icon/assets/img/icon/quote.svg" alt="Quote Icon">
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No testimonials found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

        <script>
          document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.read-more-btn').forEach(button => {
              button.addEventListener("click", function () {
                let parent = this.parentElement;
                let shortText = parent.querySelector('.short');
                let fullText = parent.querySelector('.full');
                if (fullText.style.display === "none") {
                  fullText.style.display = "block"; // Show full text
                  shortText.style.display = "none"; // Hide short text
                  this.innerText = "Read Less";
                } else {
                  fullText.style.display = "none"; // Hide full text
                  shortText.style.display = "block"; // Show short text
                  this.innerText = "Read More";
                }
              });
            });
          });
        </script>
        <!-- testimonial area end -->
    <?php
function slugify($text) {
  // Replace non-letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // Transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // Remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // Trim
  $text = trim($text, '-');
  // Remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // Lowercase
  $text = strtolower($text);
  return empty($text) ? 'n-a' : $text;
}

$stmt = $pdo->prepare("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- blog area -->
<div class="blog-area py-100">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="site-heading text-center">
          <span class="site-title-tagline">Our Blog</span>
          <h2 class="site-title">Our Latest News & <span>Blog</span></h2>
        </div>
      </div>
    </div>
    <div class="row g-4">
      <?php foreach ($blogs as $blog): 
        $slug = slugify($blog['blog_title']);
      ?>
        <div class="col-md-6 col-lg-4">
          <div class="blog-item">
            <div class="blog-item-img">
              <img src="<?= htmlspecialchars($blog['blog_image']) ?>" alt="Thumb">
              <span class="blog-date">
                <i class="far fa-calendar-alt"></i>
                <?= date("M d, Y", strtotime($blog['created_at'])) ?>
              </span>
            </div>
            <div class="blog-item-info">
              <div class="blog-item-meta">
                <ul>
                  <li>
                    <a href="#">
                      <i class="far fa-user-circle"></i> By <?= htmlspecialchars($blog['author']) ?>
                    </a>
                  </li>
                </ul>
              </div>
              <h4 class="blog-title">
                <a href="blog-details.php?title=<?= urlencode($slug) ?>">
                  <?= htmlspecialchars($blog['blog_title']) ?>
                </a>
              </h4>
              <a class="theme-btn" href="blog-details.php?title=<?= urlencode($slug) ?>">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- blog area end -->
<style>
    .blog-item-img{
        max-width: 500px;
        max-height: 278px;
        object-fit: cover;
    }
</style>

        <!-- instagram-area -->
       <div class="instagram-area pb-100">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="site-heading text-center">
          <h2 class="site-title">Instagram <span>@Icon furniture</span></h2>
        </div>
      </div>
    </div>
    <?php
    // Fetch Instagram data
    $stmt = $pdo->query("SELECT image_path, instagram_link FROM instagram");
    $instagramItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="instagram-slider owl-carousel owl-theme">
      <?php if ($instagramItems): ?>
        <?php foreach ($instagramItems as $item): ?>
          <div class="instagram-item">
            <div class="instagram-img">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="Instagram Image">
              <a href="<?= htmlspecialchars($item['instagram_link']) ?>" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No Instagram posts found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<!-- instagram-area end -->

  </main>
  <?php include "inc/footer.php"; ?>
  <!-- js -->
  <script src="/icon/assets/js/jquery-3.7.1.min.js"></script>
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