<?php
session_start();

// Lakukan koneksi ke database
include 'koneksi.php';

// Inisialisasi variabel pesan alert
$alert_message = "";

// Periksa apakah pengguna sudah melakukan submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim dari formulir
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email dan password sesuai dengan yang ada di database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    // Periksa apakah ada hasil dari query
    if ($result->num_rows > 0) {
        // Jika ada, maka login berhasil
        $row = $result->fetch_assoc();
        $_SESSION['namaP'] = $row['nama_panggilan']; // Simpan Nama Panggilan dalam sesi
        // Redirect ke halaman beranda setelah login berhasil
        header("Location: index.php");
        exit();
    } else {
        // Jika tidak ada hasil, maka login gagal
        $alert_message = "Email atau kata sandi salah.";
    }
}

// Tutup koneksi ke database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-left">
        <span class="navbar-brand"><span class="wise">Wise</span><span class="hotel">Hotel</span></span>
    </div>
</nav>
<div class="masuk">
    <form method="post">
        <h2>Masuk</h2>
        <p>Hi, Selamat Datang !</p>
        <!-- Tampilkan pesan alert jika ada -->
        <?php if ($alert_message): ?>
            <div class="alert"><?php echo $alert_message; ?></div>
        <?php endif; ?>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="" placeholder="Masukan email"><br><br>
        <label for="password">Sandi</label><br>
        <input type="password" id="password" name="password" value="" placeholder="Masukan kata sandi"><br>
        <a href="#">Lupa sandi?</a><br>
        <button type="submit">Masuk</button><br><br><br><br>
    </form>
</div>

<script>
    // Ambil pesan alert
    var alertMessage = document.querySelector('.alert');

    // Jika terdapat pesan alert, tampilkan dan hilangkan setelah 2 detik
    if (alertMessage && alertMessage.innerHTML.trim() !== '') {
        alertMessage.style.display = 'block';
        setTimeout(function () {
            alertMessage.style.display = 'none';
        }, 2000);
    }
</script>

</body>
</html>
