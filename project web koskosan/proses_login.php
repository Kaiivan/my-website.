<?php
session_start();
include 'db.php'; // koneksi database

// Ambil data dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input kosong
if (empty($username) || empty($password)) {
  echo "<script>
    alert('Username dan password wajib diisi!');
    window.location.href = 'login.php';
  </script>";
  exit;
}

// Cek data pengguna dari database
$stmt = $conn->prepare("SELECT id, nama, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // Verifikasi password
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama'] = $user['nama'];

    echo "<script>
      alert('Login berhasil!');
      window.location.href = 'dashboard.php';
    </script>";
    exit;
  } else {
    echo "<script>
      alert('Password salah!');
      window.location.href = 'login.php';
    </script>";
    exit;
  }
} else {
  echo "<script>
    alert('Username tidak ditemukan!');
    window.location.href = 'login.php';
  </script>";
  exit;
}

$stmt->close();
$conn->close();
?>
