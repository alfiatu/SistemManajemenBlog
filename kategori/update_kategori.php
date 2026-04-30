<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id   = intval($_POST['id'] ?? 0);
$nama = $_POST['nama_kategori'] ?? '';
$ket  = $_POST['keterangan'] ?? '';

if ($id <= 0) {
    echo json_encode(["status"=>"error","msg"=>"ID tidak valid"]);
    exit;
}

$q = mysqli_query($koneksi, "
UPDATE kategori_artikel 
SET nama_kategori='$nama', keterangan='$ket'
WHERE id=$id
");

if ($q) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","msg"=>mysqli_error($koneksi)]);
}