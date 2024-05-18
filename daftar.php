<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Akun</title>
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        </style>
    </head>
    <style>
        body {
            display: flex;
        }
    </style>
    <body>
        <div class="daftar-left">
            <h1>HotelWISE >></h1>
            <img src="gambar/HoteWise Logo.svg">
        </div>
        <div class="daftar-right">
            <div class="form-daftar">
                <form method="post">
                    <h2>Daftar</h2>
                    <p>Hi, Selamat Datang !</p>
                    <?php
                    $alert_message = "";

                    include 'koneksi.php';
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST['email'];
                        $namaL = $_POST['namaL'];
                        $namaP = $_POST['namaP'];
                        $password = $_POST['password'];
                        $konfPassword = $_POST['konf_password'];

                        if (empty($email) || empty($namaL) || empty($namaP) || empty($password) || empty($konfPassword)) {
                            $alert_message = "Isi Semua Data!";
                        } else {
                            if ($password !== $konfPassword) {
                                $alert_message = "Konfirmasi kata sandi tidak cocok!";
                            } else {
                                $email_check_query = "SELECT * FROM client WHERE email='$email' LIMIT 1";
                                $result = $conn->query($email_check_query);
                                if ($result->num_rows > 0) {
                                    $alert_message = "Email sudah terdaftar, silakan login!";
                                } else {
                                    $sql = "INSERT INTO client (email, nama_lengkap, nama_panggilan, password)
                                    VALUES ('$email', '$namaL', '$namaP', '$password')";

                                    if ($conn->query($sql) === TRUE) {
                                        $alert_message = "Pendaftaran berhasil!";
                                        echo "<script>setTimeout(function(){ window.location.href = 'masuk.php'; }, 1000);</script>";
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                }
                            }
                        }
                    }

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
                        <img class="password-toggle" src="gambar/mata.svg" alt="Show Password" onclick="togglePassword('buat-pass')">
                    </div><br>
                    <label for="konf-pass">Konfirmasi Kata Sandi</label><br>
                    <div class="password-container">
                        <input type="password" id="konf-pass" name="konf_password" value="" placeholder="Konfirmasi kata sandi">
                        <img class="password-toggle" src="gambar/mata.svg" alt="Hide Password" onclick="togglePassword('konf-pass')">
                    </div><br>
                    <button type="submit">Daftar</button><br><br><br><br>
                    <p style="text-align: center; margin-top: -60px;">Sudah punya akun?</p>
                    <a href="masuk.php">Masuk disini</a>
                </form>
            </div>
        </div>

        <script>
            var alertMessage = document.getElementById('alertMessage');

            if (alertMessage.innerHTML.trim() !== '') {
                alertMessage.style.display = 'block';
                setTimeout(function () {
                    alertMessage.style.display = 'none';
                }, 2000);
            }

            function togglePassword(inputId) {
                var passwordInput = document.getElementById(inputId);
                var passwordToggle = document.querySelector('#' + inputId + ' + .password-toggle');
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordToggle.src = "gambar/mata.svg";
                } else {
                    passwordInput.type = "password";
                    passwordToggle.src = "gambar/mata.svg";
                }
            }
        </script>
    </body>
</html>