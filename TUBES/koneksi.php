<?php
$host = 'localhost'; // atau alamat server database jika berbeda
$user = 'root'; // username untuk koneksi database
$password = ''; // password untuk koneksi database
$dbname = 'arei_outdoor'; // nama database yang telah Anda buat

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>