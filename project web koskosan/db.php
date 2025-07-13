<?php
$host = "sql104.infinityfree.com";
$user = "if0_39446207";
$pass = "Y0e1gAadNQ8cU8";
$db   = "if0_39446207_juragankost";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
