<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

include 'header.php';
?>

<main>
  <?php
  switch ($page) {
      case 'cart':
          require_once 'pages/cart.php';
          break;
      case 'profile':
          require_once 'pages/profile.php';
          break;
      case 'products':
          require_once 'pages/products.php';
          break;
      case 'login':
          require_once 'pages/login.php';
          break;
      case 'register':
          require_once 'pages/register.php';
          break;
      case 'logout':
          require_once 'pages/logout.php';
          break;
      case 'checkout':
          require_once 'pages/checkout.php';
          break;
      default:
          if (!isset($_SESSION['username'])) {
              require_once 'pages/page404.php';
          } else {
              require_once 'index.php';
          }
          break;
  }
?>
</main>

<?php include 'footer.php'; ?>
