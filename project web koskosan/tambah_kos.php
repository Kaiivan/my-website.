<?php
include 'db.php'; // koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama      = $_POST['nama'];
  $alamat    = $_POST['alamat'];
  $harga     = (int)$_POST['harga'];
  $gambar    = $_POST['gambar'];
  $deskripsi = $_POST['deskripsi'];
  $jenis     = $_POST['jenis'];
  $maps      = $_POST['maps'];

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO kosan (nama, alamat, harga, gambar, deskripsi, jenis, maps) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssissss", $nama, $alamat, $harga, $gambar, $deskripsi, $jenis, $maps);
  $stmt->execute();
  $stmt->close();

  echo "<script>alert('Kos berhasil ditambahkan!'); window.location.href='admin.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Form Tambah Kos</h2>
    <form method="POST">
      <input name="nama" placeholder="Nama Kos" class="w-full mb-3 p-2 border rounded" required>
      <input name="alamat" placeholder="Alamat" class="w-full mb-3 p-2 border rounded" required>
      <input name="harga" type="number" placeholder="Harga per bulan" class="w-full mb-3 p-2 border rounded" required>
      <input name="gambar" placeholder="Nama file gambar (contoh: kosbaru.jpg)" class="w-full mb-3 p-2 border rounded" required>
      <input name="jenis" placeholder="Jenis (Putra/Putri/Campur)" class="w-full mb-3 p-2 border rounded" required>
      <textarea name="deskripsi" placeholder="Deskripsi kos" class="w-full mb-3 p-2 border rounded" required></textarea>
      <textarea name="maps" placeholder="Embed Google Maps URL" class="w-full mb-3 p-2 border rounded" required></textarea>
      <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Simpan Kos</button>
    </form>
  </div>
</body>
</html>
