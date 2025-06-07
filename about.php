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
<style>
      .hero-single {
    position: relative;
    overflow: hidden;
}

.testimonial-text {
    transition: max-height 0.3s ease-in-out;
}

.full {
    display: none; /* Hide full text initially */
}

.read-more-btn {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    padding: 0;
    font-size: 14px;
    margin-top: 5px;
}

</style>

<body>

    


    <!-- header area -->
   <!-- header area -->
   <?php include('inc/header.php'); ?>


    <main class="main">

       <div class="site-breadcrumb">
        <div id="dynamic-div" class="site-breadcrumb-bg" style="background: url(/icon/assets/img/breadcrumb/01.jpg)"></div>
        <div class="container">
          <div class="site-breadcrumb-wrap">
            <h4 class="breadcrumb-title">About</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">About</li>
            </ul>
          </div>
        </div>
      </div>
          <script>

        
let randomNumber = Math.floor(Math.random() * 5) + 1;

console.log(randomNumber); 

document.getElementById("dynamic-div").style.background = `url(/icon/assets/img/breadcrumb/0${randomNumber}.jpg)`

    </script>


        <!-- about area -->
        <div class="about-area py-120 mt-30 mb-30">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <img class="img-1" src="assets/img/about/01.jpg" alt="">
                                <img class="img-2" src="assets/img/about/02.jpg" alt="">
                                <img class="img-3" src="assets/img/about/03.jpg" alt="">
                            </div>
                            <div class="about-experience">
                                <div class="about-experience-icon">
                                    <img src="assets/img/icon/experience.svg" alt="">
                                </div>
                                <b>30 Years Of <br> Experience</b>
                            </div>
                            <div class="about-shape">
                                <img src="assets/img/shape/01.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline justify-content-start">
                                    <i class="flaticon-drive"></i> About Us
                                </span>
                                <h2 class="site-title">
                                    Bringing the Best-Quality Furniture <span>Just for You:</span> 
                                </h2>
                            </div>
                            <p>
                                From day one, we've made it our mission to offer high-end furniture that combines good looks, toughness, and usefulness. We started with a drive to create classic pieces that spruce up your home and last for years to come.
                            </p>
                            <div class="about-list">
                                <ul>
                                    <li><i class="fas fa-check-double"></i> Streamlined Shipping Experience</li>
                                    <li><i class="fas fa-check-double"></i> Affordable Modern Design</li>
                                    <li><i class="fas fa-check-double"></i> Competitive Price & Easy To Shop</li>
                                    <li><i class="fas fa-check-double"></i> We Made Awesome Products</li>
                                </ul>
                            </div>
                            <a href="contact.php" class="theme-btn mt-4">Discover More<i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


        <!-- counter area -->
        <div class="counter-area pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/sale.svg" alt="">
                            </div>
                            <div class="counter-info">
                                <div class="counter-amount">
                                    <span class="counter" data-count="+" data-to="50" data-speed="3000">50</span>
                                    <span class="counter-sign">k</span>
                                </div>
                                <h6 class="title">Total Sales </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/rate.svg" alt="">
                            </div>
                            <div class="counter-info">
                                <div class="counter-amount">
                                    <span class="counter" data-count="+" data-to="90" data-speed="3000">90</span>
                                    <span class="counter-sign">k</span>
                                </div>
                                <h6 class="title">Happy Clients</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/employee.svg" alt="">
                            </div>
                            <div class="counter-info">
                                <div class="counter-amount">
                                    <span class="counter" data-count="+" data-to="150" data-speed="3000">150</span>
                                    <span class="counter-sign">+</span>
                                </div>
                                <h6 class="title">Team Workers</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <img src="assets/img/icon/award.svg" alt="">
                            </div>
                            <div class="counter-info">
                                <div class="counter-amount">
                                    <span class="counter" data-count="+" data-to="30" data-speed="3000">30</span>
                                    <span class="counter-sign">+</span>
                                </div>
                                <h6 class="title">Win Awards</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter area end -->
        
        
          <!-- choose-area -->
        <div class="choose-area pt-100 pb-100">
            <div class="container">
                <div class="row g-4 align-items-center wow fadeInDown" data-wow-delay=".25s">
                    <div class="col-lg-4">
                        <span class="site-title-tagline">Why Us</span>
                        <h2 class="site-title">Why We're the Best Choice</h2>
                    </div>
                    <div class="col-lg-4">
                        <p>We are dedicated to providing you with the finest furniture options that combine durability, style, and affordability. Our goal is to help you create a home that stands out with pieces that not only look stunning but also offer exceptional value and lasting quality.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="choose-img">
                            <img src="assets/img/choose/01.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="choose-content wow fadeInUp" data-wow-delay=".25s">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="assets/img/icon/warranty.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>3 Years Warranty</h4>
                                    <p>We have confidence in the quality of our furniture and are backing it up with an extended 3-year warranty. That provides you with assurance, as you know that your purchase will be protected over the long term.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="assets/img/icon/price.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>Affordable Price</h4>
                                    <p>Good furniture need not be expensive. We offer trendy and durable pieces at prices that are economical without compromising quality.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="choose-item">
                                <div class="choose-icon">
                                    <img src="assets/img/icon/delivery.svg" alt="">
                                </div>
                                <div class="choose-info">
                                    <h4>Free Shipping</h4>
                                    <p>Enjoy free shipping on all orders. No charges, and no extras—just rapid and secure shipping straight to your doorstep.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- choose-area end-->


          <?php


