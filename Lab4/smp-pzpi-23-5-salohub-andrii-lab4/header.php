<?php
if (!isset($_SESSION['username']) && !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'register.php', 'page404.php'])) {
    header('Location: /pages/page404.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo (basename(__DIR__) == 'pages') ? '../style.css' : '/style.css'; ?>">
  <title>Магазин Весна</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <nav class="nav">
        <div class="nav__item">
          <a href="/index.php" class="nav__link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'nav__link--active' : ''; ?>">
            Головна
          </a>
        </div>
        <div class="nav__item">
          <a href="/pages/products.php" class="nav__link <?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'nav__link--active' : ''; ?>">
            Товари
          </a>
        </div>
        <div class="nav__item">
          <a href="/pages/cart.php" class="nav__link <?php echo (basename($_SERVER['PHP_SELF']) == 'cart.php') ? 'nav__link--active' : ''; ?>">
            Кошик
          </a>
        </div>
        <div class="nav__item">
          <a href="/pages/profile.php" class="nav__link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'nav__link--active' : ''; ?>">
            Профіль
          </a>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
          <div class="nav__item">
            <a href="/pages/logout.php" class="nav__link">
              Вийти
            </a>
          </div>
        <?php else: ?>
          <div class="nav__item">
            <a href="/pages/login.php" class="nav__link <?php echo (basename($_SERVER['PHP_SELF']) == 'login.php') ? 'nav__link--active' : ''; ?>">
              Вхід
            </a>
          </div>
        <?php endif; ?>
      </nav>
    </header>
