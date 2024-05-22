<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = mysqli_real_escape_string($conn, $_POST['id_client']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $tgl_lahir = mysqli_real_escape_string($conn, $_POST['tgl_lahir']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);

    $query = "UPDATE client SET nama_lengkap='$nama', email='$email', no_telp='$no_telp', tgl_lahir='$tgl_lahir', jenis_kelamin='$jenis_kelamin' WHERE id_client='$id_client'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Profil berhasil disimpan";
        header('Location: profil.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
