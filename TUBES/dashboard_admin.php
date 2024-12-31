<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

// Proses Hapus Produk
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM data WHERE id = $delete_id";
    if ($conn->query($delete_query)) {
        echo "<script>alert('Data berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Proses Tambah Data Produk
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $gambar = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $uploadDir = 'uploads/';
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }

    $insert_query = "INSERT INTO data (nama, deskripsi, harga, stok, kategori, gambar) 
                     VALUES ('$nama', '$deskripsi', '$harga', '$stok', '$kategori', '$gambar')";
    if ($conn->query($insert_query)) {
        echo "<script>alert('Data berhasil ditambahkan');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Proses Edit Produk
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $gambar = $_POST['gambar_lama']; // Mengambil gambar lama

    // Cek jika ada gambar baru yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $uploadDir = 'uploads/';
        $gambar = basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar);
    }

    // Query untuk update produk
    $update_query = "UPDATE data SET nama='$nama', deskripsi='$deskripsi', harga='$harga', stok='$stok', kategori='$kategori', gambar='$gambar' WHERE id='$id'";
    if ($conn->query($update_query)) {
        echo "<script>
                alert('Data berhasil diperbarui');
                window.location.href = 'dashboard_admin.php'; // Pastikan URL-nya benar
              </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}


// Query untuk mendapatkan data produk
$query = "SELECT * FROM data";
$result = $conn->query($query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff4d4d; /* Mengubah warna background menjadi merah */
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
        .logout-btn {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .action-container {
    display: flex; /* Membuat tombol berjajar */
    gap: 20px; /* Memberikan jarak antar tombol */
}

.action-buttons {
    background-color: #ff4d4d;
    color: white;
    padding: 5px 30px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
}
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #ff4d4d;
            color: white;
        }
        table td img {
            max-width: 100px;
        }
        .form-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .form-container input, .form-container textarea, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-container button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #ff4d4d;
        }
        .action-buttons:hover {
            background-color: #ff4d4d;
        }
    </style>
</head>
<body>
    <!-- Konten HTML Anda -->
</body>
</html>

</head>
<body>
    <header>
        <h1>Dashboard Admin</h1>
    </header>
    <div class="container">
        <a href="logout.php" class="logout-btn">Logout</a>
        <h2>Data Produk</h2>
        <a href="javascript:void(0)" class="action-buttons" onclick="showAddForm()">Tambah Data</a>
        
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($row['harga'], 0, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars($row['stok']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Produk">
                        <?php else: ?>
                            Tidak ada gambar
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="action-buttons" onclick="editData(<?php echo $row['id']; ?>, '<?php echo addslashes($row['nama']); ?>', '<?php echo addslashes($row['deskripsi']); ?>', <?php echo $row['harga']; ?>, <?php echo $row['stok']; ?>, '<?php echo addslashes($row['kategori']); ?>', '<?php echo addslashes($row['gambar']); ?>')">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="action-buttons" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Formulir Tambah Produk -->
        <div id="add-form-container" class="form-container">
            <h2>Tambah Produk</h2>
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
                <button type="submit" name="add">Simpan Produk</button>
            </form>
        </div>

        <!-- Formulir Edit Produk -->
        <div id="edit-form-container" class="form-container">
            <h2>Edit Produk</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="gambar_lama" id="edit-gambar-lama">
                <label>Nama:</label>
                <input type="text" name="nama" id="edit-nama" required><br>
                <label>Deskripsi:</label>
                <textarea name="deskripsi" id="edit-deskripsi" required></textarea><br>
                <label>Harga:</label>
                <input type="number" name="harga" id="edit-harga" required><br>
                <label>Stok:</label>
                <input type="number" name="stok" id="edit-stok" required><br>
                <label>Kategori:</label>
                <input type="text" name="kategori" id="edit-kategori" required><br>
                <label>Gambar:</label>
                <input type="file" name="gambar" id="edit-gambar"><br>
                
                <!-- Menampilkan gambar lama jika ada -->
                <div id="current-image-container"></div>
                
                <button type="submit" name="edit">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan form tambah produk
        function showAddForm() {
            document.getElementById('add-form-container').style.display = 'block';
        }

        // Fungsi untuk menampilkan form edit produk
        function editData(id, nama, deskripsi, harga, stok, kategori, gambar) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-deskripsi').value = deskripsi;
            document.getElementById('edit-harga').value = harga;
            document.getElementById('edit-stok').value = stok;
            document.getElementById('edit-kategori').value = kategori;
            document.getElementById('edit-gambar-lama').value = gambar;

            var currentImageContainer = document.getElementById('current-image-container');
            
            // Menampilkan gambar lama jika ada
            if (gambar) {
                currentImageContainer.innerHTML = '<img src="uploads/' + gambar + '" style="max-width: 100px; margin-top: 10px;" alt="Gambar Produk Lama">';
            } else {
                currentImageContainer.innerHTML = 'Tidak ada gambar sebelumnya.';
            }

            document.getElementById('edit-form-container').style.display = 'block';
        }
    </script>
</body>
</html>
