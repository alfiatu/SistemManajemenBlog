<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

// ================== VALIDASI ID ==================
$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode([
        "status" => "error",
        "msg" => "ID tidak valid"
    ]);
    exit;
}

// ================== AMBIL DATA ==================
$nama_depan     = $_POST['nama_depan'] ?? '';
$nama_belakang  = $_POST['nama_belakang'] ?? '';
$username       = $_POST['username'] ?? '';

// ================== QUERY DASAR ==================
$query = "UPDATE penulis SET 
    nama_depan=?, 
    nama_belakang=?, 
    user_name=?";

$params = [$nama_depan, $nama_belakang, $username];
$types  = "sss";

// ================== PASSWORD ==================
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $query .= ", password=?";
    $params[] = $password;
    $types .= "s";
}

// ================== FOTO ==================
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

    $folder = __DIR__ . '/../uploads_penulis/';

    // buat folder jika belum ada
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // nama file aman
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $namaFile = 'foto_' . time() . '.' . $ext;

    $tmp = $_FILES['foto']['tmp_name'];

    if (move_uploaded_file($tmp, $folder . $namaFile)) {

        // hapus foto lama
        $get = mysqli_query($koneksi, "SELECT foto FROM penulis WHERE id=$id");
        $old = mysqli_fetch_assoc($get);

        if ($old && $old['foto'] != 'default.png') {
            @unlink($folder . $old['foto']);
        }

        // masuk ke query
        $query .= ", foto=?";
        $params[] = $namaFile;
        $types .= "s";
    }
}

// ================== WHERE ==================
$query .= " WHERE id=?";
$params[] = $id;
$types .= "i";

// ================== EXECUTE ==================
$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "msg" => mysqli_error($koneksi)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, $types, ...$params);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "msg" => mysqli_error($koneksi)
    ]);
}