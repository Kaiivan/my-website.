<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
  echo "ID kos tidak ditemukan.";
  exit;
}

$id = $_GET['id'];

// Ambil data kos dari database
$stmt = $conn->prepare("SELECT * FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  echo "Kos tidak ditemukan.";
  exit;
}

$kos = $result->fetch_assoc();
?>

<?php include 'partials.php'; ?>

<section class="max-w-xl mx-auto my-12 bg-white p-6 rounded-lg shadow">
  <h2 class="text-2xl font-bold mb-6 text-blue-600 text-center">Form Penyewaan Kos</h2>

  <form action="proses_sewa.php" method="POST" class="space-y-4">
    <input type="hidden" name="id_kos" value="<?= $kos['id'] ?>">
    <input type="hidden" name="nama_kos" value="<?= htmlspecialchars($kos['nama']) ?>">

    <!-- Nama Kos (Tampil) -->
    <div>
      <label class="block text-gray-700 mb-1">Nama Kos</label>
      <input type="text" value="<?= htmlspecialchars($kos['nama']) ?>" class="w-full p-3 border bg-gray-100 rounded" readonly>
    </div>

    <!-- Nama Penyewa -->
    <div>
      <label class="block text-gray-700 mb-1">Nama Penyewa</label>
      <input type="text" name="nama_penyewa" value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" class="w-full p-3 border border-gray-300 rounded" required readonly>
    </div>

    <!-- Nomor HP -->
    <div>
      <label class="block text-gray-700 mb-1">Nomor HP</label>
      <input type="text" name="no_hp" class="w-full p-3 border border-gray-300 rounded" required>
    </div>

    <!-- Tanggal Sewa -->
    <div>
      <label class="block text-gray-700 mb-1">Tanggal Sewa</label>
      <input type="date" name="tanggal" class="w-full p-3 border border-gray-300 rounded" required>
    </div>

    <!-- Durasi Sewa -->
    <div>
      <label class="block text-gray-700 mb-1">Durasi Sewa (bulan)</label>
      <input type="number" name="durasi" class="w-full p-3 border border-gray-300 rounded" min="1" required>
    </div>

    <!-- Harga per Bulan -->
    <div>
      <label class="block text-gray-700 mb-1">Harga per Bulan</label>
      <input type="text" value="Rp<?= number_format($kos['harga'], 0, ',', '.') ?>" class="w-full p-3 border bg-gray-100 rounded" readonly>
    </div>

    <!-- Input Uang Pembayaran -->
    <div>
      <label class="block text-gray-700 mb-1">Jumlah Uang yang Dibayarkan</label>
      <input type="number" name="uang_dibayar" class="w-full p-3 border border-gray-300 rounded" required>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full">Kirim Sewa</button>
  </form>
</section>

<?php include 'footer.php'; ?>
