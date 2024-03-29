<?php
session_start();

include 'koneksi.php';

$alert_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['namaP'] = $row['nama_panggilan'];
        header("Location: index.php");
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
        <?php if ($alert_message): ?>
            <div class="alert"><?php echo $alert_message; ?></div>
        <?php endif; ?>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="" placeholder="Masukan email"><br><br>
        <label for="password">Sandi</label><br>
        <div class="password-container">
            <input type="password" id="password" name="password" value="" placeholder="Buat kata sandi">
            <img class="password-toggle" src="mata.png" alt="Show Password" onclick="togglePassword('password')">
        </div><br>
        <a href="#">Lupa sandi?</a><br>
        <button type="submit">Masuk</button><br><br><br><br>
    </form>
</div>

<script>
    var alertMessage = document.querySelector('.alert');

    if (alertMessage && alertMessage.innerHTML.trim() !== '') {
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
            passwordToggle.src = "mata.png";
        } else {
            passwordInput.type = "password";
            passwordToggle.src = "mata.png";
        }
    }
</script>

</body>
</html>
