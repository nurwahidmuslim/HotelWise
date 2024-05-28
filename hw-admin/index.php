<?php
session_start();
require 'db/db.php'; // Mengimpor file koneksi database

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Pengguna sudah login, arahkan ke dashboard.php
    header("Location: dashboard.php");
    exit;
} else {
    // Pengguna belum login, arahkan ke login.php
    header("Location: login.php");
    exit;
}
?>
