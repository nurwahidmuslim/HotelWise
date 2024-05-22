<?php
session_start();
include 'koneksi.php';

$id_client = $_SESSION['id_client'];
$query = "SELECT tipe_kamar, no_kamar, tgl_in, tgl_out, status FROM pemesanan WHERE id_client = ? AND tgl_book >= NOW() - INTERVAL 90 DAY";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

$days_indonesia = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
);

$months_indonesia = array(
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
);

function translate_day($day, $days_indonesia) {
    return $days_indonesia[$day] ?? $day;
}

function translate_month($month, $months_indonesia) {
    return $months_indonesia[$month] ?? $month;
}

function format_date_indonesia($date_str, $days_indonesia, $months_indonesia) {
    $timestamp = strtotime($date_str);
    $day = translate_day(date('l', $timestamp), $days_indonesia);
    $month = translate_month(date('F', $timestamp), $months_indonesia);
    return $day . ', ' . date('d', $timestamp) . ' ' . $month . ' ' . date('Y', $timestamp) . ' (' . date('H:i', $timestamp) . ')';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking History</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    body {
        height: 100%;
        margin: 0;
        justify-content: center;
        align-items: center;
        background-color: #042048;
    }
    .navbar-right {
        margin-right: 0px;
    }
    body::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 500px;
        height: 500px;
        background: url('gambar/HoteWise Logo.svg') no-repeat center center;
        background-size: contain;
        margin-top: 50px;
        transform: translate(-50%, -50%);
        opacity: 0.5;
        z-index: -1;
    }
    .card {
        background-color: #1A4473;
        border: none;
        margin-bottom: 1rem;
        border-radius: 15px;
        width: 100%;
        height: auto;
    }
    .card-header {
        font-weight: bold;
    }
    .card-body {
        margin-top: 25px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .card-header, .card-body {
        color: #ABCDF6;
    }
    .status-pending {
        font-size: 14px;
        color: white;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .status-diterima {
        font-size: 14px;
        color: green;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .status-ditolak {
        font-size: 14px;
        color: red;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    h1 {
        font-size: 32px;
        margin-bottom: 20px;
        text-align: center;
        color: #ABCDF6;
    }
    .bi-info-circle-fill {
        margin-left: 5px;
        font-size: 20px;
    }
</style>
<body>
<nav class="navbar">
    <div class="navbar-left">
        <img src="gambar/logo.svg" alt="Logo" class="logo">
    </div>
    <div class="navbar-right">
        <img src="gambar/bar.svg" alt="Icon" class="icon" id="dropdown-icon">
        <div class="separator"></div>
        <?php if (isset($_SESSION['namaP'])): ?>
            <span class="hello" style="color: #ABCDF6; text-transform: capitalize; font-size: 18px;">Halo, <span style="font-weight: bold;"><?php echo $_SESSION['namaP']; ?></span></span>
        <?php endif; ?>
        <div class="dropdown" id="dropdown-menu">
            <a href="home.php">Home</a>
            <a href="profil.php">Profil</a>
            <a href="contact.php">Contact</a>
            <a href="riwayat.php">Riwayat Booking</a>
            <a href="index.html">Keluar</a>
        </div>
    </div>
</nav>

<div class="content">
    <div class="text-left mb-4">
        <h1 style="text-align: center;">History</h1>
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill" style="color: #042048;"> Menampilkan riwayat pemesanan dalam 90 hari terakhir.</i>
        </div>
    </div>
    
    <?php if (!empty($pesanan)): ?>
        <?php foreach ($pesanan as $order): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo htmlspecialchars($order['tipe_kamar']); ?></span>
                    <span class="
                    <?php 
                        if ($order['status'] == 'Pending') {
                            echo 'status-pending';
                        } elseif ($order['status'] == 'Diterima') {
                            echo 'status-diterima';
                        } elseif ($order['status'] == 'Ditolak') {
                            echo 'status-ditolak';
                        }
                    ?>">
                        <?php echo htmlspecialchars($order['status']); ?>
                    </span>
                </div>
                <div class="card-body">
                    <p>No. Kamar: <?php echo htmlspecialchars($order['no_kamar']); ?></p>
                    <p>Check in: 
                        <?php 
                            $check_in = date('Y-m-d', strtotime($order['tgl_in'])) . ' 15:00';
                            echo format_date_indonesia($check_in, $days_indonesia, $months_indonesia);
                        ?>
                    </p>
                    <p>Check out: 
                        <?php 
                            $check_out = date('Y-m-d', strtotime($order['tgl_out'])) . ' 12:00';
                            echo format_date_indonesia($check_out, $days_indonesia, $months_indonesia);
                        ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Tidak ada riwayat pemesanan dalam 90 hari terakhir.
        </div>
    <?php endif; ?>
</div>

<footer class="footer">
    <div class="footer-top">
        <h3>MEET US</h3>
        <p>Jl. Prof. Dr. Ir. Sumantri Brojonegoro No.1,<br>
            Gedong Meneng, Kec. Rajabasa,<br>
            Kota Bandar Lampung,<br>
            Lampung 35141</p>
    </div>
    <div class="footer-img">
        <img src="gambar/ig.svg">
        <img src="gambar/twt.svg">
        <img src="gambar/fb.svg">
    </div>
    <div class="footer-bottom">
        <p>Copyright 2024 by WiseHotel Teams. All rights reserved</p>
    </div>
</footer>

<script src="dropdown.js"></script>
</body>
</html>
