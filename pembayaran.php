<?php
session_start();
include 'koneksi.php'; // File to connect to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis_pembayaran = $_POST['jenis_pembayaran'];
    $norek_e_wallet = $_POST['norek_e_wallet'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $total = str_replace(['Rp ', '.'], '', $_POST['total']); // Remove 'Rp ' and dots
    $no_kamar = $_POST['no_kamar']; // Nomor kamar yang dipilih

    // Upload bukti pembayaran
    $target_dir = "bukti_pembayaran/";
    $imageFileType = strtolower(pathinfo($_FILES["bukti"]["name"], PATHINFO_EXTENSION));
    $random_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $random_file_name;
    $uploadOk = 1;

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES["bukti"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["bukti"]["size"] > 5000000) { // 5MB limit
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO pemesanan (nama, jenis_pembayaran, norek_ewallet, tipe_kamar, total, bukti) VALUES (?, ?, ?, ?, ?, ?)");
            
            // Check if prepare() failed
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            
            $stmt->bind_param("ssssss", $nama, $jenis_pembayaran, $norek_e_wallet, $tipe_kamar, $total, $random_file_name);

            if ($stmt->execute()) {
                // Update the status of the selected room to 'Tidak Tersedia'
                $update_stmt = $conn->prepare("UPDATE kamar SET status = 'Tidak Tersedia' WHERE no_kamar = ?");
                
                // Check if prepare() failed
                if ($update_stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                
                $update_stmt->bind_param("s", $no_kamar);
                if ($update_stmt->execute()) {
                    echo "Room status updated successfully.";
                } else {
                    echo "Error updating room status: " . htmlspecialchars($update_stmt->error);
                }

                $update_stmt->close();
            } else {
                echo "Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
}
?>
