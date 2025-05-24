<?php
require_once '../db/credential.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $error = "Реєстрація тимчасово недоступна";
}
?>

<?php include '../header.php'; ?>

<main class="register-page">
  <h1>Реєстрація</h1>
  <?php if (isset($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <schaft-form method="post" action="/pages/register.php" class="register-form">
    <div class="form-group">
      <label for="username">Ім'я користувача:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Пароль:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn--primary">Зареєструватись</button>
  </form>
  <p>Вже маєте акаунт? <a href="/pages/login.php">Увійдіть</a></p>
</main>

<?php include '../footer.php'; ?>
