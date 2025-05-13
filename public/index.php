<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;


$env = Dotenv::createImmutable(__DIR__ . '/../');
$env->load();

$cookie = $_ENV['FB_COOKIE'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Facebook Profile Guard</title>
  <style>
    body { font-family: sans-serif; max-width: 400px; margin: 2rem auto; }
    textarea { width: 100%; height: 6rem; }
    button { padding: .5rem 1rem; margin-top: 1rem; }
  </style>
</head>
<body>
  <h1>Facebook Profile Guard</h1>
  <form action="guard.php" method="POST">
    <label for="cookie">Facebook Cookie:</label><br>
    <textarea name="cookie" id="cookie" required><?php echo htmlspecialchars($cookie); ?></textarea>
    <br>
    <button type="submit">Enable Profile Guard</button>
  </form>
</body>
</html>
