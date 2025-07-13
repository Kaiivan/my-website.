<?php
include 'db.php'; // koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data dari form
  $nama = $_POST['nama'] ?? '';
  $alamat = $_POST['alamat'] ?? '';
  $harga = $_POST['harga'] ?? '';
  $jenis = $_POST['jenis'] ?? '';
  $deskripsi = $_POST['deskripsi'] ?? '';
  $maps = $_POST['maps'] ?? '';

  // Cek apakah file gambar diupload
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $gambar_name = basename($_FILES['gambar']['name']);
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = 'images/' . $gambar_name;

    // Pindahkan gambar ke folder images/
    if (move_uploaded_file($gambar_tmp, $gambar_path)) {
      // Simpan data kos ke database
      $stmt = $conn->prepare("INSERT INTO kosan (nama, alamat, harga, jenis, deskripsi, gambar, maps) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssissss", $nama, $alamat, $harga, $jenis, $deskripsi, $gambar_name, $maps);

      if ($stmt->execute()) {
        header('Location: admin.php');
        exit;
      } else {
        echo "Gagal menyimpan ke database: " . $conn->error;
      }
      $stmt->close();
    } else {
      echo "Gagal mengupload gambar.";
    }
  } else {
    echo "Gambar tidak valid atau belum diunggah.";
  }
} else {
  echo "Metode tidak valid.";
}
?>
