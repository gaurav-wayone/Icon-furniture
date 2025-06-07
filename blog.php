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

<body>

<?php include('inc/header.php'); ?>

    <main class="main">

        <!-- breadcrumb -->
       <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Blog</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Blog</li>
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

$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($blogs as $blog): 
        $slug = slugify($blog['blog_title']);
      ?>
    <div class="col-md-6 col-lg-4">
        <div class="blog-item wow fadeInUp" data-wow-delay=".25s">
            <div class="blog-item-img">
                <img src="<?php echo htmlspecialchars($blog['blog_image']); ?>" alt="Blog Image">
                <span class="blog-date">
                    <i class="far fa-calendar-alt"></i> 
                    <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                </span>
            </div>
            <div class="blog-item-info">
                <div class="blog-item-meta">
                    <ul>
                        <li><a href="#"><i class="far fa-user-circle"></i> By <?php echo htmlspecialchars($blog['author']); ?></a></li>
                        
                    </ul>
                </div>
                <h4 class="blog-title">
                   <a href="blog-details.php?title=<?= urlencode($slug) ?>">
                  <?= htmlspecialchars($blog['blog_title']) ?>
                </a>
                </h4>
                <p><?php 
$cleanContent = strip_tags(html_entity_decode($blog['content'])); // Decode and remove HTML tags
$shortContent = mb_substr($cleanContent, 0, 50); // Limit to 100 characters
echo nl2br($shortContent) . '...'; // Convert newlines to <br> and append ellipsis
?>
</p>
               <a class="theme-btn" href="blog-details.php?title=<?= urlencode($slug) ?>">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
               
            </div>
        </div>
    </div>
<?php endforeach; ?>

                   
                </div>
                <!-- pagination -->
                
                <!-- pagination end -->
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

    </main>


    <?php include ('inc/footer.php');?>


    <!-- js -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.7.1.min.js"></script>
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