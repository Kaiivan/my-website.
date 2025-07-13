<?php
session_start();
include 'db.php';

if (!isset($_SESSION['sewa'])) {
  echo "<h2>Data kos tidak ditemukan!</h2>";
  exit;
}

$sewa = $_SESSION['sewa'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <section class="max-w-xl mx-auto bg-white p-6 mt-10 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Pembayaran</h2>

    <p><strong>Nama Kos:</strong> <?= htmlspecialchars($sewa['nama_kos']) ?></p>
    <p><strong>Nama Penyewa:</strong> <?= htmlspecialchars($sewa['nama_penyewa']) ?></p>
    <p><strong>No HP:</strong> <?= htmlspecialchars($sewa['no_hp']) ?></p>
    <p><strong>Tanggal Mulai:</strong> <?= htmlspecialchars($sewa['tanggal']) ?></p>
    <p><strong>Durasi:</strong> <?= htmlspecialchars($sewa['durasi']) ?> bulan</p>
    <p><strong>Total Harga:</strong> Rp<?= number_format($sewa['total_harga'], 0, ',', '.') ?></p>

    <form action="nota.php" method="POST" class="mt-6 space-y-4">
      <label class="block">
        <span class="block text-sm font-medium text-gray-700">Metode Pembayaran</span>
        <select name="metode_pembayaran" required class="mt-1 p-2 w-full border rounded">
          <option value="">Pilih Metode</option>
          <option value="Transfer Bank">Transfer Bank</option>
          <option value="E-Wallet">E-Wallet</option>
          <option value="Tunai">Tunai</option>
        </select>
      </label>

      <label class="block">
        <span class="block text-sm font-medium text-gray-700">Nominal Pembayaran</span>
        <input type="number" name="nominal_pembayaran" required class="mt-1 p-2 w-full border rounded" min="<?= $sewa['total_harga'] ?>">
      </label>

      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full">Bayar</button>
    </form>
  </section>
</body>
</html>
