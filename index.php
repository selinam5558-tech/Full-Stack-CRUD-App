<?php
require 'config.php';

// paging optional
$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE :s OR email LIKE :s ORDER BY id DESC");
    $stmt->execute(['s' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
}
$users = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Users - CRUD</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Users</h1>
    <p><a class="btn" href="create.php">Create New User</a></p>

    <form method="get" action="index.php" class="search">
      <input type="text" name="search" placeholder="Search name or email" value="<?php echo htmlspecialchars($search); ?>">
      <button type="submit">Search</button>
      <?php if($search): ?><a href="index.php" class="btn small">Clear</a><?php endif;?>
    </form>

    <?php if(count($users) === 0): ?>
      <p>No users found.</p>
    <?php else: ?>
      <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($users as $u): ?>
          <tr>
            <td><?php echo htmlspecialchars($u['id']); ?></td>
            <td><?php echo htmlspecialchars($u['name']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><?php echo htmlspecialchars($u['created_at']); ?></td>
            <td>
              <a href="view.php?id=<?php echo $u['id']; ?>">View</a> |
              <a href="edit.php?id=<?php echo $u['id']; ?>">Edit</a> |
              <a href="delete.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
