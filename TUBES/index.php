<?php 
session_start();
include 'koneksi.php'; // Opsional jika diperlukan di masa depan
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Arei Outdoor Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <img src="assets/images/logo.png" alt="Logo Arei Outdoor" class="logo">
            <nav>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign up</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#produk">Produk Unggulan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="hero">
        <div class="container">
            <h1>Selamat Datang di Arei Outdoor Shop</h1>
            <p>Temukan perlengkapan outdoor terbaik untuk petualangan Anda!</p>
            <a href="#produk" class="btn">Lihat Produk Kami</a>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="about">
        <div class="container">
            <h2>Tentang Kami</h2>
            <p>
                Arei Outdoor adalah toko perlengkapan outdoor yang menyediakan produk berkualitas tinggi, 
                mulai dari tenda, tas hiking, hingga pakaian outdoor. 
                Kami hadir untuk menemani setiap petualangan Anda di alam bebas.
            </p>
        </div>
    </section>

    <!-- Produk Unggulan -->
    <section id="produk">
        <div class="container">
            <h2>Produk Unggulan</h2>
            <div class="produk-list">
                <div class="produk-item">
                    <img src="assets/images/tenda.jpg" alt="Tenda Arei 4P Pro">
                    <h3>Tenda Arei 4P Pro</h3>
                    <p>Tenda kapasitas 4 orang, bahan waterproof.</p>
                </div>
                <div class="produk-item">
                    <img src="assets/images/carrier.jpg" alt="Carrier Arei 60L">
                    <h3>Carrier Arei 60L</h3>
                    <p>Tas carrier kapasitas 60 liter, kuat dan tahan lama.</p>
                </div>
                <div class="produk-item">
                    <img src="assets/images/jaket.jpg" alt="Jaket Windproof">
                    <h3>Jaket Arei Windproof</h3>
                    <p>Jaket tahan angin dan air, cocok untuk pendakian.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Arei Outdoor Shop. Semua Hak Dilindungi.</p>
        </div>
    </footer>
</body>
</html>
