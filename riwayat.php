<?php
session_start();

include 'koneksi.php';
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
            width: 477;
            height: 100;
        }
        .card-header{
            font-weight: bold;
        }
        .card-body{
            margin-top: 25px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .card-header, .card-body {
            color: #ABCDF6;
        }
        .status-pending {
            font-size: 10px;
            color: #FF0000;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .status-complete {
            font-size: 10px;
            color: green;
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
                <i class="bi bi-info-circle-fill" style="color: #042048;">  Menampilkan riwayat pemesanan dalam 90 hari terakhir.</i>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Superior Double Room</span>
                <span class="status-pending">Menunggu Konfirmasi</span>
            </div>
            <div class="card-body">
                <p>Check in Rab, 10 April 2023 (20:00)</p>
                <p>Check out Kam, 12 April 2023 (10:00)</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Superior Double Room</span>
                <span class="status-complete">Selesai</span>
            </div>
            <div class="card-body">
                <p>Check in Sen, 1 Januari 2023 (14:00)</p>
                <p>Check out Sel, 3 Januari 2023 (11:00)</p>
            </div>
        </div>
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
