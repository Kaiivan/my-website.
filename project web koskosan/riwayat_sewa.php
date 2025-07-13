<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$nama_penyewa = $_SESSION['username'];

$query = $conn->prepare("SELECT * FROM penyewaan WHERE nama_penyewa = ?");
$query->bind_param("s", $nama_penyewa);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Sewa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 p-6">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-blue-600 text-center">Riwayat Sewa Kos</h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="space-y-6">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-xl font-semibold"><?= htmlspecialchars($row['nama_kos']) ?></h3>
            <p class="text-gray-600">Tanggal: <?= htmlspecialchars($row['tanggal']) ?></p>
            <p class="text-gray-600">Durasi: <?= htmlspecialchars($row['durasi']) ?> bulan</p>
            <p class="text-gray-600">Total Harga: Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500">Belum ada riwayat sewa.</p>
    <?php endif; ?>
  </div>
</body>
</html>
