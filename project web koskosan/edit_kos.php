<?php
include 'partials.php';
include 'db.php';

// Ambil ID dari POST
$id = $_POST['id'] ?? null;

if (!$id) {
  echo "ID tidak ditemukan.";
  exit;
}

// Ambil data kos dari database
$stmt = $conn->prepare("SELECT * FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$kos = $result->fetch_assoc();
$stmt->close();

if (!$kos) {
  echo "Data kos tidak ditemukan.";
  exit;
}
?>

<section class="max-w-2xl mx-auto my-12 bg-white p-8 rounded-lg shadow">
  <h2 class="text-3xl font-bold mb-6 text-center">Edit Data Kos</h2>

  <form action="proses_edit_kos.php" method="POST" class="space-y-4">
    <input type="hidden" name="id" value="<?= $kos['id'] ?>">

    <input type="text" name="nama" value="<?= htmlspecialchars($kos['nama']) ?>" placeholder="Nama Kos" required class="w-full p-3 border border-gray-300 rounded">
    <input type="text" name="alamat" value="<?= htmlspecialchars($kos['alamat']) ?>" placeholder="Alamat" required class="w-full p-3 border border-gray-300 rounded">
    <input type="number" name="harga" value="<?= $kos['harga'] ?>" placeholder="Harga per Bulan" required class="w-full p-3 border border-gray-300 rounded">
    <input type="url" name="gambar" value="<?= htmlspecialchars($kos['gambar']) ?>" placeholder="Link Gambar" required class="w-full p-3 border border-gray-300 rounded">
    <textarea name="deskripsi" placeholder="Deskripsi Kos" rows="4" class="w-full p-3 border border-gray-300 rounded"><?= htmlspecialchars($kos['deskripsi']) ?></textarea>
    <input type="url" name="maps" value="<?= htmlspecialchars($kos['maps']) ?>" placeholder="Link  Embed Google Maps (opsional)" class="w-full p-3 border border-gray-300 rounded">

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
  </form>
</section>

<?php include 'footer.php'; ?>
