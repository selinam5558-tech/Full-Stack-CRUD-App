<?php
require 'config.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();
if (!$user) { echo 'User not found'; exit; }

$errors = [];
$name = $user['name'];
$email = $user['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '') $errors[] = 'Name is required';
    if ($email === '') $errors[] = 'Email is required';
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email is invalid';

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit User</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Edit User</h1>
    <p><a class="btn" href="index.php">Back to list</a></p>

    <?php if ($errors): ?>
      <div class="errors">
        <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
      </div>
    <?php endif; ?>

    <form method="post" action="edit.php?id=<?php echo $id; ?>">
      <label>Name<br><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br>
      <label>Email<br><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></label><br>
      <button type="submit">Save</button>
    </form>
  </div>
</body>
</html>
