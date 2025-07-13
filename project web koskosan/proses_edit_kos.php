<?php
include 'db.php'; // koneksi ke database

// Ambil data dari form
$id       = $_POST['id'] ?? '';
$nama     = $_POST['nama'] ?? '';
$alamat   = $_POST['alamat'] ?? '';
$harga    = $_POST['harga'] ?? '';
$gambar   = $_POST['gambar'] ?? '';
$deskripsi = $_POST['deskripsi'] ?? '';

// Validasi
if (empty($id) || empty($nama) || empty($alamat) || empty($harga) || empty($gambar) || empty($deskripsi)) {
  echo "Semua field wajib diisi!";
  exit;
}

// Update data ke database
$stmt = $conn->prepare("UPDATE kosan SET nama = ?, alamat = ?, harga = ?, gambar = ?, deskripsi = ? WHERE id = ?");
$stmt->bind_param("ssissi", $nama, $alamat, $harga, $gambar, $deskripsi, $id);

if ($stmt->execute()) {
  echo "<script>
    alert('Data kos berhasil diperbarui!');
    window.location.href = 'admin.php';
  </script>";
} else {
  echo "Gagal memperbarui data: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
