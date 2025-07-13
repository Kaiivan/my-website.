<?php
session_start();
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "<h2>ID Kos tidak ditemukan!</h2>";
  exit;
}

$stmt = $conn->prepare("SELECT * FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
  echo "<h2>Kos tidak ditemukan!</h2>";
  exit;
}

$kos = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Sewa - <?= htmlspecialchars($kos['nama']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8 text-gray-800">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Form Sewa Kos</h2>
    <form action="proses_sewa.php" method="POST" class="space-y-4">
      <!-- Kirim ID kos ke proses_sewa -->
      <input type="hidden" name="id_kos" value="<?= $kos['id'] ?>">
      <input type="text" name="nama_kos" value="<?= htmlspecialchars($kos['nama']) ?>" readonly class="w-full p-2 border rounded bg-gray-100">

      <input name="nama_penyewa" placeholder="Nama Penyewa" required class="w-full p-2 border rounded">
      <input name="no_hp" placeholder="Nomor HP" required class="w-full p-2 border rounded">
      <input type="date" name="tanggal" required class="w-full p-2 border rounded">
      <input type="number" name="durasi" placeholder="Durasi (bulan)" required class="w-full p-2 border rounded">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lanjutkan</button>
    </form>
  </div>
</body>
</html>
