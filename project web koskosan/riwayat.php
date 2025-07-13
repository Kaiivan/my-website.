<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

include 'partials.php';
include 'db.php';

$username = $_SESSION['username'];
$riwayat = [];

// Ambil data penyewaan berdasarkan nama_penyewa
$stmt = $conn->prepare("SELECT * FROM penyewaan WHERE nama_penyewa = ? ORDER BY tanggal DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $riwayat[] = $row;
}
?>

<section class="max-w-4xl mx-auto my-12 px-4">
  <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Riwayat Penyewaan</h2>

  <?php if (empty($riwayat)): ?>
    <p class="text-center text-gray-500">Belum ada riwayat penyewaan.</p>
  <?php else: ?>
    <div class="space-y-6">
      <?php foreach ($riwayat as $sewa): ?>
        <div class="bg-white p-6 rounded shadow">
          <h3 class="text-xl font-semibold"><?= htmlspecialchars($sewa['nama_kos']) ?></h3>
          <p class="text-gray-600">Disewa oleh: <strong><?= htmlspecialchars($sewa['nama_penyewa']) ?></strong></p>
          <p class="text-gray-600">Tanggal: <?= htmlspecialchars($sewa['tanggal']) ?></p>
          <p class="text-gray-600">Durasi: <?= htmlspecialchars($sewa['durasi']) ?> bulan</p>
          <p class="text-blue-600 font-semibold">Total Harga: Rp<?= number_format($sewa['total_harga'], 0, ',', '.') ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
