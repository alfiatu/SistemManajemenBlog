<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM penulis");

if (!$query) {
    echo json_encode([
        "status" => "error",
        "msg" => mysqli_error($koneksi)
    ]);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);