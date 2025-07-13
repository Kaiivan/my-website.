<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$id = $_SESSION['user_id'];

// Ambil data user dari database
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$user = $query->get_result()->fetch_assoc();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username    = $_POST['username'] ?? '';
  $email       = $_POST['email'] ?? '';
  $newPassword = $_POST['password'] ?? '';

  if (empty($username) || empty($email)) {
    $error = "Username dan email wajib diisi!";
  } else {
    // Update username dan email
    $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $email, $id);
    $stmt->execute();

    $_SESSION['username'] = $username;

    // Jika ada input password baru, update juga
    if (!empty($newPassword)) {
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
      $stmt->bind_param("si", $hashedPassword, $id);
      $stmt->execute();
    }

    $success = "Data akun berhasil diperbarui!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-6">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-blue-600">Kelola Akun</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input name="username" placeholder="Username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required class="w-full p-3 border border-gray-300 rounded" />
      <input name="email" type="email" placeholder="Email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full p-3 border border-gray-300 rounded" />
      <input name="password" type="password" placeholder="Password baru (biarkan kosong jika tidak diganti)" class="w-full p-3 border border-gray-300 rounded" />
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
