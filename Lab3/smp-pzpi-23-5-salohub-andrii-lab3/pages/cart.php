<?php
require_once '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'remove' && isset($_POST['item_id'])) {
        $item_id = (int)$_POST['item_id'];
        update_cart_item($item_id, 0);
    }
}

$cart_items = get_cart_items();
$total = calculate_cart_total();
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
          <a href="products.php" class="nav__link">
              Товари
          </a>
        </div>
        <div class="nav__item">
          <a href="cart.php" class="nav__link nav__link--active">
              Кошик
          </a>
        </div>
      </nav>
    </header>
    <main class="cart-page">
      <h1>Ваш кошик</h1>
      <?php if (isset($_SESSION['checkout_success']) && $_SESSION['checkout_success']): ?>
        <div class="cart-page__success">
          <p>Дякуємо за ваше замовлення!</p>
          <a href="products.php" class="btn">Продовжити покупки</a>
        </div>
        <?php unset($_SESSION['checkout_success']); ?>
      <?php elseif (!empty($cart_items)): ?>
        <div class="cart-table">
          <div class="cart-table__header">
            <div class="cart-table__cell">ID</div>
            <div class="cart-table__cell">Назва</div>
            <div class="cart-table__cell">Ціна</div>
            <div class="cart-table__cell">Кількість</div>
            <div class="cart-table__cell">Сума</div>
            <div class="cart-table__cell">Дія</div>
          </div>
          <?php foreach ($cart_items as $index => $item): ?>
            <div class="cart-table__row <?php echo $index % 2 === 0 ? 'cart-table__row--even' : 'cart-table__row--odd'; ?>">
              <div class="cart-table__cell"><?php echo $index + 1; ?></div>
              <div class="cart-table__cell"><?php echo htmlspecialchars($item['name']); ?></div>
              <div class="cart-table__cell"><?php echo number_format($item['price'], 2); ?></div>
              <div class="cart-table__cell"><?php echo $item['quantity']; ?></div>
              <div class="cart-table__cell"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
              <div class="cart-table__cell">
                <form method="post" action="cart.php">
                  <input type="hidden" name="action" value="remove">
                  <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                  <button type="submit" class="btn-remove">
                    Видалити
                  </button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
          <div class="cart-table__footer">
            <div class="cart-table__cell">Всього</div>
            <div class="cart-table__cell"></div>
            <div class="cart-table__cell"></div>
            <div class="cart-table__cell"></div>
            <div class="cart-table__cell"><?php echo number_format($total, 2); ?></div>
            <div class="cart-table__cell"></div>
          </div>
        </div>
        <div class="cart-page__actions">
          <a href="products.php" class="btn">Продовжити покупки</a>
          <form method="post" action="checkout.php">
            <button type="submit" class="btn btn--primary">Оформити замовлення</button>
          </form>
        </div>
      <?php else: ?>
        <div class="cart-page__empty">
          <p>Ваш кошик порожній</p>
          <a href="products.php" class="btn">Перейти до покупок</a>
        </div>
      <?php endif; ?>
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