// Fetch testimonials
$stmt = $pdo->query("SELECT * FROM testimonial ORDER BY id DESC");
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

        <!-- testimonial area -->
        <div class="testimonial-area bg ts-bg py-90">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-delay=".25s">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Testimonials</span>
                            <h2 class="site-title">What Our Client <span>Say's</span></h2>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-delay=".25s">
                <?php if ($testimonials): ?>
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="testimonial-item">
                <div class="testimonial-author">
                    <div class="testimonial-author-img">
                        <img src="<?php echo htmlspecialchars($testimonial['author_image']); ?>" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4><?php echo htmlspecialchars($testimonial['author_name']); ?></h4>
                        <p><?php echo htmlspecialchars($testimonial['author_role']); ?></p>
                    </div>
                </div>
               <div class="testimonial-quote">
    <?php 
        $fullText = htmlspecialchars($testimonial['testimonial_text']);
        $shortText = substr($fullText, 0, 100);
    ?>
    
    <p class="testimonial-text short"><?php echo $shortText; ?>...</p>
    <p class="testimonial-text full" style="display: none;"><?php echo $fullText; ?></p>

    <?php if (strlen($fullText) > 100): ?>
        <button class="read-more-btn">Read More</button>
    <?php endif; ?>
</div>



                <div class="testimonial-rate">
                    <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                        <i class="fas fa-star"></i>
                    <?php endfor; ?>
                    <?php for ($i = $testimonial['rating']; $i < 5; $i++): ?>
                        <i class="far fa-star"></i>
                    <?php endfor; ?>
                </div>
                <div class="testimonial-quote-icon">
                    <img src="assets/img/icon/quote.svg" alt="">
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

        <!-- video area -->
        <div class="video-area pt-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Video</span>
                            <h2 class="site-title">Let's check our latest <span>videos</span></h2>
                        </div>
                    </div>
                </div>
                <div class="video-content" style="background-image: url(assets/img/video/01.jpg);">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="video-wrapper">
                                <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video area end -->


       


        <!-- feature area -->
        <div class="feature-area2 pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
                <div class="feature-wrap">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fal fa-truck"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Free Delivery</h4>
                                    <p>Orders Over $120</p>
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


      <!-- instagram-area -->
      <div class="instagram-area pb-100">
            <div class="container wow fadeInUp" data-wow-delay=".25s">
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

        <!-- instagram-area end -->


        
         
    </main>


    

<?php include('inc/footer.php'); ?>


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