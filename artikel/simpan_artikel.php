<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

$now = new DateTime();
$hari_tanggal =
$hari[$now->format('w')] . ", " .
$now->format('j') . " " .
$bulan[(int)$now->format('n')] . " " .
$now->format('Y') . " | " .
$now->format('H:i');

$id_penulis  = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$judul       = $_POST['judul'];
$isi         = $_POST['isi'];

$folder = __DIR__ . '/../uploads_artikel/';
if (!is_dir($folder)) mkdir($folder, 0777, true);

$gambar = time() . '_' . $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];

move_uploaded_file($tmp, $folder . $gambar);

$q = mysqli_query($koneksi, "
INSERT INTO artikel
(id_penulis,id_kategori,judul,isi,gambar,hari_tanggal)
VALUES
('$id_penulis','$id_kategori','$judul','$isi','$gambar','$hari_tanggal')
");

echo json_encode(["status"=>$q ? "success" : "error"]);