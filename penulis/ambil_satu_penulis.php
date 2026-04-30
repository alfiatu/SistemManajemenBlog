<?php
ob_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["status"=>"error","msg"=>"ID tidak valid"]);
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM penulis WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

ob_end_clean();
echo json_encode([
    "status"=>"success",
    "data"=>$data
]);
exit;