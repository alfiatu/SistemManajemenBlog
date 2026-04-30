<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$id = intval($_GET['id']);

$q = mysqli_query($koneksi, "
SELECT * FROM artikel WHERE id=$id
");

echo json_encode(mysqli_fetch_assoc($q));