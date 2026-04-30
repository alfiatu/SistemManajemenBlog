<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_GET['id'] ?? 0);

$q = mysqli_query($koneksi, "SELECT * FROM kategori_artikel WHERE id=$id");

$data = mysqli_fetch_assoc($q);

echo json_encode($data);