<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskrips i'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $uploadDir = 'uploads/';
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }

    $query = "INSERT INTO data (nama, deskripsi, harga, stok, kategori, gambar) VALUES ('$nama', '$deskripsi', '$harga', '$stok', '$kategori', '$gambar')";
    if ($conn->query($query)) {
        header('Location: dashboard_admin.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
</head>
<body>
    <h1>Tambah Data Produk</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama:</label>
        <input type="text" name="nama" required><br>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required></textarea><br>
        <label>Harga:</label>
        <input type="number" name="harga" required><br>
        <label>Stok:</label>
        <input type="number" name="stok" required><br>
        <label>Kategori:</label>
        <input type="text" name="kategori" required><br>
        <label>Gambar:</label>
        <input type="file" name="gambar"><br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
