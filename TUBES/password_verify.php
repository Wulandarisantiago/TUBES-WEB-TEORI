<?php
// Password yang dimasukkan pengguna
$inputPassword = "admin123";  // Misalnya user memasukkan "admin123"

// Hash yang tersimpan di database
$hashedPassword = "$2y$10$uIoiZnMIMsHcQPcosQR3duxHmcJgh34jNAocYDVIKCMe14PZBHn7G";

// Verifikasi password
if (password_verify($inputPassword, $hashedPassword)) {
    echo "Password benar!";
} else {
    echo "Password salah!";
}
?>
