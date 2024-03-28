<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="styles.css">
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-left">
        <span class="navbar-brand"><span class="wise">Wise</span><span class="hotel">Hotel</span></span>
    </div>
</nav>
<div class="daftar">
    <form method="post">
        <h2>Daftar</h2>
        <p>Hi, Selamat Datang !</p>
        <!-- Tampilkan pesan alert jika ada -->
        <?php
        // Variabel untuk menyimpan pesan alert
        $alert_message = "";

        // Periksa koneksi
        $servername = "localhost";
        $username = "root";
        $password = ""; 
        $dbname = "hotelwise";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Jika formulir disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $namaL = $_POST['namaL'];
            $namaP = $_POST['namaP'];
            $password = $_POST['password'];
            $konfPassword = $_POST['konf_password'];

            // Periksa apakah semua bidang formulir telah diisi
            if (empty($email) || empty($namaL) || empty($namaP) || empty($password) || empty($konfPassword)) {
                $alert_message = "Semua bidang harus diisi!";
            } else {
                // Periksa apakah konfirmasi kata sandi sesuai
                if ($password !== $konfPassword) {
                    $alert_message = "Konfirmasi kata sandi tidak cocok!";
                } else {
                    // Query untuk menyimpan data ke database
                    $sql = "INSERT INTO users (email, nama_lengkap, nama_panggilan, password)
                    VALUES ('$email', '$namaL', '$namaP', '$password')";

                    if ($conn->query($sql) === TRUE) {
                        // Notifikasi berhasil
                        $alert_message = "Pendaftaran berhasil!";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }

        // Tutup koneksi
        $conn->close();

        if (!empty($alert_message)) {
            echo '<div class="alert" id="alertMessage">' . $alert_message . '</div>';
        }
        ?>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" placeholder="Masukan email"><br><br>
        <label for="namaL">Nama Lengkap</label><br>
        <input type="text" id="namaL" name="namaL" placeholder="Masukan nama lengkap"><br><br>
        <label for="namaP">Nama Panggilan</label><br>
        <input type="text" id="namaP" name="namaP" placeholder="Masukan nama panggilan"><br><br>
        <label for="buat-pass">Buat Kata Sandi</label><br>
        <div class="password-container">
            <input type="password" id="buat-pass" name="password" value="" placeholder="Buat kata sandi">
            <img class="password-toggle" src="mata.png" alt="Show Password" onclick="togglePassword('buat-pass')">
        </div><br>
        <label for="konf-pass">Konfirmasi Kata Sandi</label><br>
        <div class="password-container">
            <input type="password" id="konf-pass" name="konf_password" value="" placeholder="Konfirmasi kata sandi">
            <img class="password-toggle" src="mata.png" alt="Hide Password" onclick="togglePassword('konf-pass')">
        </div><br>
        <button type="submit">Daftar</button><br><br><br><br>
        <p style="text-align: center;">Sudah punya akun?</p>
        <a href="masuk.html">Masuk disini</a>
    </form>
</div>

<script>
    // Ambil pesan alert
    var alertMessage = document.getElementById('alertMessage');

    // Jika terdapat pesan alert, tampilkan dan hilangkan setelah ? detik
    if (alertMessage.innerHTML.trim() !== '') {
        alertMessage.style.display = 'block';
        setTimeout(function () {
            alertMessage.style.display = 'none';
        }, 1000);
    }

    function togglePassword(inputId) {
        var passwordInput = document.getElementById(inputId);
        var passwordToggle = document.querySelector('#' + inputId + ' + .password-toggle');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.src = "mata.png";
        } else {
            passwordInput.type = "password";
            passwordToggle.src = "mata.png";
        }
    }
</script>
</body
