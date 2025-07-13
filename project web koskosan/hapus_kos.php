<?php
session_start();
require 'db.php'; // Koneksi database

// Pastikan permintaan berasal dari POST dan ada ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);

  // Siapkan dan eksekusi query DELETE
  $stmt = $conn->prepare("DELETE FROM kosan WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    header("Location: admin.php");
    exit;
  } else {
    echo "Gagal menghapus kos: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Permintaan tidak valid.";
}

$conn->close();
?>
