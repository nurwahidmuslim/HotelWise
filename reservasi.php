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
            color: #042048;
            margin-top: -20px;
            margin-bottom: 10px;
        }
        .room-info p {
            margin: 10px 0;
            font-size: 14px;
            color: #042048;
        }
        .price {
            font-size: 16px;
            font-style: italic;
            text-align: left;
            color: #042048;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: right;
            margin-top: -50px;
        }
        .button {
            background-color: #042048;
            color: #d9d9d9;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 50px;
            margin-bottom: -25px
        }

        .container {
            display: flex;
            align-items: center;
        }
        .container img {
            margin-right: 10px;
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
                <div class="container">
                    <img src="gambar/size.svg" alt="Size">
                    <p>Size: 20m²</p>
                </div>
                <div class="container">
                    <img src="gambar/bed.svg" alt="Bed Type">
                    <p>Bed Type: Single Bed</p>
                </div>
                <div class="container">
                    <img src="gambar/cate.svg" alt="Categories">
                    <p>Categories: double, single</p>
                </div>
                <div class="container">
                    <img src="gambar/star.svg" alt="Amenities">
                    <p>Amenities: free wi-fi, Meja dan Kursi, Teko Elektrik, TV</p>
                </div>
            </div>
            <div class="button-container">
                <p class="price"><span>Harga mulai dari:</span><br>
                <span style="font-size: 20px; font-weight: bold;">Rp 150.000,00</span><br>
                <span>per malam</span></p>
                <a href="#" class="button">Pesan Sekarang</a>
            </div>
        </div>

        <div class="room-card">
            <img src="gambar/kamar 1.svg" width="300">
            <div class="room-info">
                <h2>Standard Single/Twin Room</h2>
                <div class="container">
                    <img src="gambar/size.svg" alt="Size">
                    <p>Size: 20m²</p>
                </div>
                <div class="container">
                    <img src="gambar/bed.svg" alt="Bed Type">
                    <p>Bed Type: Single Bed</p>
                </div>
                <div class="container">
                    <img src="gambar/cate.svg" alt="Categories">
                    <p>Categories: double, single</p>
                </div>
                <div class="container">
                    <img src="gambar/star.svg" alt="Amenities">
                    <p>Amenities: free wi-fi, Meja dan Kursi, Teko Elektrik, TV</p>
                </div>
            </div>
            <div class="button-container">
                <p class="price"><span>Harga mulai dari:</span><br>
                <span style="font-size: 20px; font-weight: bold;">Rp 150.000,00</span><br>
                <span>per malam</span></p>
                <a href="#" class="button">Pesan Sekarang</a>
            </div>
        </div>

        <div class="room-card">
            <img src="gambar/kamar 1.svg" width="300">
            <div class="room-info">
                <h2>Standard Single/Twin Room</h2>
                <div class="container">
                    <img src="gambar/size.svg" alt="Size">
                    <p>Size: 20m²</p>
                </div>
                <div class="container">
                    <img src="gambar/bed.svg" alt="Bed Type">
                    <p>Bed Type: Single Bed</p>
                </div>
                <div class="container">
                    <img src="gambar/cate.svg" alt="Categories">
                    <p>Categories: double, single</p>
                </div>
                <div class="container">
                    <img src="gambar/star.svg" alt="Amenities">
                    <p>Amenities: free wi-fi, Meja dan Kursi, Teko Elektrik, TV</p>
                </div>
            </div>
            <div class="button-container">
                <p class="price"><span>Harga mulai dari:</span><br>
                <span style="font-size: 20px; font-weight: bold;">Rp 150.000,00</span><br>
                <span>per malam</span></p>
                <a href="#" class="button">Pesan Sekarang</a>
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
    </div>
</body>
</html>
