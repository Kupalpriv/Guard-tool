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
    <textarea name="cookie" id="cookie" required></textarea>
    <br>
    <button type="submit">Enable Profile Guard</button>
  </form>
</body>
</html>
