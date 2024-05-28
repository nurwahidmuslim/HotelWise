<?php
session_start();

include 'koneksi.php'; // Pastikan file koneksi ini sudah benar dan berfungsi

$alert_message = ""; // Initialize the variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $sql = "SELECT id_gabungan FROM gabungan WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check if id_gabungan is 1
        if ($row['id_gabungan'] == 1) {
            $_SESSION['id_gabungan'] = $row['id_gabungan'];
            header("Location: validasi_reservasi.php"); 
            exit();
        } else {
            $alert_message = "Akses ditolak. ID tidak valid.";
        }
    } else {
        $alert_message = "Username atau kata sandi salah.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
    body{
        display : flex;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #042048;
        height: 100vh;
    }

    .login-left {
        background-color: #d9d9d9;
        width: 50%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #042048;
        text-align: left;
    }
    .login-left h1 {
        margin-left: 75px;
        margin-bottom: 10px;
        margin-top: -20px;
        font-size: 20px;
    }
    .login-left img {
        max-width: 100%;
        max-height: 80%;
    }
    .login-right {
        background-color: #042048;
        width: 50%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .form-container {
        width: 300px;
        padding: 20px;
        border-radius: 10px;
        background-color: #042048;
    }
    .form-container h2 {
        color: #ABCDF6;
    }
    .form-container p {
        color: #ABCDF6;
        margin-top: -20px;
        margin-bottom: 50px;
    }
    .form-container label {
        color: #ABCDF6;
    }
    .form-container input[type="text"],
    .form-container input[type="password"] {
        width: 95%;
        height: 30px;
        background-color: transparent;
        color: #C4C4C4;
        border: 1px solid #7F7F7F;
        border-radius: 10px;
        padding-left: 5%;
        margin-top: 5px;
    }
    .form-container .password-container {
        position: relative;
        width: 95%;
        margin-bottom: 15px;
    }
    .form-container .password-container input {
        width: 100%;
    }
    .form-container .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
    .form-container a {
        display: block;
        text-align: right;
        font-style: italic;
        font-weight: bold;
        color: #7076FA;
        text-decoration: none;
        cursor: pointer;
        margin-top: -10px;
        margin-bottom: 20px;
    }
    .form-container button {
        width: 100%;
        height: 30px;
        background-color: #ABCDF6;
        color: #17448F;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }
    .form-container button:hover {
        background-color: #17448F;
        color: #ABCDF6;
    }
    .alert {
        background-color: #d9d9d9;
        color: #17448F;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    .password-container {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
        cursor: pointer;
        user-select: none;
        width: 20px;
        height: auto;
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
                <p>Hi, Selamat Datang!</p>
                <?php if ($alert_message): ?>
                    <div id="alertMessage" style="display:none;"><?php echo $alert_message; ?></div>
                <?php endif; ?>
                <div class="input-container">
                    <label for="username">Username</label><br>
                    <input type="text" id="username" name="username" value="" placeholder="Masukkan username"><br><br>
                    <label for="password">Sandi</label><br>
                    <div class="password-container">
                        <input type="password" id="password" name="password" value="" placeholder="Masukkan kata sandi">
                        <img class="password-toggle" src="gambar/mata.svg" alt="Tampilkan Sandi" onclick="togglePassword('password')">
                    </div>
                </div><br>
                <a href="#">Lupa sandi?</a><br>
                <button type="submit">Masuk</button>
            </form>
        </div>
    </div>

    <script>
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
