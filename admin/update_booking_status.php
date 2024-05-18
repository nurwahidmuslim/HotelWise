<?php
include 'koneksi.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id_pemesanan'];
$status = $data['action'];

$sql = "UPDATE pemesanan SET action = '$status' WHERE id_pemesanan = $id";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
