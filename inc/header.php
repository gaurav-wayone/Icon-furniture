


    <!-- header area -->
    
    <style>
        
        

/* Enable scrolling when the header exceeds a certain height */
.offcanvas-body {
    max-height: 80vh; /* Adjust height as needed */
    overflow-y: auto;
}

/* Ensure mega menu remains visible and scrollable */
.mega-content {
    max-height: 60vh;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Prevent dropdown from closing when clicking inside */
.dropdown-menu {
    pointer-events: auto !important;
}

    </style>
  
    

   
<header class="header">
    <!-- navbar -->
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">
                <a class="navbar-brand" href="https://iconfurniture.in">
                    <img src="/icon/assets/img/logo/logo.png" alt="logo">
                </a>
                <div class="mobile-menu-right">
                    <div class="mobile-menu-btn">
                        <a href="#" class="nav-right-link search-box-outer"><i class="far fa-search"></i></a>
                        
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
                        <a href="https://iconfurniture.in" class="offcanvas-brand" id="offcanvasNavbarLabel">
                            <img style="width: 300px;" src="/icon/assets/img/logo/logo.png" alt="">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-lg-5">
                            <li class="nav-item"><a class="nav-link" href="https://iconfurniture.in">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://iconfurniture.in/about.php">About</a></li><?php
require_once 'db.php';

try {
    $stmt = $pdo->prepare("
        SELECT c.id AS category_id, c.category_name, c.slug AS category_slug,
               s.id AS subcategory_id, s.subcategory_name, s.slug AS subcategory_slug,
               COUNT(*) OVER (PARTITION BY s.category_id) AS total_subcategories
        FROM (
            SELECT s.*, ROW_NUMBER() OVER (PARTITION BY s.category_id ORDER BY s.subcategory_name) as row_num 
            FROM subcategory s
        ) s
        JOIN category c ON c.id = s.category_id
        ORDER BY c.category_name, s.subcategory_name
    ");
    $stmt->execute();

    $categories = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[$row['category_name']]['id'] = $row['category_id'];
        $categories[$row['category_name']]['slug'] = $row['category_slug'];
        $categories[$row['category_name']]['subcategories'][] = [
            'id' => $row['subcategory_id'],
            'name' => $row['subcategory_name'],
            'slug' => $row['subcategory_slug'],
        ];
        $categories[$row['category_name']]['total'] = $row['total_subcategories'];
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<li class="nav-item mega-menu dropdown">
    <a class="nav-link dropdown-toggle" href="shop" data-bs-toggle="dropdown">Products</a>
    <div class="dropdown-menu fade-down">
        <div class="mega-content">
            <div class="container-fluid px-lg-0">
                <div class="row">
                    <?php foreach ($categories as $categoryName => $data): ?>
                        <div class="col-12 col-lg-2">
                            <h5 class="mega-menu-title">
                                <a href="/subcategory/<?= urlencode($data['slug']); ?>" class="category-link">
                                    <?= htmlspecialchars($categoryName); ?>
                                </a>
                            </h5>
                            <ul class="mega-menu-item">
                                <?php 
                                $subcategories = $data['subcategories'];
                                $hasMore = count($subcategories) > 4;
                                ?>

                                <!-- Show first 4 subcategories -->
                                <?php foreach (array_slice($subcategories, 0, 4) as $subcategory): ?>
                                    <li>
                                        <a class="dropdown-item" href="/product/<?= urlencode($data['slug']); ?>/<?= urlencode($subcategory['slug']); ?>">
                                            <?= htmlspecialchars($subcategory['name']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                                <!-- Hidden subcategories -->
                                <?php if ($hasMore): ?>
                                    <div class="more-subcategories d-none" id="more-<?= $data['id']; ?>">
                                        <?php foreach (array_slice($subcategories, 4) as $subcategory): ?>
                                            <li>
                                                <a class="dropdown-item" href="/product/<?= urlencode($data['slug']); ?>/<?= urlencode($subcategory['slug']); ?>">
                                                    <?= htmlspecialchars($subcategory['name']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- View More Button -->
                                    <li>
                                        <button class="btn btn-sm text-primary view-more-btn" data-category="<?= $data['id']; ?>">View More</button>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</li>




<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-more-btn").forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents the dropdown from closing on click
            let category = this.getAttribute("data-category");
            let moreList = document.getElementById("more-" + category);
            
            if (moreList.classList.contains("d-none")) {
                moreList.classList.remove("d-none");
                this.textContent = "View Less";
            } else {
                moreList.classList.add("d-none");
                this.textContent = "View More";
            }
        });
    });
});
</script>




