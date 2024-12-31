<?php
session_start();
// Memulai sesi dan memeriksa apakah pengguna adalah admin. Jika tidak, alihkan ke halaman login.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit; // Menghentikan eksekusi skrip setelah pengalihan
}

include 'koneksi.php'; // Menghubungkan ke database

$id = $_GET['id']; // Mendapatkan ID dari query string
$query = "SELECT * FROM data WHERE id = $id"; // Membuat query untuk mengambil data berdasarkan ID
$result = $conn->query($query); // Menjalankan query
$data = $result->fetch_assoc(); // Mengambil data sebagai associative array

// Memeriksa apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    $gambar = $data['gambar']; // Menyimpan nama gambar lama
    // Memeriksa apakah ada file gambar yang diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $uploadDir = 'uploads/'; // Folder upload
        $gambar = basename($_FILES['gambar']['name']); // Mengambil nama file gambar
        // Memindahkan file gambar yang diupload ke folder uploads
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }

    // Membuat query untuk memperbarui data
    $query = "UPDATE data SET nama='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok', kategori='$kategori', gambar='$gambar' WHERE id = $id";
    // Menjalankan query dan memeriksa keberhasilannya
    if ($conn->query($query)) {
        header('Location: dashboard_admin.php'); // Mengalihkan ke dashboard admin setelah sukses
    } else {
        echo "Error: " . $conn->error; // Menampilkan pesan error jika query gagal
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <h1>Edit Data Produk</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required><br>
        <label>Deskripsi:</label>
        <textarea name="deskripsi" required><?php echo $data['deskripsi']; ?></textarea><br>
        <label>Harga:</label>
        <input type="number" name="harga" value="<?php echo $data['harga']; ?>" required><br>
        <label>Stok:</label>
        <input type="number" name="stok" value="<?php echo $data['stok']; ?>" required><br>
        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?php echo $data['kategori']; ?>" required><br>
        <label>Gambar:</label>
        <input type="file" name="gambar"><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>