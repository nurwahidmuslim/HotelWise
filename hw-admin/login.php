<?php
session_start();
require 'db/db.php'; // Mengimpor file koneksi database

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Redirect berdasarkan level yang sesuai
    if ($_SESSION['level'] == 1) {
        header("Location: dashboard.php");
    } elseif ($_SESSION['level'] == 2) {
        header("Location: staff-dashboard.php");
    }
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Persiapkan statement SQL
    $stmt = $conn->prepare('SELECT id, username, password, level FROM `hw-admin` WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi password tanpa hashing
    if ($user && $password === $user['password']) {
        // Simpan informasi pengguna di sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['level'] = $user['level'];

        // Redirect berdasarkan level
        if ($user['level'] == 1) {
            header("Location: dashboard.php");
        } elseif ($user['level'] == 2) {
            header("Location: staff-dashboard.php");
        }
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css"> <!-- Menggunakan login.css -->
</head>
<body>
    <header>
        <div class="header">
            <h4>HotelWise >></h4>
        </div>
    </header>
    <div class="login-right">
        <div class="form-container">
            <?php if ($error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <h2>Masuk</h2>
                <p>Hi, Selamat Datang Staff atau Admin!</p>
                <div class="input-container">
                    <label for="username">Username</label><br>
                    <input id="username" name="username" type="text" autocomplete="username" required placeholder="Masukkan username"><br><br>
                    <label for="password">Sandi</label><br>
                    <div class="password-container">
                        <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan kata sandi">
                        <img class="password-toggle" src="assets/img/mata.svg" alt="Tampilkan Sandi" onclick="togglePassword('password')">
                    </div>
                </div><br>
                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>

    <script src="assets/js/login.js"></script> <!-- Menggunakan login.js -->
</body>
</html>
