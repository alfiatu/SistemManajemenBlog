<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$query = mysqli_query($koneksi, "
SELECT 
    artikel.*,
    penulis.nama_depan,
    penulis.nama_belakang,
    kategori_artikel.nama_kategori
FROM artikel
JOIN penulis ON artikel.id_penulis = penulis.id
JOIN kategori_artikel ON artikel.id_kategori = kategori_artikel.id
ORDER BY artikel.id DESC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);