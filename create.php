<?php
require 'config.php';

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '') $errors[] = 'Name is required';
    if ($email === '') $errors[] = 'Email is required';
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email is invalid';

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, created_at) VALUES (:name, :email, NOW())");
        $stmt->execute(['name' => $name, 'email' => $email]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create User</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Create User</h1>
    <p><a class="btn" href="index.php">Back to list</a></p>

    <?php if ($errors): ?>
      <div class="errors">
        <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
      </div>
    <?php endif; ?>

    <form method="post" action="create.php">
      <label>Name<br><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br>
      <label>Email<br><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></label><br>
      <button type="submit">Create</button>
    </form>
  </div>
</body>
</html>
