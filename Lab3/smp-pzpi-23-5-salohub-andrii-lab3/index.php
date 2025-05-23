<?php
require_once './db/config.php';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Магазин Весна</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <nav class="nav">
        <div class="nav__item">
          <a href="index.php" class="nav__link nav__link--active">
              Головна
          </a>
        </div>
        <div class="nav__item">
          <a href="./pages/products.php" class="nav__link">
              Товари
          </a>
        </div>
        <div class="nav__item">
          <a href="./pages/cart.php" class="nav__link">
              Кошик
          </a>
        </div>
      </nav>
    </header>
    <main class="home-page">
      <h1>Вас вітає магазин "Весна"</h1>
      <p>Ласкаво просимо до онлайн-магазину!</p>
      <div class="home-page__buttons">
        <a href="./pages/products.php" class="btn">Перейти до покупок</a>
      </div>
    </main>
    <footer class="footer">
      <div class="footer__nav">
        <a href="index.php" class="footer__link">Головна</a> |
        <a href="./pages/products.php" class="footer__link">Товари</a> |
        <a href="./pages/cart.php" class="footer__link">Кошик</a> 
      </div>
    </footer>
  </div>
</body>
</html>
