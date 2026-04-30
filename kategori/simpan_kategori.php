<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$nama = $_POST['nama_kategori'] ?? '';
$ket  = $_POST['keterangan'] ?? '';

if ($nama == '') {
    echo json_encode(["status"=>"error","msg"=>"Nama kategori wajib diisi"]);
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?,?)");
mysqli_stmt_bind_param($stmt, "ss", $nama, $ket);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","msg"=>mysqli_error($koneksi)]);
}