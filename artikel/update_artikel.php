<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

$id_penulis = $_POST['id_penulis'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$judul = $_POST['judul'] ?? '';
$isi = $_POST['isi'] ?? '';

if ($id == 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "ID kosong"
    ]);
    exit;
}

$query = "
UPDATE artikel SET
id_penulis='$id_penulis',
id_kategori='$id_kategori',
judul='$judul',
isi='$isi'
";

if (!empty($_FILES['gambar']['name'])) {
    $folder = __DIR__ . '/../uploads_artikel/';
    $gambar = time() . '_' . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $gambar);

    $query .= ", gambar='$gambar'";
}

$query .= " WHERE id=$id";

$q = mysqli_query($koneksi, $query);

echo json_encode([
    "status" => $q ? "success" : "error",
    "debug_id" => $id,
    "error" => mysqli_error($koneksi)
]);