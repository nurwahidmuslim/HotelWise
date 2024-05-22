<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "SELECT id_pemesanan, nama, norek_ewallet, tipe_kamar, no_kamar, total, bukti FROM pemesanan WHERE id_pemesanan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p>Nama&nbsp;&nbsp;: " . $row['nama'] . "</p>
          <p>Nomor Rekening Ewallet&nbsp;&nbsp;: " . $row['norek_ewallet'] . "</p>
          <p>Tipe Kamar&nbsp;&nbsp;: " . $row['tipe_kamar'] . "</p>
          <p>Nomor Kamar&nbsp;&nbsp;: " . $row['no_kamar'] . "</p>
          <p>Total Pembayaran&nbsp;&nbsp;: Rp. " . number_format($row['total'], 2, ',', '.') . "</p>
          <p>Bukti Pembayaran&nbsp;&nbsp;<a href='../bukti_pembayaran/". $row['bukti'] . "' target='_blank'><i class='bi bi-file-earmark'></i>Lihat</a></p>";
} else {
    echo "<p>No data found</p>";
}

$stmt->close();
$conn->close();
?>