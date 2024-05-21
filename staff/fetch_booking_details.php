<?php
include 'koneksi.php';

$sql = "SELECT id_pemesanan, nama, norek_ewallet, jenis, total, bukti FROM pemesanan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div data-id='" . $row['id_pemesanan'] . "'>
                <p>Nama&nbsp;&nbsp;: " . $row['nama_pemesan'] . "</p>
                <p>Nomor Telepon&nbsp;&nbsp;: " . $row['telepon'] . "</p>
                <p>Jenis Kamar&nbsp;&nbsp;: " . $row['jenis'] . "</p>
                <p>Total Pembayaran&nbsp;&nbsp;: Rp. " . number_format($row['total'], 2, ',', '.') . "</p>
                <p>Bukti Pembayaran&nbsp;&nbsp;<a href='" . $row['bukti'] . "' target='_blank'><i class='bi bi-file-earmark'></i>Lihat</a></p>
              </div>";
    }
} else {
    echo "No data found";
}

$conn->close();
?>
