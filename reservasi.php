<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room Booking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .date-selection {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .room-card {
            background-color: #d9d9d9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .room-card img {
            border-radius: 10px;
            margin-right: 20px;
        }
        .room-info {
            flex: 1;
        }
        .room-info h2 {
            margin: 0 0 10px 0;
        }
        .room-info p {
            margin: 5px 0;
        }
        .price {
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: right;
        }
        .button {
            background-color: #ff6600;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
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
                <a href="daftar.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="content">
    <div class="room-card">
    <img src="gambar/kamar 1.svg" width="300">
    <div class="room-info">
        <h2>Standard Single/Twin Room</h2>
        <p>Size: 20m²</p>
        <p>Bed Type: Single Bed</p>
        <p>Categories: double, single</p>
        <p>Amenities: free wi-fi, Meja dan Kursi, Teko Elektrik, TV</p>
    </div>
    <div class="button-container">
    <p class="price">Harga mulai dari:<br>Rp 150.000,00<br>/per malam</p>
        <a href="#" class="button">Pesan Sekarang</a>
    </div>
</div>

<div class="room-card">
    <img src="gambar/kamar 1.svg" width="300">
    <div class="room-info">
        <h2>Standard Single/Twin Room</h2>
        <p>Size: 20m²</p>
        <p>Bed Type: Single Bed</p>
        <p>Categories: double, single</p>
        <p>Amenities: free wi-fi, Meja dan Kursi, Teko Elektrik, TV</p>
    </div>
    <div class="button-container">
    <p class="price">Harga mulai dari:<br>Rp 150.000,00<br>/per malam</p>
        <a href="#" class="button">Pesan Sekarang</a>
    </div>
</div>

    </div>
</body>
</html>
