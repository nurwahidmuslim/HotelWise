<?php
session_start();
require 'db/db.php'; // Mengimpor file koneksi database

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Ambil data pengguna dari session
    $user_id = $_SESSION['user_id'];

    // Persiapkan statement SQL untuk mengambil data pengguna berdasarkan ID
    $stmt = $conn->prepare('SELECT level FROM `hw-admin` WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Periksa level pengguna dan arahkan ke halaman yang sesuai
    if ($user['level'] == 1) {
        // Jika admin, arahkan ke dashboard admin
        header("Location: dashboard.php");
        exit;
    } elseif ($user['level'] == 2) {
        // Jika staff, arahkan ke dashboard staff
        header("Location: staff-dashboard.php");
        exit;
    }
} else {
    // Pengguna belum login, arahkan ke login.php
    header("Location: login.php");
    exit;
}
?>
