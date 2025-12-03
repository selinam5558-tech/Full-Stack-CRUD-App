<?php
require 'config.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();
if (!$user) { echo 'User not found'; exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>View User</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>View User</h1>
    <p><a class="btn" href="index.php">Back to list</a></p>

    <table class="detail">
      <tr><th>ID</th><td><?php echo htmlspecialchars($user['id']); ?></td></tr>
      <tr><th>Name</th><td><?php echo htmlspecialchars($user['name']); ?></td></tr>
      <tr><th>Email</th><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
      <tr><th>Created</th><td><?php echo htmlspecialchars($user['created_at']); ?></td></tr>
    </table>
  </div>
</body>
</html>
