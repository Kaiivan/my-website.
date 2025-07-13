<?php
session_start();
include 'partials.php';

// Ambil data sewa terakhir dari sesi (atau bisa juga dari database jika pakai ID)
$nama_kos     = $_SESSION['sewa_nama_kos'] ?? '';
$nama_penyewa = $_SESSION['sewa_nama_penyewa'] ?? '';
$tanggal      = $_SESSION['sewa_tanggal'] ?? '';
$durasi       = $_SESSION['sewa_durasi'] ?? '';
?>

<section class="max-w-xl mx-auto my-12 bg-white p-8 rounded shadow text-center">
  <h2 class="text-3xl font-bold text-green-600 mb-6">Pemesanan Berhasil!</h2>
  <p class="text-lg mb-4">Terima kasih, <strong><?= htmlspecialchars($nama_penyewa) ?></strong> telah menyewa <strong><?= htmlspecialchars($nama_kos) ?></strong>.</p>
  <p class="text-gray-700 mb-6">Tanggal Mulai: <?= htmlspecialchars($tanggal) ?><br>Durasi: <?= htmlspecialchars($durasi) ?> bulan</p>
  
  <a href="pembayaran.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Lanjut ke Pembayaran</a>
</section>

<?php include 'footer.php'; ?>
