<?php
include 'db.php'; // Koneksi ke database

// Ambil data dari form
$nama     = $_POST['nama'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($nama) || empty($username) || empty($password)) {
  echo "<script>
    alert('Semua kolom wajib diisi!');
    window.location.href = 'register.php';
  </script>";
  exit;
}

// Cek apakah username sudah ada
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo "<script>
    alert('Username sudah terdaftar, gunakan yang lain.');
    window.location.href = 'register.php';
  </script>";
  $stmt->close();
  exit;
}
$stmt->close();

// Hash password sebelum disimpan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO users (nama, username, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nama, $username, $hashed_password);

if ($stmt->execute()) {
  echo "<script>
    alert('Pendaftaran berhasil! Silakan login.');
    window.location.href = 'login.php';
  </script>";
} else {
  echo "<script>
    alert('Terjadi kesalahan saat mendaftar.');
    window.location.href = 'register.php';
  </script>";
}

$stmt->close();
$conn->close();
?>
