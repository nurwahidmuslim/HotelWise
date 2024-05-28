<?php
session_start();
include 'koneksi.php'; // File to connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menyimpan data dari formulir ke variabel
    $id_client = $_POST['id_client'];
    $nama = $_POST['nama'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $norek_e_wallet = $_POST['norek_e_wallet'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $total = str_replace(['Rp ', '.'], '', $_POST['total']); // Remove 'Rp ' and dots
    $no_kamar = $_POST['no_kamar']; // Nomor kamar yang dipilih
    $tanggal_check_in = $_POST['checkin_date'];
    $tanggal_check_out = $_POST['checkout_date'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];

    // Upload bukti pembayaran
    $target_dir = "bukti_pembayaran/";
    $imageFileType = strtolower(pathinfo($_FILES["bukti"]["name"], PATHINFO_EXTENSION));
    $random_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $random_file_name;
    $uploadOk = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["bukti"]["tmp_name"]);
    if ($check === false) {
        die("File yang diunggah bukan gambar.");
    }

    // Check file size
    if ($_FILES["bukti"]["size"] > 5000000) { // 5MB limit
        die("Maaf, ukuran file terlalu besar.");
    }

    // Allow certain file formats
    $allowed_formats = array("jpg", "png", "jpeg", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        die("Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        die("Maaf, file tersebut sudah ada.");
    }

    // Upload the file
    if (!move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
        die("Maaf, ada kesalahan saat mengunggah file.");
    }

    // Masukkan ke dalam database
    $sql = "INSERT INTO pemesanan (id_client, nama, jenis_pembayaran, norek_ewallet, tipe_kamar, total, bukti, no_kamar, tgl_in, tgl_out, tgl_book) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    $stmt->bind_param("sssssssssss", $id_client, $nama, $jenis_pembayaran, $norek_e_wallet, $tipe_kamar, $total, $random_file_name, $no_kamar, $tanggal_check_in, $tanggal_check_out, $tanggal_pemesanan);

    if ($stmt->execute()) {
        // Update the status of the selected room to 'Tidak Tersedia'
        $update_stmt = $conn->prepare("UPDATE kamar SET status = 'tidak tersedia' WHERE no_kamar = ?");
        
        if ($update_stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        
        $update_stmt->bind_param("s", $no_kamar);
        if ($update_stmt->execute()) {
            echo "Pemesanan berhasil dan status kamar telah diperbarui.";
        } else {
            echo "Gagal memperbarui status kamar: " . htmlspecialchars($update_stmt->error);
        }

        $update_stmt->close();
    } else {
        echo "Gagal melakukan pemesanan: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