<li class="nav-item"><a class="nav-link" href="https://iconfurniture.in/gallery.php">Gallery</a></li>

                            <li class="nav-item"><a class="nav-link" href="https://iconfurniture.in/blog.php">Blogs</a></li>
                            <li class="nav-item"><a class="nav-link" href="http://iconfurniture.in/contact.php">Contact</a></li>
                        </ul>
                        <div class="nav-right">
                            <ul class="nav-right-list">
                                <!-- <li><a href="#" class="list-link search-box-outer"><i class="far fa-search"></i></a></li> -->
                                <div class="search-box">
                                    
    <button class="btn-search"><i class="fas fa-search"></i></button>
    <form action="https://iconfurniture.in/product.php">
    <input type="search" name="search-field" class="input-search" placeholder="Type to Search...">
    </form>
  </div>

                                

                            </ul>
                            <div class="nav-right-btn">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->
</header>

<style>
     .search-box {
  width: fit-content;
  height: fit-content;
  position: relative;
  display: flex;
  align-items: center;
}

.btn-search i {
  color: #5C86B8;
}

.input-search {
  height: 40px;
  width: 40px;
  border: none;
  padding: 8px;
  font-size: 16px;
  letter-spacing: 1.4px;
  outline: none;
  border-radius: 20px;
  transition: all .4s ease-in-out;
  background-color: #f1b647;
  padding-right: 35px;
  color: #fff;
}

.input-search::placeholder {
  color: rgb(0, 0, 0);
  font-size: 16px;
  letter-spacing: 1.5px;
  font-weight: 500;
}

.btn-search {
  width: 40px;
  height: 40px;
  border: none;
  font-size: 18px;
  font-weight: bold;
  outline: none;
  cursor: pointer;
  border-radius: 50%;
  position: absolute;
  right: 0;
  color: #ffffff;
  background-color: transparent;
}

/* NEW: Use :focus-within to expand search input */
.search-box:focus-within .input-search {
  width: 250px;
  border-radius: 0;
  background-color: transparent;
  border-bottom: 1px solid rgb(0, 0, 0);
  transition: all 400ms cubic-bezier(0, 0.110, 0.35, 2);
}


/* === RESPONSIVE DESIGN === */

/* Smaller screens: Reduce search bar width */
@media (max-width: 768px) {
  .search-box:focus-within .input-search {
    width: 200px;
  }
}

/* Mobile screens: Adjust for better usability */
@media (max-width: 480px) {
  .search-box {
    width: 100%;
    justify-content: center;
  }

  .input-search {
    width: 35px;
    height: 35px;
    font-size: 14px;
    padding: 6px;
  }

  .btn-search {
    width: 35px;
    height: 35px;
    font-size: 16px;
  }

  .search-box:focus-within .input-search {
    width: 180px;
  }
}
</style>

    <!-- popup search -->
    <div class="search-popup">
        <button class="close-search"><span class="far fa-times"></span></button>
        <form action="shop">
            <div class="form-group">
                <input type="search" name="search-field" class="form-control" placeholder="Search Here..." required>
                <button type="submit"><i class="far fa-search"></i></button>
            </div>
        </form>
    </div>
    <!-- popup search end -->