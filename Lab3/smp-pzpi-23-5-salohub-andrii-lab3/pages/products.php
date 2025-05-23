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
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Магазин Весна</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <nav class="nav">
        <div class="nav__item">
          <a href="../index.php" class="nav__link">
              Головна
          </a>
        </div>
        <div class="nav__item">
          <a href="products.php" class="nav__link nav__link--active">
              Товари
          </a>
        </div>
        <div class="nav__item">
          <a href="cart.php" class="nav__link">
              Кошик
          </a>
        </div>
      </nav>
    </header>
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
    <footer class="footer">
      <div class="footer__nav">
        <a href="../index.php" class="footer__link">Головна</a> |
        <a href="products.php" class="footer__link">Товари</a> |
        <a href="cart.php" class="footer__link">Кошик</a>
      </div>
    </footer>
  </div>
</body>
</html>

