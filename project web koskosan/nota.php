<?php
session_start();

// Cek data session pembayaran
if (!isset($_SESSION['sewa']) || !isset($_POST['metode_pembayaran']) || !isset($_POST['nominal_pembayaran'])) {
  echo "<h2>Data pembayaran tidak lengkap!</h2>";
  exit;
}

$sewa = $_SESSION['sewa'];
$metode = htmlspecialchars($_POST['metode_pembayaran']);
$nominal = (int) $_POST['nominal_pembayaran'];
$total = (int) $sewa['total_harga'];
$kembalian = $nominal > $total ? $nominal - $total : 0;

// Tentukan link kembali
$link_kembali = isset($_SESSION['user_id']) ? 'dashboard.php' : 'index.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nota Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <section class="max-w-xl mx-auto bg-white p-6 mt-10 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Nota Pembayaran</h2>

    <p><strong>Nama Kos:</strong> <?= htmlspecialchars($sewa['nama_kos']) ?></p>
    <p><strong>Nama Penyewa:</strong> <?= htmlspecialchars($sewa['nama_penyewa']) ?></p>
    <p><strong>No HP:</strong> <?= htmlspecialchars($sewa['no_hp']) ?></p>
    <p><strong>Tanggal Mulai:</strong> <?= htmlspecialchars($sewa['tanggal']) ?></p>
    <p><strong>Durasi:</strong> <?= htmlspecialchars($sewa['durasi']) ?> bulan</p>
    <p><strong>Total Harga:</strong> Rp<?= number_format($total, 0, ',', '.') ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $metode ?></p>
    <p><strong>Nominal Dibayar:</strong> Rp<?= number_format($nominal, 0, ',', '.') ?></p>

    <?php if ($kembalian > 0): ?>
      <p class="text-green-600 font-semibold"><strong>Kembalian:</strong> Rp<?= number_format($kembalian, 0, ',', '.') ?></p>
    <?php endif; ?>

    <div class="text-center mt-6">
      <a href="<?= $link_kembali ?>" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Kembali ke Beranda</a>
    </div>
  </section>
</body>
</html>
