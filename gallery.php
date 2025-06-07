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
    <title>Fameo - Furniture Store HTML5 Template</title>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">
    <!-- css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body> <?php include('inc/header.php'); ?> <main class="main">
      <!-- breadcrumb -->
      <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Our Gallery</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Our Gallery</li>
            </ul>
          </div>
        </div>
      </div>
          <script>

        
let randomNumber = Math.floor(Math.random() * 5) + 1;

console.log(randomNumber); 

document.getElementById("dynamic-div").style.background = `url(/icon/assets/img/breadcrumb/0${randomNumber}.jpg)`

    </script>
      <!-- breadcrumb end --> <?php
require 'inc/db.php'; // Ensure this file correctly initializes $pdo

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
      <!-- gallery-area end -->
    </main> <?php include('inc/footer.php'); ?>
    <!-- scroll-top -->
    <a href="#" id="scroll-top">
      <i class="far fa-arrow-up-from-arc"></i>
    </a>
    <!-- scroll-top end -->
    <!-- js -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.appear.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/counter-up.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/countdown.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>