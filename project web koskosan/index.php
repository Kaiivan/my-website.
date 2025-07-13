<?php
include 'db.php';

// Ambil data dari database
$kosan = [];
$result = $conn->query("SELECT * FROM kosan");
while ($row = $result->fetch_assoc()) {
  $kosan[] = $row;
}

// Ambil data pencarian
$search = $_GET['search'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$jenis = $_GET['jenis'] ?? '';

// Filter hasil
$filtered = [];
foreach ($kosan as $kos) {
  $match = true;

  if ($search && stripos($kos['nama'], $search) === false && stripos($kos['alamat'], $search) === false) {
    $match = false;
  }

  if ($max_price && $kos['harga'] > (int)$max_price) {
    $match = false;
  }

  if ($jenis && isset($kos['jenis']) && strtolower($kos['jenis']) !== strtolower($jenis)) {
    $match = false;
  }

  if ($match) {
    $filtered[] = $kos;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>JuraganKost</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JuraganKost</h1>
    <div class="space-x-4">
      <a href="index.php" class="text-gray-700 hover:text-blue-600">Beranda</a>
      <a href="login.php" class="text-gray-700 hover:text-blue-600">Masuk</a>
      <a href="register.php" class="text-gray-700 hover:text-blue-600">Daftar</a>
    </div>
  </nav>

  <!-- Hero -->
  <section class="bg-blue-100 py-16 px-4 text-center">
    <h2 class="text-4xl font-bold mb-4">Cari Kos Mudah dan Cepat</h2>
    <p class="mb-6 text-lg">Temukan kost terbaik sesuai kebutuhanmu di seluruh Indonesia</p>

    <!-- Pencarian -->
    <form method="GET" class="max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-3">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nama/lokasi..." class="p-3 border rounded w-full">
      <input type="number" name="max_price" value="<?= htmlspecialchars($max_price) ?>" placeholder="Harga maksimal" class="p-3 border rounded w-full">
      <select name="jenis" class="p-3 border rounded w-full">
        <option value="">Jenis Kos</option>
        <option value="Putra" <?= $jenis == 'Putra' ? 'selected' : '' ?>>Putra</option>
        <option value="Putri" <?= $jenis == 'Putri' ? 'selected' : '' ?>>Putri</option>
        <option value="Campur" <?= $jenis == 'Campur' ? 'selected' : '' ?>>Campur</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Cari</button>
    </form>
  </section>

  <!-- Daftar Kos -->
  <section class="p-6">
    <h3 class="text-2xl font-semibold mb-4">Kos Populer</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php if (empty($filtered)): ?>
        <p class="col-span-full text-center text-gray-500">Tidak ada kos yang cocok dengan pencarian.</p>
      <?php else: ?>
        <?php foreach ($filtered as $kos): ?>
          <?php
            $gambar = $kos['gambar'];
            $gambarSrc = filter_var($gambar, FILTER_VALIDATE_URL) ? $gambar : 'images/' . $gambar;
          ?>
          <div class="bg-white rounded-xl shadow p-4">
            <img src="<?= htmlspecialchars($gambarSrc) ?>" alt="Kos" class="rounded-lg mb-4 w-full h-48 object-cover" />
            <h4 class="text-xl font-bold"><?= htmlspecialchars($kos['nama']) ?></h4>
            <p class="text-gray-600"><?= htmlspecialchars($kos['alamat']) ?></p>
            <p class="text-blue-600 font-semibold mt-2">Rp<?= number_format($kos['harga'], 0, ',', '.') ?> / bulan</p>
            <a href="detail.php?id=<?= urlencode($kos['id']) ?>" class="text-blue-500 hover:underline mt-2 block">Lihat Detail</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="bg-blue-50 py-12 text-center mt-16">
    <h3 class="text-3xl font-semibold mb-4">Punya kos dan ingin dipromosikan?</h3>
    <p class="mb-6 text-lg">Daftarkan kosmu sekarang dan jangkau lebih banyak penyewa potensial.</p>
    <a href="admin.php" class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition">
      Daftarkan Kos Sekarang
    </a>
  </section>

  <!-- Footer -->
  <footer class="bg-white text-center p-4 mt-10 border-t">
    <p>&copy; 2025 JuraganKost. Dibuat untuk Cuan.</p>
  </footer>

</body>
</html>
