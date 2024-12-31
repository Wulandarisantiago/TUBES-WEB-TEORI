<?php 
// Masukkan password plaintext di sini
$admin_password = "admin123";
$user_password = "user123";

// Hash password menggunakan algoritma BCRYPT
$hashed_admin_password = password_hash($admin_password, PASSWORD_BCRYPT);
$hashed_user_password = password_hash($user_password, PASSWORD_BCRYPT);

// Tampilkan hash yang dihasilkan
echo "Hash Password Admin: " . $hashed_admin_password . "<br>";
echo "Hash Password User: " . $hashed_user_password . "<br>";
?>
