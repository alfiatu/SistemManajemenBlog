<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_POST['id']);

$get = mysqli_query($koneksi, "SELECT gambar FROM artikel WHERE id=$id");
$data = mysqli_fetch_assoc($get);

if ($data) {
    @unlink(__DIR__ . '/../uploads_artikel/' . $data['gambar']);
}

$q = mysqli_query($koneksi, "DELETE FROM artikel WHERE id=$id");

echo json_encode(["status"=>$q ? "success" : "error"]);