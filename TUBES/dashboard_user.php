<?php
session_start();

// Cek apakah user sudah login dan role-nya adalah 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

// Query untuk mendapatkan data produk
$query = "SELECT * FROM data"; // Ganti 'data' dengan nama tabel yang sesuai
$result = $conn->query($query);

// Cek apakah query berhasil
if (!$result) {
    die("Error pada query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('background.jpg') no-repeat center center/cover;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1, h2 {
            text-align: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(-50px);
            animation: slideIn 1s ease-out forwards;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeIn 1.5s ease-in forwards;
        }

        .nav-menu a {
            padding: 10px 20px;
            background-color: rgba(255, 0, 0, 0.8);
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .nav-menu a:hover {
            transform: scale(1.1);
            background-color: rgb(255, 255, 255);
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 30px;
        }

        .card {
            width: 300px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 20px;
            opacity: 0;
            transform: scale(0.8);
            animation: fadeInCard 1s ease-in forwards;
            transition: transform 0.6s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .card:hover img {
            transform: scale(1.1);
        }

        .card h3, .card p {
            text-align: center;
        }

        .card .price {
            font-weight: bold;
            color: #ff4e4e;
        }

        .card .stock, .card .category {
            font-size: 0.9rem;
            color: #555;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInCard {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <h1>Dashboard User</h1>

    <div class="nav-menu">
        <a href="index.php">Logout</a>
    </div>

    <h2>Data Produk</h2>

    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <div class="image">
                <?php if (!empty($row['gambar'])): ?>
                    <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Produk">
                <?php else: ?>
                    <div class="no-image">Tidak ada gambar</div>
                <?php endif; ?>
            </div>
            <h3><?php echo htmlspecialchars($row['nama']); ?></h3>
            <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
            <p class="price">Rp <?php echo number_format($row['harga'], 2, ',', '.'); ?></p>
            <p class="stock">Stok: <?php echo htmlspecialchars($row['stok']); ?></p>
            <p class="category">Kategori: <?php echo htmlspecialchars($row['kategori']); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>