<?php
include 'koneksi.php';

$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $namaL = $_POST['namaL'];
    $namaP = $_POST['namaP'];
    $password = $_POST['password'];
    $konfPassword = $_POST['konf_password'];

    if (empty($email) || empty($namaL) || empty($namaP) || empty($password) || empty($konfPassword)) {
        $response = "Isi Semua Data!";
    } else {
        if ($password !== $konfPassword) {
            $response = "Konfirmasi kata sandi tidak cocok!";
        } else {
            $email_check_query = "SELECT * FROM client WHERE email='$email' LIMIT 1";
            $result = $conn->query($email_check_query);
            if ($result->num_rows > 0) {
                $response = "Email sudah terdaftar, silakan login!";
            } else {
                $sql = "INSERT INTO client (email, nama_lengkap, nama_panggilan, password)
                        VALUES ('$email', '$namaL', '$namaP', '$password')";

                if ($conn->query($sql) === TRUE) {
                    $response = "Pendaftaran berhasil!";
                } else {
                    $response = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
}

$conn->close();
echo $response
?>