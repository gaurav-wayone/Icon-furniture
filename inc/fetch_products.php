<?php
require 'db.php'; // Database connection
include 'header.php';

// Function to generate URL slugs from product names
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text ?: 'n-a');
}

// Pagination setup
$limit = 16;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Filters
$search = isset($_GET['search-field']) ? trim($_GET['search-field']) : null;
$category_id = isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Base query
$query = "SELECT * FROM product WHERE 1";
$params = [];

if ($category_id) {
    $query .= " AND category_id = :category_id";
    $params[':category_id'] = $category_id;
}

if ($search) {
    $query .= " AND product_name LIKE :search";
    $params[':search'] = "%$search%";
}

$query .= " LIMIT :limit OFFSET :offset";

// Prepare & bind
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Badge helper
function getProductTypeBadge($type) {
    $badges = [
        'hot' => ['hot', '🔥 HOT'],
        'oss' => ['oss', 'OUT OF STOCK'],
        'new' => ['new', '⭐ NEW'],
        'trending' => ['trending', 'Trending'],
        'featured' => ['featured', 'Featured'],
        'popular' => ['popular', 'Popular'],
        'best_sale' => ['best_sale', 'Best Sale']
    ];
    return $badges[strtolower($type)] ?? ['', ''];
}
?>

<div class="container py-5">
    <div class="row">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <?php
                    list($badgeClass, $badgeText) = getProductTypeBadge($product['type']);
                    $slug = slugify($product['product_name']);
                ?>
                <div class="col-md-6 col-lg-3 mt-4 product-item">
                    <div class="card">
                        <div class="product-img position-relative">
                            <?php if ($badgeClass && $badgeText): ?>
                                <span class="type position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                    <?php echo htmlspecialchars($badgeText); ?>
                                </span>
                            <?php endif; ?>
                            <a href="shop-details.php?id=<?php echo $product['id']; ?>&name=<?php echo urlencode($slug); ?>">
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="shop-details.php?id=<?php echo $product['id']; ?>&name=<?php echo urlencode($slug); ?>">
                                    <?php echo htmlspecialchars($product['product_name']); ?>
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">No products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
