<?php
require_once '../db/credential.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Усі поля обов'язкові";
    } elseif ($username === $credentials['userName'] && $password === $credentials['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = time();
        header('Location: /index.php');
        exit;
    } else {
        $error = "Невірне ім'я користувача або пароль";
    }
}
?>

<?php include '../header.php'; ?>

<main class="login-page">
  <h1>Вхід</h1>
  <?php if (isset($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <form method="post" action="/pages/login.php" class="login-form">
    <div class="form-group">
      <label for="username">Ім'я користувача:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Пароль:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn--primary">Увійти</button>
  </form>
  <p>Немає акаунта? <a href="/pages/register.php">Зареєструйтесь</a></p>
</main>

<?php include '../footer.php'; ?>
