<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>JuraganKost</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Navbar -->
<nav class="bg-white shadow p-4 flex justify-between items-center">
  <h1 class="text-2xl font-bold text-blue-600">JuraganKost</h1>

  <div class="space-x-4">
    <?php if (isset($_SESSION['username'])): ?>
      <span class="text-gray-700">Halo, <?= htmlspecialchars($_SESSION['username']) ?></span>
      <a href="dashboard.php" class="text-gray-700 hover:text-blue-600">Dashboard</a>
      <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
    <?php else: ?>
      <a href="index.php" class="text-gray-700 hover:text-blue-600">Beranda</a>
      <a href="login.php" class="text-gray-700 hover:text-blue-600">Masuk</a>
      <a href="register.php" class="text-gray-700 hover:text-blue-600">Daftar</a>
    <?php endif; ?>
  </div>
</nav>
