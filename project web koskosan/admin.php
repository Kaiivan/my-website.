<?php
include 'partials.php';
include 'db.php';

// Ambil data kos dari database
$kosan = [];
$result = $conn->query("SELECT * FROM kosan");
while ($row = $result->fetch_assoc()) {
  $kosan[] = $row;
}
?>

<section class="max-w-4xl mx-auto my-12 px-4">
  <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">Admin Panel - Manajemen Kos</h2>

  <!-- Form Tambah Kos -->
  <form action="proses_tambah_kos.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
    <input type="text" name="nama" placeholder="Nama Kos" required class="w-full p-3 border border-gray-300 rounded">
    <input type="text" name="alamat" placeholder="Alamat" required class="w-full p-3 border border-gray-300 rounded">
    <input type="number" name="harga" placeholder="Harga per Bulan" required class="w-full p-3 border border-gray-300 rounded">

    <!-- Upload Gambar -->
    <input type="file" name="gambar" accept="image/*" required class="w-full p-3 border border-gray-300 rounded">

    <input type="text" name="jenis" placeholder="Jenis Kos (Putra/Putri/Campur)" required class="w-full p-3 border border-gray-300 rounded">
    <textarea name="deskripsi" placeholder="Deskripsi Kos" rows="3" class="w-full p-3 border border-gray-300 rounded"></textarea>
    <textarea name="maps" placeholder="Link Embed Google Maps" rows="2" class="w-full p-3 border border-gray-300 rounded" required></textarea>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Tambah Kos</button>
  </form>

  <!-- Daftar Kos -->
  <div class="mt-10">
    <h3 class="text-2xl font-semibold mb-4">Daftar Kos yang Terdaftar</h3>

    <?php if (!empty($kosan)): ?>
      <?php foreach ($kosan as $kos): ?>
        <?php
          $gambar = $kos['gambar'];
          $gambarSrc = filter_var($gambar, FILTER_VALIDATE_URL) ? $gambar : 'images/' . $gambar;
        ?>
        <div class="bg-white p-4 rounded shadow mb-4">
          <h4 class="text-xl font-bold"><?= htmlspecialchars($kos['nama']) ?></h4>
          <p class="text-gray-600"><?= htmlspecialchars($kos['alamat']) ?></p>
          <p class="text-blue-600 font-semibold">Rp<?= number_format($kos['harga'], 0, ',', '.') ?> / bulan</p>
          <p class="text-sm text-gray-500 mb-2"><?= htmlspecialchars($kos['deskripsi']) ?></p>
          <p class="text-sm text-gray-500 mb-2">Jenis: <?= htmlspecialchars($kos['jenis']) ?></p>

          <!-- Gambar -->
          <img src="<?= htmlspecialchars($gambarSrc) ?>" alt="Gambar Kos" class="w-full h-40 object-cover rounded my-2" />

          <div class="flex gap-2 mt-2">
            <form action="edit_kos.php" method="POST">
              <input type="hidden" name="id" value="<?= htmlspecialchars($kos['id']) ?>">
              <button class="bg-yellow-400 text-white px-4 py-1 rounded">Edit</button>
            </form>
            <form action="hapus_kos.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus kos ini?');">
              <input type="hidden" name="id" value="<?= htmlspecialchars($kos['id']) ?>">
              <button class="bg-red-500 text-white px-4 py-1 rounded">Hapus</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-500">Belum ada kos yang terdaftar.</p>
    <?php endif; ?>
  </div>
</section>

<?php include 'footer.php'; ?>
