<?php
require 'db.php';

$offset = isset($_GET['offset']) && is_numeric($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 16;

$query = "SELECT * FROM product WHERE 1 LIMIT :offset, :limit";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product) :
    list($badgeClass, $badgeText) = getProductTypeBadge($product['type']);
?>
    <div class="col-md-6 col-lg-3 mt-4 product-item">
        <div class="product-img">
            <?php if ($badgeClass && $badgeText) : ?>
                <span class="type <?php echo htmlspecialchars($badgeClass); ?>">
                    <?php echo htmlspecialchars($badgeText); ?>
                </span>
            <?php endif; ?>
            <a href="shop-details.php?id=<?php echo $product['id']; ?>">
                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </a>
        </div>
        <div class="product-content">
            <h3 class="product-title">
                <a href="shop-details.php?id=<?php echo $product['id']; ?>">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </a>
            </h3>
        </div>
    </div>
<?php endforeach; ?>
