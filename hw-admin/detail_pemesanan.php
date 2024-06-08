<?php
include 'db/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit;
}

$id = $_GET['id'];
$sql = "SELECT id_pemesanan, nama, norek_ewallet, tipe_kamar, no_kamar, total, bukti FROM pemesanan WHERE id_pemesanan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<table class='details-table'>
            <tr><td><strong>Nama:</strong></td><td>&nbsp&nbsp" . $row['nama'] . "</td></tr>
            <tr><td><strong>Nomor Rekening/Ewallet:</strong></td><td> &nbsp&nbsp" . $row['norek_ewallet'] . "</td></tr>
            <tr><td><strong>Tipe Kamar:</strong></td><td>&nbsp&nbsp" . $row['tipe_kamar'] . "</td></tr>
            <tr><td><strong>Nomor Kamar:</strong></td><td>&nbsp&nbsp" . $row['no_kamar'] . "</td></tr>
            <tr><td><strong>Total Pembayaran:</strong></td><td>&nbsp&nbspRp. " . number_format($row['total'], 2, ',', '.') . "</td></tr>
            <tr><td><strong>Bukti Pembayaran:</strong></td><td>&nbsp&nbsp<a href='../bukti_pembayaran/" . $row['bukti'] . "' target='_blank'><i class='bi bi-file-earmark'></i> Lihat</a></td></tr>
          </table>";
} else {
    echo "<p>No data found</p>";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .details-table td {
    padding: 8px;
    vertical-align: top;
}

</style>
<body>
    
</body>
</html>