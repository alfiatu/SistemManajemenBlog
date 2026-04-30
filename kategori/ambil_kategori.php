<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$q = mysqli_query($koneksi, "SELECT * FROM kategori_artikel ORDER BY id DESC");

$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}

echo json_encode($data);