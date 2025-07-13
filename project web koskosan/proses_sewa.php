<?php
session_start();
include 'db.php';

// Ambil data dari form
$id_kos        = $_POST['id_kos'] ?? null;
$nama_penyewa  = $_POST['nama_penyewa'] ?? '';
$no_hp         = $_POST['no_hp'] ?? '';
$tanggal       = $_POST['tanggal'] ?? '';
$durasi        = $_POST['durasi'] ?? '';

// Validasi sederhana
if (!$id_kos || empty($nama_penyewa) || empty($no_hp) || empty($tanggal) || empty($durasi)) {
  echo "<script>alert('Semua field harus diisi!'); window.location.href='form_sewa.php?id=$id_kos';</script>";
  exit;
}

// Ambil data kos dari database berdasarkan ID
$stmt = $conn->prepare("SELECT nama, harga FROM kosan WHERE id = ?");
$stmt->bind_param("i", $id_kos);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $kos = $result->fetch_assoc();
  $nama_kos = $kos['nama'];
  $harga_per_bulan = $kos['harga'];
  $total_harga = $harga_per_bulan * (int)$durasi;

  // Simpan ke tabel penyewaan
  $stmt = $conn->prepare("INSERT INTO penyewaan (nama_kos, nama_penyewa, no_hp, tanggal, durasi, total_harga) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssii", $nama_kos, $nama_penyewa, $no_hp, $tanggal, $durasi, $total_harga);
  $stmt->execute();

  // Simpan data ke session untuk konfirmasi dan nota
  $_SESSION['sewa'] = [
    'nama_kos'     => $nama_kos,
    'nama_penyewa' => $nama_penyewa,
    'no_hp'        => $no_hp,
    'tanggal'      => $tanggal,
    'durasi'       => $durasi,
    'total_harga'  => $total_harga
  ];

  // Redirect ke halaman konfirmasi pembayaran
  header("Location: pembayaran.php");
  exit;
} else {
  echo "<script>alert('Kos tidak ditemukan di database.'); window.location.href='form_sewa.php?id=$id_kos';</script>";
  exit;
}
?>
