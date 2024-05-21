<?php
include 'koneksi.php';

// Mendekode data JSON yang diterima
$data = json_decode(file_get_contents('php://input'), true);

// Tambahkan debug log untuk data yang diterima
file_put_contents('php://stderr', print_r($data, TRUE));

// Periksa apakah kunci 'id' dan 'status' ada di array
if (isset($data['id']) && isset($data['status'])) {
    $id = $data['id'];
    $status = $data['status'];

    // Gunakan prepared statements untuk keamanan
    $stmt = $conn->prepare("UPDATE pemesanan SET action = ? WHERE id_pemesanan = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Missing id or status";
}

$conn->close();
?>
