<?php
ob_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

$nama_depan     = $_POST['nama_depan'] ?? '';
$nama_belakang  = $_POST['nama_belakang'] ?? '';
$username       = $_POST['username'] ?? '';
$password_input = $_POST['password'] ?? '';

if (!$nama_depan || !$username || !$password_input) {
    echo json_encode(["status"=>"error","msg"=>"Data wajib belum lengkap"]);
    exit;
}

$password = password_hash($password_input, PASSWORD_BCRYPT);

$namaBaru = 'default.png';

if (!empty($_FILES['foto']['name'])) {
    $folder = '../uploads_penulis/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $namaBaru = time() . '_' . $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $namaBaru);
}

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto)
     VALUES (?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "sssss",
    $nama_depan, $nama_belakang, $username, $password, $namaBaru
);

if (mysqli_stmt_execute($stmt)) {
    $response = ["status"=>"success"];
} else {
    $response = ["status"=>"error","msg"=>mysqli_error($koneksi)];
}

ob_end_clean();
echo json_encode($response);
exit;