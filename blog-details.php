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
    <title>Blog details</title>

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


<?php
// Function to generate slug exactly like listing page
function slugify($text) {
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  return empty($text) ? 'n-a' : $text;
}

// Get the slug from URL
if (isset($_GET['title'])) {
    $slug = $_GET['title'];

    // Fetch all blogs first
    $stmt = $pdo->query("SELECT * FROM blogs");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $foundBlog = null;

    foreach ($blogs as $blog) {
        if (slugify($blog['blog_title']) === $slug) {
            $foundBlog = $blog;
            break;
        }
    }
}
else {
    echo "No blog selected.";
}
?>



    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">Blog Details </h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Blog Details</li>
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
        <div class="blog-area py-90">
            <div class="container">
                <div class="row">
					<div class="col-lg-8">
                        <div class="blog-single-wrap">
                            <div class="blog-single-content">
                                <div class="blog-thumb-img">
                                <img src="<?php echo htmlspecialchars($blog['blog_image']); ?>" alt="thumb">
                                </div>
                                <div class="blog-info">
                                    <div class="blog-meta">
                                        <div class="blog-meta-left">
                                            <ul>
                                            <li><i class="far fa-user"></i><a href="#"><?php echo htmlspecialchars($blog['author']); ?></a></li>
                                            </ul>
                                        </div>
                                        <div class="blog-meta-right">
                                        </div>
                                    </div>
                                    <div class="blog-details">
                                    <h3 class="blog-details-title mb-20"><?php echo htmlspecialchars($blog['blog_title']); ?></h3>
                                    <p class="mb-10"><?php echo nl2br(strip_tags(html_entity_decode($blog['content']))); ?></p>
                                    </div>
                                   
                                </div>
                                
                            </div>
                        </div>
                    </div>
					<div class="col-lg-4">
                        <aside class="sidebar">
<?php
// 1. Define a simple and safe slugify function
function simpleSlugify($text) {
    // Convert to lowercase
    $text = strtolower($text);
    // Remove any character that is not alphanumeric, whitespace, or hyphen
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    // Replace multiple spaces or hyphens with single hyphen
    $text = preg_replace('/[\s-]+/', '-', $text);
    // Trim hyphens from beginning and end
    $text = trim($text, '-');
    return $text;
}

// 2. Fetch recent posts
$stmt = $pdo->query("SELECT id, blog_title, blog_image, created_at FROM blogs ORDER BY RAND() LIMIT 5");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>                       
                            
                            <!-- recent post -->
                            <div class="widget recent-post">
                                <h5 class="widget-title">Recent Post</h5>
                               <?php foreach ($blogs as $blog): 
      $slug = simpleSlugify($blog['blog_title']); 
  ?>
    <div class="recent-post-item">
        <div class="recent-post-img">
            <img src="<?= htmlspecialchars($blog['blog_image']) ?>" alt="thumb">
        </div>
        <div class="recent-post-bio">
            <h6>
              <a href="blog-details.php?title=<?= urlencode($slug) ?>">
                <?= htmlspecialchars($blog['blog_title']) ?>
              </a>
            </h6>
            <span><i class="far fa-clock"></i> <?= date("F d, Y", strtotime($blog['created_at'])) ?></span>
        </div>
    </div>
  <?php endforeach; ?>        
                            </div>
                           
                            
                        </aside>
                    </div>
                </div>
            </div>
       
       </div>
        <!-- blog area end -->
    
    </main>


    <?php include ('inc/footer.php'); ?>


    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
    <!-- scroll-top end -->


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