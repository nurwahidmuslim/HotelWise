<?php
session_start();
include 'koneksi.php'; // File to connect to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_SESSION['namaL'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $no_rek_e_wallet = $_POST['no_rek_e_wallet'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $total = str_replace('.', '', $_POST['total']); // Remove dot from the total
    $total = str_replace(',', '.', $total); // Replace comma with dot for float conversion

    // Debug: Print the received values
    echo "Nama: $nama\n";
    echo "Jenis Pembayaran: $jenis_pembayaran\n";
    echo "No Rek/E-wallet: $no_rek_e_wallet\n";
    echo "Tipe Kamar: $tipe_kamar\n";
    echo "Total: $total\n";

    // Verify if the tipe_kamar exists in the tipe_kamar table
    $verify_query = "SELECT COUNT(*) FROM tipe_kamar WHERE id_kamar = ?";
    $verify_stmt = $conn->prepare($verify_query);
    if ($verify_stmt) {
        $verify_stmt->bind_param("s", $tipe_kamar);
        $verify_stmt->execute();
        $verify_stmt->bind_result($count);
        $verify_stmt->fetch();
        $verify_stmt->close();

        if ($count == 0) {
            echo "Error: Tipe kamar $tipe_kamar does not exist.";
            exit;
        }
    } else {
        echo "Error preparing verification query: " . $conn->error;
        exit;
    }

    // Handle file upload
    $target_dir = "bukti_pembayaran/";
    $target_file = $target_dir . basename($_FILES["bukti"]["name"]);

    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
        // Insert data into the pemesanan table
        $query = "INSERT INTO pemesanan (nama, jenis_pembayaran, norek_ewallet, tipe_kamar, total, bukti) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssss", $nama, $jenis_pembayaran, $no_rek_e_wallet, $tipe_kamar, $total, $target_file);
            if ($stmt->execute()) {
                echo "Pemesanan berhasil!";
            } else {
                echo "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing insert query: " . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
}
?>
