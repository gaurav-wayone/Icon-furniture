<?php
require_once 'db.php'; // Ensure database connection

// Fetch contact details
$stmt = $pdo->query("SELECT * FROM contact_details LIMIT 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all categories
$stmt = $pdo->query("SELECT id, category_name FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Footer Area -->
<footer class="footer-area">
    <div class="footer-widget">
        <div class="container">
            <div class="row footer-widget-wrapper pt-100 pb-40">
                <div class="col-md-6 col-lg-4">
                    <div class="footer-widget-box about-us">
                        <a href="https://iconfurniture.in" class="footer-logo">
                            <img src="/icon/assets/img/logo/logo.png" alt="">
                        </a>
                        <p class="mb-3">
                            We ensure to offer fine quality, classy and functional furniture for every taste and budget. 
                            We believe in workmanship, customer satisfaction, and ease of purchase. Grateful for believing in us 
                            and trusting us in making your abode even lovelier!
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Quick Links</h4>
                        <ul class="footer-list">
                            <li><a href="https://iconfurniture.in/about.php">About Us</a></li>
                            <li><a href="https://iconfurniture.in/contact.php">Contact Us</a></li>
                            <li><a href="https://iconfurniture.in/blog.php">Update Blogs</a></li>
                            <li><a href="https://iconfurniture.in/terms-of-service.php">Terms Of Service</a></li>
                            <li><a href="https://iconfurniture.in/privacy-policy.php">Privacy policy</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Support</h4>
                        <ul class="footer-list">
                            <li><a href="https://iconfurniture.in/return-policy.php">Returns Policy</a></li>
                            <li><a href="https://iconfurniture.in/sitemap.xml">Sitemap</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Contact Details</h4>
                        <ul class="footer-contact">
                            <?php
                            $phoneNumbers = explode(',', $contact['phone'] ?? 'N/A');
                            foreach ($phoneNumbers as $phone):
                                $phone = trim($phone);
                                if (!empty($phone) && $phone !== 'N/A'): ?>
                                    <li>
                                        <a href="tel:+91<?= htmlspecialchars($phone) ?>">
                                            <i class="far fa-phone"></i> <?= htmlspecialchars($phone) ?>
                                        </a>
                                    </li>
                                <?php endif; 
                            endforeach; ?>
                            <li><?= htmlspecialchars($contact['address'] ?? 'N/A') ?></li>
                            <li><a href="mailto:<?= htmlspecialchars($contact['email'] ?? 'N/A') ?>">
                                <i class="far fa-envelope"></i> <?= htmlspecialchars($contact['email'] ?? 'N/A') ?>
                            </a></li>
                            <li><i class="far fa-clock"></i><?= htmlspecialchars($contact['opening_time'] ?? 'N/A') ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="copyright-wrap">
                <div class="row">
                    <div class="col-12 col-lg-6 align-self-center">
                        <p class="copyright-text">
                            &copy; Copyright <span>2025</span> <a href="https://iconfurniture.com"> Icon Furniture </a> 
                            All Rights Reserved. & Made By <a href="https://wayone.co.in">Wayone</a>
                        </p>
                    </div>
                    <div class="col-12 col-lg-6 align-self-center">
                        <div class="footer-social">
                            <span>Follow Us:</span>
                            <a href="https://www.facebook.com/iconfurniture25"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/icon_furnitures13/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area End -->

<!-- Scroll-top -->
<a href="#" id="scroll-top"><i class="far fa-arrow-up-from-arc"></i></a>
<!-- Scroll-top End -->

<!-- JavaScript to Show More Categories -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let viewMoreBtn = document.getElementById("view-more-btn");
        let moreCategories = document.getElementById("more-categories");

        if (viewMoreBtn) {
            viewMoreBtn.addEventListener("click", function () {
                if (moreCategories.classList.contains("d-none")) {
                    moreCategories.classList.remove("d-none");
                    this.textContent = "View Less";
                } else {
                    moreCategories.classList.add("d-none");
                    this.textContent = "View More";
                }
            });
        }
    });
</script>
