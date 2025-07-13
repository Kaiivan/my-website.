<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
include 'partials.php';

// Ambil data dari database
$conn = new mysqli("localhost", "root", "", "juragankost");
$kosan = [];
$result = $conn->query("SELECT * FROM kosan");
while ($row = $result->fetch_assoc()) {
  $kosan[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Konten -->
  <section class="max-w-6xl mx-auto my-12 px-4">
    <h2 class="text-3xl font-bold mb-6 text-blue-600">Kos yang Tersedia</h2>

    <?php if (empty($kosan)): ?>
      <p class="text-center text-gray-600">Belum ada kos yang tersedia saat ini.</p>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($kosan as $kos): ?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="images/<?= htmlspecialchars($kos['gambar']) ?>" alt="<?= htmlspecialchars($kos['nama']) ?>" class="w-full h-48 object-cover">
            <div class="p-4">
              <h3 class="text-xl font-semibold"><?= htmlspecialchars($kos['nama']) ?></h3>
              <p class="text-gray-500"><?= htmlspecialchars($kos['alamat']) ?></p>
              <p class="text-sm text-gray-600">Jenis: <?= htmlspecialchars($kos['jenis']) ?></p>
              <p class="text-blue-600 font-bold mt-2">Rp<?= number_format($kos['harga'], 0, ',', '.') ?> / bulan</p>
              <a href="detail.php?id=<?= urlencode($kos['id']) ?>" class="inline-block mt-4 text-blue-500 hover:underline">Lihat Detail</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
  
  <!-- Tombol Aksi Pengguna -->
  <section class="text-center my-12 space-x-4">
    <a href="riwayat_sewa.php" class="inline-block bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded hover:bg-blue-50 transition">Riwayat Sewa</a>
    <a href="admin.php" class="inline-block bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded hover:bg-blue-50 transition">Tambah Kos</a>
    <a href="kelola_akun.php" class="inline-block bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded hover:bg-blue-50 transition">Kelola Akun</a>
  </section>

</body>
</html>
