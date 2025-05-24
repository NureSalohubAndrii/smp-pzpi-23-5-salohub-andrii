<?php
require_once '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if ($quantity > 0) {
            add_to_cart($product_id, $quantity);
        }
    }
}

$products = get_products();
?>

<?php include '../header.php'; ?>

<main class="products-page">
  <h1>Виберіть товари</h1>
  <div class="products-list">
    <?php foreach ($products as $product): ?>
      <div class="product-item">
        <form method="post" action="products.php">
          <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
          <div class="product-item__name"><?php echo htmlspecialchars($product['name']); ?></div>
          <div class="product-item__quantity">
            <input type="number" name="quantity" value="1" min="1" max="99" class="product-item__quantity-input">
          </div>
          <div class="product-item__price"><?php echo number_format($product['price'], 2); ?> грн</div>
          <div class="product-item__action">
            <button type="submit" class="btn">Додати</button>
          </div>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="products-page__action-buttons">
    <a href="cart.php" class="btn">Перейти до кошика</a>
  </div>
</main>

<?php include '../footer.php'; ?>
