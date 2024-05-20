<?php
session_start();

include 'koneksi.php';

$alert_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM client WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['namaP'] = $row['nama_panggilan'];
        $_SESSION['id_client'] = $row['id_client'];
        $_SESSION['namaL'] = $row['nama_lengkap'];
        header("Location: home.php");
        exit();
    } else {
        $alert_message = "Email atau kata sandi salah.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Masuk</title>
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <style>
        body {
            display: flex;
        }
    </style>
    <body>
        <div class="login-left">
            <h1>HotelWISE >></h1>
            <img src="gambar/HoteWise Logo.svg">
        </div>
        <div class="login-right">
            <div class="form-container">
                <form method="post">
                    <h2>Masuk</h2>
                    <p>Hi, Selamat Datang !</p>
                    <?php if ($alert_message): ?>
                        <div id="alertMessage" style="display:none;"><?php echo $alert_message; ?></div>
                    <?php endif; ?>
                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email" value="" placeholder="Masukan email"><br><br>
                    <label for="password">Sandi</label><br>
                    <div class="password-container">
                        <input type="password" id="password" name="password" value="" placeholder="Masukan kata sandi">
                        <img class="password-toggle" src="gambar/mata.svg" alt="Show Password" onclick="togglePassword('password')">
                    </div><br>
                    <a href="#">Lupa sandi?</a><br>
                    <button type="submit">Masuk</button>
                </form>
            </div>
        </div>

        <div id="alertModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="modalMessage"></p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var alertMessage = document.getElementById('alertMessage');
                var modal = document.getElementById('alertModal');
                var modalMessage = document.getElementById('modalMessage');
                var span = document.getElementsByClassName('close')[0];

                if (alertMessage && alertMessage.innerHTML.trim() !== '') {
                    modalMessage.textContent = alertMessage.innerHTML;
                    modal.style.display = 'block';
                }

                span.onclick = function () {
                    modal.style.display = 'none';
                }
            });

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
