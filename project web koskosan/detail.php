<?php
include 'db.php';
$id = $_GET['id'] ?? null;

$stmt = $conn->prepare("SELECT * FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$kos = $result->fetch_assoc();

if (!$kos) {
  echo "<h2>Kos tidak ditemukan!</h2>";
  exit;
}

$gambar = $kos['gambar'];
$gambarSrc = filter_var($gambar, FILTER_VALIDATE_URL) ? $gambar : 'images/' . $gambar;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($kos['nama']) ?> - Detail Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">JuraganKost</h1>
    <div class="space-x-4">
      <a href="index.php" class="text-gray-700 hover:text-blue-600">Beranda</a>
      <a href="login.php" class="text-gray-700 hover:text-blue-600">Masuk</a>
      <a href="register.php" class="text-gray-700 hover:text-blue-600">Daftar</a>
    </div>
  </nav>

  <!-- Detail Kos -->
  <section class="max-w-4xl mx-auto my-12 p-6 bg-white rounded-lg shadow">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div>
        <img src="<?= htmlspecialchars($gambarSrc) ?>" alt="Gambar Kos" class="w-full h-64 object-cover rounded-lg mb-4" />
        <h2 class="text-3xl font-bold"><?= htmlspecialchars($kos['nama']) ?></h2>
        <p class="text-gray-600"><?= htmlspecialchars($kos['alamat']) ?></p>
        <p class="text-blue-600 font-semibold text-lg mt-2">Rp<?= number_format($kos['harga'], 0, ',', '.') ?> / bulan</p>
        <p class="text-gray-700 mt-4"><?= nl2br(htmlspecialchars($kos['deskripsi'])) ?></p>
      </div>
      <div>
        <h2 class="text-2xl font-semibold mb-4">Lokasi Kos</h2>
        <div class="w-full h-72 rounded-lg overflow-hidden shadow">
          <iframe 
            src="<?= htmlspecialchars($kos['maps']) ?>"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
    </div>

    <!-- Tombol Sewa -->
    <div class="mt-8 text-center">
      <a href="form_sewa.php?id=<?= urlencode($kos['id']) ?>" class="bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-700 transition inline-block">
        Sewa Sekarang
      </a>
    </div>
  </section>

  <footer class="text-center p-4 mt-12 text-sm text-gray-500">
    &copy; 2025 JuraganKost
  </footer>
</body>
</html>
