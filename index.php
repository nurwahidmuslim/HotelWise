<?php
include 'koneksi.php';

$rooms = [];
$query = "SELECT tipe_kamar, foto FROM tipe_kamar";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelWISE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<style>
    body {
        height: 100%;
        margin: 0;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
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

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
        color: #d9d9d9;
    }

    .room-booking {
        background-color: #d9d9d9;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    .rooms-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .room {
        background-color: transparent;
        overflow: hidden;
        max-width: 300px;
    }

    .room img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .room-info {
        padding: 15px;
    }

    .room-info h3 {
        margin: 0 0 10px 0;
        color: #042048;
    }

    .room-info p {
        margin: 0 0 15px 0;
        color: #666;
    }

    .room-info .btn-pesan {
        display: inline-block;
        padding: 10px 20px;
        background-color: #042048;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
    }

    .room-info .btn-pesan:hover {
        background-color: #054080;
    }
</style>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <img src="gambar/logo.svg" alt="Logo" class="logo">
        </div>
        <div class="navbar-right">
            <a href="daftar.html" class="btn" id="daftar-btn">Daftar</a>
            <a href="masuk.php" class="btn" id="masuk-btn">Masuk</a>
        </div>
    </nav>

    <div class="content">
        <h1>Tingkatkan Pengalaman Menginap Anda<br>
        Temukan Kenyamanan Tanpa Batas<br>di Hotel Kami!</h1>
        <div class="box">
            <span class="box-left" id="checkin_box">
                <p>Check In</p>
                <input type="text" id="checkin_date" readonly>
            </span>
            <span class="box-right" id="checkout_box">
                <p>Check Out</p>
                <input type="text" id="checkout_date" readonly>
            </span>                                      
            <div class="box-bottom" onclick="toggleOptions()">
                <p>Rooms</p>
                <h3 id="selectedOption">1 Room, 2 Guests</h3>
                <div class="options" id="options">
                    <p style="font-weight: bold; font-size: 14px;">Rooms</p>
                    <div class="option" onclick="selectRoomOption('1 Room,')">1 Room</div>
                    <div class="option" onclick="selectRoomOption('2 Rooms,')">2 Rooms</div>
            
                    <p style="font-weight: bold; font-size: 14px;">Guests</p>
                    <div class="option" onclick="selectGuestOption('1 Guest')">1 Guest</div>
                    <div class="option" onclick="selectGuestOption('2 Guests')">2 Guests</div>
                    <div class="option" onclick="selectGuestOption('3 Guests')">3 Guests</div>
                    <div class="option" onclick="selectGuestOption('4 Guests')">4 Guests</div>
                </div>
            </div>
            <a href="#" class="btn-cari">Pesan Sekarang</a>
        </div>
    </div>

    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <img src="gambar/alert.svg">
            <span class="close">&times;</span>
            <p>Anda harus login terlebih dahulu!</p>
            <div class="overlay-buttons">
                <a href="daftar.html" class="btn-overlay">Daftar</a>
                <a href="masuk.php" class="btn-overlay">Masuk</a>
            </div>
        </div>
    </div>  

    <div class="room-booking">
        <h1 style="color: #042048; font-weight: 1000;">Jelajahi Kamar</h1>
        <div class="rooms-container">
            <?php foreach ($rooms as $room): ?>
                <div class="room">
                    <img src="gambar/<?php echo htmlspecialchars($room['foto']); ?>?t=<?php echo time(); ?>" width="300">
                    <div class="room-info">
                        <h3><?php echo htmlspecialchars($room['tipe_kamar']); ?></h3>
                        <p>★★★★☆</p>
                    </div>
                </div>
            <?php endforeach; ?>
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
 
    <script src="home.js"></script>      
    <script>
        document.querySelector('.btn-cari').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('overlay').style.display = 'flex';
        });
        document.addEventListener('DOMContentLoaded', function () {
            var span = document.getElementsByClassName('close')[0];

            span.onclick = function () {
                overlay.style.display = 'none';
            }
        });
    </script>        
</body>
</html>
