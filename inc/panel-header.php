


    <!-- header area -->
  
    <?php

include ('../inc/db.php');
// Count total items in the cart
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}


$wishlist_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Count wishlist items for the logged-in user
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM wishlist WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $wishlist_count = $result['total'];
}
?>
   
<header class="header">
    <!-- navbar -->
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                <a class="navbar-brand" href="../index.php">
                    <img src="../icon/assets/img/logo/logo.png" alt="logo">
                </a>
                <div class="mobile-menu-right">
                    <div class="mobile-menu-btn">
                        <a href="#" class="nav-right-link search-box-outer"><i class="far fa-search"></i></a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="wishlist.php" class="nav-right-link">
                                <i class="far fa-heart"></i><span>2</span>
                            </a>
                        <?php endif; ?>
                        <a href="../cart.php" class="nav-right-link"><i class="far fa-shopping-bag"></i><span>5</span></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <a href="../index.php" class="offcanvas-brand" id="offcanvasNavbarLabel">
                            <img style="width: 300px;" src="assets/img/logo/logo.png" alt="">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-lg-5">
                            <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="../about.php">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="../shop.php">Shop</a></li>
                            <li class="nav-item"><a class="nav-link" href="../blog.php">Blogs</a></li>
                            <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
                        </ul>
                        <div class="nav-right">
                            <ul class="nav-right-list">
                                <li><a href="#" class="list-link search-box-outer"><i class="far fa-search"></i></a></li>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li>
    <a href="wishlist.php" class="list-link">
        <i class="far fa-heart"></i>
        <span><?= $wishlist_count ?></span>
    </a>
</li>
                                <?php endif; ?>
                                <li>
    <a href="../cart.php" class="list-link">
        <i class="far fa-shopping-bag"></i>
        <span><?php echo $cart_count; ?></span>
    </a>
</li>
                            </ul>
                            <div class="nav-right-btn">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="dashboard.php" class="theme-btn theme-btn2">
                                        <span class="far fa-user"></span> Dashboard
                                    </a>
                                <?php else: ?>
                                    <a href="../login.php" class="theme-btn theme-btn2">
                                        <span class="far fa-user-tie"></span> Login
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->
</header>



    <!-- popup search -->
    <div class="search-popup">
        <button class="close-search"><span class="far fa-times"></span></button>
        <form action="#">
            <div class="form-group">
                <input type="search" name="search-field" class="form-control" placeholder="Search Here..." required>
                <button type="submit"><i class="far fa-search"></i></button>
            </div>
        </form>
    </div>
    <!-- popup search end -->