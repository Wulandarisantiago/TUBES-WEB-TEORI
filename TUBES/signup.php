<?php
session_start();

// Sertakan file koneksi
include 'koneksi.php';

// Logika pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data inputan dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk cek apakah username sudah terdaftar
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username sudah terdaftar!";
            } else {
                // Query untuk menambahkan user baru tanpa 'nama'
                $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
                $stmt = $conn->prepare($query);

                if ($stmt) {
                    $stmt->bind_param('ss', $username, $hashed_password);  // Menghilangkan 'nama' dalam query
                    if ($stmt->execute()) {
                        $success = "Pendaftaran berhasil! Silakan login.";
                    } else {
                        $error = "Gagal mendaftar. Silakan coba lagi.";
                    }
                } else {
                    $error = "Query gagal diproses!";
                }
            }

            $stmt->close();
        } else {
            $error = "Query gagal diproses!";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Arei Outdoor</title>
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
            color: #FF0000;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 14px;
            color: #FF0000;
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
            background: #FF0000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #B22222;
        }
        p.error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
        p.success {
            color: green;
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
        <h2>Sign Up Arei Outdoor</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Konfirmasi Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Daftar</button>

        <div>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </form>
</body>
</html>
