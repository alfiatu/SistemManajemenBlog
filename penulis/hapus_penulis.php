<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_POST['id'] ?? 0);

// cek relasi artikel
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) as total FROM artikel WHERE id_penulis=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    echo json_encode([
        "status"=>"error",
        "msg"=>"Penulis masih memiliki artikel"
    ]);
    exit;
}

// hapus
$stmt = mysqli_prepare($koneksi, "DELETE FROM penulis WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode([
        "status"=>"error",
        "msg"=>mysqli_error($koneksi)
    ]);
}