<?php
session_start();
?>
<?php
require_once 'inc/db.php'; // Database connection

$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot field to prevent bot submissions
    if (!empty($_POST['website'])) {
        $errorMsg = "Invalid submission detected.";
    } else {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $subject = htmlspecialchars(trim($_POST['subject']));
        $message = htmlspecialchars(trim($_POST['message']));

        if ($name && $email && $subject && $message) {
            try {
                $stmt = $pdo->prepare("INSERT INTO contact_form (name, email, subject, message, submitted_at) VALUES (:name, :email, :subject, :message, NOW())");
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':subject' => $subject,
                    ':message' => $message
                ]);
                $successMsg = "We look forward to assisting you and making your experience with us exceptional. Thank you for choosing Icon Furniture!";
            } catch (PDOException $e) {
                $errorMsg = "Database Error: " . $e->getMessage();
            }
        } else {
            $errorMsg = "Please fill in all fields correctly.";
        }
    }
}
?>

<?php


// Fetch contact details
$stmt = $pdo->query("SELECT * FROM contact_details LIMIT 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <h4 class="breadcrumb-title">Contact</h4>
            <ul class="breadcrumb-menu">
              <li>
                <a href="index.html">
                  <i class="far fa-home"></i> Home </a>
              </li>
              <li class="active">Contact</li>
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


        <!-- contact area -->
        <div class="contact-area pt-100 pb-80">
            <div class="container">
                <div class="contact-wrapper">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="contact-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="contact-info">
                                            <div class="contact-info-icon">
                                                <i class="fal fa-map-location-dot"></i>
                                            </div>
                                            <div class="contact-info-content">
                                                <h5>Office Address</h5>
                                                <p><?= htmlspecialchars($contact['address'] ?? 'N/A') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-info">
                                            <div class="contact-info-icon">
                                                <i class="fal fa-headset"></i>
                                            </div>
                                            <div class="contact-info-content">
                                                <h5>Call Us</h5>
                                                <p><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-info">
                                            <div class="contact-info-icon">
                                                <i class="fal fa-envelopes"></i>
                                            </div>
                                            <div class="contact-info-content">
                                                <h5>Email Us</h5>
                                                <p><?= htmlspecialchars($contact['email'] ?? 'N/A') ?></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="contact-info">
                                            <div class="contact-info-icon">
                                                <i class="fal fa-alarm-clock"></i>
                                            </div>
                                            <div class="contact-info-content">
                                                <h5>Open Time</h5>
                                                <p><?= htmlspecialchars($contact['opening_time'] ?? 'N/A') ?></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="contact-form">
                                <div class="contact-form-header">
                                    <h2>Get In Touch</h2>
                                    <p>We'd be delighted to hear from you! If you have a question, require support, or simply wish to give us your feedback, our team is here to assist you. Contact us using any of the methods below, and we'll respond as soon as possible. </p>
                                </div>
                                

<form method="post" action="contact.php" id="contact-form">
<?php if ($successMsg): ?>
        <div class="alert alert-success"><?php echo $successMsg; ?></div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Your Name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="subject" placeholder="Your Subject" required>
    </div>
    <div class="form-group">
        <textarea name="message" cols="30" rows="4" class="form-control" placeholder="Write Your Message" required></textarea>
    </div>

    <!-- Honeypot Field (Hidden from real users) -->
    <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">

    <button type="submit" class="theme-btn">Send Message <i class="far fa-paper-plane"></i></button>
    <div class="col-md-12 my-3">
        <div class="form-messege text-success"></div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end contact area -->


        

        <!-- map -->
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.4543891010044!2d77.13814187416924!3d28.64611028346631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d0339ee9ebc81%3A0x818df505bed0ca0!2sIcon%20furniture!5e0!3m2!1sen!2sin!4v1741346396434!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" ></iframe>
        </div>
        <!-- end map -->

    </main>


    <!-- footer area -->
    <?php include ('inc/footer.php'); ?>


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
    <script src="assets/js/contact-form.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>