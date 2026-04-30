<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["status"=>"error","msg"=>"ID tidak valid"]);
    exit;
}

// cek dipakai di artikel
$cek = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM artikel WHERE id_kategori=$id");
$row = mysqli_fetch_assoc($cek);

if ($row['total'] > 0) {
    echo json_encode([
        "status"=>"error",
        "msg"=>"Kategori masih digunakan di artikel"
    ]);
    exit;
}

// hapus
$del = mysqli_query($koneksi, "DELETE FROM kategori_artikel WHERE id=$id");

echo json_encode([
    "status" => $del ? "success" : "error"
]);