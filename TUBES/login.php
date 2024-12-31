<?php
session_start();

// Sertakan file koneksi
include 'koneksi.php';

// Logika login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data inputan dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Query untuk cek username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind parameter untuk query
        $stmt->bind_param('s', $username);
        $stmt->execute(); // Eksekusi query
        $result = $stmt->get_result(); // Ambil hasil query

        // Cek apakah user ditemukan
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc(); // Ambil data user

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Simpan data ke sesi
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header('Location: dashboard_admin.php');
                } else {
                    header('Location: dashboard_user.php');
                }
                exit;
            } else {
                $error = "Password salah!"; // Jika password salah
            }
        } else {
            $error = "Username tidak ditemukan!"; // Jika username tidak ditemukan
        }

        $stmt->close(); // Tutup statement
    } else {
        $error = "Query gagal diproses!"; // Jika query gagal disiapkan
    }
}

$conn->close(); // Tutup koneksi setelah selesai
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Arei Outdoor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('aboutbanner.jpg'); /* Ganti dengan path gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #FF0000; /* Ganti warna judul menjadi merah terang */
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 14px;
            color: #FF0000; /* Ganti warna label menjadi merah terang */
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #FF0000; /* Ganti warna tombol menjadi merah terang */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #B22222; /* Ganti warna tombol hover menjadi merah lebih gelap */
        }
        p.error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
        @media (max-width: 400px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Login Arei Outdoor</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
