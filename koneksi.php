<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_blog";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die(json_encode([
        "status" => "error",
        "msg" => "Koneksi gagal: " . mysqli_connect_error()
    ]));
}
?>