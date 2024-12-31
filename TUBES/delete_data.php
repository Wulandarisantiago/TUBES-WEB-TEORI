<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';

// Validasi dan sanitasi parameter ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Cek apakah data dengan ID tersebut ada
    $query_check = "SELECT * FROM data WHERE id = $id";
    $result = $conn->query($query_check);

    if ($result && $result->num_rows > 0) {
        // Hapus data jika ditemukan
        $query = "DELETE FROM data WHERE id = $id";
        if ($conn->query($query)) {
            header('Location: dashboard_admin.php');
            exit;
        } else {
            echo "Gagal menghapus data. Error: " . $conn->error;
        }
    } else {
        echo "Data dengan ID tersebut tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}
?>
